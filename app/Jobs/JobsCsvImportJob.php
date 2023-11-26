<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Batch;
use App\Jobs\JobImportJob;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Providers\JobsImportedNotifyAdminEvent;

class JobsCsvImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    public $timeout = 600;
 
    public function __construct(private string $file)
    {
    }

    public function handle(): void
    {
        // TODO save file into imports table


        $fieldMap = [
            'job_code',
            'title',
            'location',
            'job_type',
            'salary',
            'application_deadline',
            'description',
            'requirements',
            'accepting_applications'
        ];
 
        $fileStream = fopen($this->file, 'r');
        $header = fgetcsv($fileStream); 

        // allow columns to be in different order
        if ((array_diff($fieldMap, $header) != array_diff($header, $fieldMap)) && (array_diff($header, $fieldMap) != array())) {
            throw new Exception('Invalid headers.');
        }

        $jobs = [];
 
        while (($line = fgetcsv($fileStream)) !== false) {
            // set all values to null that are empty string
            $result = array_map(function ($value) {
                return $value === '' ? null : $value;
            }, $line);

        
            $jobs[] = new JobImportJob($result, $header);
        }
 
        if (!empty($jobs)) {
            Bus::batch($jobs)
                ->allowFailures()
                ->then(function (Batch $batch) {
                    event(new JobsImportedNotifyAdminEvent($batch));
            })
            ->dispatch();
        }

        fclose($fileStream);
        unlink($this->file);
    }
}

<?php

namespace App\Jobs;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Import;
use Illuminate\Bus\Batch;
use App\Jobs\JobImportJob;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Providers\JobsImportedNotifyAdminEvent;

class JobsCsvImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    public $timeout = 600;
 
    public function __construct(private string $file, private User $user)
    {
    }

    public function handle(): void
    {
        $filename = (string) Carbon::now() . '_jobs_import.csv';
        $content = File::get($this->file);

        Storage::disk('local')->put($filename, $content);

        $import = Import::new([
            'filename' => $filename
        ]);
        $import->uploading_user_id = '53418372-0a3e-4b13-8335-f74baf73a4de';//$this->user->id;
        $import->save();


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

        
            $jobs[] = new JobImportJob($result, $header, $import->import_id);
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

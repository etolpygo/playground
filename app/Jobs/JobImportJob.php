<?php

namespace App\Jobs;

use App\Models\Job;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class JobImportJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private array $line, private array $header)
    {
    }

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $job = new Job();
        $data = array_combine($this->header, $this->line);

        if (!isset($data['accepting_applications'])) {
            $data['accepting_applications'] = true; 
        }

        if ($job->validate($data)) {
            $job = Job::create($data);
        } else {
            Log::error($job->errors());
        }
    }
}
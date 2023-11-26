<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\JobsImportedNotification;
use App\Providers\JobsImportedNotifyAdminEvent;

class JobsImportedNotifyAdminEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(JobsImportedNotifyAdminEvent $event): void
    {
        $batch = $event->batch;
        $email = $event->email;
        Mail::to($email)->send(
            new JobsImportedNotification([
                'totalJobs' => $batch->totalJobs,
                'failedJobs' => $batch->failedJobs,
                'processedJobs' => $batch->processedJobs,
                'parsed_date' => Carbon::now()->format('d/m/Y H:i'),
            ])
        );
    }

    public function failed(JobsImportedNotifyAdminEvent $event, $exception): void
    {
        Log::error('JobsImportedNotifyAdminEvent-FAILED - '.$exception->getMessage());
    }
}

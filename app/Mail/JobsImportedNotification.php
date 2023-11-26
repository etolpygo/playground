<?php

declare(strict_types=1);

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobsImportedNotification extends Mailable implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public int $retryAfter = 60;
    public int $tries = 5;

    public function __construct(
        private array $mailPayload
    ) {
    }

    public function build()
    {
        $subject = 'Jobs file imported';
        return $this
            ->from('info@thisapp.com')
            ->subject($subject)
            ->markdown('jobs_imported', $this->mailPayload)
        ;
    }
}

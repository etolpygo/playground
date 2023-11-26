<?php

namespace App\Providers;

use Illuminate\Bus\Batch;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class JobsImportedNotifyAdminEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Batch $batch;

    /**
     * Create a new event instance.
     */
    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }

}

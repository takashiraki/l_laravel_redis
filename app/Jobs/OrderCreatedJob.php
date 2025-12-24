<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class OrderCreatedJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $orderId
    )
    {
        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('create order mail', ['orderId' => $this->orderId]);
    }
}

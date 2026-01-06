<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisStreamPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis-stream-push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $prefix = 'order_' . CarbonImmutable::now()->timezone('Asia/Tokyo')->format('YmdHis') . '_';

        $event = [
            'event' => 'OrderCreated',
            'order_id' => uniqid($prefix, true),
            'occurred_at' => CarbonImmutable::now()->toIso8601String(),
        ];

        Redis::xadd(
            'order.events',
            '*',
            $event
        );
        
        $this->info('Pushed event to Redis stream: ' . json_encode($event));
    }
}

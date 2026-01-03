<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class RedisPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis-push';

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
        for ($i = 0; $i < 500; $i++) {
            $timestamp = CarbonImmutable::parse(CarbonImmutable::now())->timezone('Asia/Tokyo')->format('YmdHis');
            $prefix = 'order' . $i . '_' . $timestamp . '_';
            $id = uniqid($prefix, true);
            Redis::rpush('order.queue', json_encode(['order_id' => $id]));
            $this->info("Pushed order ID: {$id} to Redis queue");
        }
    }
}

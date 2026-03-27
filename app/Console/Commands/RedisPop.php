<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Packages\Commons\Gateways\GatewayInterface;

class RedisPop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:redis-pop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        GatewayInterface $gateway
    )
    {
        $this->info('LPopRedisWorker started.');

        while (true) {
            $result = $gateway->subscribe('order.queue', 0);

            if (! $result) {
                $this->info('No more items in the queue. Waiting for new items...');
                continue;
            }

            $payload = json_decode($result, true);
            $orderId = $payload['order_id'] . PHP_EOL;

            // 実際の処理（例：メール送信・DB保存など）
            $this->process($orderId);

            $this->info("Handled order: {$orderId}");
        }
    }

    private function process(string $id): void
    {
        echo "Processing ID: {$id}";
    }
}

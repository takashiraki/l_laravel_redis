<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\SendOrderMailJob;
use Illuminate\Console\Command;

class CreateOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-order';

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
        $id = uniqid('order_', true);
        SendOrderMailJob::dispatch($id);
    }
}

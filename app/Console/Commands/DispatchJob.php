<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Jobs\JobCreated;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class DispatchJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-job';

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
        for ($i = 0; $i < 100; $i++) {
            $uuid = Str::uuid()->toString();

            $job = new JobCreated($uuid);
            dispatch($job);
        }
    }
}

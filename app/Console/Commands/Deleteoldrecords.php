<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class Deleteoldrecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 30 days old records each hour';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
 {
            Task::whereDate('created_at', '<', Carbon::now()->subDays(30))->delete();
            $this->info('Task older than 30 days are deleted successfully!');
 }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\UserTask;

class ExpireAndDeleteTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:expire-and-delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark overdue tasks as expired and delete expired tasks older than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tandai tugas yang melewati deadline sebagai expired
        UserTask::checkExpired();
        $this->info('Expired tasks have been marked.');

        // Hapus tugas expired lebih dari 7 hari
        UserTask::deleteExpired();
        $this->info('Expired tasks older than 7 days have been deleted.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TaskManage;
use App\Models\User;
use App\Models\UserTask;

class AssignTasksToNewUsers extends Command
{
    protected $signature = 'tasks:assign-new-users';
    protected $description = 'Assign tasks to users who do not have them yet';

    public function handle()
    {
        $tasks = TaskManage::all();

        foreach ($tasks as $task) {
            $users = User::whereDoesntHave('userTasks', function ($query) use ($task) {
                $query->where('task_id', $task->id);
            })->get();

            foreach ($users as $user) {
                UserTask::create([
                    'user_id' => $user->id,
                    'task_id' => $task->id,
                ]);
            }
        }

        $this->info('Tasks have been assigned to new users.');
    }
}

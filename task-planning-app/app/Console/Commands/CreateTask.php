<?php

namespace App\Console\Commands;

use App\Http\Repositories\TaskRepository;
use App\Http\Services\TaskService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CreateTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:create {api}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description task:create {api}';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new TaskService(new TaskRepository());
        
        $this->info(''.$this->argument('api').' - Create Action Starting...');

        try {
            $taskList = Http::get(
                env($this->argument('api'))
            )->json();

            foreach($taskList as $task) {
                $service->create($task);
            }
        } catch (Exception $exception) {
            $this->error('Error: '.$exception.' ');
        }
        

        $this->info('Api Url: '.env($this->argument('api')).' ');
        $this->info(''.$this->argument('api').' - Create Action Finished...');
    }
}

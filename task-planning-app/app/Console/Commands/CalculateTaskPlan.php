<?php

namespace App\Console\Commands;

use App\Console\Constants\SqlOrderConstants;
use App\Http\Repositories\TaskRepository;
use App\Http\Services\TaskPlanService;
use App\Http\Services\TaskService;
use App\Models\Task;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CalculateTaskPlan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:calculate-plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description task:calculate-plan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new TaskPlanService(new TaskService(new TaskRepository()));
        
        $this->info('Calculate - Starting...');
        
        var_dump($service->calculate());

        $this->info('Calculate - Finished...');
    }
}

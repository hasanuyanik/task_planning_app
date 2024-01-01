<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskPlanService;
use App\Http\Services\TaskService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class TaskPlanController extends BaseController
{
    /**
     * @var TaskPlanService
     */
    private TaskPlanService $service;

    /**
     * @param TaskPlanService $service
     */
    public function __construct(TaskPlanService $service)
    {
        $this->service = $service;
    }

    /**
     * @return View
     */
    public function calculate(): View
    {
        try{
            return view('taskPlan', ['data' => $this->service->calculate()]);
        } catch(Exception $exception)
        {
            Log::error($exception);

            return response()->json(['error' => 'An error occured!'], 400);
        }
    }
}
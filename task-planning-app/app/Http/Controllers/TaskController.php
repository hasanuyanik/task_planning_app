<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class TaskController extends BaseController
{
    /**
     * @var TaskService
     */
    private TaskService $service;

    /**
     * @param TaskService $service
     */
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * @param TaskRequest $request
     * 
     * @return JsonResponse
     */
    public function create(TaskRequest $request): JsonResponse
    {
        try{
            return response()->json($this->service->create($request->validated()));
        } catch(Exception $exception)
        {
            Log::error($exception);

            return response()->json(['error' => 'An error occured!'], 400);
        }
    }

    /**
     * @param String $tableId
     * @param TaskRequest $request
     * 
     * @return JsonResponse
     */
    public function update(String $tableId, TaskRequest $request): JsonResponse
    {
        try{
            return response()->json($this->service->update($tableId, $request->validated()));
        } catch(Exception $exception)
        {
            Log::error($exception);

            return response()->json(['error' => 'An error occured!'], 400);
        }
    }

    /**
     * @param int $tableId
     * 
     * @return JsonResponse
     */
    public function delete(int $tableId): JsonResponse
    {
        try{
            return response()->json(['status' => $this->service->delete($tableId)]);
        } catch(Exception $exception)
        {
            Log::error($exception);

            return response()->json(['error' => 'An error occured!'], 400);
        }
    }

    /**
     * @param string $tableId
     * 
     * @return JsonResponse
     */
    public function byId(string $tableId): JsonResponse
    {
        try{
            return response()->json($this->service->byId($tableId));
        } catch(Exception $exception)
        {
            Log::error($exception);

            return response()->json(['error' => 'An error occured!'], 400);
        }
    }

    /**
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        try{
            return response()->json($this->service->list());
        } catch(Exception $exception)
        {
            Log::error($exception);

            return response()->json(['error' => 'An error occured!'], 400);
        }
    }
}
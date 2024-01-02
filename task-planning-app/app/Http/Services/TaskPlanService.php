<?php
namespace App\Http\Services;

use App\Console\Contracts\ITaskPlanService;
use App\Models\Task;

class TaskPlanService
{
    private array $developers;

    private array $handleItem;

    private array $devsPointers;

    private array $taskListByValue;

    private int $valueTopLimit;

    private array $plan;

    private array $week;

    private int $weekCounter;

    private array $day;

    private int $dayCounter;

    private array $dailyPlanForDev;

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
        $this->developers = [
            'DEV1' => [
                'name' => 'DEV1',
                'estimated_duration' => '1',
                'value' => '1'
            ],
            'DEV2' => [
                'name' => 'DEV2',
                'estimated_duration' => '1',
                'value' => '2'
            ],
            'DEV3' => [
                'name' => 'DEV3',
                'estimated_duration' => '1',
                'value' => '3'
            ],
            'DEV4' => [
                'name' => 'DEV4',
                'estimated_duration' => '1',
                'value' => '4'
            ],
            'DEV5' => [
                'name' => 'DEV5',
                'estimated_duration' => '1',
                'value' => '5'
            ]
            ];

        $this->devsPointers = [];
        $this->valueTopLimit = 5;
        $this->week = [];
        $this->weekCounter = 1;
        $this->day = [];
        $this->dayCounter = 1;
        $this->plan = [];
        $this->dailyPlanForDev = [];

        $this->handleDevsItems();
        $this->initTaskListByValue();
    }

    public function handleDevsItems(): void
    {
        foreach ($this->developers as $developer) 
        {
            $this->devsPointers[$developer['name']] = [
                'pointer' => 0,
                'dailyHour' => 9,
                'handleItem' => []
            ];
        }
    }

    public function initTaskListByValue(): void
    {
        for ($counter = 1; $counter <= $this->valueTopLimit; $counter++) 
        {
            $this->taskListByValue[$counter] = $this->service->listByValue($counter);
        }
    }

    public function calculate(): array
    {
        $flag = true;
        while ($flag == true) {

            while ($this->dayCounter < 6)
            {
                for ($devCounter = $this->valueTopLimit; $devCounter > 0; $devCounter--) 
                {
                    $this->fillDailyPlanForDev($devCounter);
                    if (count($this->dailyPlanForDev) > 0) {
                        array_push(
                            $this->day, ['DEV'.$devCounter => $this->dailyPlanForDev]
                        );
                    }
                    
                }

                if (count($this->day) > 0) {
                    array_push($this->week, ['DAY'.$this->dayCounter => $this->day]);
                    $this->dayCounter = $this->dayCounter + 1;
                } else {
                    $this->dayCounter = 8;
                }
                $this->day = [];
            }

                if (count($this->week)) {
                    array_push($this->plan, ['WEEK'.$this->weekCounter => $this->week]);
                    $this->weekCounter = $this->weekCounter + 1;     
                } else {
                    $flag = false;
                }
                $this->week = [];
                $this->dayCounter = 1;
        }
        return $this->plan;
    }

    private function fillItem(int $estimated_duration, Task|array $item): array
    {
            return [
                    'name' => $item['name'],
                    'estimated_duration' => $estimated_duration,
                    'value' => $item['value']
                    ];
    }
    
    private function setDailyPlanForDev(int $estimated_duration, Task|array $item)
    {
                array_push(
                    $this->dailyPlanForDev,
                    $this->fillItem($estimated_duration, $item)
                );
    }

    private function fillDailyPlanForDev(int $sortNumber)
    {
        $this->devsPointers['DEV'.$sortNumber]['dailyHour'] = 9;
        $optionalNumber = $sortNumber;
        $this->dailyPlanForDev = [];
                
                while($this->devsPointers['DEV'.$sortNumber]['dailyHour'] > 0) {
                        $handleItem = $this->devsPointers['DEV'.$sortNumber]['handleItem'];
                        $dailyHourBySortNumber = $this->devsPointers['DEV'.$sortNumber]['dailyHour'];
                           
                            if ($this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])) {
                                if (array_key_exists('estimated_duration', $this->devsPointers['DEV'.$sortNumber]['handleItem'])) {
                                    if ($this->devsPointers['DEV'.$sortNumber]['handleItem']['estimated_duration'] <= $this->devsPointers['DEV'.$sortNumber]['dailyHour']) {
                                        $this->addTaskAtDailyPlanBySortNumber($sortNumber);
                                    } else {
                                        $this->addTaskAtDailyPlanChangeHandleItemBySortNumber($sortNumber);
                                    }
                                } else if ($this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])['estimated_duration'] <= $this->devsPointers['DEV'.$sortNumber]['dailyHour']) {
                                    $estimatedDuration = $this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])['estimated_duration'];
                                    if ($optionalNumber < $sortNumber) {
                                        $estimatedDuration = ($estimatedDuration * $optionalNumber) / $sortNumber;
                                    }
                                    
                                    $this->setDailyPlanForDev(
                                        $estimatedDuration,
                                        $this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])
                                    );
                                    $this->devsPointers['DEV'.$sortNumber]['dailyHour'] = $dailyHourBySortNumber - $estimatedDuration;
                                    $this->devsPointers['DEV'.$optionalNumber]['pointer'] = $this->devsPointers['DEV'.$optionalNumber]['pointer'] + 1;
                                } else {
                                    $estimatedDuration = $this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])['estimated_duration'];
                                    if ($optionalNumber < $sortNumber) {
                                        $estimatedDuration = ($estimatedDuration * $optionalNumber) / $sortNumber;
                                    }
                                    $remainingValue = $estimatedDuration - $dailyHourBySortNumber;
                                    $this->setDailyPlanForDev(
                                        $dailyHourBySortNumber,
                                        $this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])
                                    );
                                    $this->devsPointers['DEV'.$sortNumber]['handleItem'] = $this->fillItem(
                                        $remainingValue,
                                        $this->taskListByValue[$optionalNumber]->get($this->devsPointers['DEV'.$optionalNumber]['pointer'])
                                    );
                                    $this->devsPointers['DEV'.$sortNumber]['dailyHour'] = 0;
                                    $this->devsPointers['DEV'.$optionalNumber]['pointer'] = $this->devsPointers['DEV'.$optionalNumber]['pointer'] + 1;
                                }
                            } else {
                                if (array_key_exists('estimated_duration', $handleItem)) {
                                        if ($this->devsPointers['DEV'.$sortNumber]['handleItem']['estimated_duration'] <= $dailyHourBySortNumber) {
                                            $this->addTaskAtDailyPlanBySortNumber($sortNumber);
                                        } else {
                                            $this->addTaskAtDailyPlanChangeHandleItemBySortNumber($sortNumber);
                                        }
                                } else {
                                    if ($optionalNumber > 1) {
                                        $optionalNumber = $optionalNumber-1;
                                    } else {
                                        $this->devsPointers['DEV'.$sortNumber]['dailyHour'] = 0;
                                    }
                                }
                            }
                }
    }

    private function addTaskAtDailyPlanBySortNumber(int $sortNumber): void
    {
        $this->setDailyPlanForDev(
            $this->devsPointers['DEV'.$sortNumber]['handleItem']['estimated_duration'],
            $this->devsPointers['DEV'.$sortNumber]['handleItem']
        );
        $this->devsPointers['DEV'.$sortNumber]['dailyHour'] = $this->devsPointers['DEV'.$sortNumber]['dailyHour'] - $this->devsPointers['DEV'.$sortNumber]['handleItem']['estimated_duration'];
        $this->devsPointers['DEV'.$sortNumber]['handleItem'] = [];
    }

    private function addTaskAtDailyPlanChangeHandleItemBySortNumber(int $sortNumber): void
    {
        $remainingValue = $this->devsPointers['DEV'.$sortNumber]['handleItem']['estimated_duration'] - $this->devsPointers['DEV'.$sortNumber]['dailyHour'];
        $this->setDailyPlanForDev(
            $this->devsPointers['DEV'.$sortNumber]['dailyHour'], 
            $this->devsPointers['DEV'.$sortNumber]['handleItem']
        );
        $this->devsPointers['DEV'.$sortNumber]['handleItem'] = $this->fillItem(
            $remainingValue,
            $this->devsPointers['DEV'.$sortNumber]['handleItem']
        );
        $this->devsPointers['DEV'.$sortNumber]['dailyHour'] = 0;
    }
}
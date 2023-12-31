<?php
namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    /**
     * @param array $datas
     * 
     * @return Task
     */
    public function create(array $datas): Task
    {
        return Task::create($datas); 
    }

    /**
     * @param int $tableId
     * @param array $datas
     * 
     * @return mixed
     */
    public function update(int $tableId, array $datas)
    {
        return Task::where(['tableId' => $tableId])->update($datas);
    }

    /**
     * @param int $tableId
     * 
     * @return bool
     */
    public function delete(int $tableId): bool
    {
        return Task::where(['tableId' => $tableId])->delete();
    }

    /**
     * @param string $tableId
     * 
     * @return Task
     */
    public function byId(string $tableId): Task
    {
            return Task::where(['tableId' => $tableId])->first();        
    }

    /**
     * 
     * @return Collection
     */
    public function list(): Collection
    {
            return Task::get();        
    }
}
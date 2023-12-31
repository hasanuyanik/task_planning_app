<?php
namespace App\Console\Contracts;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface ITaskService
{
    /**
     * @param array $datas
     * 
     * @return Task
     */
    public function create(array $datas): Task;

    /**
     * @param String $tableId
     * @param array $datas
     * 
     * @return mixed
     */
    public function update(String $tableId, array $datas);

    /**
     * @param int $tableId
     * 
     * @return bool
     */
    public function delete(int $tableId): bool;

    /**
     * @param string $tableId
     * 
     * @return Task
     */
    public function byId(string $tableId): Task;

    /**
     * 
     * @return Collection
     */
    public function list(): Collection;

}
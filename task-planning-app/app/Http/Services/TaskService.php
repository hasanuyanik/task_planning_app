<?php
namespace App\Http\Services;

use App\Console\Contracts\ITaskService;
use App\Http\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService implements ITaskService
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $repository;

    /**
     * @param TaskRepository $repository
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;    
    }

    /**
     * @param array $datas
     * 
     * @return Task
     */
    public function create(array $datas): Task
    {
        return $this->repository->create($this->mapperControl($datas));
    }

    /**
     * @param String $id
     * @param array $datas
     * 
     * @return mixed
     */
    public function update(String $id, array $datas)
    {
        return $this->repository->update($id, $this->mapperControl($datas));
    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @param string $id
     * 
     * @return Task
     */
    public function byId(string $id): Task
    {
            return $this->repository->byId($id);        
    }

    /**
     * 
     * @return Collection
     */
    public function list(): Collection
    {
            return $this->repository->list();        
    }

    /**
     * 
     * @return Collection
     */
    public function listByValue(int $value): Collection
    {
            return $this->repository->listByValue($value);        
    }

    /**
     * @param array $datas
     * 
     * @return array
     */
    public function mapperControl(array $datas): array
    {
        if (array_key_exists('id', $datas)) {
            if (array_key_exists('estimated_duration', $datas) && array_key_exists('value', $datas)) {
                return $this->mapperEn($datas);
            } else if (array_key_exists('sure', $datas) && array_key_exists('zorluk', $datas)) {
                return $this->mapperTR($datas);
            }
        }
    }

    /**
     * @param array $datas
     * 
     * @return array
     */
    public function mapperTr(array $datas): array
    {
        return [
            'name' => $datas['id'],
            'estimated_duration' => $datas['sure'],
            'value' => $datas['zorluk']
        ];
    }

    /**
     * @param array $datas
     * 
     * @return array
     */
    public function mapperEn(array $datas): array
    {
        return [
            'name' => $datas['id'],
            'estimated_duration' => $datas['estimated_duration'],
            'value' => $datas['value']
        ];
    }
}
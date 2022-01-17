<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    private Builder $query;

    public function __construct(private Task $task)
    {
        $this->query = $this->task::query();
    }

    /**
     * @param int $id
     *
     * @return Task
     * @throws ModelNotFoundException
     */
    public function get(int $id): Task
    {
        return $this->task = $this->task->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return $this->task = $this->task::create($data);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Task
     */
    public function update(int $id, array $data): Task
    {
        $this->get($id)->update($data);

        return $this->task;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): Bool
    {
        return $this->get($id)->delete();
    }

    /**
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return $this->query->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Builder
     */
    public function filter(array $data): Builder
    {
        return $this->query->where($data);
    }

    /**
     * @param string $column
     * @param string $direction
     * @return Builder
     */
    public function orderBy(string $column, string $direction = 'asc'): Builder
    {
        return $this->query->orderBy($column, $direction);
    }

    /**
     * @param int $id
     * @return Task
     */
    public function confirm(int $id): Task
    {
        $this->get($id);
        $this->task->is_confirmed = true;
        $this->task->save();

        return $this->task;
    }
}

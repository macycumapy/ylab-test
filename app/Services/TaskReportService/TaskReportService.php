<?php

namespace App\Services\TaskReportService;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TaskReportService
{
    private Builder $tasks;

    public function __construct()
    {
        $this->tasks = Task::query();
    }

    public function generate(): string
    {
        $document = new TaskReportDocument($this->getTasks());

        return $document->generate();
    }

    public function setFilters(array $filters): self
    {
        if (isset($filters['date_start'])) {
            $this->tasks->where('date_start', '>=', $filters['date_start']);
        }
        if (isset($filters['date_finish'])) {
            $this->tasks->where('date_finish', '<=', $filters['date_finish']);
        }
        if (isset($filters['is_confirmed'])) {
            $this->tasks->where('is_confirmed', $filters['is_confirmed']);
        }
        if (isset($filters['user_id'])) {
            $this->tasks->where('user_id', $filters['user_id']);
        }

        return $this;
    }

    private function getTasks(): Collection
    {
        return $this->tasks->get();
    }
}

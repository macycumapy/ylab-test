<?php

namespace App\Services\TaskReportService;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TaskReportService
{
    private Builder $tasks;

    public function __construct(private array $filters = [])
    {
        $this->tasks = Task::query();
    }

    public function generate(): string
    {
        if (!empty($this->filters)) {
            $this->setFilters();
        }
        $document = new TaskReportDocument($this->getTasks());

        return $document->generate();
    }

    private function setFilters(): void
    {
        if (isset($this->filters['date_start'])) {
            $this->tasks->where('date_start', '>=', $this->filters['date_start']);
        }
        if (isset($this->filters['date_finish'])) {
            $this->tasks->where('date_finish', '<=', $this->filters['date_finish']);
        }
        if (isset($this->filters['is_confirmed'])) {
            $this->tasks->where('is_confirmed', $this->filters['is_confirmed']);
        }
        if (isset($this->filters['user_id'])) {
            $this->tasks->where('user_id', $this->filters['user_id']);
        }
    }

    private function getTasks(): Collection
    {
        return $this->tasks->get();
    }
}

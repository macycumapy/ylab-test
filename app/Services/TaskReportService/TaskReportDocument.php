<?php

namespace App\Services\TaskReportService;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TaskReportDocument
{
    private string $filePath;
    public function __construct(private Collection $tasks)
    {
        $this->initFilePath();
    }

    private function initFilePath()
    {
        $disc = Storage::disk('local');
        $dir = 'task-reports';
        if (!$disc->exists($dir)) {
            $disc->makeDirectory($dir);
        }
        $day = now()->format('Y_m_d');
        $fileName = "task_$day.csv";
        $this->filePath = $disc->path("$dir/$fileName");
    }

    public function generate(): string
    {
        $file = fopen($this->filePath, 'w');
        fputcsv($file, $this->getHeader());

        /** @var Task $task */
        foreach ($this->tasks as $task) {
            fputcsv($file, $this->getTaskData($task));
        }

        fclose($file);

        return $this->filePath;
    }

    private function getHeader(): array
    {
        return [
          'Name',
          'Project',
          'User name',
          'Is confirmed',
          'Date start',
          'Date finish'
        ];
    }

    private function getTaskData(Task $task): array
    {
        return [
            $task->name,
            $task->project,
            $task->user->name,
            $task->is_confirmed,
            $task->date_start,
            $task->date_finish
        ];
    }
}

<?php

namespace App\Console\Commands;

use App\Services\TaskReportService\TaskReportService;
use Illuminate\Console\Command;

class GenerateTaskReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task-report:generate {--date_start=} {--date_finish=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация отчета по задачам (по умолчанию за последнюю неделю)';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filters = collect($this->options())->only(['date_start', 'date_finish'])->filter()->toArray();
        if (empty($filters)) {
            $filters['date_start'] = now()->startOfWeek()->format('Y-m-d');
            $filters['date_finish'] = now()->endOfWeek()->format('Y-m-d H:i');
        }

        $report = new TaskReportService();
        $report->setFilters($filters)->generate();

        $this->info('Отчет сформирован');
    }
}

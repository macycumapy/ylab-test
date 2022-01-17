<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskIndexRequest;
use App\Http\Requests\TaskReportRequest;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Resources\TaskPaginatorResource;
use App\Http\Resources\TaskResource;
use App\Repositories\TaskRepository;
use App\Services\TaskReportService\TaskReportService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TaskController extends Controller
{
    public function __construct(private TaskRepository $repository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param TaskIndexRequest $request
     * @return JsonResponse
     */
    public function index(TaskIndexRequest $request): JsonResponse
    {
        if (!empty($request->filters())) {
            $this->repository->filter($request->filters());
        }

        if ($request->has('sort_by')) {
            $this->repository->orderBy($request->sort_by, $request->sort_direction ?? 'asc');
        }

        return response()->json(
            TaskPaginatorResource::make($this->repository->paginate($request->per_page))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TaskStoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(TaskStoreRequest $request): JsonResponse
    {
        $task = $this->repository->create($request->validated());

        return response()->json(
            TaskResource::make($task)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $task = $this->repository->get($id);

        return response()->json(
            TaskResource::make($task)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TaskStoreRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(TaskStoreRequest $request, int $id): JsonResponse
    {
        $task = $this->repository->update($id, $request->validated());

        return response()->json(
            TaskResource::make($task)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'success' => $deleted
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function confirm(int $id): JsonResponse
    {
        $task = $this->repository->confirm($id);

        return response()->json(
            TaskResource::make($task)
        );
    }

    /**
     * @param TaskReportRequest $request
     * @param TaskReportService $reportService
     * @return BinaryFileResponse
     */
    public function getReport(TaskReportRequest $request, TaskReportService $reportService): BinaryFileResponse
    {
        $filters = $request->validated();
        $report = $reportService
            ->setFilters($filters)
            ->generate();

        return response()->download($report, 'task.csv');
    }
}

<?php

namespace App\Http\Controllers;






use App\Helpers\Helpers;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Traits\RequestType;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;

use Doctrine\DBAL\Query\QueryException;

class TaskController extends Controller
{
    use RequestType;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {    $task = Task::latest()->paginate(10);
        return TaskResource::collection($task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return TaskResource
     */
    public function store(TaskRequest $request)
    {
        if(!$task = $request->createTask()) {
            return response('Failed to create task! Please try again later');
        }
        return (new TaskResource($request));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return string
     */
    public function show(Task $task)
    {
        $url = Helpers::generateurl($task);
        $single_task = $this->getSingleTask($task);

        return response()->json([
               'task' => $single_task,
               'File' => $url
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if(!$task->delete()) {
            return response()->errorResponse('Failed to delete task');
        }
        return response('Task deleted successfully', 200);
    }

}

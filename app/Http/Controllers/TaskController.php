<?php

namespace App\Http\Controllers;



use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Resources\TaskResource;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
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
     * @param  \Illuminate\Http\Request  $request
     * @return TaskResource
     */
    public function store(TaskRequest $request)
    {
        try {
            if(!$task = $request->createTask()) {
                return response()->errorResponse('Failed to create task! Please try again later');
            }

            return (new TaskResource($task))->additional([
                'message' => 'Task successfully created',
                'status' => 'success'
            ]);
        } catch(QueryException $e) {
            report($e);
            return response()->errorResponse('Failed to create task! Please try again later');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
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
     * @return TaskResource
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return new TaskResource($task);

    }
}

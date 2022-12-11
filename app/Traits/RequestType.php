<?php


namespace App\Traits;


use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;

trait RequestType
{
    public static function getSingleTask($task)
    {
        if (request()->has('fullDetails') && request('fullDetails') === 'true') {

            return new TaskResourceCollection($task);
        }

        return new TaskResource($task);
    }
}

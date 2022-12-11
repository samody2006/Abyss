<?php

namespace App\Http\Requests;

use App\Http\Resources\TaskResource;
use App\Http\Resources\TaskResourceCollection;
use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules( )
    {
        $data =  [
            "name"          => ['required', 'max:50'],
            "description"   => ['required', 'max:255'],
            "file"          => ['required','max:4883','image'],
            "type"          => ['required', 'in:1,2,3'],
        ];
        if($this->filled('file'))
        {
            $task_image = filled('task_image')->getClientOriginalName();
            $filename = time() . rand(1,10) . '.' . $task_image->getClientOriginalExtension();
            $newImage = \Image::make($task_image)->getRealPath();
            Storage::disk('public/image')->put( $filename, $newImage->stream());
        }

return $data;

    }

    public function createTask()
    {

        $data = $this->validated();
        Task::create($data);
        return response('OK', 200);
    }

    public function messages()
    {
        return [
            'file.*.required' => ' image is required'
        ];
    }
}

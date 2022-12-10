<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $data =  [


            "name"          => ['required', 'max:50'],
            "description"   => ['required', 'max:255'],
            "file"          => ['required','size:4883','image'],
            "type"          => ['required', 'in:1,2,3'],
        ];

        if($this->filled('file'))
            foreach($this->input('file') as $index => $photo) {
                if(photoType($photo)) {
                    $data['file'.$index] = photoType($photo) == "file" ? 'image|mimes:jpeg,jpg,png,gif,webp' : 'base64image|base64mimes:jpeg,jpg,png,gif,webp';
                }
            }

        return $data;
    }

    public function createTask()
    {
        $data = $this->validated();
        return task()->create($data);
    }

    protected function getPhotoType()
    {
        if ($this->filled('file')) {
            return photoType($this->input('file'));
        } elseif($this->file('file')) {
            return photoType($this->file('file'));
        }
    }

    public function messages()
    {
        return [
            'file.*.required' => ' image is required'
        ];
    }
}

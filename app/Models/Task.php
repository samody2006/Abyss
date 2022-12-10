<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'file',
        'type'
    ];

    public function setImageAttribute($input) {
        if($input) {
            $this->attributes['file'] = !is_null($input) ? uploadImage('images/', $input) : null;
        }
    }
}

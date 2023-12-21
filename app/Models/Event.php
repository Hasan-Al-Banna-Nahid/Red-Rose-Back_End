<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'date', 'time', 'type', 'status', 'price', 'image_path', 'duration'];

    public function syllabus()
    {
        return $this->hasMany(Syllabus::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}

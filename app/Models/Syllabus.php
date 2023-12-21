<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'name', 'description'];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'name', 'option1', 'option2', 'option3', 'option4', 'option5'];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}

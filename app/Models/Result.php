<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $fillable = ['event_id', 'user_id', 'total_q', 'r_ans', 'w_ans', 'total_mark', 'neg_mark', 'give_ans', 'not_give_ans'];

    public function events()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

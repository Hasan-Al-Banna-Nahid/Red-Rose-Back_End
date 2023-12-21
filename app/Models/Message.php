<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['chat_id','message', 'sender_id', 'receiver_id', 'seen', 'time', 'type'];

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'message');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

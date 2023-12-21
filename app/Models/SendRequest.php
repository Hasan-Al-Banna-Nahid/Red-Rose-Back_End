<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'request_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function sendRequest()
    {
        return $this->belongsTo(User::class, 'request_id');
    }
}

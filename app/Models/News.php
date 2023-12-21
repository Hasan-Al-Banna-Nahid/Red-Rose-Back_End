<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'image_path', 'description', 'pageview'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

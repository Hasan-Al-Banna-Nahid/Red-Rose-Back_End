<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'whatsapp', 'facebook', 'twitter', 'instagram', 'linkedin', 'pinterest', 'tiktok', 'wechat'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

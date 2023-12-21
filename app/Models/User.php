<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type',
        'redrose_id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function sociallink()
    {
        return $this->hasOne(SocialLink::class);
    }
    public function notification()
    {
        return $this->hasMany(Notification::class);
    }
    public function support()
    {
        return $this->hasMany(Support::class);
    }
    public function friend()
    {
        return $this->hasMany(Friend::class);
    }
    public function send_request()
    {
        return $this->hasMany(SendRequest::class);
    }
    public function receive_request()
    {
        return $this->hasMany(ReceiveRequest::class);
    }
    public function message()
    {
        return $this->hasMany(Message::class);
    }
    public function history()
    {
        return $this->hasMany(History::class);
    }
    public function enroll()
    {
        return $this->hasMany(Enroll::class);
    }
    public function blog()
    {
        return $this->hasMany(Blog::class);
    }
}

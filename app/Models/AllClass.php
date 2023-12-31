<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllClass extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    public function model_test()
    {
        return $this->hasMany(ModelTestAll::class);
    }
}

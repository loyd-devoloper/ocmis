<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "price",
        "status",
        'image'
    ];

    public function transactions()
    {
        return $this->hasMany(\App\Models\UserService::class,'service_id','id');
    }
}

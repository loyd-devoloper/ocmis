<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'address',
        'status'
    ];

    public function schedules()
    {
        return $this->hasMany(\App\Models\PriestSchedule::class,'priest_id','id');
    }
}

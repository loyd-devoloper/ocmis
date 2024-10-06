<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    public function niches()
    {
        return $this->hasMany(\App\Models\Niche::class,'building_id','id')->orderBy('level','asc');
    }
}

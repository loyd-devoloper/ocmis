<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Urn extends Model
{
    use HasFactory;

    protected $fillable = [
        'niche_id',
        'urn_number'
    ];

    public function nicheInfo()
    {
        return $this->hasOne(\App\Models\Niche::class,'id','niche_id');
    }
}

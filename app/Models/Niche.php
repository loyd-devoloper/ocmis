<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niche extends Model
{
    use HasFactory;


    protected $fillable = [

        'customer_id',

        'building_id',
        'description',

        'niche_number',

        'capacity',

        'status',

        'level',

        'price',

        'paymentmethod',

        'paymenttype',
        'image'

    ];

    public function buildingInfo()
    {
        return $this->hasOne(\App\Models\Building::class,'id','building_id');
    }
}

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

        'payment_method',

        'payment_type',
        'image',
        'price_checkout',
        'total_paid',
        'service',
        'products',
        'image',
        'checkout_url',
        'payment_ref',
        'status_payment',
        'plan',
        'downpayment',
        'ref_number'

    ];

    public function buildingInfo()
    {
        return $this->hasOne(\App\Models\Building::class,'id','building_id');
    }
    public function customerInfo()
    {
        return $this->hasOne(\App\Models\User::class,'id','customer_id');
    }
    public function installments()
    {
        return $this->hasMany(\App\Models\NicheInstallment::class,'niche_id','id');
    }
}

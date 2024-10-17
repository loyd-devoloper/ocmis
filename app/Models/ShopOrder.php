<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'items',
        'payment_method',
        'payment_ref',
        'total',
        'checkout_url'
    ];

    public function userInfo()
    {
        return $this->hasOne(\App\Models\User::class, 'id','user_id');
    }
}

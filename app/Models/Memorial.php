<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Memorial extends Model
{
    use HasFactory;

    protected $fillable = [

        'payment_method',

        'payment_ref',

        'checkout_url',

        'user_id',

        'message',

        'deceased_name',

        'date_time',

        'password',

        'link',
        'images',
        'status'

    ];

    public function userInfo()
    {
       return $this->hasOne(\App\Models\User::class,'id','user_id');
    }
}

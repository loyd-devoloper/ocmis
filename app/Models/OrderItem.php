<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'amount',
        'user_id',
        'quantity',
        'product_id',
        'order_id',
        'status',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NicheOwner extends Model
{
    use HasFactory;

    protected $fillable = [
        'niche_id',
        'customer_id',
        'lname',
        'fname',
        'birthdate',
        'deathdate',
        'message',
        'image',
    ];
}

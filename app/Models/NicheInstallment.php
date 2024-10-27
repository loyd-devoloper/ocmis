<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NicheInstallment extends Model
{
    use HasFactory;

    protected $fillable = ['niche_id','customer_id','price','status','date','date_paid'];
}

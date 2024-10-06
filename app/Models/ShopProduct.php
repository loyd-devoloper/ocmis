<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    use HasFactory;

    protected $fillable = [

    "product_name","price","category_id","seller_id","description","quantity","status","image"];

    public function sellerInfo()
    {
        return $this->hasOne(\App\Models\ShopSeller::class,'id','seller_id');
    }
    public function categoryInfo()
    {
        return $this->hasOne(\App\Models\ShopCategory::class,'id','category_id');
    }
}

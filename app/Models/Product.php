<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;



class Product extends Model
{
    use HasFactory;
    protected $guarded=[];

  public function  order(){
        return $this->belongsToMany(Order::class,'order_product','products_id','orders_id');
    }
    public function  productsDetaile(){
        return $this->belongsTo(ProductDetail::class,'product_details_id');
    }
}

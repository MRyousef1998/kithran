<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDetail;

use illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{ use SoftDeletes;
     protected $table = 'products';
    use HasFactory;
    protected $guarded=[];
    protected $dates=['deleted_at'];
  public function  order(){
        return $this->belongsToMany(Order::class,'order_product','products_id','orders_id');
    }
    public function  productsDetaile(){
        return $this->belongsTo(ProductDetail::class,'product_details_id','id');
    }
   
    
}

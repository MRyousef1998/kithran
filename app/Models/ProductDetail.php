<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductCompany;


class ProductDetail extends Model
{
    use HasFactory;
    protected $guarded=[];


    public function companies()
    {
    return $this->belongsTo(ProductCompany::class,'company_id');
   
    }
}

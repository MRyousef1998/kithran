<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
      

    //     $product_id =DB::table('products')-> where("product_details_id", $request->id)->
    //     Join('order_product', 'products.id', '=', 'order_product.products_id')->
    //     where("order_product.orders_id", $request->order_id)->
    //    first();
     
    //    $prouct=Product::find($product_id->products_id);
    $prouct=Product::find($request->id);
      
       Box::create([
        'code' => $request->box_code,
    ]);
       $box_id = Box::latest()->first()->id;
    
        if($request->pic!=null){
            $imageName = $request->pic;
            $fileName = $imageName->getClientOriginalName();
     $request->pic->move(public_path('Attachments/Box' . $box_id ), $fileName);
           
        
     }

     $prouct->update([
        'box_id' => $box_id,

        ]);
    
         session()->flash('Add', 'تم التغليف بنجاح ');
         return redirect('ExportOrderDetails/'. $request->order_id);
         
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function edit(Box $box)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Box $box)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Box  $box
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        //
    }
}

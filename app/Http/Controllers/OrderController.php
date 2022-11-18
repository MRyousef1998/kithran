<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\ProductCompany;
use App\Models\ProductGroup;
use App\Models\ProductCategory;

use App\Models\ProductDetail;
use App\Models\Status;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productDetail = ProductDetail::all();
        $productCompany = ProductCompany::all();
        $productGroups = ProductGroup::all();

       

        return view('order.import_order',compact('productDetail','productCompany','productGroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $importClints = User::where('role_id','=',2)->get();
      //  $importClint = User::where('role_id','=',2)->get();
        $clients = User::where('role_id','=',3)->get();
        $productDetail = ProductDetail::all();
        $productCompanies = ProductCompany::all();
        $productCatgories= ProductCategory::all();
     
        $orders= Order::all();


       

        return view('order.add_import_order',compact('importClints','clients','productDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            return $request;
        
     
        $products=json_decode($request->my_hidden_input);
       
  

        if($products == null){
            session()->flash('Erorr', 'يرجى اختيار منتاجات هذه الطلبية');
            //  return $request;
              return redirect('add_order');
        }
        if($request->pic!=null){
            
  
      
       
            $imageName = $request->pic;
            $fileName = $imageName->getClientOriginalName();
        
            Order::create([
             'order_date' => $request->order_Date,
             'order_due_date' => $request->Due_date,
             
             'exported_id' => $request->importer,
             'representative_id' => $request->clint,
             'statuses_id' => $request->status,

             'image_name' => $fileName,

             'category_id' => $request->order_category,
             'Amount_Commission' => $request->Amount_Commission,
             'Value_VAT' => $request->Value_VAT,

             'Total' => $request->Total,



     
         ]);
     // move pic
     $order_id = Order::latest()->first()->id;
     
     $request->pic->move(public_path('Attachments/' . $order_id ), $fileName);
     foreach($products as $product)
        { 
            Product::create([
                'product_details_id' => $product->id,
                'primary_price' => $product->qty,
                
                'selling_price' => ($product->commission_pice+$product->price),
                
                'statuses_id' =>$request->status ,
   
        
            ]);
     $product_id = Product::latest()->first()->id;

          }
    
     
          

     
         session()->flash('Add', 'تم اضافة المنتج بنجاح ');
         return redirect('/all_product');
           
        
     }

        return json_decode($request->my_hidden_input);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function create1()
    {
        $importClints = User::where('role_id','=',2)->get();
      //  $importClint = User::where('role_id','=',2)->get();
        $clients = User::where('role_id','=',3)->get();
        $productDetail = ProductDetail::all();
        $productCompanies = ProductCompany::all();
        $productCatgories= ProductCategory::all();
        $status= Status::all();
    
        $orders= Order::all();


       

        return view('order.add_import_order1',compact('importClints','clients','productDetail','status'));
    }

}

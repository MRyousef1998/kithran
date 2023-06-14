<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;


use App\Models\ProductCompany;
use App\Models\ProductGroup;
use App\Models\ProductCategory;
use App\Models\Product;


use App\Models\ProductDetail;


use App\Models\Status;
use Carbon\Carbon;

class ExportController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       
        //$orders = Order::where('category_id','=',2)->get();
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.export_order.exports_order',compact('exporter', 'importer','representative'));
    }


    public function export_order_serch(Request $request)
    {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        if($start_at==null){

            $orders = Order::where('order_date','<=',[$end_at])->where('category_id','=',2)->get();

        }
        else
        {
        $orders = Order::whereBetween('order_date',[$start_at,$end_at])->where('category_id','=',2)->get();

        }
        
        
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.export_order.exports_order',compact('start_at','end_at','orders','exporter', 'importer','representative'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { return 1;
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
           
        
     
        $products=json_decode($request->my_hidden_input);
       
      
      

       
        if($request->pic==null){
            session()->flash('Erorr', 'يرجى ادخال ملف يوثق هذه الطلبية ');
            //  return $request;
              return redirect('add_export_order');
        }
        if($request->pic!=null){
        
          
            $imageName = $request->pic;
            $fileName = $imageName->getClientOriginalName();
        
            Order::create([
             'order_date' => $request->order_Date,
             'order_due_date' => $request->Due_date,
             
             'exported_id' => $request->exporter,
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
     ////
     if($products == null){


        $newInvoice =  Invoice::create([
            'invoice_Date' =>  Carbon::today(),
            'orders_id' => $order_id,
            
            'invoice_categories_id' => $request->order_category,
            
            'Amount_collection' =>0 ,
            'Discount' =>0 ,
            'Total' =>0 ,
            'Value_Status' =>3 ,
          
            'note' =>"" ,
    
    
    
        ]);
        session()->flash('Add', ' تم اضافة الطلبية بنجاح قم بإضاقة المنتجات وحرر الفاتورة');
             return redirect('ExportOrderDetails/'. $order_id);
    }
    
     foreach($products as $product)
     
     { 
         
         for($i=0 ;$i<$product->qty;$i++ ){
       
         $allProducts =Product::where("product_details_id", $product->id)->where("selling_date", null) ->get();
         
         $Olderproduct=Product::where("product_details_id", $product->id)->where("selling_date", null) ->first();
         $importOrderOldProdect=$Olderproduct->order()->get();
         $olderdate=$importOrderOldProdect[0]->order_due_date;
         $olderProductId=$Olderproduct->id;
         foreach($allProducts as $currentProduct){
             $importOrdeForCurrentProdect=$currentProduct->order()->get();
         $currentdate=$importOrdeForCurrentProdect[0]->order_due_date;
         if($olderdate>$currentdate)
         {
             $olderdate=$currentdate;
             $Olderproduct=$currentProduct;
             $olderProductId=$currentProduct->id;
         }
         
        
         }
         $Olderproduct->update([
            'selling_date' => Carbon::today(),
            'selling_price' => $product->price,
            'selling_price_with_comm' => $product->price+$product->commission_pice,

    
    
            ]);
         $Olderproduct->order()->attach($order_id);


       
 
       }
    
    }
          

     
    session()->flash('Add', ' تم اضافة الطلبية  بنجاح يرجى تحرير الفاتورة');
    return redirect('add_invoices/'.$request->order_category.'/'.$order_id);
           
        
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
    public function store_one_by_one(Request $request)
    {
    
      
        $products=json_decode($request->my_hidden_input);
       
      
      

        if($products == null){
            session()->flash('Erorr', 'يرجى اختيار منتاجات');
            //  return $request;
              return redirect('ExportOrderDetails/add_produ_to_order/'.$request->order_id);
        }
       

        
         
            
        
            
     // move pic
     $order_id = $request->order_id;
     

     ////
     $totalPrice=0;
     $totalcom=0;
     if($request->typeproductOrder!=null){
        
        $importOrder = $request->typeproductOrder;
  foreach($products as $product)
     
     {  
         
         for($i=0 ;$i<$product->qty;$i++ ){
       
        //  $allProducts =Product::where("product_details_id", $product->id)->where("selling_date", null)->with(["order" => function ($query)use ($importOrder){
        //     $query->where('orders_id', $importOrder);   
        // }])->get();
         
        $Olderproduct=Product::with(['order' => function($query) use ($importOrder) { $query->where('orders_id',$importOrder);}])
 ->whereHas('order', function ($query) use ($importOrder) { 
 $query->where('orders_id',$importOrder);}
 )
 ->where("product_details_id", $product->id)->where("selling_date", null)->first();
        //  $Olderproduct=Product::with('order')->whereHas(["order" => function ($query)use ($importOrder){
        //     $query->where('orders_id', $importOrder);   
        // }])->where("product_details_id", $product->id)->where("selling_date", null)->first();
     
        //  $importOrderOldProdect=$Olderproduct->order()->get();
        //  $olderdate=$importOrderOldProdect[0]->order_due_date;
        //  $olderProductId=$Olderproduct->id;
    
        //  foreach($allProducts as $currentProduct){
            
        //      $importOrdeForCurrentProdect=$currentProduct->order()->get();
        //  $currentdate=$importOrdeForCurrentProdect[0]->order_due_date;
        //  if($olderdate>$currentdate)
        //  {
        //      $olderdate=$currentdate;
        //      $Olderproduct=$currentProduct;
        //      $olderProductId=$currentProduct->id;
        //  }
         
       
        //  }
     
         $Olderproduct->update([
            'selling_date' => Carbon::today(),
            'selling_price' => $product->price,
            'selling_price_with_comm' => $product->price+$product->commission_pice,

    
    
            ]);
            $totalPrice=$totalPrice+$product->price;
            $totalcom=$totalcom+$product->commission_pice;

         $Olderproduct->order()->attach($order_id);
        

       
 
       }
    
    }

     }

     else{
       
        foreach($products as $product)
     
        {  
            
            for($i=0 ;$i<$product->qty;$i++ ){
          
            $allProducts =Product::where("product_details_id", $product->id)->where("selling_date", null) ->get();
            
            $Olderproduct=Product::where("product_details_id", $product->id)->where("selling_date", null) ->first();
            $importOrderOldProdect=$Olderproduct->order()->get();
            $olderdate=$importOrderOldProdect[0]->order_due_date;
            $olderProductId=$Olderproduct->id;
       
            foreach($allProducts as $currentProduct){
               
                $importOrdeForCurrentProdect=$currentProduct->order()->get();
            $currentdate=$importOrdeForCurrentProdect[0]->order_due_date;
            if($olderdate>$currentdate)
            {
                $olderdate=$currentdate;
                $Olderproduct=$currentProduct;
                $olderProductId=$currentProduct->id;
            }
            
           
            }
           
            $Olderproduct->update([
               'selling_date' => Carbon::today(),
               'selling_price' => $product->price,
               'selling_price_with_comm' => $product->price+$product->commission_pice,
   
       
       
               ]);
               $totalPrice=$totalPrice+$product->price;
               $totalcom=$totalcom+$product->commission_pice;
   
            $Olderproduct->order()->attach($order_id);
           
   
          
    
          }
       
       }


     }
    
   
  
    $order = Order::find($order_id);
    $order->Amount_Commission =  ($order->Amount_Commission)+( $totalcom);
    $order->Total =  ($order->Total)+(( $totalcom))+(($totalPrice));

    $order->save();

     
    session()->flash('Add', ' تم اضافة المنتچ  بنجاح يرجى تحرير الفاتورة');
    return redirect('ExportOrderDetails/'.$request->order_id);
           
        
     

        return json_decode($request->my_hidden_input);
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
        $importClints = User::where('role_id','=',1)->get();
      //  $importClint = User::where('role_id','=',2)->get();
        $clients = User::where('role_id','=',3)->get();
        $productDetail = ProductDetail::all();
        $productCompanies = ProductCompany::all();
        $productCatgories= ProductCategory::all();
        $status= Status::all();
    
        $orders= Order::all();


        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

        $machines =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id')
         ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 1)->where("products.selling_date", null)->where("products.statuses_id",'!=',7)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       
       
        $grinder =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 2)->where("products.selling_date", null)->where("products.statuses_id",'!=',7)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        $parts =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 3)->where("products.selling_date", null)->where("products.statuses_id",'!=',7)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();

        $broken_machines =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id')
         ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 1)->where("products.selling_date", null)->where("products.statuses_id",'=',7)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       
       
        $broken_grinder =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 2)->where("products.selling_date", null)->where("products.statuses_id",'=',7)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
    
       

        return view('order.export_order.add_export_order',compact('grinder','parts','machines','broken_machines','broken_grinder','importClints','clients','productDetail','status','exporter', 'importer','representative'));
    }

    public function exporterOrders($id)
    {
     
       
        $orders = Order::where('exported_id','=',$id)->get();
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.export_order.exports_order',compact('orders','exporter', 'importer','representative'));
    }
    public function add_produ_to_order($order_id)
    {
        $importOrder =Order::where("category_id",'=',1)->get();

       // return $importOrder;
        $productGroupes=ProductGroup::all();
        $productCompanies=ProductCompany::all();
       $productCatgories=ProductCategory::all();
       
        
        $productDetail = ProductDetail::all();
        $productCompanies = ProductCompany::all();
        $productCatgories= ProductCategory::all();
        $orders= Order::where('id','=',$order_id)->get();
        $status=Status::where('id','>',6)->get();

        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.export_order.add_product_to_order',compact('order_id','importOrder','productCatgories','productCompanies','productGroupes','status','exporter', 'importer','representative','orders'));
    }

}

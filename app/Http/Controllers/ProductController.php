<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicesDetails;
use App\Models\Product;

use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\OrderDetail;
use App\Models\Status;

use Illuminate\Support\Facades\DB;


use App\Models\ProductCompany;
use App\Models\User;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        
        $machines =DB::table('products')->where("products.statuses_id",'!=',4)->where("products.statuses_id",'!=',7)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", $id)->where("products.selling_date", null)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        

 
 $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();


 return view('my_product.machine',compact('id','machines','exporter', 'importer','representative'));
    

    }

    public function broken_machine_view($id)
    {
        
        $machines =DB::table('products')->where("products.statuses_id",'=',7)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", $id)->where("products.selling_date", null)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        

 
 $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();


 return view('my_product.machine',compact('id','machines','exporter', 'importer','representative'));
    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        
        $productDetail = ProductDetail::all();
        $productCompanies = ProductCompany::all();
        $productCatgories= ProductCategory::all();
        $orders= Order::where('category_id','=',1)->get();
        $status=Status::all();

        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('my_product.add_product',compact('productCompanies','productCatgories','orders','status','exporter', 'importer','representative'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        

            $order_id = $request->productorder;
     
            //$request->pic->move(public_path('Attachments/' . $order_id ), $fileName);
             for($i=0;$i<$request->qountity;$i++){
                   $newproduct =  Product::create([
                       'product_details_id' => $request->productClass,
                        'primary_price' => $request->primary_price,
                       
                   
                       
                       'statuses_id' =>$request->status ,
                       'note' =>$request->note ,
                       
                       'price_with_comm' => $request->primary_price+$request->Amount_Commission,
                       'selling_price' => $request->primary_price+$request->Amount_Commission,
                       
          
               
                   ]);
                   $newproduct->order()->attach($order_id);
                   $order = Order::find($order_id);
                    $order->Amount_Commission =  ($order->Amount_Commission)+$request->Amount_Commission;
                    $order->Total =  ($order->Amount_Commission)+($order->Amount_Commission)+$request->Total;

                    $order->save();
           
                 }

            
//                
                  session()->flash('Add', 'تم اضافة المنتج بنجاح ');
             return redirect('all_machine/'. $request->productCategory);
                }
           
            
                 
       
            
            
                  
               
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }


    


    public function getproductsDetaile($id,$category_id)
    {
       
        $products = DB::table('product_details')->where("company_id", $id)->where("category_id", $category_id)
->select('product_name')
->distinct()
->pluck("product_name",);
        $products1 = DB::table("product_details")->where("company_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }
    public function getproductsGruops($productName,$category_id)
    {

        
    //     $products = ProductDetail::where('product_name',$name);
        
    //    $productName=$products->product_name;

        $products =DB::table('product_details')
            ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->where("product_details.product_name", $productName)->where("product_details.category_id", $category_id)->pluck("product_details.id","product_groups.group_name",);
           
           
            return json_encode($products);
          
    }

    public function getorderProductDeteil($id)
    {
        $detailProduct =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
       
       
        Join('order_product', 'products.id', '=', 'order_product.products_id')->
        leftJoin('orders', 'order_product.orders_id', '=', 'orders.id') ->
        leftJoin('users', 'orders.exported_id', '=', 'users.id')  ->
        where("product_details.id", $id)
        ->selectRaw('orders.order_due_date,count(order_product.orders_id) as aggregate')
        ->groupBy('orders.order_due_date')->pluck("orders.order_due_date","aggregate");
   
        
  

       
           
            return json_encode($detailProduct);
          
    }
    public function getDetailsOrder($id)
    { 

      $order=Order::find($id); 
      $smallShop = Order::where('category_id','=',3)->where('related_to_id','=',$id)->get();
     
        $detail=OrderDetail::where("orders_id",$id);
        $machines =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $id)->where("product_details.category_id", 1)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
   //return $machines;
       $grinders =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $id)->where("product_details.category_id", 2)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       $parts =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $id)->where("product_details.category_id", 3)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       $invoices = Invoice::where('orders_id',$id)->first();
       
       $details  = InvoicesDetails::where('invoices_id',$invoices->id)->get();
       $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();

        return view('order.details_order',compact('order','machines','grinders','invoices','details','parts','exporter', 'importer','representative','id','smallShop'));

        
       

       

    }
    public function getExportDetailsOrder($id) 
    {  $boxes =DB::table('products')->
        leftJoin('boxes', 'boxes.id', '=', 'products.box_id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')-> leftJoin('orders', 'orders.id', '=', 'order_product.orders_id') ->where("orders.id", $id)->where("products.box_id",'!=',null)
        ->selectRaw('boxes.id ,boxes.box_code')
        ->groupBy('boxes.id','boxes.box_code')->get();

        $order=Order::find($id);
        
        $detail=OrderDetail::where("orders_id",$id);
        $machines =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $id)->where("product_details.category_id", 1)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,count(products.box_id) as box_count,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
  // return $machines;
       $grinders =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $id)->where("product_details.category_id", 2)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,count(products.box_id) as box_count,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       $parts =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $id)->where("product_details.category_id", 3)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,count(products.box_id) as box_count,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       $invoices = Invoice::where('orders_id',$id)->first();
       
       $details  = InvoicesDetails::where('invoices_id',$invoices->id)->get();
      
       $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();

        return view('order.export_order.details_order1',compact('order','machines','grinders','parts','details','invoices','exporter', 'importer','representative','id','boxes'));

        
       

       

    }
    public function getproductDetails($id)
    { 
 
        $product =DB::table('products')->where("products.statuses_id",'!=',4)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.id", $id)->where("products.selling_date", null)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        


        $detailProduct =DB::table('products')->where("products.statuses_id",'!=',4)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
        leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->
        leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')->
       
        Join('order_product', 'products.id', '=', 'order_product.products_id')->
        leftJoin('orders', 'order_product.orders_id', '=', 'orders.id') ->
        leftJoin('users', 'orders.exported_id', '=', 'users.id') ->leftJoin('statuses', 'orders.statuses_id', '=', 'statuses.id') ->
        where("product_details.id", $id)->where("products.selling_date", null)
        ->selectRaw('order_product.orders_id,orders.order_due_date,statuses.id as statusesId,users.name,statuses.status_name,company_name,product_name,group_name,country_of_manufacture,count(order_product.orders_id) as aggregate,product_details.image_name')
        ->groupBy('statuses.id','users.name','orders.order_due_date','order_product.orders_id','statuses.status_name','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
   

        
// $product = Product::where('category_id', $id)->get();
 
$exporter = User::where('role_id','=',1)->get();
$importer = User::where('role_id','=',2)->get();
$representative = User::where('role_id','=',3)->get();


 return view('order.order_product_details',compact('detailProduct','product','exporter', 'importer','representative'));



 
    

    }


    public function getexport_productDetails($id)
    { 
 
        $product =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.id", $id)->where("products.selling_date", null)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        


        $detailProduct =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
        leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->
        leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')->
       
        Join('order_product', 'products.id', '=', 'order_product.products_id')->
        leftJoin('orders', 'order_product.orders_id', '=', 'orders.id') ->
        leftJoin('users', 'orders.exported_id', '=', 'users.id') ->leftJoin('statuses', 'orders.statuses_id', '=', 'statuses.id') ->
        where("product_details.id", $id)->where("products.selling_date", null)
        ->selectRaw('order_product.orders_id,orders.order_due_date,statuses.id as statusesId,users.name,statuses.status_name,company_name,product_name,group_name,country_of_manufacture,count(order_product.orders_id) as aggregate,product_details.image_name')
        ->groupBy('statuses.id','users.name','orders.order_due_date','order_product.orders_id','statuses.status_name','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
   

        
// $product = Product::where('category_id', $id)->get();
 


 return view('order.export_order.export_product_details',compact('detailProduct','product'));



 
    

    }


    public function getexport_productBoxcDetails(Request $request)
    { 

      

        $boxes =DB::table('products')->
        leftJoin('boxes', 'boxes.id', '=', 'products.box_id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')-> leftJoin('orders', 'orders.id', '=', 'order_product.orders_id') ->where("orders.id", $request->order_id)->where("products.box_id",'!=',null)
        ->selectRaw('boxes.id ,boxes.box_code')
        ->groupBy('boxes.id','boxes.box_code')->get();
        
     
        $product =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $request->order_id)->where("products.product_details_id", $request->product_id)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,count(products.box_id) as box_count,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        
      


        $detailProduct =DB::table('products')->where("products.product_details_id", $request->product_id)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
        leftJoin('boxes', 'boxes.id', '=', 'products.box_id')->
        leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->
        leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
        ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $request->order_id)
        -> get();
        
       


//         $detailProduct =DB::table('products')->
//         leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
//         leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->
//         leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')->
       
//         Join('order_product', 'products.id', '=', 'order_product.products_id')->
//         leftJoin('orders', 'order_product.orders_id', '=', 'orders.id') ->
//         leftJoin('users', 'orders.exported_id', '=', 'users.id') ->leftJoin('statuses', 'orders.statuses_id', '=', 'statuses.id') ->
//         where("product_details.id", $id)->where("products.selling_date", null)
//         ->selectRaw('order_product.orders_id,orders.order_due_date,statuses.id as statusesId,users.name,statuses.status_name,company_name,product_name,group_name,country_of_manufacture,count(order_product.orders_id) as aggregate,product_details.image_name')
//         ->groupBy('statuses.id','users.name','orders.order_due_date','order_product.orders_id','statuses.status_name','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
   

        
// // $product = Product::where('category_id', $id)->get();
 


 return view('order.export_order.export_product_box_details',compact('detailProduct','product','boxes'));



 
    

    }
 

    public function rechoce_product_confirm(Request $request)
    { $unwont_prodect=Product::find($request->product_id);
        $sellingDate=$unwont_prodect->selling_date;
        $price=$unwont_prodect->selling_price;
        $commision=$unwont_prodect->selling_price_with_comm;
        $unwont_prodect->update([
            'selling_date' => null,
            'selling_price' => null,
            'selling_price_with_comm' => null,
 
    
    
            ]);
            $unwont_prodect->order()->detach($request->order_id);
        $allProducts =Product::where("product_details_id", $request->id)->where("selling_date", null)->where("statuses_id", 2)->get();
         
        $Olderproduct=Product::where("product_details_id", $request->id)->where("selling_date", null) ->where("statuses_id", 2)->first();
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
           'selling_date' => $sellingDate,
           'selling_price' => $price,
           'selling_price_with_comm' => $commision,

   
   
           ]);
        $Olderproduct->order()->attach($request->order_id);


        session()->flash('Add', ' تم استبدال المنتج');
        return redirect('ExportOrderDetails/'. $request->order_id);

       

        
    }
    public function getrechose_product(Request $request)
    { 
        

        $machines =DB::table('products')->where("products.statuses_id",'!=',4)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", $request->category_id)->where("products.selling_date", null)
        ->selectRaw('product_details.id as product_detail_id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        
       $product_id=$request->product_id;

$order_id=$request->order_id;
        return view('order.export_order.export_product_rechose',compact('machines','product_id','order_id'));

        
    }

    public function submit_product(Request $request){
       
        $product = Product::findOrFail($request->id);

      

            $product->update([
                'statuses_id' => 2,
            ]);


            session()->flash('Add', '     :تم تأكيد المنتج بنجاح يرجى اعطاءه الكود التالي:'.'PNO'.$request->id .' ORNO '.$request->order_id);
            return redirect('OrderDetails/'. $request->order_id);


    }

    
    public function submit_all_product(Request $request){
       
        $product =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')
        ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')
        ->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
        ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",  $request->order_id)->where("products.product_details_id", $request->id)
        ->selectRaw('products.id')
        ->get();
        foreach($product as $i){
            $myProduct=Product::findOrFail($i->id);
            $myProduct->update([
                'statuses_id' => 2,
            ]);

            
        }
       
        session()->flash('Add', '     :تم تأكيد المنتجات بنجاح    :'.'PNO'.$request->id .' ORNO '.$request->order_id);
            return redirect('OrderDetails/'. $request->order_id);


    }


    public function unsubmit_product(Request $request){
       
        $product = Product::findOrFail($request->id);

      

            $product->update([
                'statuses_id' => 4,
            ]);


            session()->flash('Add', 'تم تحديد المنتج كنقص');
            return redirect('OrderDetails/'. $request->order_id);


    }
    public function getimport_order_productDetails(Request $request)
    { 
        $surproduct =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')
        ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')
        ->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
        ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",  $request->order_id)->where("products.product_details_id", $request->product_id)->where("products.statuses_id", 2)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
         
       
        
 
      

    
        
     
        $product =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')
       ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')
       ->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
       ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",  $request->order_id)->where("products.product_details_id", $request->product_id)
       ->selectRaw('order_product.orders_id,product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name','order_product.orders_id')->get();
        
      

        $detailProduct =DB::table('products')->where("products.product_details_id", $request->product_id)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
       
        leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->
        leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
        ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $request->order_id)
        ->get();
        
    


 return view('order.import_product_details',compact('detailProduct','product','surproduct'));



 
    

    }


    public function removeProductFomOrder(Request $request)
    {
        $product=Product::find($request->id);
$order=Order::find($request->order_id);
$invoice=Invoice::where('orders_id',$request->order_id)->first();
$myInvoice=Invoice::findOrFail($invoice->id);

$newValueForInvoice=$invoice->Amount_collection - $request->product_price;
$newTotalForInvoice=$invoice->Total - $request->product_price;
$newTotalForOrder=$order->Total - $request->product_price;
$newAmountComtion=$order->Amount_Commission - ($product->selling_price_with_comm-$product->selling_price);

$product->order()->detach($request->order_id);
$myInvoice ->update([
    'Amount_collection' =>$newValueForInvoice ,
    'Total' =>$newTotalForInvoice ,
]);
$order ->update([
    'Total' => $newTotalForOrder,
    'Amount_Commission' =>$newAmountComtion ,
]);
session()->flash('Add', ' تم ازالة المنتج من الطلبية');
            return redirect('ExportOrderDetails/'. $request->order_id);

    }



    public function product_report_view(){
       
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

        return view('reports.product_report',compact('exporter', 'importer','representative',));
           
    }
    public function product_report_serch(Request $request){
        $products =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')
       ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')
       ->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
       ->Join('order_product', 'products.id', '=', 'order_product.products_id')-> leftJoin('orders', 'order_product.orders_id', '=', 'orders.id') -> leftJoin('users', 'orders.exported_id', '=', 'users.id') ->where("products.id", $request->product_id)
      -> leftJoin('boxes', 'boxes.id', '=', 'products.box_id')->leftJoin('shipments', 'boxes.shipment_id', '=', 'shipments.id') -> get();
     $product_data =Product::find($request->product_id);
     if ($products->isEmpty()==false) {
   
        $satatus=Status::find($product_data->statuses_id);
      
        
       }
       else{

        $satatus=new Request(['id'=>0,
        'status_name'=>null,
      
        
        ]);
       }
  
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

        return view('reports.product_report',compact('exporter', 'importer','representative','products','satatus'));
           
      
        
           
    }



    public function product_set_proken(Request $request){
       
          $product =Product::find($request->products_id);
       
          $product->update(['statuses_id' => 7,
        
        'note'=>$request->note]);
          session()->flash('Add', ' تم تحديد المنتج كانقص في القطع الداخلية');
            return redirect('product_report/');


    }

    public function product_remove_from_proken(Request $request){
       
        $product =Product::find($request->products_id);
     
        $product->update(['statuses_id' => 2,
      
      'note'=>$request->note]);
        session()->flash('Add', ' تم استعادة المنتج');
          return redirect('product_report/');


  }
}




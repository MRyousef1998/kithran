<?php

namespace App\Http\Controllers;

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
        
        $machines =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", $id)->where("products.selling_date", null)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        
 $product = Product::where('category_id', $id)->get();
 
 $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();


 return view('my_product.machine',compact('product','id','machines','exporter', 'importer','representative'));
    

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
        $orders= Order::where('statuses_id','=',1)->get();
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
                       
                       'selling_price' => $request->selling_price,
                       
                       'statuses_id' =>$request->status ,
                       'note' =>$request->note ,

          
               
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


    


    public function getproductsDetaile($id)
    {
        $products = DB::table('product_details')->where("company_id", $id)
->select('product_name')
->distinct()
->pluck("product_name",);
        $products1 = DB::table("product_details")->where("company_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }
    public function getproductsGruops($productName)
    {

        
    //     $products = ProductDetail::where('product_name',$name);
        
    //    $productName=$products->product_name;

        $products =DB::table('product_details')
            ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->where("product_details.product_name", $productName)->pluck("product_details.id","product_groups.group_name",);
           
           
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

       $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();

        return view('order.details_order',compact('order','machines','grinders','parts','exporter', 'importer','representative','id'));

        
       

       

    }
    public function getExportDetailsOrder($id)
    {

        $order=Order::find($id);
        
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

       $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();

        return view('order.export_order.details_order1',compact('order','machines','grinders','parts','exporter', 'importer','representative','id'));

        
       

       

    }
    public function getproductDetails($id)
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
return $request->id;


       
     
        $product =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $request->order_id)->where("products", $request->id)
       ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        



        $detailProduct =DB::table('products')->where("product_details_id", $request->id)->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->
        leftJoin('boxes', 'boxes.id', '=', 'products.box_id')->
        leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->
        leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') 
        ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $request->order_id)
        ->get();
        


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
 


 return view('order.export_order.export_product_box_details',compact('detailProduct','product'));



 
    

    }
}

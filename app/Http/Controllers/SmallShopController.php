<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCompany;
use App\Models\ProductDetail;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmallShopController extends Controller
{
    public function index()
    {
       
       
        $orders = Order::where('category_id','=',3)->get();
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('shop.shop_orders',compact('orders','exporter', 'importer','representative'));
    }
    public function store(Request $request)
    {
           
        
     
        $products=json_decode($request->my_hidden_input);
       
      
      

        if($products == null){
            session()->flash('Erorr', 'يرجى اختيار منتاجات هذه الطلبية');
            //  return $request;
              return redirect('add_export_order');
        }
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
            'selling_date' => $importOrderOldProdect[0]->order_due_date,
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

    public function create1()
    {
       


        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',3)->get();
        $representative = User::where('role_id','=',3)->get();

        $parts =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 3)->where("products.selling_date", null)->where("products.statuses_id",'!=',7)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();

       
       

        return view('shop.add_shop_order',compact('parts','exporter', 'importer','representative'));
    }

    public function exporterOrders($id)
    {
     
       
        $orders = Order::where('exported_id','=',$id)->get();
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.export_order.exports_order',compact('orders','exporter', 'importer','representative'));
    }
    public function getOrder($id)
    {
       
//         $order = DB::table('orders')->where("exported_id", $id)
// ->select('id')
// ->distinct()
// ->pluck("id",);
        $order = DB::table("orders")->where("exported_id", $id)->pluck("order_date", "id");
        return json_encode($order);
    }

}

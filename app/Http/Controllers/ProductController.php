<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\ProductDetail;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;


use App\Models\ProductCompany;

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
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", $id)
        ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        
 $product = Product::where('category_id', $id)->get();
 


 return view('my_product.machine',compact('product','id','machines'));
    

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
        


       

        return view('my_product.add_product',compact('productCompanies','productCatgories','orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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


    public function Invoice_Paid()
    {
        $invoices = Invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = Invoices::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = Invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }


    public function getproductsDetaile($id)
    {
        $products = DB::table("product_details")->where("company_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }
    public function getproductsGruops($id)
    {

        
        $products = ProductDetail::find($id);
        
       $productName=$products->product_name;

        $products =DB::table('product_details')
            ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->where("product_details.product_name", $productName)->pluck("product_groups.group_name","product_groups.id");
           
           
            return json_encode($products);
          
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

     
        return view('order.details_order',compact('order','machines','grinders','parts'));

        
       

       

    }
}

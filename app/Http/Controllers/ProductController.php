<?php

namespace App\Http\Controllers;

use App\Models\Product;

use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\ProductDetail;

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
 $product = Product::where('category_id', $id)->get();
 


 return view('my_product.machine',compact('product','id'));
    

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
        $orders= Order::all();


       

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
}

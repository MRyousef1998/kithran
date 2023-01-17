<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::all();
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

       
       

        return view('shipment.shipmentes',compact('shipments','exporter', 'importer','representative'));

  
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        //
    }
    public function getboxesOrder($clientId)
    {

        
    //     $products = ProductDetail::where('product_name',$name);
        
    //    $productName=$products->product_name;
         $machines =DB::table('products')->
       leftJoin('boxes', 'boxes.id', '=', 'products.box_id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id", $clientId)
       ->selectRaw('boxes.id as boxId,count(products.box_id) as count_insaid,product_details.image_name')
       ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        $products =DB::table('product_details')
            ->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->where("product_details.product_name", $productName)->pluck("product_details.id","product_groups.group_name",);
           
           
            return json_encode($products);
          
    }


    public function create1()
    {
       
       $importClints = User::where('role_id','=',2)->get();
        // $clients = User::where('role_id','=',3)->get();
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

       
      

        // $machines =DB::table('products')->
        // leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        // ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id')
        //  ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 1)->where("products.selling_date", null)
        // ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        // ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
       
       
        // $grinder =DB::table('products')->
        // leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        // ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 2)->where("products.selling_date", null)
        // ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        // ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();
        // $parts =DB::table('products')->
        // leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        // ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("product_details.category_id", 3)->where("products.selling_date", null)
        // ->selectRaw('product_details.id,company_name,product_name,group_name,country_of_manufacture,count(products.product_details_id) as aggregate,product_details.image_name')
        // ->groupBy('product_details.id','company_name','product_name','country_of_manufacture','group_name','product_details.image_name')->get();


       

        return view('shipment.add_shipment',compact('importClints','exporter', 'importer','representative'));
    }
}

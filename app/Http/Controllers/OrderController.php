<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;

use Illuminate\Http\Request;
use App\Models\ProductCompany;
use App\Models\ProductGroup;
use App\Models\ProductCategory;
use App\Models\Product;


use App\Models\ProductDetail;
use App\Models\Status;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
       
       
        $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();
            $Statuses =Status::all();

       

        return view('order.import_order',compact('exporter', 'importer','representative','Statuses'));
    }


    public function  import_order_serch(Request $request)
    {
        $start_at = date($request->start_at);
        $end_at = date($request->end_at);
        if($start_at==null){

            $orders = Order::where('order_date','<=',[$end_at])->where('category_id','=',1)->get();
            
        }
        else
        {
        $orders = Order::whereBetween('order_date',[$start_at,$end_at])->where('category_id','=',1)->get();

        }
        
        
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();
        $Statuses =Status::all();
       

        return view('order.import_order',compact('start_at','Statuses','end_at','orders','exporter', 'importer','representative'));
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

        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.add_import_order',compact('importClints','clients','productDetail','exporter', 'importer','representative'));
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
       
         

        if($products == null){
            session()->flash('Erorr', 'يرجى اختيار منتاجات هذه الطلبية');
            //  return $request;
              return redirect('add_order');
        }
        if($request->pic==null){
            session()->flash('Erorr', 'يرجى ادخال ملف يوثق هذه الفاتورة');
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
     
        { for($i=0 ;$i<$product->qty;$i++ ){
            $newproduct =  Product::create([
                'product_details_id' => $product->id,
                'primary_price' => $product->price,
                'price_with_comm' => $product->commission_pice+$product->price,
                'selling_price' => ($product->commission_pice+$product->price),
                
                'statuses_id' =>$request->status ,
   
        
            ]);
            $newproduct->order()->attach($order_id);
    
          }}
    
     
          

     
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

        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('order.add_import_order1',compact('importClints','clients','productDetail','status','exporter', 'importer','representative'));
    }

    public function Status_Update(Request $request)
    { 
        
        $order = Order::findOrFail($request->order_id);

      

        $order->update([
            'statuses_id' => $request->status_id,
            'order_due_date'=> Carbon::today(),
        ]);


        session()->flash('Add', 'تم تحديث الحالة بنجاح');
        return redirect('import_order');
    
    }


    

}

<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

use App\Models\InvoiceCategory;

use App\Models\InvoicesDetails;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $PaidFromUSInvoices = Invoice::where('invoice_categories_id',1)->get();
        $PaidForUSInvoices = Invoice::where('invoice_categories_id',2)->get();

        $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();

        return view('invoices.invoices', compact('PaidFromUSInvoices',"PaidForUSInvoices",'exporter','importer','representative'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 1;

    }

    public function createInvoice($category_id,$order_id)
    {
       $invoice_category=InvoiceCategory::find($category_id);
       $order=Order::find($order_id);
       

        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('invoices.add_invoice',compact('invoice_category','order','exporter', 'importer','representative'));

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
 
        
        $newInvoice =  Invoice::create([
            'invoice_Date' => $request->invoice_Date,
            'orders_id' => $request->clint_id,
            
            'invoice_categories_id' => $request->invoice_category,
            
            'Amount_collection' =>$request->Amount_collection ,
            'Discount' =>$request->Discount ,
            'Total' =>$request->Total ,
            'Value_Status' =>3 ,
          
            'note' =>$request->note ,


    
        ]);
        $invoiceId = $newInvoice->id;
        
        $order = Order::where('id',  $newInvoice->orders_id)->first();
        $machines =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",   $newInvoice->orders_id)->where("product_details.category_id", 1)
        ->selectRaw('products.id,company_name,product_name,group_name,country_of_manufacture,selling_price_with_comm,price_with_comm')
        ->groupBy('products.id','company_name','product_name','country_of_manufacture','group_name','selling_price_with_comm','price_with_comm')->get();
 
        $grinders =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",   $newInvoice->orders_id)->where("product_details.category_id", 2)
        ->selectRaw('products.id,company_name,product_name,group_name,country_of_manufacture,selling_price_with_comm,price_with_comm')
        ->groupBy('products.id','company_name','product_name','country_of_manufacture','group_name','selling_price_with_comm','price_with_comm')->get();
 
       $parts =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",   $newInvoice->orders_id)->where("product_details.category_id", 3)
       ->selectRaw('products.id,company_name,product_name,group_name,country_of_manufacture,selling_price_with_comm,price_with_comm')
       ->groupBy('products.id','company_name','product_name','country_of_manufacture','group_name','selling_price_with_comm','price_with_comm')->get();

       $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();
            $invoices =$newInvoice;
        return view('invoices.Print_invoice',compact('invoices','machines','grinders','parts','exporter','importer','representative','order'));


    }
    public function store1(Request $request)
    {
        return $request;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
        $invoices = Invoice::where('id', $id)->first();
        $order =Order::where('id', $invoices->orders_id)->first();
        $invoices_detailes =DB::table('invoices_details')->
      where ("invoices_details.invoices_id",$invoices->id)
        ->selectRaw('invoices_details.invoices_id,sum(invoices_details.amount_payment) as amount_payment_pefor')
        ->groupBy('invoices_details.invoices_id')->get();
        
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();
        return view('invoices.status_update', compact('invoices','order','exporter','importer','representative','invoices_detailes'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }
    public function Status_Update( Request $request)
    { 
        $fileName=null;
        if($request->pic!=null){
    
            $imageName = $request->pic;
            $fileName = $imageName->getClientOriginalName();
            }

        $invoices = Invoice::findOrFail($request->invoice_id);

        if ($request->Status == 1) {

            $invoices->update([
                'Value_Status' => 1,
              
                'Payment_Date' => $request->Payment_Date,
            ]);

            InvoicesDetails::create([
                'invoices_id' => $request->invoice_id,
               
                'amount_payment' => $request->new_payment,
                'image_name' => $fileName,
                'Value_Status' => 1,
                'note' => $request->note,
                'payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 2,
                
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoicesDetails::create([
                'invoices_id' => $request->invoice_id,
               
                'amount_payment' => $request->new_payment,
                'image_name' => $fileName,
            
                'Value_Status' => 2,
                'note' => $request->note,
                'payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        if($request->pic!=null){
        $invoice_detail_id = InvoicesDetails::latest()->first()->id;
        $request->pic->move(public_path('Attachments/InvoicesDetails/' . $invoice_detail_id ), $fileName);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
    public function show_invoice($invoice_id)
    {  $invoices =Invoice::find($invoice_id);
        $order = Order::where('id',  $invoices->orders_id)->first();
        $machines =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",   $invoices->orders_id)->where("product_details.category_id", 1)
        ->selectRaw('products.id,company_name,product_name,group_name,country_of_manufacture,selling_price_with_comm,price_with_comm')
        ->groupBy('products.id','company_name','product_name','country_of_manufacture','group_name','selling_price_with_comm','price_with_comm')->get();
 
        $grinders =DB::table('products')->
        leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
        ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",   $invoices->orders_id)->where("product_details.category_id", 2)
        ->selectRaw('products.id,company_name,product_name,group_name,country_of_manufacture,selling_price_with_comm,price_with_comm')
        ->groupBy('products.id','company_name','product_name','country_of_manufacture','group_name','selling_price_with_comm','price_with_comm')->get();
 
       $parts =DB::table('products')->
       leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')->leftJoin('product_groups', 'product_details.group_id', '=', 'product_groups.id')->leftJoin('product_companies', 'product_details.company_id', '=', 'product_companies.id')
       ->leftJoin('statuses', 'products.statuses_id', '=', 'statuses.id') ->Join('order_product', 'products.id', '=', 'order_product.products_id')->where("order_product.orders_id",   $invoices->orders_id)->where("product_details.category_id", 3)
       ->selectRaw('products.id,company_name,product_name,group_name,country_of_manufacture,selling_price_with_comm,price_with_comm')
       ->groupBy('products.id','company_name','product_name','country_of_manufacture','group_name','selling_price_with_comm','price_with_comm')->get();

       $exporter = User::where('role_id','=',1)->get();
            $importer = User::where('role_id','=',2)->get();
            $representative = User::where('role_id','=',3)->get();
          
        return view('invoices.Print_invoice',compact('invoices','machines','grinders','parts','exporter','importer','representative','order'));


    }

    public function Invoice_Paid()
    {
      
        $PaidFromUSInvoices = Invoice::where('invoice_categories_id',1)->where('Value_Status', 1)->get();
        $PaidForUSInvoices = Invoice::where('invoice_categories_id',2)->where('Value_Status', 1)->get();

        $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();

        return view('invoices.invoices', compact('PaidFromUSInvoices',"PaidForUSInvoices",'exporter','importer','representative'));
    }
    public function Invoice_Partial()
    {
      
        $PaidFromUSInvoices = Invoice::where('invoice_categories_id',1)->where('Value_Status', 2)->get();
        $PaidForUSInvoices = Invoice::where('invoice_categories_id',2)->where('Value_Status', 2)->get();

        $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();

        return view('invoices.invoices', compact('PaidFromUSInvoices',"PaidForUSInvoices",'exporter','importer','representative'));
    }
    public function Invoice_UnPaid()
    {
      
        $PaidFromUSInvoices = Invoice::where('invoice_categories_id',1)->where('Value_Status', 3)->get();
        $PaidForUSInvoices = Invoice::where('invoice_categories_id',2)->where('Value_Status', 3)->get();

        $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();

        return view('invoices.invoices', compact('PaidFromUSInvoices',"PaidForUSInvoices",'exporter','importer','representative'));
    }
}
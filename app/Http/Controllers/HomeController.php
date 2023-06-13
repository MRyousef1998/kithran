<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
 $macineSoldParMonth=DB::table('products')-> leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')-> 
Join('order_product', 'products.id', '=', 'order_product.products_id')->leftJoin('orders', 'order_product.orders_id', '=', 'orders.id')->where("product_details.category_id", '=',1)->where("orders.category_id", '=',2)->where("products.selling_date", '!=',null)
->selectRaw('count(products.id) as number_sold ,sum(products.price_with_comm) as primery_price_with_com_product_sold,sum(products.selling_price) as selling_price_without_com_product_sold,sum(products.selling_price_with_comm) as selling_price_with_com_product_sold,YEAR(order_date) year, MONTH(order_date) month')
->groupBy('year','month')->get();

$grinderSoldParMonth=DB::table('products')-> leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')-> 
Join('order_product', 'products.id', '=', 'order_product.products_id')->leftJoin('orders', 'order_product.orders_id', '=', 'orders.id')->where("product_details.category_id", '=',2)->where("orders.category_id", '=',2)->where("products.selling_date", '!=',null)
->selectRaw('count(products.id) as number_sold ,sum(products.price_with_comm) as primery_price_with_com_product_sold,sum(products.selling_price) as selling_price_without_com_product_sold,sum(products.selling_price_with_comm) as selling_price_with_com_product_sold,YEAR(order_date) year, MONTH(order_date) month')
->groupBy('year','month')->get();
    

$PartsSoldParMonth=DB::table('products')-> leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')-> 
Join('order_product', 'products.id', '=', 'order_product.products_id')->leftJoin('orders', 'order_product.orders_id', '=', 'orders.id')->where("product_details.category_id", '=',3)->where("orders.category_id", '=',2)->where("products.selling_date", '!=',null)
->selectRaw('count(products.id) as number_sold ,sum(products.price_with_comm) as primery_price_with_com_product_sold,sum(products.selling_price) as selling_price_without_com_product_sold,sum(products.selling_price_with_comm) as selling_price_with_com_product_sold,YEAR(order_date) year, MONTH(order_date) month')
->groupBy('year','month')->get();
    
         
    


$PartsSoldParMonth=DB::table('products')-> leftJoin('product_details', 'product_details.id', '=', 'products.product_details_id')-> 
Join('order_product', 'products.id', '=', 'order_product.products_id')->leftJoin('orders', 'order_product.orders_id', '=', 'orders.id')->where("product_details.category_id", '=',3)->where("orders.category_id", '=',2)->where("products.selling_date", '!=',null)
->selectRaw('count(products.id) as number_sold ,sum(products.price_with_comm) as primery_price_with_com_product_sold,sum(products.selling_price) as selling_price_without_com_product_sold,sum(products.selling_price_with_comm) as selling_price_with_com_product_sold,YEAR(order_date) year, MONTH(order_date) month')
->groupBy('year','month')->get();

$paymentsthismonth = DB::table('account_statements')->where("account_statements.account_statement_types_id", 1)
->selectRaw('count(id) as number ,sum(amount) as payments')->whereMonth("account_statements.pay_date", Carbon::now()->month)
->groupBy('account_statements.pay_date')->get();
$erningthismonth = DB::table('account_statements')->where("account_statements.account_statement_types_id", '=',2)
->selectRaw('count(id) as number ,sum(amount) as payments')->whereMonth("account_statements.pay_date", Carbon::now()->month)
->groupBy('account_statements.pay_date')->get();
$parsonalpaymentthismonth = DB::table('account_statements')->where("account_statements.account_statement_types_id", '=',3)
->selectRaw('count(id) as number ,sum(amount) as payments')->whereMonth("account_statements.pay_date", Carbon::now()->month)
->groupBy('account_statements.pay_date')->get();

if ($paymentsthismonth->isEmpty()==true) {

    $paymentsthismonth=[new Request(['count'=>0,

    "payments"=>0,
   
])];
    
   }
   if ($erningthismonth->isEmpty()==true) {

    $erningthismonth=[new Request(['count'=>0,

    "payments"=>0,
   
])];
    
   }
   if ($parsonalpaymentthismonth->isEmpty()==true) {

    $parsonalpaymentthismonth=[new Request(['count'=>0,

    "payments"=>0,
   
])];
    
   }
 
        $chartjs = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 300 , 'height' => 200])
        ->labels(['مدفوعات', 'مقبوضات','مصاریف خارجیة'])
        ->datasets([
            [
                'backgroundColor' => ['#FF6384', '#36A2EB','#Fa672e'],
                'hoverBackgroundColor' => ['#FF6384', '#36A2EB','#Fa672e'],
                'data' => [$paymentsthismonth[0]->payments, $erningthismonth[0]->payments,$parsonalpaymentthismonth[0]->payments]
            ]
        ])
        ->options([]);
        $exporter = User::where('role_id','=',1)->get();
 $importer = User::where('role_id','=',2)->get();
 $representative = User::where('role_id','=',3)->get();






        foreach ($macineSoldParMonth as $key => $value) {
            $result[++$key] = [$value->year.'-'.$value->month, (int)$value->selling_price_with_com_product_sold, (int)$value->selling_price_with_com_product_sold];
        }
    
        



        
        return view('home',compact('chartjs','exporter','importer','representative','result'));
    }
}

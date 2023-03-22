<?php

namespace App\Http\Controllers;

use App\Models\AccountStatement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diposit = AccountStatement::where('account_statement_types_id','=',1)->where('pay_date','=', Carbon::today())->get();
        $withdrow = AccountStatement::where('account_statement_types_id','=',2)->where('pay_date','=', Carbon::today())->get();

      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('account.show_account',compact('diposit','withdrow','exporter', 'importer','representative'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        AccountStatement::create([
            'purpose' => $request->purpose,
            'account_statement_types_id' => $request->type_id,
            
            'amount' => $request->amount,
            'note' => $request->note,
            'user_id' =>(Auth::user()->id),

            //'palance_after_this' => $fileName,

            'pay_date' =>  Carbon::today(),
  
        ]);
        session()->flash('success', ' تم الاضافة بنجاح');

        return redirect('/today_account_statment');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function show(AccountStatement $accountStatement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountStatement $accountStatement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $accountStatement = AccountStatement::findOrFail($request->id);

      

        $accountStatement->update([
            'purpose' => $request->purpose,
            'amount' => $request->amount,
            'note' => $request->note,
        ]);
        session()->flash('success', ' تم التعديل بنجاح');

        return redirect('/today_account_statment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccountStatement  $accountStatement
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountStatement $accountStatement)
    {
        //
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\BankAccountStatements;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\User;

class BankAccountStatementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diposit = BankAccountStatements::where('account_statement_types_id','=',1)->where('pay_date','=', Carbon::today())->get();
        $withdrow = BankAccountStatements::where('account_statement_types_id','=',2)->where('pay_date','=', Carbon::today())->get();
        $externaldiposit = BankAccountStatements::where('account_statement_types_id','=',3)->where('pay_date','=', Carbon::today())->get();
      
        $exporter = User::where('role_id','=',1)->get();
        $importer = User::where('role_id','=',2)->get();
        $representative = User::where('role_id','=',3)->get();

       

        return view('bank_account.show_account',compact('diposit','withdrow','exporter', 'importer','representative','externaldiposit'));
    
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
     * @param  \App\Models\BankAccountStatements  $bankAccountStatements
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccountStatements $bankAccountStatements)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BankAccountStatements  $bankAccountStatements
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccountStatements $bankAccountStatements)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BankAccountStatements  $bankAccountStatements
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccountStatements $bankAccountStatements)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BankAccountStatements  $bankAccountStatements
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccountStatements $bankAccountStatements)
    {
        //
    }
}

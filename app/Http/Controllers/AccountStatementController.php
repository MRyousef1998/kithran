<?php

namespace App\Http\Controllers;

use App\Models\AccountStatement;
use Illuminate\Http\Request;

class AccountStatementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diposit = AccountStatement::where('account_statement_types_id','=',1)->where('account_statement_types_id', Carbon::today())->get();
        $withdrow = AccountStatement::where('account_statement_types_id','=',2)->where('account_statement_types_id', Carbon::today())->get();

      
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
    public function update(Request $request, AccountStatement $accountStatement)
    {
        //
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

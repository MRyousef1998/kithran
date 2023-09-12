<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeStatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_statments', function (Blueprint $table) {
            $table->id();
            $table->text('purpose');
            $table->bigInteger( 'account_statement_types_id' )->unsigned();
            $table->foreign('account_statement_types_id')->references('id')->on('account_statement_types')->onDelete('cascade');
            $table->decimal('amount',8,2);
            $table->text('note')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('pay_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_statments');
    }
}

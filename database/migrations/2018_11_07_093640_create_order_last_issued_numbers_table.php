<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLastIssuedNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('sqlsrvHODB')->create('order_last_issued_numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('branch_id');
            $table->integer('header_no');
            $table->integer('details_no');
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
        Schema::dropIfExists('order_last_issued_numbers');
    }
}

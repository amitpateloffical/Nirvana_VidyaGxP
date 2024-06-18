<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_contract_grids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('supplier_contract_id')->nullable();
            $table->string('type')->nullable();
            $table->string('transaction')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('date')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency_used')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('supplier_contract_grids');
    }
};

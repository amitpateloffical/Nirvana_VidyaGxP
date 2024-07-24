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
        Schema::create('medical-devices', function (Blueprint $table) {
            $table->id();
            $table->string('initiator_id');
            $table->string('record')->nullable();
            $table->string('initiator')->nullable();
            $table->date('date_of_initiation')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('type')->nullable();
            $table->longText('other_type')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('URLs')->nullable();
            $table->longtext('attachment')->nullable();
            $table->longText('trade_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->integer('therapeutic_area')->nullable();
            $table->integer('prooduct_code')->nullable();
            $table->longText('intended_use')->nullable();
// -------------------------------------//////////-------------------------------------------//
            $table->string('started_by')->nullable();
            $table->string('started_on')->nullable();
            $table->string('retired_by')->nullable();
            $table->string('retired_on')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();


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
        Schema::dropIfExists('medical-devices');
    }
};

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
        Schema::table('variations', function (Blueprint $table) {
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('cancelled_comment')->nullable();
            $table->string('req_info_by')->nullable();
            $table->string('req_info_on')->nullable();
            $table->string('req_info_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('variations', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::table('validations', function (Blueprint $table) {
            // $table->string('submited_comment')->nullable();
            // $table->string('review_comment')->nullable();
            // $table->string('1st_final_comment')->nullable();
            // $table->string('2nd_final_comment')->nullable();
            // $table->string('report_reject_comment')->nullable();
            // $table->string('obsolete_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validations', function (Blueprint $table) {
            //
        });
    }
};

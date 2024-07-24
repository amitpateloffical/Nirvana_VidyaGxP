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
        Schema::create('g_c_p_study_grids', function (Blueprint $table) {
            $table->id();
            $table->integer('gcp_study_id')->default(0);
            $table->string('identifier')->nullable();
            $table->longText('data')->nullable();
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
        Schema::dropIfExists('g_c_p_study_grids');
    }
};

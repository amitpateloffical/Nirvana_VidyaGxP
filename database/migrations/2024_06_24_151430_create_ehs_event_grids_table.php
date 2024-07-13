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
        Schema::create('ehs_event_grids', function (Blueprint $table) {
            $table->id();
            $table->integer('ci_id')->nullable();
            $table->string('identifier')->nullable();
            $table->longText('data')->nullable();
            // $table->string('type')->nullable();
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
        Schema::dropIfExists('ehs_event_grids');
    }
};

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
        Schema::create('national_approval_grids', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('national_id')->nullable();
            $table->string('identifier')->nullable();
            $table->longtext('data')->nullable();

            // $table->bigInteger('national_id')->nullable();
            // $table->text('primary_packaging')->nullable();
            // $table->text('material')->nullable();
            // $table->text('pack_size')->nullable();
            // $table->text('shelf_life')->nullable();
            // $table->text('storage_condition')->nullable();
            // $table->text('secondary_packaging')->nullable();
            // $table->text('remarks')->nullable();
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
        Schema::dropIfExists('national_approval_grids');
    }
};

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
        Schema::create('verification_grids', function (Blueprint $table) {
            $table->id();

                $table->integer('verification_id')->default(0);
                $table->string('identifier');
                $table->longText('data')->nullable(); // Column to store serialized data.

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
        Schema::dropIfExists('verification_grids');
    }
};
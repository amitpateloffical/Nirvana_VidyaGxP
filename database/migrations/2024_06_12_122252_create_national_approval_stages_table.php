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
        Schema::create('national_approval_stages', function (Blueprint $table) {
            $table->id();

            $table->string('national_id');
            $table->string('national_user_id')->comment('user_id');
            $table->string('national_stage')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->date('completed_on')->nullable(); 
            $table->integer('is_required')->default(0);

            $table->softDeletes();
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
        Schema::dropIfExists('national_approval_stages');
    }
};

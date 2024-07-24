<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('validation_audit_trails', function (Blueprint $table) {
            $table->id();
            $table->string('validation_id')->nullable();
            $table->string('activity_type')->nullable();
            $table->longText('previous')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_role')->nullable();
            $table->string('change_to')->nullable();
            $table->string('change_from')->nullable();
            $table->string('action_name')->nullable();
            $table->string('stage')->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('validation_audit_trails');
    }
};

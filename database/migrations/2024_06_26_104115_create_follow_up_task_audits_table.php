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
        Schema::create('follow_up_task_audits', function (Blueprint $table) {
            $table->id();
            $table->string('task_id');
            $table->string('activity_type');
            $table->longText('previous')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id');
            $table->string('user_name');
            // $table->string('origin_state');
            $table->string('user_role');
            $table->string('change_to');
            $table->string('change_from');
            $table->string('action_name');
            $table->string('stage')->nullable();
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
        Schema::dropIfExists('follow_up_task_audits');
    }
};

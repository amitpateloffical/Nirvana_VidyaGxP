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
        Schema::create('audit_task_audit_trials', function (Blueprint $table) {
            $table->id();
            $table->string('audit_tasks_id');
            $table->string('activity_type');
            $table->longText('previous')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id');
            $table->string('user_name');
            $table->string('origin_state')->nullable();
            $table->string('user_role');
            $table->string('stage')->nullable();
            $table->text('change_to')->nullable();
            $table->text('change_from')->nullable();
            $table->text('action_name')->nullable();
            $table->text('action')->nullable();
            $table->text('submit_comment')->nullable();
            $table->text('come_verification_comment')->nullable();
            $table->text('comments')->nullable();
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
        Schema::dropIfExists('audit_task_audit_trials');
    }
};

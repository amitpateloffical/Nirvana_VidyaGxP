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
        Schema::create('client_inquiry_audit_trials', function (Blueprint $table) {
            $table->id();
               $table->string('clientInquiry_id');
            $table->string('activity_type');
            $table->longText('previous')->nullable();
            $table->string('stage')->nullable();
            $table->longText('current')->nullable();
            $table->longText('comment')->nullable();
            $table->string('user_id')->nullable();
            $table->string('action_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_role')->nullable();
            $table->string('origin_state')->nullable();
            $table->string('change_to')->nullable();
            $table->string('change_from')->nullable();
            $table->string('action')->nullable();
            $table->text('Submited_Comment')->nullable();
            $table->text('simple_resol_omment')->nullable();
            $table->text('resolution_progress_Comment')->nullable();
            $table->text('work_in_progress_Comment')->nullable();
            $table->text('completed_Comment')->nullable();
            $table->text('resolution_Comment')->nullable();
            $table->text('resol_Comment')->nullable();
            $table->text('no_analysis_Comment')->nullable();
            $table->text('analysis_Comment')->nullable();
            $table->text('pending_approval_Comment')->nullable();
            $table->text('reject_Comment')->nullable();
            $table->text('approve_Comment')->nullable();
            $table->text('cancel_Comment')->nullable();
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
        Schema::dropIfExists('client_inquiry_audit_trials');
    }
};

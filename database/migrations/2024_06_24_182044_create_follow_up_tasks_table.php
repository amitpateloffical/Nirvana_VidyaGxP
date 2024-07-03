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
        Schema::create('follow_up_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->string('initiator_id')->nullable();
            $table->date('initiation_date')->nullable();
            $table->string('division_id')->nullable();
            $table->string('record_number')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('division_code')->nullable();
            $table->longText('file_attachment')->nullable();
            $table->longText('execution_attachment')->nullable();
            $table->longText('verification_attachment')->nullable();
            $table->text('followup_Desc')->nullable();
            $table->text('submitted_by')->nullable();
            $table->text('submitted_on')->nullable();
            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('comment')->nullable();
            $table->text('cancellation_comment')->nullable();

            $table->date('parent_date')->nullable();
            $table->text('capa_taken')->nullable();
            $table->text('Parent_observation')->nullable();
            $table->text('parent_classification')->nullable();
            $table->date('tcd_date')->nullable();
            $table->text('execution_details')->nullable();

            $table->text('compliance_by')->nullable();
            $table->text('compliance_on')->nullable();
            $table->text('compliance_comment')->nullable();

            $table->text('open_state_by')->nullable();
            $table->text('open_state_on')->nullable();
            $table->text('open_state_comment')->nullable();

            $table->text('progress_by')->nullable();
            $table->text('progress_on')->nullable();
            $table->text('progress_comment')->nullable();

            $table->text('varification_by')->nullable();
            $table->text('varification_on')->nullable();
            $table->text('varification_comment')->nullable();

            $table->date('completion_date')->nullable();
            $table->text('delay_justification')->nullable();
            $table->text('varification_comments')->nullable();
            $table->text('cancellation_remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();


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
        Schema::dropIfExists('follow_up_tasks');
    }
};

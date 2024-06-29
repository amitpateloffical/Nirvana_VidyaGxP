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
        Schema::create('c_t_a_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('record_number')->nullable();
            $table->integer('record')->nullable();
            $table->string('division_code')->nullable();
            $table->string('division_id')->nullable();
            $table->string('form_type')->nullable();
            $table->string('initiation_date')->nullable();
            $table->string('originator_id')->nullable();
            $table->string('initiator_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();

            $table->string('short_description');
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('type')->nullable();
            $table->string('other_type')->nullable();
            $table->string('attached_files')->nullable();
            $table->longText('description')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state_district')->nullable();

            $table->integer('procedure_number')->nullable();
            $table->string('project_code')->nullable();
            $table->string('authority_type')->nullable();
            $table->string('authority')->nullable();
            $table->integer('registration_number')->nullable();
            $table->string('other_authority')->nullable();
            $table->integer('year')->nullable();
            $table->string('procedure_type')->nullable();
            $table->string('registration_status')->nullable();
            $table->string('outcome')->nullable();
            $table->string('trade_name')->nullable();
            $table->longText('comments')->nullable();
            $table->string('manufacturer')->nullable();
            $table->date('actual_submission_date')->nullable();
            $table->date('actual_rejection_date')->nullable();
            $table->date('actual_withdrawn_date')->nullable();
            $table->date('inquiry_date')->nullable();
            $table->date('planned_submission_date')->nullable();
            $table->date('planned_date_sent_to_affilate')->nullable();
            $table->date('effective_date')->nullable();
           
            $table->string('additional_assignees')->nullable();
            $table->string('additional_investigators')->nullable();
            $table->string('approvers')->nullable();
            $table->string('negotiation_team')->nullable();
            $table->string('trainer')->nullable();

            $table->longText('root_cause_description')->nullable();
            $table->longText('reason_for_non_approval')->nullable();
            $table->longText('reason_for_withdrawal')->nullable();
            $table->longText('justification_rationale')->nullable();
            $table->longText('meeting_minutes')->nullable();
            $table->longText('rejection_reason')->nullable();
            $table->longText('effectiveness_check_summary')->nullable();
            $table->longText('decisions')->nullable();
            $table->longText('summary')->nullable();
            $table->string('documents_affected')->nullable();
            $table->string('actual_time_spent')->nullable();
            $table->string('documents')->nullable();

            $table->text('submission_by')->nullable();
            $table->text('submission_on')->nullable();
            $table->text('submission_comment')->nullable();
            $table->text('approved_by')->nullable();
            $table->text('approved_on')->nullable();
            $table->text('approved_comment')->nullable();
            $table->text('withdraw_by')->nullable();
            $table->text('withdraw_on')->nullable();
            $table->text('withdraw_comment')->nullable();
            $table->text('finalize_dossier_by')->nullable();
            $table->text('finalize_dossier_on')->nullable();
            $table->text('finalize_dossier_comment')->nullable();
            $table->text('notification_by')->nullable();
            $table->text('notification_on')->nullable();
            $table->text('notification_comment')->nullable();
            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->text('cancelled_comment')->nullable();
            $table->text('not_approved_by')->nullable();
            $table->text('not_approved_on')->nullable();
            $table->text('not_approved_comment')->nullable();
            $table->text('approved_with_conditions_by')->nullable();
            $table->text('approved_with_conditions_on')->nullable();
            $table->text('approved_with_conditions_comment')->nullable();
            $table->text('conditions_to_fulfill_before_FPI_by')->nullable();
            $table->text('conditions_to_fulfill_before_FPI_on')->nullable();
            $table->text('conditions_to_fulfill_before_FPI_comment')->nullable();
            $table->text('more_comments_by')->nullable();
            $table->text('more_comments_on')->nullable();
            $table->text('more_comments')->nullable();
            $table->text('submit_response_by')->nullable();
            $table->text('submit_response_on')->nullable();
            $table->text('submit_response_comment')->nullable();
            $table->text('early_termination_by')->nullable();
            $table->text('early_termination_on')->nullable();
            $table->text('early_termination_comment')->nullable();
            $table->text('all_conditions_are_met_by')->nullable();
            $table->text('all_conditions_are_met_on')->nullable();
            $table->text('all_conditions_are_met_comment')->nullable();
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
        Schema::dropIfExists('c_t_a_submissions');
    }
};

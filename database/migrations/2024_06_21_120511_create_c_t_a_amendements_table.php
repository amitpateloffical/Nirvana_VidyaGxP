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
        Schema::create('c_t_a_amendements', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('type')->nullable();
            $table->string('other_type')->nullable();
            $table->longText('attached_files')->nullable();
            $table->longText('description')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            //Amendement Information
            $table->string('procedure_number')->nullable();
            $table->string('project_code')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('other_authority')->nullable();
            $table->string('authority_type')->nullable();
            $table->string('authority')->nullable();
            $table->string('year')->nullable();
            $table->string('registration_status')->nullable();
            $table->string('car_clouser_time_weight')->nullable();
            $table->string('outcome')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('estimated_man_hours')->nullable();
            $table->longText('comments')->nullable();

            //Product Information
            $table->string('manufaturer')->nullable();

            //Important Dates
            $table->string('actual_submission_date')->nullable();
            $table->string('actual_rejection_date')->nullable();
            $table->string('actual_withdrawn_date')->nullable();
            $table->string('inquiry_date')->nullable();
            $table->string('planned_submission_date')->nullable();
            $table->string('planned_date_sent_to_affiliate')->nullable();
            $table->string('effective_date')->nullable();

            //Person Involved
            $table->longText('additional_assignees')->nullable();
            $table->longText('additional_investigators')->nullable();
            $table->longText('approvers')->nullable();
            $table->longText('negotiation_team')->nullable();
            $table->string('trainer')->nullable();

            //Root Cause
            $table->longText('root_cause_description')->nullable();
            $table->longText('reason_for_non_approval')->nullable();
            $table->longText('reason_for_withdrawal')->nullable();
            $table->longText('justification_rationale')->nullable();
            $table->longText('meeting_minutes')->nullable();
            $table->longText('rejection_reason')->nullable();
            $table->longText('effectiveness_check_summary')->nullable();
            $table->longText('decision')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('documents_affected')->nullable();
            $table->longText('actual_time_spend')->nullable();
            $table->string('documents')->nullable();


            $table->string('status')->nullable();
            $table->string('stage')->nullable();


            $table->text('submit_by')->nullable();
            $table->text('submit_on')->nullable();
            $table->text('submit_comment')->nullable();

            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('cancel_comment')->nullable();

            $table->text('notification_by')->nullable();
            $table->text('notification_on')->nullable();
            $table->text('notification_comment')->nullable();

            $table->text('finalize_dossier_by')->nullable();
            $table->text('finalize_dossier_on')->nullable();
            $table->text('finalize_dossier_comment')->nullable();

            $table->text('withdraw_by')->nullable();
            $table->text('withdraw_on')->nullable();
            $table->text('withdraw_comment')->nullable();

            $table->text('approve_by')->nullable();
            $table->text('approve_on')->nullable();
            $table->text('approve_comment')->nullable();

            $table->text('not_approved_by')->nullable();
            $table->text('not_approved_on')->nullable();
            $table->text('not_approved_comment')->nullable();

            $table->text('management_withdraw_by')->nullable();
            $table->text('management_withdraw_on')->nullable();
            $table->text('management_withdraw_comment')->nullable();

            $table->text('management_approved_by')->nullable();
            $table->text('management_approved_on')->nullable();
            $table->text('management_approved_comment')->nullable();

            $table->text('no_conditions_by')->nullable();
            $table->text('no_conditions_on')->nullable();
            $table->text('no_conditions_comment')->nullable();

            $table->text('conditions_by')->nullable();
            $table->text('conditions_on')->nullable();
            $table->text('conditions_comment')->nullable();

            $table->text('submit_response_by')->nullable();
            $table->text('submit_response_on')->nullable();
            $table->text('submit_response_comment')->nullable();

            $table->text('all_conditions_by')->nullable();
            $table->text('all_conditions_on')->nullable();
            $table->text('all_conditions_comment')->nullable();

            $table->text('early_termination_by')->nullable();
            $table->text('early_termination_on')->nullable();
            $table->text('early_termination_comment')->nullable();

            $table->text('more_comments_by')->nullable();
            $table->text('more_comments_on')->nullable();
            $table->text('more_comments_comment')->nullable();

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
        Schema::dropIfExists('c_t_a_amendements');
    }
};

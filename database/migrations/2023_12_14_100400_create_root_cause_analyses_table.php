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
        Schema::create('root_cause_analyses', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->string('type')->nullable();
            $table->string('division_id')->nullable();
            $table->string('date_opened')->nullable();
            $table->string('severity_level')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->text('initiator_group_code')->nullable();
            $table->string('priority_level')->nullable();
            $table->longText('root_cause_description')->nullable();
            $table->longText('cft_comments_new')->nullable();
            $table->text('qa_comments_new')->nullable();
            $table->string('cft_attchament_new')->nullable();
            $table->string('Type1')->nullable();
            $table->string('investigators')->nullable();
            $table->string('department')->nullable();
            $table->longText('description')->nullable();
            $table->longText('comments')->nullable();
            $table->string('root_cause_initial_attachment')->nullable();
            $table->string('related_url')->nullable();
            $table->string('root_cause_methodology')->nullable();
            $table->string('measurement')->nullable();
            $table->string('materials')->nullable();
            $table->string('methods')->nullable();
            $table->string('environment')->nullable();
            $table->string('manpower')->nullable();
            $table->string('machine')->nullable();
            $table->string('problem_statement')->nullable();
            $table->string('why_problem_statement')->nullable();
            $table->string('why_1')->nullable();
            $table->string('why_2')->nullable();
            $table->string('why_3')->nullable();
            $table->string('why_4')->nullable();
            $table->string('Root_Cause_Category')->nullable();
            $table->string('Root_Cause_Sub_Category')->nullable();
            $table->string('Probability')->nullable();
            $table->string('Remarks')->nullable();
            $table->string('why_5')->nullable();
            $table->string('why_root_cause')->nullable();
            $table->string('what_will_be')->nullable();
            $table->string('what_will_not_be')->nullable();
            $table->string('what_rationable')->nullable();
            $table->string('where_will_be')->nullable();
            $table->string('where_will_not_be')->nullable();
            $table->string('where_rationable')->nullable();
            $table->string('when_will_be')->nullable();
            $table->string('when_will_not_be')->nullable();
            $table->string('when_rationable')->nullable();
            $table->string('coverage_will_be')->nullable();
            $table->string('coverage_will_not_be')->nullable();
            $table->string('coverage_rationable')->nullable();
            $table->string('who_will_be')->nullable();
            $table->string('who_will_not_be')->nullable();
            $table->string('who_rationable')->nullable();
            $table->longText('investigation_summary')->nullable();
            $table->integer('record')->nullable(); 
            $table->integer('initiator_id')->nullable(); 
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('initiator_Group')->nullable();
            $table->integer('assign_to')->nullable();
            $table->string('Sample_Types')->nullable();
            $table->text('initiated_through')->nullable();
            $table->text('initiated_if_other')->nullable();
            $table->text('risk_factor')->nullable();
            $table->text('risk_element')->nullable();
            $table->text('problem_cause')->nullable();
            $table->text('existing_risk_control')->nullable();
            $table->text('risk_control_measure')->nullable();
            $table->text('residual_severity')->nullable();
            $table->text('residual_probability')->nullable();
            $table->text('residual_detectability')->nullable();
            $table->text('residual_rpn')->nullable();
            $table->text('risk_acceptance2')->nullable();
            $table->text('mitigation_proposal')->nullable();
            $table->text('initial_severity')->nullable();
            $table->text('initial_detectability')->nullable();
            $table->text('initial_probability')->nullable();
            $table->text('initial_rpn')->nullable();
            $table->text('risk_acceptance')->nullable();
            $table->string('acknowledge_by')->nullable();
            $table->string('acknowledge_on')->nullable();
            $table->text('lab_inv_concl')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('qA_review_complete_by')->nullable();
            $table->string('qA_review_complete_on')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('report_result_by')->nullable();
            $table->string('submitted_on')->nullable();

            $table->string('hod_review_complete_by')->nullable();
            $table->string('hod_review_complete_on')->nullable();
            $table->string('responsible_person_update_by')->nullable();
            $table->string('responsible_person_update_on')->nullable();
            $table->string('initial_qa_review_by')->nullable();
            $table->string('initial_qa_review_on')->nullable();
            $table->string('cft_review_by')->nullable();
            $table->string('cft_review_on')->nullable();
            $table->string('qa_approve_review_by')->nullable();
            $table->string('qa_approve_review_on')->nullable();
            $table->string('hod_final_review_by')->nullable();
            $table->string('hod_final_review_on')->nullable();
            $table->string('child_closure_by')->nullable();
            $table->string('child_closure_on')->nullable();
            $table->string('qa_head_review_by')->nullable();
            $table->string('qa_head_review_on')->nullable();
            $table->string('close_done_by')->nullable();
            $table->string('close_done_on')->nullable();
            $table->string('re_open_addendum_by')->nullable();
            $table->string('re_open_addendum_on')->nullable();
            $table->string('addendum_approved_by')->nullable();
            $table->string('addendum_approved_on')->nullable();
            $table->string('under_addendum_execution_by')->nullable();
            $table->string('under_addendum_execution_on')->nullable();
            $table->string('under_addendum_verification_by')->nullable();
            $table->string('under_addendum_verification_on')->nullable();
            $table->string('closed_done_by')->nullable();
            $table->string('closed_done_on')->nullable();
            
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
        Schema::dropIfExists('root_cause_analyses');
    }
};

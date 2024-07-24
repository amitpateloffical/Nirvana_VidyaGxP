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
        Schema::create('contract_testing_lab_audits', function (Blueprint $table) {
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
            //$table->string('date_opened')->nullable();
            $table->string('audit_scheduled_for_the_year')->nullable();
            $table->string('ctl_audit_schedule_no')->nullable();
            $table->string('name_of_contract_testing_lab')->nullable();
            $table->longText('laboratory_address')->nullable();
            $table->longText('application_sites')->nullable();
            $table->string('new_existing_laboratory')->nullable();
            $table->string('date_of_last_audit')->nullable();
            $table->string('audit_due_on_month')->nullable();
            $table->string('tcd_for_audit_completion')->nullable();
            $table->string('audit_planing_to_be_done_on')->nullable();
            $table->string('audit_request_communicated_to')->nullable();
            $table->string('proposed_audit_start_date')->nullable();
            $table->string('proposed_audit_completion')->nullable();
            $table->string('name_of_lead_auditor')->nullable();
            $table->longText('name_of_co_auditor')->nullable();
            $table->string('external_auditor_if_applicable')->nullable();
            $table->string('propose_of_audit')->nullable();
            $table->longText('details_of_for_cause_audit')->nullable();
            $table->longText('other_information_gi')->nullable();
            $table->string('qa_approver')->nullable();
            $table->longText('proposal_attachments')->nullable();
            $table->longText('remarks')->nullable();

            //CTL Audit Preparation
            $table->longText('audit_agenda')->nullable();
            $table->string('audit_agenda_sent_on')->nullable();
            $table->string('audit_agenda_sent_to')->nullable();
            $table->longText('comments_remarks')->nullable();
            $table->string('communication_and_others')->nullable();

            //CTL Audit Execution
            $table->string('ctl_audit_started_on')->nullable();
            $table->string('ctl_audit_completed_on')->nullable();
            $table->longText('audit_execution_comments')->nullable();
            $table->string('audit_enclosures')->nullable();
            $table->longText('delay_justification_deviation')->nullable();

            //Audit Report Prep. & Approval
            $table->string('critical')->nullable();
            $table->string('major')->nullable();
            $table->string('minor')->nullable();
            $table->string('recomendations_comments')->nullable();
            $table->string('total')->nullable();
            $table->longText('corrective_actions_agreed')->nullable();
            $table->longText('executive_summary')->nullable();
            $table->longText('laboratory_acceptability')->nullable();
            $table->longText('remarks_conclusion')->nullable();
            $table->string('audit_report_ref_no')->nullable();
            $table->string('audit_report_signed_on')->nullable();
            $table->string('audit_report_approved_on')->nullable();
            $table->longText('ctl_audit_report')->nullable();
            $table->longText('delay_justification')->nullable();
            $table->string('supportive_documents')->nullable();

            //CTL Audit Report Issueance
            $table->string('ctl_audit_report_issue_date')->nullable();
            $table->string('audit_report_sent_to_ctl_on')->nullable();
            $table->string('audit_report_sent_to')->nullable();
            $table->string('report_acknowledged_on')->nullable();
            $table->string('tcd_for_receipt_of_compliance')->nullable();
            $table->longText('other_information')->nullable();
            $table->longText('file_attachments_if_any')->nullable();

            //Pending CTL Response
            $table->string('initial_response_received_on')->nullable();
            $table->string('final_response_received_on')->nullable();
            $table->string('response_received_within_tcd')->nullable();
            $table->longText('reason_for_delayed_response')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('ctl_response_report')->nullable();

            //CTL Audit Compliance
            $table->longText('response_review_comments')->nullable();
            $table->string('audit_task_required')->nullable();
            $table->string('audit_task_ref_no')->nullable();
            $table->string('follow_up_task_required')->nullable();
            $table->string('follow_up_task_ref_no')->nullable();
            $table->string('tcd_for_capa_implementation')->nullable();
            $table->string('response_review')->nullable();
            $table->longText('reason_for_disqualification')->nullable();
            $table->string('requalification_frequency')->nullable();
            $table->string('next_audit_due_date')->nullable();
            $table->longText('audit_closure_report')->nullable();
            $table->longText('response_file_attachments')->nullable();

            //CTL Audit Compliance Approval
            $table->longText('approval_comments')->nullable();
            $table->longText('approval_attachments')->nullable();

            //Audit Conclusion
            $table->string('all_observation_closed')->nullable();
            $table->longText('implementation_review_comments')->nullable();
            $table->string('implementation_completed_on')->nullable();
            $table->string('audit_closure_report_issued_on')->nullable();
            $table->longText('audit_closure_attachments')->nullable();

            $table->string('status')->nullable();
            $table->string('stage')->nullable();

            $table->text('submitted_by')->nullable();
            $table->text('submitted_on')->nullable();
            $table->text('submitted_comment')->nullable();

            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->text('cancelled_comment')->nullable();

            $table->text('preparation_completed_by')->nullable();
            $table->text('preparation_completed_on')->nullable();
            $table->text('preparation_completed_comment')->nullable();

            $table->text('open_state_by')->nullable();
            $table->text('open_state_on')->nullable();
            $table->text('open_state_comment')->nullable();

            $table->text('completed_by')->nullable();
            $table->text('completed_on')->nullable();
            $table->text('completed_comment')->nullable();

            $table->text('audit_preparation_by')->nullable();
            $table->text('audit_preparation_on')->nullable();
            $table->text('audit_preparation_comment')->nullable();

            $table->text('report_completed_by')->nullable();
            $table->text('report_completed_on')->nullable();
            $table->text('report_completed_comment')->nullable();

            $table->text('audit_executed_by')->nullable();
            $table->text('audit_executed_on')->nullable();
            $table->text('audit_executed_comment')->nullable();

            $table->text('report_issued_by')->nullable();
            $table->text('report_issued_on')->nullable();
            $table->text('report_issued_comment')->nullable();

            $table->text('report_prepared_by')->nullable();
            $table->text('report_prepared_on')->nullable();
            $table->text('report_prepared_comment')->nullable();

            $table->text('response_received_by')->nullable();
            $table->text('response_received_on')->nullable();
            $table->text('response_received_comment')->nullable();

            $table->text('acceptance_completed_by')->nullable();
            $table->text('acceptance_completed_on')->nullable();
            $table->text('acceptance_completed_comment')->nullable();

            $table->text('approval_completed_by')->nullable();
            $table->text('approval_completed_on')->nullable();
            $table->text('approval_completed_comment')->nullable();

            $table->text('compliance_accepted_by')->nullable();
            $table->text('compliance_accepted_on')->nullable();
            $table->text('compliance_accepted_comment')->nullable();

            $table->text('monitoring_completed_by')->nullable();
            $table->text('monitoring_completed_on')->nullable();
            $table->text('monitoring_completed_comment')->nullable();

            $table->text('conclusion_completed_by')->nullable();
            $table->text('conclusion_completed_on')->nullable();
            $table->text('conclusion_completed_comment')->nullable();

            $table->text('audit_comp_accepted_by')->nullable();
            $table->text('audit_comp_accepted_on')->nullable();
            $table->text('audit_comp_accepted_comment')->nullable();


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
        Schema::dropIfExists('contract_testing_lab_audits');
    }
};

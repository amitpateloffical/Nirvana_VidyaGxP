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
        Schema::create('country_sub_data', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->text('form_type_new')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('intiation_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->text('assigned_to')->nullable();
            $table->text('due_date')->nullable();
            $table->integer('record')->nullable();
            $table->text('type')->nullable();
            $table->text('other_type')->nullable();
            $table->text('attached_files')->nullable();
            $table->text('related_urls')->nullable();
            $table->longText('descriptions')->nullable();
            $table->text('zone')->nullable();
            $table->text('country')->nullable();
            $table->text('city')->nullable();
            $table->text('state_district')->nullable();
            $table->text('manufacturer')->nullable();
            $table->text('number_id')->nullable();
            $table->text('project_code')->nullable();
            $table->text('authority_type')->nullable();
            $table->text('authority')->nullable();
            $table->text('priority_level')->nullable();
            $table->text('other_authority')->nullable();
            $table->text('approval_status')->nullable();
            $table->text('managed_by_company')->nullable();
            $table->text('marketing_status')->nullable();
            $table->text('therapeutic_area')->nullable();
            $table->text('end_of_trial_date_status')->nullable();
            $table->text('protocol_type')->nullable();
            $table->text('registration_status')->nullable();
            $table->text('unblinded_SUSAR_to_CEC')->nullable();
            $table->text('trade_name')->nullable();
            $table->text('dosage_form')->nullable();
            $table->text('photocure_trade_name')->nullable();
            $table->text('currency')->nullable();
            $table->text('attacehed_payments')->nullable();
            $table->text('follow_up_documents')->nullable();
            $table->text('hospitals')->nullable();
            $table->text('vendors')->nullable();
            $table->text('INN')->nullable();
            $table->text('route_of_administration')->nullable();
            $table->text('first_IB_version')->nullable();
            $table->text('first_protocol_version')->nullable();
            $table->text('eudraCT_number')->nullable();
            $table->text('budget')->nullable();
            $table->text('phase_of_study')->nullable();
            $table->text('related_clinical_trials')->nullable();
            $table->text('data_safety_notes')->nullable();
            $table->text('comments')->nullable();
            $table->text('annual_IB_update_date_due')->nullable();
            $table->text('date_of_first_IB')->nullable();
            $table->text('date_of_first_protocol')->nullable();
            $table->text('date_safety_report')->nullable();
            $table->text('date_trial_active')->nullable();
            $table->text('end_of_study_report_date')->nullable();
            $table->text('end_of_study_synopsis_date')->nullable();
            $table->text('end_of_trial_date')->nullable();
            $table->text('last_visit')->nullable();
            $table->text('next_visit')->nullable();
            $table->text('ethics_commitee_approval')->nullable();
            $table->text('safety_impact_risk')->nullable();
            $table->text('CROM')->nullable();
            $table->text('lead_investigator')->nullable();
            $table->integer('assign_to')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('additional_investigators')->nullable();
            $table->string('clinical_events_committee')->nullable();
            $table->string('clinical_research_team')->nullable();
            $table->string('data_safety_monitoring_board')->nullable();
            $table->string('distribution_list')->nullable();
            $table->longText('comment')->nullable();
            $table->string('activate_by')->nullable();
            $table->string('activate_on')->nullable();
            $table->string('activate_comment')->nullable();
            $table->string('close_by')->nullable();
            $table->string('close_on')->nullable();
            $table->string('close_comment')->nullable();
            $table->string('cancel_by')->nullable();
            $table->string('cancel_on')->nullable();
            $table->string('cancel_comment')->nullable();
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
        Schema::dropIfExists('country_sub_data');
    }
};

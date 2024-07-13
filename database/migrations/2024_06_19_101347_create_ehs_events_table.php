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
        Schema::create('ehs_events', function (Blueprint $table) {
            $table->id();
            $table->string('initiator_id')->nullable();
            $table->integer('record')->nullable();
            $table->string('intiation_date')->nullable();

            $table->string('assigned_to')->nullable();
            $table->string('date_due')->nullable();
            $table->string('short_description')->nullable();
            // $table->date('date_of_initiation')->nullable();
            // $table->string('short_description')->nullable();
            $table->string('event_type')->nullable();

            $table->string('incident_sub_type')->nullable();
            
            $table->string('date_occurred')->nullable();
            $table->string('time_occurred')->nullable();
            $table->string('date_of_reporting')->nullable();
            $table->string('reporter')->nullable();

            $table->longText('file_attachment')->nullable();
            
            $table->string('similar_incidents')->nullable();
            $table->longText('description')->nullable();
            $table->longText('immediate_actions')->nullable();
            
            // --------------------CCform2 -------------------------------
            $table->string('accident_type')->nullable();
            $table->string('osha_reportable')->nullable();
            $table->string('first_lost_work_date')->nullable();
            $table->string('last_lost_work_date')->nullable();
            $table->string('first_restricted_work_date')->nullable();
            $table->string('last_restricted_work_date')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('litigation')->nullable();
            $table->string('department')->nullable();
            $table->longText('employee_involved')->nullable();
            $table->longText('involved_contractor')->nullable();
            $table->longText('attorneys_involved')->nullable();
            $table->text('lead_investigator')->nullable();
            $table->text('line_operator')->nullable();
            $table->text('detail_info_reporter')->nullable();
            $table->text('supervisor')->nullable();
            $table->text('unsafe_situation')->nullable();
            $table->text('safeguarding_measure_taken')->nullable();
            $table->text('enviromental_category')->nullable();
            $table->text('Special_Weather_Conditions')->nullable();
            $table->text('source_Of_release_or_spill')->nullable();
            $table->text('environment_evacuation_ordered')->nullable();
            $table->text('date_simples_taken')->nullable();
            $table->text('agency_notified')->nullable();
            $table->text('fire_category')->nullable();
            $table->text('fire_evacuation_ordered')->nullable();
            $table->text('combat_by')->nullable();
            $table->text('fire_fighting_equipment_used')->nullable();
            $table->text('zone')->nullable();
            $table->text('country')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('site_name')->nullable();
            $table->text('building')->nullable();
            $table->text('floor')->nullable();
            $table->text('room')->nullable();
            $table->text('location')->nullable();

            // --------------------CCform3 -------------------------------
            $table->text('victim')->nullable();
            $table->text('medical_treatment')->nullable();
            $table->text('victim_position')->nullable();
            $table->text('victim_realation')->nullable();
            $table->text('hospitalization')->nullable();
            $table->text('hospital_name')->nullable();
            $table->text('date_of_treatment')->nullable();
            $table->text('victim_treated_by')->nullable();
            $table->longText('medical_treatment_discription')->nullable();
            $table->text('injury_type')->nullable();
            $table->text('number_of_injuries')->nullable();
            $table->text('type_of_illness')->nullable();
            $table->text('permanent_disability')->nullable();
            $table->text('damage_category')->nullable();
            $table->text('related_equipment')->nullable();
            $table->text('estimated_amount')->nullable();
            // $table->string('currency')->nullable();
            $table->string('insurance_company_involved')->nullable();
            $table->string('denied_by_insurance')->nullable();
            $table->longText('damage_details')->nullable();

            // --------------------CCform4 -------------------------------
            $table->string('actual_amount')->nullable();
            $table->string('currency')->nullable();
            $table->longText('investigation_summary')->nullable();
            $table->longText('conclusion')->nullable();

            // --------------------CCform5 -------------------------------
            $table->text('safety_impact_probability')->nullable();
            $table->text('safety_impact_severity')->nullable();
            $table->text('legal_impact_probability')->nullable();
            $table->text('legal_impact_severity')->nullable();
            $table->text('business_impact_probability')->nullable();
            $table->text('business_impact_severity')->nullable();
            $table->text('revenue_impact_probability')->nullable();
            $table->text('revenue_impact_severity')->nullable();
            $table->text('brand_impact_probability')->nullable();
            $table->text('brand_impact_severity')->nullable();
            $table->text('safety_impact_risk')->nullable();
            $table->text('legal_impact_risk')->nullable();
            $table->text('business_impact_risk')->nullable();
            $table->text('revenue_impact_risk')->nullable();
            $table->text('brand_impact_risk')->nullable();
            $table->text('impact')->nullable();
            $table->longText('impact_analysis')->nullable();
            $table->longText('recommended_action')->nullable();
            $table->longText('comments')->nullable();
            $table->text('direct_cause')->nullable();
            $table->string('root_cause_safeguarding_measure_taken')->nullable();
            $table->string('root_cause_methodlogy')->nullable();
            $table->longText('root_cause_description')->nullable();
            $table->text('severity_rate')->nullable();
            $table->text('occurrence')->nullable();
            $table->text('detection')->nullable();
            $table->text('rpn')->nullable();
            $table->longText('risk_analysis')->nullable();
            $table->text('criticality')->nullable();
            $table->text('inform_local_authority')->nullable();
            $table->text('authority_type')->nullable();
            $table->text('authority_notified')->nullable();
            $table->text('other_authority')->nullable();

            $table->string('stage')->nullable();
            $table->string('status')->nullable();

            //------- pending colomn  ---------------------------------------
            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('submitted_comment')->nullable();

            $table->string('review_complete_by')->nullable();
            $table->string('review_complete_on')->nullable();
            $table->string('review_complete_comment')->nullable();
            
            $table->string('complete_investigation_by')->nullable();
            $table->string('complete_investigation_on')->nullable();
            $table->string('complete_investigation_comment')->nullable();
            
            $table->string('analysis_complete_by')->nullable();
            $table->string('analysis_complete_on')->nullable();
            $table->string('analysis_complete_comment')->nullable();

            $table->string('propose_plan_by')->nullable();
            $table->string('propose_plan_on')->nullable();
            $table->string('propose_plan_comment')->nullable();
            
            $table->string('approve_plan_by')->nullable();
            $table->string('approve_plan_on')->nullable();
            $table->string('approve_plan_comment')->nullable();
            
            $table->string('all_capa_closed_by')->nullable();
            $table->string('all_capa_closed_on')->nullable();
            $table->string('all_capa_closed_comment')->nullable();

             
            $table->string('cancel_by')->nullable();
            $table->string('cancel_on')->nullable();
            $table->string('cancel_comment')->nullable();

            $table->string('reject_by')->nullable();
            $table->string('reject_on')->nullable();
            $table->string('reject_comment')->nullable();

            $table->string('more_info_required_by')->nullable();
            $table->string('more_info_required_on')->nullable();
            $table->string('more_info_required_comment')->nullable();

            $table->string('more_investig_required_by')->nullable();
            $table->string('more_investig_required_on')->nullable();
            $table->string('more_investig_required_comment')->nullable();

            $table->string('comment')->nullable();

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
        Schema::dropIfExists('ehs_events');
    }
};

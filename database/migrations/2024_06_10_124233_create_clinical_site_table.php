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
        
        Schema::create('clinical_sites', function (Blueprint $table) {
            $table->id();
            $table->string('record')->nullable();
            $table->string('division_code')->nullable();
            $table->string('initiator')->nullable();
            $table->date('initiation_date')->nullable();

            $table->text('short_description')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('stage')->nullable();
            $table->longText('status')->nullable();

            $table->longText('assign_to')->nullable();
            $table->longText('type')->nullable();
            $table->longText('site_name')->nullable();
            $table->longText('source_documents')->nullable();
            $table->longText('sponsor')->nullable();
            $table->longText('description')->nullable();
            $table->longText('attached_files')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('version_no')->nullable();
            $table->longText('admission_criteria')->nullable();
            $table->longText('clinical_significance')->nullable();
            $table->longText('trade_name')->nullable();
            $table->longText('tracking_number')->nullable();
            $table->longText('phase_of_study')->nullable();
            $table->longText('parent_type')->nullable();
            $table->longText('par_oth_type')->nullable();
            $table->longText('zone')->nullable();
            $table->longText('country')->nullable();
            $table->longText('city')->nullable();
            $table->longText('state_district')->nullable();
            $table->longText('sel_site_name')->nullable();
            $table->longText('building')->nullable();
            $table->longText('floor')->nullable();
            $table->longText('room')->nullable();
            $table->longText('site_name_sai')->nullable();
            $table->longText('pharmacy')->nullable();
            $table->longText('site_no')->nullable();
            $table->longText('site_status')->nullable();
            $table->date('acti_date')->nullable();
            $table->date('date_final_report')->nullable();
            $table->date('ini_irb_app_date')->nullable();
            $table->date('imp_site_date')->nullable();
            $table->longText('lab_de_name')->nullable();
            $table->longText('moni_per_by')->nullable();
            $table->longText('drop_withdrawn')->nullable();
            $table->longText('enrolled')->nullable();
            $table->longText('follow_up')->nullable();
            $table->longText('planned')->nullable();
            $table->longText('screened')->nullable();
            $table->longText('project_annual_mv')->nullable();
            $table->date('schedule_start_date')->nullable();
            $table->date('schedule_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->longText('lab_name')->nullable();
            $table->longText('monitoring_per_by_si')->nullable();
            $table->longText('control_group')->nullable();
            $table->longText('consent_form')->nullable();
            $table->longText('budget')->nullable();
            $table->longText('proj_sites_si')->nullable();
            $table->longText('proj_subject_si')->nullable();
            $table->longText('auto_calculation')->nullable();
            $table->longText('currency_si')->nullable();
            $table->longText('attached_payments')->nullable();
            $table->longText('cra')->nullable();
            $table->longText('lead_investigator')->nullable();
            $table->longText('reserve_team_associate')->nullable();
            $table->longText('additional_investigators')->nullable();
            $table->longText('clinical_research_coordinator')->nullable();
            $table->longText('pharmacist')->nullable();
            $table->longText('comments_si')->nullable();
            $table->longText('budget_ut')->nullable();
            $table->longText('currency_ut')->nullable();
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
        Schema::dropIfExists('clinical_site');
    }
};

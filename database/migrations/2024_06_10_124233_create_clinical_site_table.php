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
            $table->string('stage')->nullable();
            $table->string('status')->nullable();

            $table->string('assign_to')->nullable();
            $table->string('type')->nullable();
            $table->string('site_name')->nullable();
            $table->string('source_documents')->nullable();
            $table->string('sponsor')->nullable();
            $table->text('description');
            $table->string('attached_files')->nullable();
            $table->text('comments')->nullable();
            $table->string('version_no')->nullable();
            $table->string('admission_criteria')->nullable();
            $table->string('clinical_significance')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('phase_of_study')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('par_oth_type')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state_district')->nullable();
            $table->string('sel_site_name')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->string('site_name_sai')->nullable();
            $table->string('pharmacy')->nullable();
            $table->string('site_no')->nullable();
            $table->string('site_status')->nullable();
            $table->date('acti_date')->nullable();
            $table->date('date_final_report')->nullable();
            $table->date('ini_irb_app_date')->nullable();
            $table->date('imp_site_date')->nullable();
            $table->string('lab_de_name')->nullable();
            $table->string('moni_per_by')->nullable();
            $table->integer('drop_withdrawn')->nullable();
            $table->integer('enrolled')->nullable();
            $table->integer('follow_up')->nullable();
            $table->integer('planned')->nullable();
            $table->integer('screened')->nullable();
            $table->integer('project_annual_mv')->nullable();
            $table->date('schedule_start_date')->nullable();
            $table->date('schedule_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->string('lab_name')->nullable();
            $table->string('monitoring_per_by_si')->nullable();
            $table->string('control_group')->nullable();
            $table->string('consent_form')->nullable();
            $table->decimal('budget', 15, 2)->nullable();
            $table->string('proj_sites_si')->nullable();
            $table->string('proj_subject_si')->nullable();
            $table->boolean('auto_calculation')->default(false);
            $table->string('currency_si')->nullable();
            $table->string('attached_payments')->nullable();
            $table->string('cra')->nullable();
            $table->string('lead_investigator')->nullable();
            $table->string('reserve_team_associate')->nullable();
            $table->string('additional_investigators')->nullable();
            $table->string('clinical_research_coordinator')->nullable();
            $table->string('pharmacist')->nullable();
            $table->text('comments_si')->nullable();
            $table->decimal('budget_ut', 15, 2)->nullable();
            $table->string('currency_ut')->nullable();
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

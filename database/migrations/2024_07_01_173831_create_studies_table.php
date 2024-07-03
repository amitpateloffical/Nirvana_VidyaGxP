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
        Schema::create('studies', function (Blueprint $table) {
            $table->id();
            $table->string('initiator_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->string('division_id')->nullable();
            $table->string('record')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('assigned_to')->nullable();
            $table->string('divison_code')->nullable();
            $table->date('due_date')->nullable();
            $table->text('study_num')->nullable();
            $table->text('sponsor')->nullable();
            $table->text('type1')->nullable();
            $table->text('version')->nullable();
            $table->text('type')->nullable();
            $table->longText('file_attach')->nullable();
            $table->text('related_urls')->nullable();
            $table->text('source_documents')->nullable();
            $table->text('comments')->nullable();
            $table->text('budget')->nullable();
            $table->text('total_study')->nullable();
            $table->longText('currency')->nullable();
            $table->text('parent_name')->nullable();
            $table->text('audit-agenda-grid')->nullable();
            $table->text('projected')->nullable();
            $table->text('total_sites')->nullable();
            $table->text('subjects')->nullable();
            $table->text('total_subjects')->nullable();

            $table->text('departments')->nullable();
            $table->text('protocol')->nullable();
            $table->text('protocol_activities')->nullable();
            $table->text('counties')->nullable();
            $table->text('agency')->nullable();
            $table->text('eudraCT')->nullable();
            $table->longText('regulatory')->nullable();
            $table->text('global_regulatory')->nullable();
            $table->text('protocol_name')->nullable();
            $table->text('comment1')->nullable();
            $table->text('case_report')->nullable();
            $table->text('case_number')->nullable();
            $table->text('background')->nullable();
            $table->text('objectives')->nullable();
            $table->text('pediatric')->nullable();
            $table->text('partner')->nullable();
            $table->text('study_hypothesis')->nullable();
            $table->text('biomarker')->nullable();
            $table->text('blinding')->nullable();
            $table->longText('consent_form')->nullable();
            $table->text('ctx')->nullable();
            $table->text('crossover_trial')->nullable();
            $table->text('comperative')->nullable();
            $table->text('comperator')->nullable();
            $table->text('version_no')->nullable();
            $table->text('study_manual')->nullable();
            $table->longText('global_version')->nullable();
            $table->text('version_approved')->nullable();
            $table->text('hospitals')->nullable();
            $table->text('venders')->nullable();
            $table->text('audit_agenda_grid1')->nullable();
            $table->text('interim_study_report')->nullable();
            $table->text('result_synopsis')->nullable();
            $table->longText('study_final_report')->nullable();

            $table->text('surrogate')->nullable();
            $table->text('special_handling')->nullable();
            $table->longText('minimum_time')->nullable();
            $table->text('washout_period')->nullable();
            $table->longText('admission_criteria')->nullable();
            $table->text('clinical_significance')->nullable();
            $table->text('audit_agenda_grid2')->nullable();
            $table->longText('audit_agenda_grid3')->nullable();
//------------------------------------------------------------------------//
            $table->date('start_Inclusion')->nullable();
            $table->date('end_Inclusion')->nullable();
            $table->date('scheduled_start_date')->nullable();
            $table->date('scheduled_end_date')->nullable();
            $table->date('actual_start')->nullable();
            $table->date('actual_end')->nullable();
            $table->date('date_trial_active')->nullable();
            $table->date('end_date_trial_active')->nullable();
            $table->date('protocol_date')->nullable();
            $table->date('dateofcurrent')->nullable();
            $table->date('irb_approval')->nullable();
            $table->date('international_birth')->nullable();
            $table->date('ethics')->nullable();
            $table->date('manual_version')->nullable();
            $table->date('first_subject')->nullable();
            $table->date('last_subject')->nullable();
            $table->date('signatures')->nullable();

            $table->text('lead')->nullable();
            $table->text('project_manager')->nullable();
            $table->text('crom')->nullable();
            $table->text('sponsors')->nullable();
            $table->text('additional_investigators')->nullable();
            $table->text('manager')->nullable();
            $table->text('clinical_research')->nullable();
            $table->text('data_safety')->nullable();
            $table->text('clinical_event')->nullable();
            $table->text('irb')->nullable();
            $table->text('statisticlans')->nullable();
            $table->text('biostatisticlans')->nullable();

            $table->text('status')->nullable();
            $table->text('stage')->nullable();

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
        Schema::dropIfExists('studies');
    }
};

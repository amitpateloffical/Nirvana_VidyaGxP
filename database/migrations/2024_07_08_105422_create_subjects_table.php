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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            
            $table->integer('initiator_id')->nullable();
            $table->integer('record')->nullable();
            $table->string('division_id')->nullable();
            $table->string('division_code')->nullable();
            $table->date('initiation_date')->nullable();
            $table->text('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('phase_of_study')->nullable();
            $table->string('study_Num')->nullable();
            $table->string('related_urls')->nullable();
            $table->longText('Description_Batch')->nullable();
            $table->string('actual_cost')->nullable();
            $table->string('currency')->nullable();
            $table->longText('Comments_Batch')->nullable();
            $table->string('subject_name')->nullable();
            $table->date('subject_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('race')->nullable();
            $table->string('screened_successfully')->nullable();
            $table->string('discontinuation')->nullable();
            $table->longText('Disposition_Batch')->nullable();
            $table->string('treatment_consent')->nullable();
            $table->string('screening_consent')->nullable();
            $table->string('exception_no')->nullable();
            $table->string('signed_consent')->nullable();
            $table->string('time_point')->nullable();
            $table->longText('family_history')->nullable();
            $table->longText('Baseline_assessment')->nullable();
            $table->string('representive')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('site')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->date('consent_form')->nullable();
            $table->date('date_granted')->nullable();
            $table->date('system_start')->nullable();
            $table->date('consent_form_date')->nullable();
            $table->date('first_treatment')->nullable();
            $table->date('date_requested')->nullable();
            $table->date('date_screened')->nullable();
            $table->date('date_signed_treatment')->nullable();
            $table->date('date_effective_from')->nullable();
            $table->date('date_effective_to')->nullable();
            $table->date('last_active')->nullable();
            $table->date('last_followup')->nullable();
            $table->longText('file_attach')->nullable();
            $table->longText('document_attach')->nullable();
            
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
        Schema::dropIfExists('subjects');
    }
};
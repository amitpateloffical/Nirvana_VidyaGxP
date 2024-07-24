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
            $table->string('record_number')->nullable();
            $table->string('division_code')->nullable();
            $table->string('division_id')->nullable();
            $table->string('initiator')->nullable();
            $table->date('initiation_date')->nullable();
            $table->string('short_description', 255)->nullable();
            $table->longText('phase_of_study')->nullable();
            $table->string('study_num')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->json('attached_files')->nullable();
            $table->string('related_urls')->nullable();
            $table->text('description')->nullable();
            $table->decimal('actual_cost', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->longText('comments')->nullable();
            $table->json('source_documents')->nullable();
            $table->string('subject_name')->nullable();
            $table->date('subject_dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('race')->nullable();
            $table->string('screened_successfully')->nullable();
            $table->string('reason_discontinuation')->nullable();
            $table->string('treatment_consent_version')->nullable();
            $table->string('screening_consent_version')->nullable();
            $table->string('exception_number')->nullable();
            $table->string('signed_consent_form')->nullable();
            $table->string('time_point')->nullable();
            $table->longText('family_history')->nullable();
            $table->longText('baseline_assessment')->nullable();
            $table->string('representative')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state_district')->nullable();
            $table->string('site_name')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->date('consent_form_signed_on')->nullable();
            $table->date('date_granted')->nullable();
            $table->date('system_start_date')->nullable();
            $table->date('consent_form_signed_date')->nullable();
            $table->date('date_first_treatment')->nullable();
            $table->date('date_requested')->nullable();
            $table->date('date_screened')->nullable();
            $table->date('date_signed_treatment_consent')->nullable();
            $table->date('effective_from_date')->nullable();
            $table->date('effective_to_date')->nullable();
            $table->date('last_active_treatment_date')->nullable();
            $table->date('last_followup_date')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('form_type')->nullable();

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

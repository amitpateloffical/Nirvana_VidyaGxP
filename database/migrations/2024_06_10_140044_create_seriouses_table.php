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
        Schema::create('seriouses', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->longText('initiator_id')->nullable();
            $table->string('date_of_initiation')->nullable();
            $table->string('short_description')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('type')->nullable();
            $table->string('file_attach')->nullable();
            $table->string('description')->nullable();
            $table->string('comments')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('site_name')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->string('number')->nullable();
            $table->string('project_code')->nullable();
            $table->string('primary_sae')->nullable();
            $table->string('Sae_number')->nullable();
            $table->string('severity_rate')->nullable();
            $table->string('occurance')->nullable();
            $table->string('detection')->nullable();
            $table->string('RPN')->nullable();
            $table->string('protocol_type')->nullable();
            $table->string('reportability')->nullable();
            $table->string('crom')->nullable();
            $table->string('lead_investigator')->nullable();
            $table->string('follow_up_information')->nullable();
            $table->string('route_of_administration')->nullable();
            $table->string('carbon_copy_list')->nullable();
            $table->string('comments2')->nullable();
            $table->string('primary_sae2')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('awareness_date')->nullable();
            $table->string('crom_saftey_report_app_on')->nullable();
            $table->string('date_crom_concurred')->nullable();
            $table->string('date_draft_sr_sent')->nullable();
            $table->string('date_mm_concurred')->nullable();
            $table->string('date_of_event_resolution')->nullable();
            $table->string('date_pi_concurred')->nullable();
            $table->string('date_recieved')->nullable();
            $table->string('date_safety_assessment_sent')->nullable();
            $table->string('date_sent_to_ra')->nullable();
            $table->string('date_sent_to_sites')->nullable();
            $table->string('sae_onset_date')->nullable();
            $table->string('mm_saftey_report_approved_on')->nullable();
            $table->string('pi_saftey_report_approved_on')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
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
        Schema::dropIfExists('seriouses');
    }
};

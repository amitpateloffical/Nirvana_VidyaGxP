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
        Schema::create('psur', function (Blueprint $table) {
            $table->id();
            $table->string('record')->nullable();
            $table->string('initiator')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->longText('documents')->nullable();
            $table->string('file_attachment')->nullable();
            $table->string('type_new')->nullable();
            $table->string('year')->nullable();
            $table->string('actual_start_date')->nullable();
            $table->string('actual_end_date')->nullable();
            $table->string('authority_type')->nullable();
            $table->string('authority')->nullable();
            $table->longText('introduction')->nullable();
            $table->string('related_records')->nullable();
            $table->longText('world_ma_status')->nullable();
            $table->longText('ra_actions_taken')->nullable();
            $table->longText('mah_actions_taken')->nullable();
 //Tab Change----------------------------------------------------------------
            $table->longText('changes_to_safety_information')->nullable();
            $table->longText('patient_exposure')->nullable();
            $table->longText('analysis_of_individual_case')->nullable();
            $table->longText('newly_analyzed_studies')->nullable();
            $table->longText('target_and_new_safety_studies')->nullable();
            $table->longText('publish_safety_studies')->nullable();
            $table->longText('efficiency_related_info')->nullable();
            $table->longText('late_breaking_information')->nullable();
            $table->longText('overall_safety_evaluation')->nullable();
            $table->longText('conclusion')->nullable();
//Tab Change----------------------------------------------------------------

            $table->string('root_parent_manufaturer')->nullable();
            $table->string('root_parent_product_type')->nullable();
            $table->string('root_parent_trade_name')->nullable();
            $table->string('international_birth_date')->nullable();
            $table->string('root_parent_api')->nullable();
            $table->string('root_parent_product_strength')->nullable();
            $table->string('route_of_administration')->nullable();
            $table->string('root_parent_product_dosage_form')->nullable();
            $table->string('therapeutic_Area')->nullable();

//Tab Change----------------------------------------------------------------
            $table->string('registration_status')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('planned_submission_date')->nullable();
            $table->string('actual_submission_date')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('procedure_type')->nullable();
            $table->string('procedure_number')->nullable();
            $table->string('reference_member_state')->nullable();
            $table->string('renewal_rule')->nullable();
            $table->string('concerned_member_states')->nullable();
            //Tab Change----------------------------------------------------------------

            $table->string('started_by')->nullable();
            $table->string('started_on')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_on')->nullable();
            $table->longText('withdrawn_by')->nullable();
            $table->string('withdrawn_on')->nullable();

            $table->string('status')->nullable();
            $table->string('stage')->nullable();


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
        Schema::dropIfExists('psur');
    }
};

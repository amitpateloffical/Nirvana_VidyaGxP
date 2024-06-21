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
        Schema::create('gcp_studies', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('short_description_gi')->nullable();
            $table->string('assign_to_gi')->nullable();
            $table->string('due_date')->nullable();
            $table->string('department_gi')->nullable();
            $table->string('study_number_sd')->nullable();
            $table->string('name_of_product_sd')->nullable();
            $table->string('study_title_sd')->nullable();
            $table->string('study_type_sd')->nullable();
            $table->string('study_protocol_number_sd')->nullable();
            $table->longText('description_sd')->nullable();
            $table->longText('comments_sd')->nullable();
            $table->string('related_studies_ai')->nullable();
            $table->string('document_link_ai')->nullable();
            $table->string('appendiceis_ai')->nullable();
            $table->string('related_audits_ai')->nullable();

            //GCP Details
            $table->string('generic_product_name_gcpd')->nullable();
            $table->string('indication_name_gcpd')->nullable();
            $table->string('clinical_study_manager_gcpd')->nullable();
            $table->string('clinical_expert_gcpd')->nullable();
            $table->string('phase_level_gcpd')->nullable();
            $table->string('therapeutic_area_gcpd')->nullable();
            $table->string('ind_no_gcpd')->nullable();
            $table->string('number_of_centers_gcpd')->nullable();
            $table->string('of_subjects_gcpd')->nullable();

            //Important Date
            $table->string('initiation_date_i')->nullable();
            $table->string('study_start_date')->nullable();
            $table->string('study_end_date')->nullable();
            $table->string('study_protocol')->nullable();
            $table->string('first_subject_in')->nullable();
            $table->string('last_subject_out')->nullable();
            $table->string('databse_lock')->nullable();
            $table->string('integrated_ctr')->nullable();

            $table->string('status')->nullable();
            $table->integer('stage')->nullable();

            $table->text('initiate_by')->nullable();
            $table->text('initiate_on')->nullable();
            $table->text('initiate_comment')->nullable();

            $table->text('initiate_cancel_by')->nullable();
            $table->text('initiate_cancel_on')->nullable();
            $table->text('initiate_cancel_comment')->nullable();

            $table->text('study_complete_by')->nullable();
            $table->text('study_complete_on')->nullable();
            $table->text('study_complete_comment')->nullable();


            $table->text('person_cancel_by')->nullable();
            $table->text('person_cancel_on')->nullable();
            $table->text('person_cancel_comment')->nullable();

            $table->text('issue_report_by')->nullable();
            $table->text('issue_report_on')->nullable();
            $table->text('issue_report_comment')->nullable();

            $table->text('no_report_require_by')->nullable();
            $table->text('no_report_require_on')->nullable();
            $table->text('no_report_require_comment')->nullable();

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
        Schema::dropIfExists('gcp_studies');
    }
};

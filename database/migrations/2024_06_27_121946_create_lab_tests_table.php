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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->string('initiator_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->string('division_id')->nullable();
            $table->string('record')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();
            $table->string('form_type')->nullable();
            $table->string('product')->nullable();
            $table->string('due_date')->nullable();

            $table->string('priority_level')->nullable();
            $table->string('type_of_product')->nullable();
            $table->string('internal_product_test_info')->nullable();
            $table->string('comments')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('comment')->nullable();
            $table->string('cancel_by')->nullable();
            $table->string('cancel_on')->nullable();
            $table->string('cancel_comment')->nullable();
            $table->string('internal_product_test_submitted_by')->nullable();
            $table->string('internal_product_test_submitted_on')->nullable();
            $table->string('comment_internal_product')->nullable();
            $table->string('demand_product_improvement_rejected_by')->nullable();
            $table->string('demand_product_improvement_rejected_on')->nullable();
            $table->string('demand_improvement_comment')->nullable();
            $table->string('not_ok_cancel_by')->nullable();
            $table->string('not_ok_cancel_on')->nullable();
            $table->string('not_ok_cancel_comment')->nullable();
            $table->string('ok_external_testing_submitted_by')->nullable();
            $table->string('ok_external_testing_submitted_on')->nullable();
            $table->string('ok_external_testing_comment')->nullable();
            $table->string('ok_panel_external_testing_submitted_by')->nullable();
            $table->string('ok_panel_external_testing_submitted_on')->nullable();
            $table->string('ok_panel_testing_comment')->nullable();
            $table->string('product_Quality_Validated_submitted_by')->nullable();
            $table->string('product_Quality_Validated_submitted_on')->nullable();
            $table->string('product_quality_validated_comment')->nullable();
            $table->string('product_Quality_not_Validated_submitted_by')->nullable();
            $table->string('product_Quality_not_Validated_submitted_on')->nullable();
            $table->string('action_needed_submitted_by')->nullable();
            $table->string('action_needed_submitted_on')->nullable();
            $table->string('action_needed_comment')->nullable();
            $table->string('conduct_product_conclusion_submitted_by')->nullable();
            $table->string('conduct_product_conclusion_submitted_on')->nullable();
            $table->string('reviewed_closed_by')->nullable();
            $table->string('reviewed_closed_on')->nullable();
            $table->string('reviewed_closed_comment')->nullable();
            $table->string('internal_test_conclusion')->nullable();
            $table->string('reviewer_comments')->nullable();
            $table->string('action_summary')->nullable();
            $table->string('lab_test_summary')->nullable();
            $table->string('file_attachment')->nullable();
            $table->string('related_urls')->nullable();
            $table->string('related_records')->nullable();
            $table->string('demand_product_comment')->nullable();
            $table->string('demand_product_improvement_comment')->nullable();
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
        Schema::dropIfExists('lab_tests');
    }
};

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
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('division_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('record')->nullable();
            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();
            $table->string('form_type')->nullable();
            $table->string('product')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('priority_level')->nullable();
            $table->string('type_of_product')->nullable();
            $table->string('internal_product_test_info')->nullable();
            $table->string('comments')->nullable();

            $table->text('submitted_by')->nullable();
            $table->text('submitted_on')->nullable();
            $table->text('comment')->nullable();

            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('cancel_comment')->nullable();

            $table->text('internal_product_test_submitted_by')->nullable();
            $table->text('internal_product_test_submitted_on')->nullable();
            $table->text('comment_internal_product')->nullable();

            $table->text('demand_product_improvement_rejected_by')->nullable();
            $table->text('demand_product_improvement_rejected_on')->nullable();

            $table->text('not_ok_cancel_by')->nullable();
            $table->text('not_ok_cancel_on')->nullable();

            $table->text('ok_external_testing_submitted_by')->nullable();
            $table->text('ok_external_testing_submitted_on')->nullable();

             $table->text('ok_panel_external_testing_submitted_by')->nullable();
             $table->text('ok_panel_external_testing_submitted_on')->nullable();

             $table->text('product_Quality_Validated_submitted_by')->nullable();
             $table->text('product_Quality_Validated_submitted_on')->nullable();

             $table->text('product_Quality_not_Validated_submitted_by')->nullable();
            $table->text('product_Quality_not_Validated_submitted_on')->nullable();

            $table->text('action_needed_submitted_by')->nullable();
            $table->text('action_needed_submitted_on')->nullable();

            $table->text('conduct_product_conclusion_submitted_by')->nullable();
            $table->text('conduct_product_conclusion_submitted_on')->nullable();
            $table->text('reviewed_closed_by')->nullable();
            $table->text('reviewed_closed_on')->nullable();

            $table->string('internal_test_conclusion')->nullable();
            $table->string('reviewer_comments')->nullable();

            $table->string('action_summary')->nullable();
            $table->string('lab_test_summary')->nullable();

            $table->longText('file_attachment')->nullable();
            $table->string('related_urls')->nullable();

            $table->string('related_records')->nullable();


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

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
        Schema::create('resamplings', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('division_id')->nullable();
            $table->string('originator_id')->nullable();
            $table->string('form_type')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('initiator_Group')->nullable();
            $table->string('initiator_group_code')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('cq_Approver')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('api_Material_Product_Name')->nullable();
            $table->string('lot_Batch_Number')->nullable();
            $table->string('ar_Number_GI')->nullable();
            $table->string('test_Name_GI')->nullable();
            $table->longText('justification_for_resampling_GI')->nullable();
            $table->longText('predetermined_Sampling_Strategies_GI')->nullable();
            $table->longText('supporting_attach')->nullable();
            $table->string('parent_tcd_hid')->nullable();
            $table->string('parent_oos_no')->nullable();
            $table->string('parent_oot_no')->nullable();
            $table->string('parent_lab_incident_no')->nullable();
            
            $table->string('parent_date_opened')->nullable();
            $table->longText('parent_short_description')->nullable();
            $table->string('parent_product_material_name')->nullable();
            $table->string('parent_target_closure_date')->nullable();

            //tab 2
            $table->longText('sample_Request_Approval_Comments')->nullable();
            $table->longText('sample_Request_Approval_attachment')->nullable();
            //tab 3
            $table->string('sample_Received')->nullable();
            $table->string('sample_Quantity')->nullable();
            $table->longText('sample_Received_Comments')->nullable();
            $table->longText('delay_Justification')->nullable();
            $table->longText('file_attchment_pending_sample')->nullable();





            $table->longText('comment')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();

            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('submitted_comment')->nullable();
            $table->string('approval_done_by')->nullable();
            $table->string('approval_done_on')->nullable();
            $table->string('approval_done_comment')->nullable();
            $table->string('sample_received_by')->nullable();
            $table->string('sample_received_on')->nullable();
            $table->string('sample_received_comment')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('cancelled_comment')->nullable();
            $table->string('more_info_by')->nullable();
            $table->string('more_info_on')->nullable();
            $table->string('more_info_comment')->nullable();
            $table->string('more_info_from_sample_req_by')->nullable();
            $table->string('more_info_from_sample_req_on')->nullable();
            $table->string('more_info_from_sample_req_comment')->nullable();

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
        Schema::dropIfExists('resamplings');
    }
};

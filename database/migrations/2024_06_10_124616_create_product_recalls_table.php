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
        Schema::create('product_recalls', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->text('type')->nullable();
            $table->text('division_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->text('product_name')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->text('recalled_from')->nullable();
            $table->text('priority_level')->nullable();
            $table->text('recalled_by')->nullable();
            $table->text('contact_person')->nullable();
            $table->text('related_product')->nullable();
            $table->longText('recall_reason')->nullable();
            $table->text('schedule_start_date')->nullable();
            $table->text('schedule_end_date')->nullable();
            $table->text('department_code')->nullable();
            $table->text('team_members')->nullable();
            $table->text('bussiness_area')->nullable();
            $table->text('estimate_man_hours')->nullable();
            $table->longText('Attachment')->nullable();
            $table->text('related_urls')->nullable();
            $table->text('reference_record')->nullable();
            $table->longText('comments')->nullable();
            $table->text('franchise_store_manager')->nullable();
            $table->text('warehouse_manager')->nullable();
            $table->text('ena_store_manager')->nullable();
            $table->text('ab_store_manager')->nullable();

            $table->text('submitted_on')->nullable();
            $table->text('submitted_by')->nullable();
            $table->longText('submitted_comment')->nullable();

            $table->text('pending_review_by')->nullable();
            $table->text('pending_review_on')->nullable();
            $table->longText('pending_review_comment')->nullable();

            $table->text('memo_initiation_on')->nullable();
            $table->text('memo_initiation_by')->nullable();
            $table->longText('memo_initiation_comment')->nullable();

            $table->text('notification_on')->nullable();
            $table->text('notification_by')->nullable();
            $table->longText('notification_comment')->nullable();

            $table->text('recall_inprogress_on')->nullable();
            $table->text('recall_inprogress_by')->nullable();
            $table->longText('recall_inprogress_comment')->nullable();

            $table->text('awaiting_feedback_on')->nullable();
            $table->text('awaiting_feedback_by')->nullable();
            $table->longText('awaiting_feedback_comment')->nullable();

            $table->text('pending_final_approval_on')->nullable();
            $table->text('pending_final_approval_by')->nullable();
            $table->longText('pending_final_approval_comment')->nullable();
            
            $table->text('status')->nullable();
            $table->integer('stage')->nullable();

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
        Schema::dropIfExists('product_recalls');
    }
};

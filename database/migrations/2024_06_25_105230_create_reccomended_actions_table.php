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
        Schema::create('reccomended_actions', function (Blueprint $table) {
            $table->id();
            $table->string('division_id')->nullable();
            $table->integer('record')->nullable();
            $table->string('initiator_id')->nullable();
            $table->date('parent_date_opened')->nullable();
            $table->string('parent_short_desecription')->nullable();
            $table->string('target_closure_date')->nullable();
            $table->string('parent_product_material_name')->nullable();
            $table->string('date_of_initiation')->nullable();
            $table->string('assignee')->nullable();
            $table->string('inv_attachment')->nullable();


            $table->string('aqa_approver')->nullable();
            $table->longText('supervisor')->nullable();
            $table->string('recommended_action')->nullable();
            $table->string('ustify_recommended_actions')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('review_comments')->nullable();
            $table->string('aqa_review_attachment')->nullable();
            $table->string('summary_of_recommended_actions')->nullable();
            $table->string('results_conclusion')->nullable();
            $table->string('delay_justification')->nullable();
            $table->string('execution_attchment_if_any')->nullable();
            $table->string('file_attchment_if_any1')->nullable();
            $table->string('aqa_review_comments')->nullable();
            $table->string('type')->nullable();
            $table->string('cancellation_request_by')->nullable();
            $table->string('cancellation_request_on')->nullable();
            $table->string('approver_complete_by')->nullable();
            $table->string('approver_complete_on')->nullable();
            $table->string('action_execution_complete_by')->nullable();
            $table->string('action_execution_complete_on')->nullable();
            $table->string('rec_action_execution_by')->nullable();
            $table->string('rec_action_execution_on')->nullable();
            $table->string('ction_execution_review_by')->nullable();
            $table->string('ction_execution_review_on')->nullable();

            $table->string('parent_oos_no')->nullable();
            $table->string('due_date')->nullable();















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
        Schema::dropIfExists('reccomended_actions');
    }
};

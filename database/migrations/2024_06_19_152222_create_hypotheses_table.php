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
        Schema::create('hypotheses', function (Blueprint $table) {
            $table->id();
            $table->string('parent_oos_no')->nullable();
            $table->string('parent_oot_no')->nullable();
            $table->date('parent_date_opened')->nullable();
            $table->text('parent_short_description')->nullable();
            $table->date('parent_target_closure_date')->nullable();
            $table->string('parent_product_material_name')->nullable();
            $table->string('record_number')->nullable();
            $table->string('division_code')->nullable();
            $table->string('initiator')->nullable();
            $table->date('initiation_date')->nullable();
            $table->date('date_opened')->nullable();
            $table->date('target_closure_date')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('qc_approver')->nullable();
            $table->string('assignee')->nullable();
            $table->text('qc_comments')->nullable();
            $table->string('aqa_approver')->nullable();
            $table->text('hyp_exp_comments')->nullable();
            $table->string('hypothesis_attachment')->nullable();
            $table->text('aqa_review_comments')->nullable();
            $table->string('aqa_review_attachment')->nullable();
            $table->text('summary_of_hypothesis')->nullable();
            $table->text('delay_justification')->nullable();
            $table->string('hypo_execution_attachment')->nullable();
            $table->text('hypo_exp_qc_review_comments')->nullable();
            $table->string('qc_review_attachment')->nullable();
            $table->text('hypo_exp_aqa_review_comments')->nullable();
            $table->string('hypo_exp_aqa_review_attachment')->nullable();
            $table->string('submit_by')->nullable();
            $table->date('submit_on')->nullable();
            $table->string('hypo_proposed_by')->nullable();
            $table->date('hypo_proposed_on')->nullable();
            $table->string('hypothesis_proposed_by')->nullable();
            $table->date('hypothesis_proposed_on')->nullable();
            $table->string('aqa_review_compelet_by')->nullable();
            $table->date('aqa_review_compelet_on')->nullable();
            $table->string('hypo_execution_done_by')->nullable();
            $table->date('hypo_execution_done_on')->nullable();
            $table->string('qc_review_done_by')->nullable();
            $table->date('qc_review_done_on')->nullable();
            $table->string('exp_aqa_review_by')->nullable();
            $table->date('exp_aqa_review_on')->nullable();
            $table->string('cancel_by')->nullable();
            $table->date('cancel_on')->nullable();
            $table->string('status')->nullable();
            $table->date('stage')->nullable();
            $table->text('form_type')->nullable();
            $table->text('initiator_id')->nullable();
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
        Schema::dropIfExists('hypotheses');
    }
};

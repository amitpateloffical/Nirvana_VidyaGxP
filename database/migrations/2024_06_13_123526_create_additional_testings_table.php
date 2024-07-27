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
        Schema::create('additional_testings', function (Blueprint $table) {
            $table->id();
            //!--------------------Tab-1-----------------------------
            $table->string('root_parent_oos_number')->nullable();
            $table->string('root_parent_oot_number')->nullable();
            $table->string('parent_date_opened')->nullable();
            $table->longText('parent_short_description')->nullable();
            $table->string('parent_target_closure_date')->nullable();
            $table->string('parent_product_mat_name')->nullable();
            $table->string('root_parent_prod_mat_name')->nullable();

            $table->string('record_number')->nullable();
            $table->string('division_code')->nullable();
            $table->string('division_id')->nullable(); //2
            $table->string('initiator_id')->nullable();
            $table->string('initiator')->nullable();

            $table->string('gi_target_closure_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('qc_approver')->nullable();
             $table->string('intiation_date')->nullable();

            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            //!--------------------Tab2------------------------------
            $table->string('cq_approver_comments')->nullable();
            $table->string('resampling_required')->nullable();
            $table->string('resampling_reference')->nullable();
            $table->string('assignee')->nullable();
            $table->string('aqa_approver')->nullable();
            $table->string('cq_approver')->nullable();
            $table->longText('add_test_attachment')->nullable();
            //!--------------------Tab3------------------------------
            $table->string('cq_approval_comment')->nullable();
            $table->longText('cq_approval_attachment')->nullable();
            //!--------------------Tab4------------------------------
            $table->string('add_testing_execution_comment')->nullable();
            $table->string('delay_justifictaion')->nullable();
            $table->longText('add_test_exe_attachment')->nullable();
            //!--------------------Tab5------------------------------
            $table->string('qc_comments_on_addl_testing')->nullable();
            $table->longText('qc_review_attachment')->nullable();
            // !--------------------Tab6------------------------------
            $table->string('summary_of_exp_hyp')->nullable();
            $table->longText('aqa_review_attachment')->nullable();

            // Activity log
            $table->string('additional_test_proposal_completed_by')->nullable();
            $table->string('additional_test_proposal_completed_on')->nullable();
            $table->string('additional_test_proposal_completed_Comment')->nullable();

            $table->string('cq_approved_by')->nullable();
            $table->string('cq_approved_on')->nullable();
            $table->string('cq_approved_comment')->nullable();

            $table->string('resampling_checked_by')->nullable();
            $table->string('resampling_checked_on')->nullable();
            $table->string('resampling_checked_comment')->nullable();


            $table->string('additional_test_exe_by')->nullable();
            $table->string('additional_test_exe_on')->nullable();
            $table->string('additional_test_exe_comment')->nullable();

            $table->string('additional_test_qc_by')->nullable();
            $table->string('additional_test_qc_on')->nullable();
            $table->string('additional_test_qc_comment')->nullable();

            $table->string('aqa_review_completed_by')->nullable();
            $table->string('aqa_review_completed_on')->nullable();
            $table->string('aqa_review_completed_comment')->nullable();

            $table->string('completed_by_close_done')->nullable();
            $table->string('completed_on_close_done')->nullable();
            $table->string('comment_close_done')->nullable();

            $table->string('opened_by')->nullable();
            $table->string('opened_on')->nullable();
            $table->string('opened_comment')->nullable();



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
        Schema::dropIfExists('additional_testings');
    }
};

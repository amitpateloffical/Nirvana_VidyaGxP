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
        Schema::create('verifications', function (Blueprint $table) {
            $table->id();

            //GI-Tab (parent record information)
            $table->string('parent_oos_no')->nullable();
            $table->string('parent_oot_no')->nullable();
            $table->string('parent_date_opened')->nullable();
            $table->longText('parent_short_description')->nullable();
            $table->string('parent_target_closure_date')->nullable();
            $table->string('parent_product_material_name')->nullable();
            //(general information section)
            $table->integer('record')->nullable();
            $table->string('division_id')->nullable();
            $table->string('division_code')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('target_closure_date_gi')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assignee')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('aqa_reviewer')->nullable();
            $table->longText('recommended_actions')->nullable();

            $table->longText('specify_if_any_action')->nullable();
            $table->longText('justification_for_actions')->nullable();
            //tab 2
            $table->longText('results_of_recommended_actions')->nullable();
            $table->string('date_of_completion')->nullable();
            $table->longText('execution_attachment')->nullable();//1
            $table->longText('delay_justification')->nullable();
            //tab 3
            $table->longText('supervisor_observation')->nullable();
            $table->longText('verification_attachment')->nullable();//2
            //tab 4
            $table->longText('aqa_comments2')->nullable();
            $table->longText('aqa_attachment')->nullable();//3



            $table->string('form_type')->nullable();
            $table->integer('record_number')->nullable();


            $table->string('status')->nullable();
            $table->integer('stage')->nullable();

            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('comment_submitted')->nullable();


            $table->string('analysis_completed_by')->nullable();
            $table->string('analysis_completed_on')->nullable();
            $table->string('comment_analysis_completed')->nullable();

            $table->string('qc_verification_completed_by')->nullable();
            $table->string('qc_verification_completed_on')->nullable();
            $table->string('comment_qc_verification_completed')->nullable();

            $table->string('aqa_verification_completed_by')->nullable();
            $table->string('aqa_verification_completed_on')->nullable();
            $table->string('comment_aqa_verification_completed')->nullable();

            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('comment_cancelled')->nullable();

            $table->string('completed_by_close_done')->nullable();
            $table->string('completed_on_close_done')->nullable();
            $table->string('comment_close_done')->nullable();



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
        Schema::dropIfExists('verifications');
    }
};

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
        Schema::create('analyst_interviews', function (Blueprint $table) {
            $table->id();

// ----------------------Tab 1----------------------------------------

            $table->string('root_parent_oos_number')->nullable();
            $table->string('root_parent_oot_number')->nullable();
            $table->string('parent_date_opened')->nullable();
            $table->longText('parent_short_description')->nullable();
            $table->string('parent_target_closure_date')->nullable();
            $table->string('parent_product_mat_name')->nullable();
            $table->string('parent_analyst_name')->nullable();

            $table->integer('record')->nullable();
            $table->string('division_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('initiator_id')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('target_closure_date_gi')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assignee')->nullable();

            $table->string('record_number')->nullable();
            $table->string('description')->nullable();

// -------------------  Tab 2  --------------------------------

            $table->string('analyst_qualification_date')->nullable();
            $table->longText('interviewer_assessment')->nullable();
            $table->longText('recommendations')->nullable();
            $table->longText('delay_justification')->nullable();
            $table->longText('any_other_comments')->nullable();
            $table->longText('file_attchment_if_any')->nullable();

            $table->string('form_type')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();

            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('comment_submitted')->nullable();


            $table->string('interview_under_progress_done_by')->nullable();
            $table->string('interview_under_progress_done_on')->nullable();
            $table->string('comment_interview_under_progress_done')->nullable();


            $table->string('canceled_by')->nullable();
            $table->string('canceled_on')->nullable();
            $table->string('comment_canceled')->nullable();


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
        Schema::dropIfExists('analyst_interviews');
    }
};

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
        Schema::create('renewals', function (Blueprint $table) {
            $table->id();
            $table->string('manufacturer')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('initiator')->nullable();
            $table->date('date_of_initiation')->nullable();
            $table->string('short_description');
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('documents')->nullable();
            $table->string('Attached_Files')->nullable();
            $table->string('dossier_parts')->nullable();
            $table->string('related_dossier_documents')->nullable();
            $table->text('stage')->nullable();
            $table->text('status')->nullable();

            $table->string('registration_status')->nullable();
            $table->string('registration_number')->nullable();
            $table->date('planned_submission_date')->nullable();
            $table->date('actual_submission_date')->nullable();

            $table->date('planned_approval_date')->nullable();
            $table->date('actual_approval_date')->nullable();
            $table->date('actual_withdrawn_date')->nullable();
            $table->date('actual_rejection_date')->nullable();
            $table->text('comments')->nullable();


            $table->string('root_parent_trade_name')->nullable();
            $table->string('parent_local_trade_name')->nullable();
            $table->string('renewal_rule')->nullable();

            $table->string('submit_by')->nullable();
            $table->string('submit_on')->nullable();
            $table->string('submit_comment')->nullable();

            $table->string('pending_submission_review_submit_by')->nullable();
            $table->string('pending_submission_review_submit_on')->nullable();
            $table->string('pending_submission_review_submit_comment')->nullable();

            $table->string('authority_assessment_submit_by')->nullable();
            $table->string('authority_assessment_submit_on')->nullable();
            $table->string('authority_assessment_submit_comment')->nullable();

            $table->string('closed_not_approved_by')->nullable();
            $table->string('closed_not_approved_on')->nullable();
            $table->string('closed_not_approved_comment')->nullable();

            $table->string('approved_by')->nullable();
            $table->string('approved_on')->nullable();
            $table->string('approved_comment')->nullable();

            
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
        Schema::dropIfExists('renewals');
    }
};

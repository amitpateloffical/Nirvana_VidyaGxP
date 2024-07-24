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
        Schema::create('client_inquiries', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->string('type')->nullable();
            $table->string('originator_id')->nullable();
            $table->string('originator')->nullable();
            $table->date('intiation_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('Customer_Name')->nullable();
            $table->string('Submitted_By')->nullable();
            $table->string('Submit_By')->nullable();
            $table->longText('Description')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('type_gi')->nullable();
            $table->string('file_Attachment')->nullable();
            $table->string('priority_level')->nullable();
            $table->string('Related_URLs')->nullable();
            $table->string('Product_Type')->nullable();
            $table->string('Manufacturer')->nullable();
            $table->integer('serial_number')->nullable();
            $table->string('Supervisor')->nullable();
            $table->string('myfile')->nullable();
            $table->string('Inquiry_ate')->nullable();
            $table->string('Inquiry_Source')->nullable();
            $table->string('Inquiry_method')->nullable();
            $table->string('branch')->nullable();
            $table->string('Branch_manager')->nullable();
            $table->string('Business_area')->nullable();
            $table->string('account_type')->nullable();
            $table->integer('account_number')->nullable();
            $table->text('dispute_amount')->nullable();
            $table->text('currency')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->longText('allegation_language')->nullable();
            $table->longText('action_taken')->nullable();
            $table->text('broker_id')->nullable();
            $table->string('related_inquiries')->nullable();
            $table->string('Customer_names')->nullable();
            $table->string('problem_name')->nullable();
            $table->text('problem_type')->nullable();
            $table->string('problem_code')->nullable();
            $table->longText('comments')->nullable();
            $table->string('Approved_by')->nullable();
            $table->string('Approved_on')->nullable();
            $table->string('Completed_By')->nullable();
            $table->string('comments_on')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->text('submitted_on')->nullable();
            // $table->string('resolution_progress_completed_by')->nullable();
            // $table->text('resolution_progress_completed_on')->nullable();
            $table->string('resolution_in_progress_completed_by')->nullable();
            $table->text('resolution_in_progress_completed_on')->nullable();
            $table->string('cash_review_completed_by')->nullable();
            $table->text('cash_review_completed_on')->nullable();
            $table->string('resolution_progress_completed_by')->nullable();
            $table->text('resolution_progress_completed_on')->nullable();
            $table->string('root_cause_completed_by')->nullable();
            $table->text('root_cause_completed_on')->nullable();
            $table->string('root_cause_analysis_completed_by')->nullable();
            $table->text('root_cause_analysis_completed_on')->nullable();
            $table->string('pending_approval_completed_by')->nullable();
            $table->text('pending_approval_completed_on')->nullable();
            $table->string('work_in_progress_completed_by')->nullable();
            $table->text('work_in_progress_completed_on')->nullable();
            $table->string('approval_completed_by')->nullable();
            $table->text('approval_completed_on')->nullable();
            $table->string('pending_preventing_action_completed_by')->nullable();
            $table->text('pending_preventing_action_completed_on')->nullable();
            $table->string('rejected_by')->nullable();
            $table->text('rejected_on')->nullable();
            $table->string('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('Submited_Comment')->nullable();
            $table->text('simple_resol_omment')->nullable();
            $table->text('resolution_progress_Comment')->nullable();
            $table->text('work_in_progress_Comment')->nullable();
            $table->text('completed_Comment')->nullable();
            $table->text('resolution_Comment')->nullable();
            $table->text('resol_Comment')->nullable();
            $table->text('no_analysis_Comment')->nullable();
            $table->text('analysis_Comment')->nullable();
            $table->text('pending_approval_Comment')->nullable();
            $table->text('reject_Comment')->nullable();
            $table->text('approve_Comment')->nullable();
            $table->text('cancel_Comment')->nullable();
  for ($i = 1; $i <= 5; $i++) {
                $table->longText("question_$i")->nullable();
                $table->longText("response_$i")->nullable();
                $table->longText("remark_$i")->nullable();
            }

 
            
            // $table->integer('dispute_amount')->nullable();
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
        Schema::dropIfExists('client_inquiries');
    }
};

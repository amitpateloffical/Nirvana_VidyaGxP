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
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->integer('initiator_id')->nullable();
            $table->string('intiation_date')->nullable(); 
            $table->string('validation_due_date')->nullable();
            $table->string('assign_due_date')->nullable();

            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();

            $table->string('validation_type')->nullable();
            $table->string('notify_type')->nullable();
            $table->longtext('short_description')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('phase_type')->nullable();
            $table->string('document_reason_type')->nullable();
            $table->string('purpose')->nullable();
            $table->string('validation_category')->nullable();
            $table->string('validation_sub_category')->nullable();
            $table->string('file_attechment')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('comments')->nullable();
            $table->longtext('document_link')->nullable();
   
            $table->longtext('related_record')->nullable();
            // $table->longtext('duration')->nullable();
            // $table->string('hazard')->nullable();
            $table->string('test_type')->nullable();
            $table->string('refrence_type')->nullable();
            $table->string('refrence_link')->nullable();
            $table->string('addition_refrence')->nullable();
            $table->string('items_attachment')->nullable();
            $table->string('addition_attachment_items')->nullable();
            $table->string('data_successfully_type')->nullable();
            $table->string('documents_summary')->nullable();
            $table->string('document_comments')->nullable();

            $table->string('test_required')->nullable();
            $table->string('test_start_date')->nullable();
            $table->string('test_end_date')->nullable();

            $table->string('test_responsible')->nullable();
            $table->string('result_attachment')->nullable();
            $table->string('test_action')->nullable();
            // $table->text('calculated_risk')->nullable();
            // $table->text('impacted_objects')->nullable();
            // $table->text('severity_rate')->nullable();
            // $table->string('occurrence')->nullable();
            // $table->string('detection')->nullable();
            // $table->string('detection2')->nullable();
            // $table->string('rpn')->nullable();
            // $table->longtext('residual_risk')->nullable();
            // $table->string('residual_risk_impact')->nullable();
            // $table->string('residual_risk_probability')->nullable();
            // $table->string('analysisN2')->nullable();
            // $table->string('analysisRPN2')->nullable();
            // $table->string('rpn2')->nullable();
            // $table->longtext('comments2')->nullable();
            // $table->longtext('investigation_summary')->nullable();
            // $table->longtext('root_cause_description')->nullable();
            // $table->string('refrence_record')->nullable();
            // $table->string('mitigation_required')->nullable();
            // $table->longtext('mitigation_plan')->nullable();
            // $table->text('mitigation_due_date')->nullable();
            // $table->longtext('mitigation_status')->nullable();
            // $table->longtext('mitigation_status_comments')->nullable();
            // $table->string('impact')->nullable();
        
            // $table->longtext('due_date_extension')->nullable();
            // $table->text('initial_rpn')->nullable();
            // $table->string('status')->nullable();
            // $table->integer('stage')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('evaluated_by')->nullable();           
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('evaluated_on')->nullable();
            // $table->string('plan_approved_on')->nullable();
            // $table->string('risk_analysis_completed_on')->nullable();
        
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
        Schema::dropIfExists('validations');
    }
};

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
        Schema::create('lab_investigations', function (Blueprint $table) {
    
            $table->id();
            $table->string('record')->nullable();
            $table->string('division_id')->nullable();
            $table->string('initiator_id')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('form_type')->nullable();
            
            $table->text('short_description')->nullable(); // Changed to text
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('trainer')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('type')->nullable();
            $table->string('priority_level')->nullable();
            $table->string('external_tests')->nullable();
            $table->string('test_lab')->nullable();
            $table->string('original_test_result')->nullable();
            $table->text('limit_specifications')->nullable(); // Changed to text
            $table->text('additional_investigator')->nullable();
            $table->string('departments')->nullable();
            $table->longtext('description')->nullable(); // Changed to text
            $table->text('comments')->nullable(); // Changed to text
            $table->string('attached_test')->nullable();
            $table->string('related_urls')->nullable();

            // tab 2
            $table->string('severity_rate')->nullable();
            $table->string('occurrence')->nullable();
            $table->string('detection')->nullable();
            $table->string('RPN')->nullable();
            $table->text('risk_analysis')->nullable(); // Changed to text
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state_district')->nullable();

            // tab 3
            $table->Text('root_cause_methodology')->nullable();
            $table->Text('measurement')->nullable();
            $table->Text('materials')->nullable();
            $table->Text('methods')->nullable();
            $table->Text('environment')->nullable();
            $table->Text('manpower')->nullable();
            $table->longText('machine')->nullable();
            $table->longtext('problem_statement')->nullable(); // Changed to longtext
            $table->longtext('why_problem_statement')->nullable(); // Changed to longtext
            $table->longText('why_1')->nullable();
            $table->longText('why_2')->nullable();
            $table->longText('why_3')->nullable();
            $table->longText('why_4')->nullable();
            $table->longText('Root_Cause_Category')->nullable();
            $table->longText('Root_Cause_Sub_Category')->nullable();
            $table->longText('Probability')->nullable();
            $table->longText('Remarks')->nullable();
            $table->longText('why_5')->nullable();
            $table->longtext('why_root_cause')->nullable(); // Changed to longtext
            $table->longtext('what_will_be')->nullable(); // Changed to longtext
            $table->longtext('what_will_not_be')->nullable(); // Changed to longtext
            $table->longtext('what_rationable')->nullable(); // Changed to longtext
            $table->longtext('where_will_be')->nullable(); // Changed to longtext
            $table->longtext('where_will_not_be')->nullable(); // Changed to longtext
            $table->longtext('where_rationable')->nullable(); // Changed to longtext
            $table->longtext('when_will_be')->nullable(); // Changed to longtext
            $table->longtext('when_will_not_be')->nullable(); // Changed to longtext
            $table->longtext('when_rationable')->nullable(); // Changed to longtext
            $table->longtext('coverage_will_be')->nullable(); // Changed to longtext
            $table->longtext('coverage_will_not_be')->nullable(); // Changed to longtext
            $table->longtext('coverage_rationable')->nullable(); // Changed to longtext
            $table->longtext('who_will_be')->nullable(); // Changed to longtext
            $table->longtext('who_will_not_be')->nullable(); // Changed to longtext
            $table->longtext('who_rationable')->nullable(); // Changed to longtext
            $table->longText('root_cause_description')->nullable(); // Changed to longtext
            $table->longText('investigation_summary')->nullable(); // Changed to longtext
            
            $table->Text('comment1')->nullable();
            $table->Text('comment2')->nullable();
            $table->Text('comment3')->nullable();
            $table->Text('comment4')->nullable();
            $table->Text('comment5')->nullable();
           


            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('qa_review_complete_by')->nullable();
            $table->string('qa_review_complete_on')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            
            $table->string('rejected_by')->nullable();
            $table->string('rejected_on')->nullable();
            
            $table->string('report_result_by')->nullable();
            $table->string('submitted_on')->nullable();
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
        Schema::dropIfExists('lab_investigations');
    }
};

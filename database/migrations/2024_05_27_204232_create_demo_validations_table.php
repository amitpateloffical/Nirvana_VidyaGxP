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
        Schema::create('demo_validations', function (Blueprint $table) {
            $table->id();
           
            // General Information
            $table->unsignedBigInteger('parent_id')->nullable();;
            $table->string('parent_type')->nullable();;
            $table->string('division_id')->nullable();
            $table->date('initiation_date')->nullable();;
            $table->text('short_description')->nullable();;

            $table->integer('initiator_id')->nullable();
            // $table->string('intiation_date')->nullable(); 
            $table->string('validation_due_date')->nullable();
            $table->string('assign_due_date')->nullable();

            $table->string('validation_type')->nullable();
            $table->string('notify_type')->nullable();

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
            $table->longtext('test_action')->nullable();
            
            $table->string('related_record')->nullable();

            // Tests Required Section
            $table->text('tests_required')->nullable();
            $table->text('reference_document')->nullable();
            $table->text('reference_link')->nullable();
            $table->text('additional_references')->nullable();
             $table->integer('record')->nullable();
         

                       // Affected Equipment fields
                       $table->string('equipment_name_code')->nullable();
                       $table->string('equipment_id')->nullable();
                       $table->string('asset_no')->nullable();
                       $table->text('remarks')->nullable();
           
                       // Affected Items fields
                       $table->string('item_type')->nullable();
                       $table->string('item_name')->nullable();
                       $table->string('item_no')->nullable();
           
                       // Affected Facilities fields
                       $table->string('facility_location')->nullable();
                       $table->string('facility_type')->nullable();
                       $table->string('facility_name')->nullable();

                    //    $table->string('deviation_occured')->nullable();
                    //    $table->string('test_name')->nullable();
                    //    $table->string('test_number')->nullable();
                    //    $table->string('test_method')->nullable();
                    //    $table->string('test_result')->nullable();
                    //    $table->string('test_accepted')->nullable();
                    //    $table->string('remarks')->nullable();

                    $table->json('deviation_occurred')->nullable();
                    $table->json('test_name')->nullable();
                    $table->json('test_number')->nullable();
                    $table->json('test_method')->nullable();
                    $table->json('test_result')->nullable();
                    $table->json('test_accepted')->nullable();
                    $table->json('test_remarks')->nullable();

            // Affected Items Section
            $table->json('affected_items')->nullable();
            // $table->text('equipment')->nullable();
            // $table->text('items')->nullable();
            // $table->text('facilities')->nullable();

            $table->json('affected_equipments')->nullable();

            $table->json('affected_facilities')->nullable();

            // Attachments
            $table->json('items_attachment')->nullable();
            $table->text('additional_attachment_items')->nullable();

            // Document Decision
            $table->boolean('data_successfully_closed')->nullable();
            $table->text('document_summary')->nullable();
            $table->text('document_comments')->nullable();

            // Test Information
            $table->boolean('test_required')->nullable();
            $table->date('test_start_date')->nullable();
            $table->date('test_end_date')->nullable();
            $table->string('test_responsible')->nullable();

            $table->string('stage')->nullable();
            // Test Results Attachment
            $table->json('result_attachment')->nullable();

            // Summary of Results
            $table->json('summary_of_results')->nullable();

            $table->text('test_actions_comments')->nullable();

            // Record Type History
            $table->json('record_history')->nullable();

            $table->string('submitted_by')->nullable();
            $table->string('evaluated_by')->nullable();           
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('evaluated_on')->nullable();
            
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
        Schema::dropIfExists('demo_validations');
    }
};

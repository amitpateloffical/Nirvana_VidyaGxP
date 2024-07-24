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
        Schema::create('meeting_management', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('initiator')->nullable();
            $table->string('division_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();
            $table->string('type')->nullable();
            $table->string('priority_level')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->longText('attendees')->nullable();
            $table->longText('description')->nullable();
            $table->string('Attached_File')->nullable();
            $table->date('start_date_checkdate')->nullable();
            $table->longText('operations')->nullable();
            $table->longText('Requirements_for_Products')->nullable();
            $table->longText('Design_and_Development')->nullable();
            $table->longText('Control_of_Externally')->nullable();
            $table->longText('Production_and_Service')->nullable();
            $table->longText('Release_of_Products')->nullable();
            $table->longText('Control_of_Non')->nullable();
            $table->longText('Risk_Opportunities')->nullable();
            $table->longText('External_Supplier_Performance')->nullable();
            $table->longText('Customer_Satisfaction_Level')->nullable();
            $table->longText('Budget_Estimates')->nullable();
            $table->longText('Completion_of_Previous_Tasks')->nullable();
            $table->longText('Production')->nullable();
            $table->longText('Plans')->nullable();
            $table->longText('Forecast')->nullable();
            $table->longText('Any_Additional_Support_Required')->nullable();
            // $table->string('file_Attachment')->nullable();
            $table->date('Date_Due')->nullable();
            $table->longText('Summary_Recommendation')->nullable();
            $table->longText('Conclusion')->nullable();
            $table->string('file_Attachment')->nullable();
            $table->string('file_attach')->nullable();
            $table->longText('Due_Date_Extension_Justification')->nullable();
            $table->string('Submitted_By')->nullable();
            $table->string('Submitted_on')->nullable();
            $table->string('Submitted_comment')->nullable();
            $table->string('completed_by')->nullable();
            $table->string('completed_on')->nullable();
            $table->string('completed_comment')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
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
        Schema::dropIfExists('meeting_management');
    }
};

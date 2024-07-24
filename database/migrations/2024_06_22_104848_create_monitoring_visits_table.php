<?php

use Illuminate\database\Migrations\Migration;
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
        Schema::create('monitoring_visits', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('initiator_id')->nullable();
            $table->string('division_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('type')->nullable();
            $table->string('file_attach')->nullable();
            $table->longText('description')->nullable();
            $table->longText('comments')->nullable();
            $table->string('source_documents')->nullable();
            $table->string('zone')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('name_on_site')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->string('site')->nullable();
            $table->string('site_contact')->nullable();
            $table->string('lead_investigator')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('additional_investigators')->nullable();
            $table->longText('comment')->nullable();
            $table->string('monitoring_report')->nullable();
            $table->date('follow_up_start_date')->nullable();
            $table->date('follow_up_end_date')->nullable();
            $table->date('visit_start_date')->nullable();
            $table->date('visit_end_date')->nullable();
            $table->date('report_complete_start_date')->nullable();
            $table->date('report_complete_end_date')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();
            $table->string('Schedule_Site_Visit_By')->nullable();
            $table->string('Schedule_Site_Visit_On')->nullable();
            $table->string('Schedule_Site_Visit_Comment')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('Cancelled_Comment')->nullable();
            $table->string('Close_Out_Visit_Scheduled_By')->nullable();
            $table->string('Close_Out_Visit_Scheduled_On')->nullable();
            $table->string('Close_Out_Visit_Scheduled_Comment')->nullable();
            $table->string('Approve_Close_Out_By')->nullable();
            $table->string('Approve_Close_Out_On')->nullable();
            $table->string('Approve_Close_Out_Comment')->nullable();

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
        Schema::dropIfExists('monitoring_visits');
    }
};

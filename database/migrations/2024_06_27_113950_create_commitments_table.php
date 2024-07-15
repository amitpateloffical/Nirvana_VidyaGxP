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
        Schema::create('commitments', function (Blueprint $table) {
            $table->id();
            $table->string('record')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();

            $table->string('division_id')->nullable();

            $table->string('member_state')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('initiator')->nullable();
            $table->string('date_of_initiaton')->nullable();
            $table->string('short_description')->nullable();
            $table->longText('assigned_to')->nullable();
            $table->longText('type')->nullable();
            $table->string('due_date')->nullable();
            $table->string('authority_duedate')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('estimated_man')->nullable();
            $table->string('file_attach')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('priority_level')->nullable();
            $table->string('person_responsible')->nullable();
            $table->string('parent_authority')->nullable();
            $table->string('authority_type')->nullable();
            $table->longText('description')->nullable();

            // ----------------------------------------------------------

            $table->string('Safety_Impact_Probability')->nullable();
            $table->string('Safety_Impact_Severity')->nullable();
            $table->string('Legal_Impact_Probability')->nullable();
            $table->string('Legal_Impact_Severity')->nullable();
            $table->string('Business_Impact_Probability')->nullable();
            $table->string('Business_Impact_Severity')->nullable();
            $table->string('Revenue_Impact_Probability')->nullable();
            $table->string('Revenue_Impact_Severity')->nullable();
            $table->string('Brand_Impact_Probability')->nullable();
            $table->string('Brand_Impact_Severity')->nullable();

            $table->string('Safety_Impact_Risk')->nullable();
            $table->string('Legal_Impact_Risk')->nullable();
            $table->string('Business_Impact_Risk')->nullable();
            $table->string('Revenue_Impact_Risk')->nullable();
            $table->string('Brand_Impact_Risk')->nullable();
            $table->string('Impact')->nullable();
            $table->longText('Impact_Analysis')->nullable();
            $table->longText('Recommended_Action')->nullable();
            $table->longText('Comments')->nullable();
            $table->string('direct_Cause')->nullable();
            $table->string('safeguarding')->nullable();
            $table->string('root')->nullable();
            $table->longText('Root_cause_Description')->nullable();

            $table->string('Severity_Rate')->nullable();
            $table->string('Occurrence')->nullable();
            $table->string('Detection')->nullable();
            $table->string('RPN')->nullable();
            $table->longText('Risk_Analysis')->nullable();
            $table->string('Criticality')->nullable();
            $table->string('Inform_Local_Authority')->nullable();
            $table->string('authority')->nullable();
            $table->longText('parent_description')->nullable();

            $table->string('acknowledged_by')->nullable();
            $table->string('acknowledged_on')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
            $table->string('taskcompleted_by')->nullable();
            $table->string('taskcompleted_on')->nullable();
            $table->string('cancel_by')->nullable();
            $table->string('cancel_on')->nullable();

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
        Schema::dropIfExists('commitments');
    }
};

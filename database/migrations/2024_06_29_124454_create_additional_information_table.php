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
        Schema::create('additional_information', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('initiator')->nullable();
            $table->string('division_id')->nullable();
            $table->date('parent_date')->nullable();
            $table->text('market_complaint')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('due_date')->nullable();
            $table->date('intiation_date')->nullable();
            $table->date('closure_date')->nullable();
            $table->longText('Short')->nullable();
            $table->longText('description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('initiating_department')->nullable();
            $table->text('file_attach')->nullable();
            $table->longText('patient_age')->nullable();
            $table->longText('Precription_Details')->nullable();
            $table->longText('Pack_Details')->nullable();
            $table->longText('Container_Opening_Date')->nullable();
            $table->longText('Storage_Condition')->nullable();
            $table->longText('Storage_Location')->nullable();
            $table->longText('Piercing_Details')->nullable();
            $table->longText('Consuption_Details_Product')->nullable();
            $table->longText('Complainant_Medication_History')->nullable();
            $table->longText('Other_Medication')->nullable();
            $table->longText('Other_Details')->nullable();
            $table->longText('Delay_Justification')->nullable();
            $table->text('file_attachement')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->string('Submitted_By')->nullable();
            $table->text('Submitted_on')->nullable();
            $table->text('Submitted_comment')->nullable();
            $table->string('Execution_Complete_by')->nullable();
            $table->text('Execution_Complete_on')->nullable();
            $table->text('Execution_Complete_comment')->nullable();
            $table->string('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('Cancel_comment')->nullable();
            $table->string('moreinformation_by')->nullable();
            $table->text('moreinformation_on')->nullable();
            $table->text('moreinformation_comment')->nullable();

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
        Schema::dropIfExists('additional_information');
    }
};

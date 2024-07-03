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
        Schema::create('medical_device_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('division_id')->nullable();
            $table->string('record_number')->nullable();
            $table->string('initiator_id')->nullable();
            $table->string('type')->nullable();
            $table->date('date_of_initiation')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date_gi')->nullable();
            $table->text('registration_type_gi')->nullable();
            $table->longText('file_attachment_gi')->nullable();
            $table->text('parent_record_number')->nullable();
            $table->text('local_record_number')->nullable();
            $table->text('zone_departments')->nullable();
            $table->text('country_number')->nullable();
            $table->text('regulatory_departments')->nullable();
            $table->text('registration_number')->nullable();
            $table->integer('risk_based_departments')->nullable();
            $table->integer('device_approval_departments')->nullable();
            $table->integer('marketing_auth_number')->nullable();
            $table->text('manufacturer_number')->nullable();
            $table->text('stage')->nullable();
            $table->text('status')->nullable();
            $table->text('audit_agenda_grid')->nullable();
            $table->longText('manufacturing_description')->nullable();
            $table->text('dossier_number')->nullable();
            $table->text('dossier_departments')->nullable();
            $table->longText('description')->nullable();
            $table->date('planned_submission_date')->nullable();
            $table->date('actual_submission_date')->nullable();
            $table->date('actual_approval_date')->nullable();
            $table->date('actual_rejection_date')->nullable();
            $table->text('renewal_departments')->nullable();
            $table->text('assign_by')->nullable();
            $table->text('assign_on')->nullable();
            $table->text('comment')->nullable();

            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->text('cancelled_comment')->nullable();


            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('cancel_comment')->nullable();

            $table->text('reject_by')->nullable();
            $table->text('reject_on')->nullable();
            $table->text('reject_comment')->nullable();


            //$table->text('classify_by')->nullable();
            $table->text('classify_on')->nullable();
            $table->text('classify_comment')->nullable();

            $table->text('withdraw_by')->nullable();
            $table->text('withdraw_on')->nullable();
            $table->text('withdraw_comment')->nullable();

            $table->text('refused_by')->nullable();
            $table->text('refused_on')->nullable();
            $table->text('refused_comment')->nullable();

            $table->text('received_by')->nullable();
            $table->text('received_on')->nullable();
            $table->text('received_comment')->nullable();

           // $table->text('classify_by')->nullable();
           // $table->text('classify_on')->nullable();
          //  $table->text('classify_comment')->nullable();

            $table->date('next_renewal_date')->nullable();



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
        Schema::dropIfExists('medical_device_registrations');
    }
};

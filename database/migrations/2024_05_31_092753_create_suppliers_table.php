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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->string('form_type_new')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('intiation_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('criticality')->nullable();
            $table->string('priority_level')->nullable();
            $table->string('auditee')->nullable();
            $table->string('contact_person')->nullable();
            $table->longText('descriptions')->nullable();
            $table->integer('record')->nullable();
            $table->string('attached_file')->nullable();
            $table->string('attached_picture')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('type')->nullable();
            $table->string('product')->nullable();
            $table->longText('proposed_actions')->nullable();
            $table->longText('comments')->nullable();
            $table->string('impact')->nullable();
            $table->longText('impact_analysis')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->string('severity_rate')->nullable();
            $table->string('occurence')->nullable();
            $table->string('detection')->nullable();
            $table->string('rpn')->nullable();
            $table->string('report_issued_by')->nullable();
            $table->string('report_issued_on')->nullable();
            $table->string('approval_received_by')->nullable();
            $table->string('approval_received_on')->nullable();
            $table->string('all_capa_closed_by')->nullable();
            $table->string('all_capa_closed_on')->nullable();
            $table->string('approve_by')->nullable();
            $table->string('approve_on')->nullable();
            $table->string('reject_by')->nullable();
            $table->string('reject_on')->nullable();
            $table->string('cancelled_by')->nullable();
            $table->string('cancelled_on')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};

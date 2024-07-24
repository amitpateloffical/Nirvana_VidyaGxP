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
        Schema::create('audit_tasks', function (Blueprint $table) {
            $table->id();
            $table->text('record')->nullable();
            $table->text('form_type')->nullable();
            $table->text('division_id')->nullable();
            $table->string('open_date')->nullable();
            $table->string('audit_nu')->nullable();
            $table->string('audit_report_nu')->nullable();
            $table->string('final_responce_on')->nullable();
            $table->string('name_contract_testing')->nullable();
            $table->string('tcd_capa_implimention')->nullable();
            $table->string('initiator_id')->nullable();
            $table->string('date_opened')->nullable();
            $table->text('short_description')->nullable();
            $table->string('classification')->nullable();
            $table->text('closure_of_task')->nullable();
            $table->text('assignee')->nullable();
            $table->longText('observation')->nullable();;
            $table->longText('complience_details')->nullable();
            $table->longText('identified_reasons')->nullable();
            $table->longText('capa_respond')->nullable();
            $table->longText('timeline_by_auditee')->nullable();
            $table->longText('audit_task_attach')->nullable();
            $table->longText('compliance_details')->nullable();
            $table->text('date_of_implemetation')->nullable();
            $table->longText('verification_comments')->nullable();
            $table->longText('dealy_justification_for_implementation')->nullable();
            $table->longText('delay_just_closure')->nullable();
            $table->string('followup_task')->nullable();
            $table->string('ref_of_followup')->nullable();
            $table->string('exe_attechment')->nullable();
            $table->string('verification_attechment')->nullable();
            // $table->string('verification_attechment')->nullable();

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
        Schema::dropIfExists('audit_tasks');
    }
};

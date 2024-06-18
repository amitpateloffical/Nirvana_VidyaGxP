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
        Schema::create('supplier_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->string('form_type')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('intiation_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->integer('assign_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('supplier_list')->nullable();
            $table->longText('distribution_list')->nullable();
            $table->longText('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('priority_level')->nullable();
            $table->string('zone')->nullable();
            $table->integer('record')->nullable(); 
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state_district')->nullable();
            $table->string('type')->nullable();
            $table->string('other_type')->nullable();
            $table->string('file_attachments')->nullable();
            $table->string('actual_start_date')->nullable();
            $table->string('actual_end_date')->nullable();
            $table->longText('negotiation_team')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->longText('comments')->nullable();
            $table->string('submit_supplier_details_by')->nullable();
            $table->string('submit_supplier_details_on')->nullable();
            $table->string('qualification_complete_by')->nullable();
            $table->string('qualification_complete_on')->nullable();
            $table->string('audit_passed_by')->nullable();
            $table->string('audit_passed_on')->nullable();
            $table->string('audit_failed_by')->nullable();
            $table->string('audit_failed_on')->nullable();
            $table->string('reject_due_to_quality_issues_by')->nullable();
            $table->string('reject_due_to_quality_issues_on')->nullable();
            $table->string('re_audit_by')->nullable();
            $table->string('re_audit_on')->nullable();
            $table->string('supplier_obsolete_by')->nullable();
            $table->string('supplier_obsolete_on')->nullable();
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
        Schema::dropIfExists('supplier_contracts');
    }
};

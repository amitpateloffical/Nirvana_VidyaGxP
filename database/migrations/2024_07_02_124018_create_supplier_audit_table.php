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
        Schema::create('supplier_audit', function (Blueprint $table) {
            $table->id();
            $table->text('initiator')->nullable();
            $table->text('initiator_name')->nullable();
            $table->text('intiation_date')->nullable();
            $table->integer('record')->nullable();
            $table->text('form_type')->nullable();
            // $table->date('date_of_initiation')->nullable();
            $table->Longtext('short_description')->nullable();
            $table->integer('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->Longtext('audit_suppllier_as')->nullable();
            $table->longtext('auditee_supplier')->nullable();
            $table->longtext('contract_person')->nullable();
            $table->longtext('cro_vendor')->nullable();
            $table->longtext('priority_list')->nullable();
            $table->longtext('manufacturer')->nullable();
            $table->longtext('type')->nullable();
            $table->text('description')->nullable();
            $table->longtext('year')->nullable();
            $table->longtext('quarter')->nullable();
            $table->longtext('file_attachments')->nullable();
            $table->longtext('related_url')->nullable();
            $table->longtext('zone')->nullable();
            $table->longtext('country')->nullable();
            $table->text('city')->nullable();
            $table->text('state_district')->nullable();
            $table->text('scope')->nullable();
            
            // second tab
            $table->text('start_date')->nullable();           // For Scheduled start Date
            $table->text('end_date')->nullable();             // For Scheduled end Date
            $table->integer('assigned_to')->nullable();        // For Assigned To
            $table->text('cro_vendor_ap')->nullable();      // For CRO/Vendor
            $table->text('date_response_due')->nullable();    // For Date response due
            $table->longtext('co_auditors')->nullable();          // For Co-Auditors
            $table->longtext('distribution_list')->nullable();    // For Distribution List
            $table->longtext('scope_ap')->nullable();             // For Scope
            $table->longtext('comments_ap')->nullable();          // For Comments
            
            // third tab
            $table->text('actual_start_date')->nullable();    // For Actual start Date
            $table->text('actual_end_date')->nullable();      // For Actual end Date
            $table->text('executive_summary')->nullable();    // For Executive Summary
            $table->text('audit_result')->nullable();       // For Audit Result
            $table->text('date_of_response')->nullable();     // For Date of Response
            $table->longtext('fileattachment_as')->nullable();    // For File Attachments
            $table->text('response_summary')->nullable();     // For Response Summary
            
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
        Schema::dropIfExists('supplier_audit');
    }
};

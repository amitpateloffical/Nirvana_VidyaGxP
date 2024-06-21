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
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('short_description_gi')->nullable();
            $table->string('assign_to_gi')->nullable();
            $table->string('due_date')->nullable();
            $table->string('supplier_list_gi')->nullable();
            $table->string('distribution_list_gi')->nullable();
            $table->longText('description_gi')->nullable();
            $table->string('manufacturer_gi')->nullable();
            $table->string('priority_level_gi')->nullable();
            $table->string('zone_gi')->nullable();
            $table->integer('country')->nullable();
            $table->integer('state')->nullable();
            $table->integer('city')->nullable();
            $table->string('type_gi')->nullable();
            $table->string('other_type')->nullable();
            $table->longText('file_attachments_gi')->nullable();

            //Contract Details
            $table->string('actual_start_date_cd')->nullable();
            $table->string('actual_end_date_cd')->nullable();
            $table->string('suppplier_list_cd')->nullable();
            $table->longText('negotiation_team_cd')->nullable();
            $table->longText('comments_cd')->nullable();

            $table->string('status')->nullable();
            $table->integer('stage')->nullable();

            $table->text('supplier_details_submit_by')->nullable();
            $table->text('supplier_details_submit_on')->nullable();
            $table->text('supplier_details_submit_comment')->nullable();

            $table->text('open_cancel_by')->nullable();
            $table->text('open_cancel_on')->nullable();
            $table->text('open_cancel_comment')->nullable();

            $table->text('qualification_complete_by')->nullable();
            $table->text('qualification_complete_on')->nullable();
            $table->text('qualification_complete_comment')->nullable();

            $table->text('qualification_cancel_by')->nullable();
            $table->text('qualification_cancel_on')->nullable();
            $table->text('qualification_cancel_comment')->nullable();

            $table->text('audit_passed_by')->nullable();
            $table->text('audit_passed_on')->nullable();
            $table->text('audit_passed_comment')->nullable();

            $table->text('quality_issues_by')->nullable();
            $table->text('quality_issues_on')->nullable();
            $table->text('quality_issues_comment')->nullable();

            $table->text('audit_failed_by')->nullable();
            $table->text('audit_failed_on')->nullable();
            $table->text('audit_failed_comment')->nullable();

            $table->text('re_audit_by')->nullable();
            $table->text('re_audit_on')->nullable();
            $table->text('re_audit_comment')->nullable();

            $table->text('approve_supplier_obsolete_by')->nullable();
            $table->text('approve_supplier_obsolete_on')->nullable();
            $table->text('approve_supplier_obsolete_comment')->nullable();

            $table->text('reject_supplier_obsolete_by')->nullable();
            $table->text('reject_supplier_obsolete_on')->nullable();
            $table->text('reject_supplier_obsolete_comment')->nullable();

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

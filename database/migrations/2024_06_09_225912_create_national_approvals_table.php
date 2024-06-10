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
        Schema::create('national_approvals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('division_id')->nullable();
            $table->date('initiation_date')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('originator')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('record')->nullable();

            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();

            $table->string('user_name')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('due_date')->nullable();

            $table->string('manufacturer')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('initiator')->nullable();
            $table->string('procedure_type')->nullable();
            $table->string('planned_subnission_date')->nullable();
            $table->string('member_state')->nullable();
            $table->string('local_trade_name')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('renewal_rule')->nullable();
            $table->string('dossier_parts')->nullable();
            $table->string('related_dossier_documents')->nullable();
            $table->string('pack_size')->nullable();
            $table->string('shelf_life')->nullable();
            $table->string('psup_cycle')->nullable();
            $table->string('expiration_date')->nullable();

            $table->string('ap_assigned_to')->nullable();
            $table->string('ap_date_due')->nullable();
            $table->string('approval_status')->nullable();
            $table->string('marketing_authorization_holder')->nullable();
            $table->string('planned_submission_date')->nullable();
            $table->string('actual_submission_date')->nullable();
            $table->string('planned_approval_date')->nullable();
            $table->string('actual_approval_date')->nullable();
            $table->string('actual_withdrawn_date')->nullable();
            $table->string('actual_rejection_date')->nullable();
            $table->string('comments')->nullable();

            $table->string('stage')->nullable();
            $table->string('status')->nullable();



            $table->string('submit_by')->nullable(); 
            $table->string('submit_on')->nullable();
            $table->string('started_by')->nullable();
            $table->string('started_on')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_on')->nullable();
            $table->string('refused_by')->nullable();
            $table->string('refused_on')->nullable();
            $table->string('withdrawn_by')->nullable();
            $table->string('withdrawn_on')->nullable();
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
        Schema::dropIfExists('national_approvals');
    }
};

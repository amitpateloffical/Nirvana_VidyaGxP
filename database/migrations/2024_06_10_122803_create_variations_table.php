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
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            // variation
            $table->string('trade_name')->nullable();
            $table->string('member_state')->nullable();
            $table->string('initiator')->nullable();
            $table->string('date_of_initiation')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('date_due')->nullable();
            $table->string('type')->nullable();
            $table->string('related_change_control')->nullable();
            $table->longText('variation_description')->nullable();
            $table->string('variation_code')->nullable();
            $table->longText('attached_files')->nullable();
            $table->string('change_from')->nullable();
            $table->string('change_to')->nullable();
            $table->longText('description')->nullable();
            $table->longText('documents')->nullable();
            // variation plan
            $table->string('registration_status')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('planned_submission_date')->nullable();
            $table->string('actual_submission_date')->nullable();
            $table->string('planned_approval_date')->nullable();
            $table->string('actual_approval_date')->nullable();
            $table->string('actual_withdrawn_date')->nullable();
            $table->string('actual_rejection_date')->nullable();
            $table->longText('comments')->nullable();
            $table->string('related_countries')->nullable();
            //  product details
            $table->string('product_trade_name')->nullable();
            $table->string('local_trade_name')->nullable();
            $table->string('manufacturer')->nullable();
            // stages
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('started_by')->nullable();
            $table->string('started_on')->nullable();
            $table->string('started_comment')->nullable();
            $table->string('review_submitted_by')->nullable();
            $table->string('review_submitted_on')->nullable();
            $table->string('review_submitted_comment')->nullable();
            $table->string('submitted_by')->nullable();
            $table->string('submitted_on')->nullable();
            $table->string('submitted_comment')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('approved_on')->nullable();
            $table->string('approved_comment')->nullable();
            $table->string('withdrawn_by')->nullable();
            $table->string('withdrawn_on')->nullable();
            $table->string('withdrawn_comment')->nullable();
            $table->string('refused_by')->nullable();
            $table->string('refused_on')->nullable();
            $table->string('refused_comment')->nullable();
            $table->string('registration_updated_by')->nullable();
            $table->string('registration_updated_on')->nullable();
            $table->string('registration_updated_comment')->nullable();
            $table->string('registration_retired_by')->nullable();
            $table->string('registration_retired_on')->nullable();
            $table->string('registration_retired_comment')->nullable();

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
        Schema::dropIfExists('variations');
    }
};

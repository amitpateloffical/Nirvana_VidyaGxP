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
        Schema::create('subject_action_items', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('assign_to_gi')->nullable();
            $table->string('due_date')->nullable();

            //Study Details
            $table->string('trade_name_sd')->nullable();
            $table->string('assign_to_sd')->nullable();

            //Subject Details
            $table->string('subject_name_sd')->nullable();
            $table->string('gender_sd')->nullable();
            $table->string('date_of_birth_sd')->nullable();
            $table->string('race_sd')->nullable();

            //Treatment Information
            $table->string('short_description_ti')->nullable();
            $table->string('clinical_efficacy_ti')->nullable();
            $table->string('carry_over_effect_ti')->nullable();
            $table->string('last_monitered_ti')->nullable();
            $table->string('total_doses_recieved_ti')->nullable();
            $table->string('treatment_effect_ti')->nullable();
            $table->string('comments_ti')->nullable();
            $table->string('summary_ti')->nullable();

            $table->string('status')->nullable();
            $table->string('stage')->nullable();

            $table->string('submit_by')->nullable();
            $table->string('submit_on')->nullable();
            $table->string('submit_comment')->nullable();


            $table->string('cancel_by')->nullable();
            $table->string('cancel_on')->nullable();
            $table->string('cancel_comment')->nullable();

            $table->string('close_by')->nullable();
            $table->string('close_on')->nullable();
            $table->string('close_comment')->nullable();

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
        Schema::dropIfExists('subject_action_items');
    }
};

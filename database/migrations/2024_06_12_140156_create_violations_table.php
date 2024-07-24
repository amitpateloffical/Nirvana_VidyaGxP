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
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->string('form_type')->nullable();
            $table->string('division_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('division_code')->nullable();
            $table->string('intiation_date')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('short_description')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('type')->nullable();
            $table->string('other_type')->nullable();
            $table->string('related_url')->nullable();
            $table->longText('file_attachments')->nullable();
            $table->longText('description')->nullable();
            $table->string('zone')->nullable();
            $table->string('country_id')->nullable();
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('site_name_id')->nullable();
            $table->string('building_id')->nullable();
            $table->string('flore_id')->nullable();
            $table->string('room_id')->nullable();

            //Violation Information

            $table->string('date_occured')->nullable();
            $table->string('notification_date')->nullable();
            $table->string('severity_rate')->nullable();
            $table->string('occurance')->nullable();
            $table->string('detection')->nullable();
            $table->string('rpn')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('date_sent')->nullable();
            $table->string('date_returned')->nullable();
            $table->longText('follow_up')->nullable();
            $table->longText('summary')->nullable();
            $table->longText('Comments')->nullable();

            $table->string('status')->nullable();
            $table->string('stage')->nullable();

            $table->text('pending_completion_by')->nullable();
            $table->text('pending_completion_on')->nullable();
            $table->text('pending_completion_comment')->nullable();

            $table->text('initiate_cancel_by')->nullable();
            $table->text('initiate_cancel_on')->nullable();
            $table->text('initiate_cancel_comment')->nullable();

            $table->text('close_by')->nullable();
            $table->text('close_on')->nullable();
            $table->text('close_comment')->nullable();


            $table->text('cs_ctm_cancel_by')->nullable();
            $table->text('cs_ctm_cancel_on')->nullable();
            $table->text('cs_ctm_cancel_comment')->nullable();

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
        Schema::dropIfExists('violations');
    }
};

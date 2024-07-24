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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();;
            $table->string('parent_type')->nullable();;
            $table->string('division_id')->nullable();
            $table->text('initiation_date')->nullable();;
            $table->text('short_description')->nullable();
            $table->integer('record')->nullable();

            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();

            $table->string('form_type')->nullable();
            $table->date('due_date')->nullable();
            $table->string('number_id')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('user_name')->nullable();
            $table->date('assign_due_date')->nullable();

            $table->string('type')->nullable();
            $table->string('site_name')->nullable();

            $table->string('assign_to')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('rooms')->nullable();
            $table->longtext('description')->nullable();
            $table->longtext('comments')->nullable();
            $table->string('pm_frequency')->nullable();
            $table->json('file_attachment')->nullable();
            $table->string('calibration_frequency')->nullable();
            $table->string('preventive_maintenance_plan')->nullable();
            $table->string('calibration_information')->nullable();
            $table->text('next_pm_date')->nullable();
            $table->text('next_calibration_date')->nullable();
            $table->longtext('maintenance_history')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();

            $table->string('submit_by')->nullable();
            $table->string('submit_on')->nullable();
            $table->string('cancel_by')->nullable();
            $table->string('cancel_on')->nullable();
            $table->string('qa_approved_by')->nullable();
            $table->string('qa_approved_on')->nullable();

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
        Schema::dropIfExists('equipment');
    }
};

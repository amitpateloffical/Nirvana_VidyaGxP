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
        Schema::create('calibrations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('division_id')->nullable();
            $table->text('initiation_date')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('originator')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('record')->nullable();

            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();

            $table->string('form_type')->nullable();
            $table->text('due_date')->nullable();

            $table->string('user_name')->nullable();
            $table->string('assign_to')->nullable();

            $table->longtext('description')->nullable();
            $table->string('device_condition_m')->nullable();
            $table->string('replace_parts_m')->nullable();
            $table->string('calibration_rating_m')->nullable();
            $table->string('update_software_m')->nullable();
            $table->string('replace_betteries_m')->nullable();
            $table->string('parent_equipment_name_m')->nullable();
            $table->string('parent_equipment_type_m')->nullable();

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
        Schema::dropIfExists('calibrations');
    }
};

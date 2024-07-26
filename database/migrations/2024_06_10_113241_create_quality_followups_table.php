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
        Schema::create('quality_followups', function (Blueprint $table) {


            $table->id();
            $table->string('division_id')->nullable();
            $table->integer('record')->nullable();
            $table->integer('record_number')->nullable();
            $table->string('initiator_id')->nullable();
            $table->date('date_of_initiation')->nullable();
            $table->string('short_description')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product_type')->nullable();
            $table->string('discription')->nullable();
            $table->string('comments')->nullable();
            $table->string('scheduled_start_date')->nullable();
            $table->string('scheduled_end_date')->nullable();
            $table->longText('file_attachment')->nullable();
            $table->string('related_url')->nullable();
            $table->string('related_record')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('acknowledge_by')->nullable();
            $table->string('acknowledge_on')->nullable();
            $table->string('type')->nullable();
            $table->string('product')->nullable();
            $table->string('priority_level')->nullable();

            $table->string('Complete_by')->nullable();
            $table->string('Complete_on')->nullable();

            $table->string('Reject_by')->nullable();
            $table->string('Reject_on')->nullable();

            $table->string('Quality_Approval_by')->nullable();
            $table->string('Quality_Approval_on')->nullable();

            $table->string('quality_follow_up_summary')->nullable();
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
        Schema::dropIfExists('quality_followups');
    }
};

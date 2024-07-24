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
        Schema::create('correspondences', function (Blueprint $table) {
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
            $table->string('assigned_to')->nullable();
            $table->string('due_date')->nullable();
            $table->string('process_application')->nullable();
            $table->string('trade_name')->nullable();
            $table->string('how_initiated')->nullable();
            $table->string('type')->nullable();
            $table->longText('file_attachments')->nullable();
            $table->string('authority_type')->nullable();
            $table->string('authority')->nullable();
            $table->longText('description')->nullable();
            $table->string('commitment_required')->nullable();
            $table->string('priority_level')->nullable();
            $table->string('date_due_to_authority')->nullable();
            $table->string('scheduled_start_date')->nullable();
            $table->string('scheduled_end_date')->nullable();

            $table->string('status')->nullable();
            $table->string('stage')->nullable();

            $table->text('questions_recieved_by')->nullable();
            $table->text('questions_recieved_on')->nullable();
            $table->text('questions_recieved_comment')->nullable();

            $table->text('open_cancel_by')->nullable();
            $table->text('open_cancel_on')->nullable();
            $table->text('open_cancel_comment')->nullable();

            $table->text('finalize_response_by')->nullable();
            $table->text('finalize_response_on')->nullable();
            $table->text('finalize_response_comment')->nullable();

            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('cancel_comment')->nullable();

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
        Schema::dropIfExists('correspondences');
    }
};

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
        Schema::create('recurring_commitments', function (Blueprint $table) {
            $table->id();
            $table->integer('record')->nullable();
            $table->text('type')->nullable();
            $table->text('division_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->text('parent_type')->nullable();
            $table->text('initiator_id')->nullable();
            $table->date('initiation_date')->nullable();
            $table->text('assign_to')->nullable();
            $table->text('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->text('zone')->nullable();
            $table->text('country')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->text('epa_number')->nullable();
            $table->text('impact')->nullable();
            $table->text('responsible_department')->nullable();
            $table->longText('permit_certificate')->nullable();
            $table->longText('file_attachments')->nullable();
            $table->text('related_url')->nullable();

            $table->text('commitment_type')->nullable();
            $table->text('commitment_frequency')->nullable();
            $table->text('commitment_start_date')->nullable();
            $table->text('commitment_end_date')->nullable();
            $table->text('next_commitment_date')->nullable();
            $table->text('other_involved')->nullable();
            $table->text('site')->nullable();
            $table->text('site_contact')->nullable();
            $table->longText('description')->nullable();
            $table->text('comments')->nullable();
            $table->text('commitment_action')->nullable();
            $table->text('commitment_notes')->nullable();

            $table->text('status')->nullable();
            $table->integer('stage')->nullable();
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
        Schema::dropIfExists('recurring_commitments');
    }
};

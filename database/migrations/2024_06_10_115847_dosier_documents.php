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
        Schema::create('dosier_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('initiator_id')->nullable();
            $table->string('division_id')->nullable();
            $table->string('record_number')->nullable();
            $table->string('intiation_date')->nullable();
            $table->string('initiator')->nullable();
            $table->string('assign_to')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('due_date')->nullable();
            $table->string('dosier_documents_type')->nullable();
            $table->string('document_language')->nullable();
            $table->string('documents')->nullable();
            $table->longText('file_attachments_pli')->nullable();
            $table->text('dossier_parts')->nullable();
            $table->text('root_parent_manufacture')->nullable();
            $table->longText('root_parent_product_code')->nullable();
            $table->longText('root_parent_trade_name')->nullable();
            $table->string('root_parent_therapeutic_area')->nullable();

            $table->text('stage')->nullable();
            $table->text('status')->nullable();
            $table->text('date_open')->nullable();
            $table->text('date_close')->nullable();
            $table->text('type')->nullable();
            $table->text('parent_record')->nullable();

            // workflow start stage 
            $table->text('cancelled_by')->nullable();
            $table->text('cancelled_on')->nullable();
            $table->text('comment_cancle')->nullable();
            $table->text('completed_by_pending_initial_assessment')->nullable();
            $table->text('completed_on_pending_initial_assessment')->nullable();
            $table->text('comment_pending_initial_assessment')->nullable();
            $table->text('completed_by_approval_completed')->nullable();
            $table->text('completed_on_approval_completed')->nullable();
            $table->text('comment_approval_completed')->nullable();
            $table->text('completed_by_close_done')->nullable();
            $table->text('completed_on_close_done')->nullable();
            $table->text('comment_close_done')->nullable();
            $table->softDeletes();
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
        //
    }
};

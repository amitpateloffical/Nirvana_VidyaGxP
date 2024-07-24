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
        Schema::create('product__validations', function (Blueprint $table) {
            $table->id();

            $table->string('division_id')->nullable();
            $table->integer('record')->nullable();
            $table->string('initiator_id')->nullable();
            $table->date('date_of_initiation')->nullable();
            $table->string('short_description')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('product_type')->nullable();
            $table->string('discription')->nullable();
            $table->string('comments')->nullable();
            $table->longText('file_attachment')->nullable();
            $table->string('related_url')->nullable();
            $table->string('related_record')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('acknowledge_by')->nullable();
            $table->string('acknowledge_on')->nullable();

            $table->string('Schedule_Send_Sample_by')->nullable();
            $table->string('Schedule_Send_Sample_on')->nullable();

            $table->string('Reject_Sample_by')->nullable();
            $table->string('Reject_Sample_on')->nullable();

            $table->string('Send_For_Analysis_by')->nullable();
            $table->string('Send_For_Analysis_on')->nullable();

            $table->string('Recall_Product_by')->nullable();
            $table->string('Recall_Product_on')->nullable();

            $table->string('Approve_Sample_by')->nullable();
            $table->string('Approve_Sample_on')->nullable();

            $table->string('Create_Recall_by')->nullable();
            $table->string('Create_Recall_on')->nullable();

            $table->string('Recall_Closed_by')->nullable();
            $table->string('Recall_Close_on')->nullable();

            $table->string('Analyzee_by')->nullable();
            $table->string('Analyze_on')->nullable();

            $table->string('Release_by')->nullable();
            $table->string('Release_on')->nullable();


            $table->string('Start_Production_by')->nullable();
            $table->string('Start_Production_on')->nullable();

            $table->string('type')->nullable();
            $table->string('product')->nullable();
            $table->string('priority_level')->nullable();
            //=============================================================Validation Information============================================================
            $table->string('start_date')->nullable();
            $table->string('sample_details')->nullable();
            $table->string('validation_summary')->nullable();
            $table->string('externail_lab')->nullable();
            $table->string('lab_commnets')->nullable();
            $table->string('product_release')->nullable();
            $table->string('product_recelldetails')->nullable();





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
        Schema::dropIfExists('product__validations');
    }
};

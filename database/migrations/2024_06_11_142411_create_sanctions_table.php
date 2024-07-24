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
        Schema::create('sanctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();;
            $table->string('parent_type')->nullable();;
            $table->string('division_id')->nullable();
            $table->date('initiation_date')->nullable();;
            $table->text('short_description')->nullable();
            $table->integer('record')->nullable();

            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();
            $table->string('originator')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('form_type')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('initiator')->nullable();
            $table->json('file_attach')->nullable();
            $table->string('sanction_type')->nullable();
            $table->longText('description')->nullable();
            $table->string('authority_type')->nullable();
            $table->string('authority')->nullable();
            $table->string('fine')->nullable();
            $table->string('currency')->nullable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            
             $table->string('submit_by')->nullable(); 
             $table->string('submit_on')->nullable();            
            //  $table->string('cancel_by')->nullable();
            //  $table->string('cancel_on')->nullable();
            //  $table->string('qa_approved_by')->nullable();
            //  $table->string('qa_approved_on')->nullable();
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
        Schema::dropIfExists('sanctions');
    }
};

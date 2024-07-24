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
        Schema::create('monthly_workings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('parent_type')->nullable();
            $table->string('division_id')->nullable();
            $table->date('initiation_date')->nullable();
            $table->integer('initiator_id')->nullable();
            $table->string('originator')->nullable();
            $table->text('short_description')->nullable();
            $table->integer('record')->nullable();
            $table->string('initiator')->nullable();

            $table->string('divison_code')->nullable();
            $table->string('general_initiator_group')->nullable();
            $table->string('initiator_group_code')->nullable();

            $table->string('user_name')->nullable();
            $table->string('assign_to')->nullable();
            $table->string('due_date')->nullable();

            $table->string('description')->nallable();
            $table->string('zone')->nallable();
            $table->string('country')->nallable();
            $table->string('state')->nallable();
            $table->string('city')->nallable();
            $table->string('year')->nallable();
            $table->string('month')->nallable();
            $table->string('number_of_own_emp')->nallable();
            $table->string('hours_own_emp')->nallable();
            $table->string('number_of_contractors')->nallable();
            $table->string('hours_of_contractors')->nallable();
            $table->string('stage')->nullable();
            $table->string('status')->nullable();



            $table->string('submit_by')->nullable(); 
            $table->string('submit_on')->nullable();
            $table->string('closed_by')->nullable();
            $table->string('closed_on')->nullable();

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
        Schema::dropIfExists('monthly_workings');
    }
};

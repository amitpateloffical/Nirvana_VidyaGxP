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
        Schema::create('lab_investigationgrids', function (Blueprint $table) {
            $table->id();
            //firstgrid
            $table->Integer('lab_investigation_id')->nullable();
            $table->text('type')->nullable();
             
            $table->text('Root_Cause_Category')->nullable();
            $table->text('Root_Cause_Sub_Category')->nullable();
            $table->text('Probability')->nullable();
            $table->text('Remarks')->nullable();
         

            //grid second
            $table->text('risk_factor')->nullable();
            $table->text('risk_element')->nullable();
            $table->text('problem_cause')->nullable();
            $table->text('existing_risk_control')->nullable();
            
            $table->text('initial_severity')->nullable();
            $table->text('initial_detectability')->nullable();
            $table->text('initial_probability')->nullable();
            
            $table->text('initial_rpn')->nullable();
            $table->text('risk_acceptance')->nullable();
            $table->text('risk_control_measure')->nullable();
            $table->text('residual_severity')->nullable();
            $table->text('residual_probability')->nullable();
            $table->text('residual_detectability')->nullable();
            $table->text('residual_rpn')->nullable();
            $table->text('risk_acceptance2')->nullable();
            $table->text('mitigation_proposal')->nullable();
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
        Schema::dropIfExists('lab_investigationgrids');
    }
};

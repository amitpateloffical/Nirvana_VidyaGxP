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
        Schema::table('clinical_sites', function (Blueprint $table) {
            $table->longText('cancel_by')->nullable();
            $table->longText('cancel_on')->nullable();
            $table->longText('to_Imp_phase_ny')->nullable();
            $table->longText('to_Imp_phase_on')->nullable();
            $table->longText('to_pending_by')->nullable();
            $table->longText('to_Pending_on')->nullable();
            $table->longText('to_In_Effect_by')->nullable();
            $table->longText('to_In_Effect_on')->nullable();
            $table->longText('Hold_Clinical_site_by')->nullable();
            $table->longText('Hold_Clinical_site_on')->nullable();
            $table->longText('Close_Protocol_by')->nullable();
            $table->longText('Close_Protocol_on')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clinical_sites', function (Blueprint $table) {
            //
        });
    }
};

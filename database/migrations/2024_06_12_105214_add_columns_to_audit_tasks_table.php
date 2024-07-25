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
        Schema::table('audit_tasks', function (Blueprint $table) {
            $table->string('stage')->nullable();
            $table->string('status')->nullable();
            $table->string('submited_by')->nullable();
            $table->string('submited_on')->nullable();
            $table->string('submit_comment')->nullable();
            $table->string('cancellation_by')->nullable();
            $table->string('cancellation_on')->nullable();
            $table->string('cancellation_comment')->nullable();
            $table->string('open_by')->nullable();
            $table->string('open_on')->nullable();
            $table->string('open_comment')->nullable();
            $table->string('com_verification_by')->nullable();
            $table->string('com_verification_on')->nullable();
            $table->string('come_verification_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_tasks', function (Blueprint $table) {
            $table->dropColumn('stage')->nullable();
            $table->dropColumn('status')->nullable();
            $table->dropColumn('submited_by')->nullable();
            $table->dropColumn('submited_on')->nullable();
            $table->dropColumn('submit_comment')->nullable();
            $table->dropColumn('cancellation_by')->nullable();
            $table->dropColumn('cancellation_on')->nullable();
            $table->dropColumn('cancellation_comment')->nullable();
            $table->dropColumn('open_by')->nullabble();
            $table->dropColumn('open_on')->nullable();
            $table->dropColumn('open_comment')->nullable();
            $table->dropColumn('com_verification_by')->nullable();
            $table->dropColumn('com_verification_on')->nullable();
            $table->dropColumn('come_verification_comment')->nullable();
        });
    }
};

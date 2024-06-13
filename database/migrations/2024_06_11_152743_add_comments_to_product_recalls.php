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
        Schema::table('product_recalls', function (Blueprint $table) {
            $table->text('reject_recall_on')->nullable();
            $table->longText('reject_recall_by')->nullable();
            $table->text('reject_recall_comment')->nullable();

            $table->longText('send_to_initator_on')->nullable();
            $table->text('send_to_initator_by')->nullable();
            $table->text('send_to_initator_comment')->nullable();

            $table->longText('recall_completed_by')->nullable();
            $table->text('recall_completed_on')->nullable();
            $table->text('recall_completed_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_recalls', function (Blueprint $table) {
            //
        });
    }
};

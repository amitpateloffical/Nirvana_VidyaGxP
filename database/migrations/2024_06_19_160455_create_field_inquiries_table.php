
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
        Schema::create('field_inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('originator_id')->nullable();
            $table->string('initiator_id')->nullable();
            $table->date('initiation_date')->nullable();
            $table->string('division_id')->nullable();
            $table->string('record_number')->nullable();
            $table->longText('short_description')->nullable();
            $table->string('assigned_to')->nullable();
            $table->string('submitted_by')->nullable();
            $table->text('description')->nullable();
            $table->longText('customer_name')->nullable();
            $table->text('type')->nullable();
            $table->text('priority_level')->nullable();
            $table->text('related_urls')->nullable();
            $table->date('due_date')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zone_type')->nullable();
            $table->string('division_code')->nullable();
            $table->longText('file_attachment')->nullable();
            $table->text('account_type')->nullable();
            $table->text('business_area')->nullable();
            $table->text('category')->nullable();
            $table->text('sub_category')->nullable();
            $table->string('broker_id')->nullable();
            $table->text('related_inquiries')->nullable();
            $table->text('comments')->nullable();
            $table->text('action_taken')->nullable();
            $table->text('completed_by')->nullable();
            $table->text('completed_on')->nullable();
            $table->text('begin_reviewed_by')->nullable();
            $table->text('begin_reviewed_on')->nullable();
            $table->text('reviewd_comment')->nullable();
            $table->text('comment')->nullable();
            $table->text('completed_comment')->nullable();
            $table->text('cancel_by')->nullable();
            $table->text('cancel_on')->nullable();
            $table->text('closed_by')->nullable();
            $table->text('closed_on')->nullable();
            $table->string('status')->nullable();
            $table->string('stage')->nullable();

            for ($i = 1; $i <= 5; $i++) {
                $table->longText("question_$i")->nullable();
                $table->longText("response_$i")->nullable();
                $table->longText("remark_$i")->nullable();
            }


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
        Schema::dropIfExists('field_inquiries');
    }
};

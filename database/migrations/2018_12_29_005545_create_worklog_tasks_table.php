<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorklogTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worklog_tasks', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('worklog_id');
			$table->unsignedInteger('field_id');
			$table->unsignedInteger('task_id')->nullable();
			$table->string('task_option')->nullable();
			$table->text('note')->nullable();
			$table->tinyInteger('status')->default(0);
			$table->tinyInteger('priority')->default(0);
			$table->timestamp('completed_on')->nullable();
			$table->unsignedInteger('completed_by_id')->nullable();
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
        Schema::dropIfExists('worklog_tasks');
    }
}

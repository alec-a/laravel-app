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
			$table->unsignedInteger('task_id');
			$table->string('task_option');
			$table->text('note');
			$table->tinyInteger('status')->default(0);
			$table->tinyInteger('priority')->default(0);
			$table->timestamp('completed_on');
			$table->unsignedInteger('completed_by_id');
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

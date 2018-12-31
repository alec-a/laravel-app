<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldIdAndNoteFromWlTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worklog_tasks', function (Blueprint $table) {
            $table->dropColumn('field_id');
			$table->dropColumn('note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worklog_tasks', function (Blueprint $table) {
            $table->unsignedInteger('field_id');
			$table->text('note')->nullable();
        });
    }
}

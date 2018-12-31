<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWlFieldIdToWlTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worklog_tasks', function (Blueprint $table) {
            $table->unsignedinteger('worklog_field_id')->after('worklog_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('worklog_fields', function (Blueprint $table) {
            $table->dropColumn('worklog_field_id');
        });
    }
}

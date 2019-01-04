<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsPlantedColumnToWorklogFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('worklog_fields', function (Blueprint $table) {
            $table->boolean('is_planted')->nullable()->default(false)->after('crop_id');
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
            $table->dropColumn('is_planted');
        });
    }
}

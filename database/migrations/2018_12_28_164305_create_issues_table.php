<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedinteger('version_id');
			$table->unsignedinteger('user_id');
			$table->string("title");
			$table->text("content");
			$table->boolean("open")->defualt(0);
			$table->boolean("re_open")->default(0);
			$table->unsignedinteger("re_open_id")->nullable();
			$table->timestamp("re_opened_at")->nullable();
            $table->timestamps();
			$table->unsignedInteger('close_id')->nullable();
			$table->timestamp("closed_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('issues');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
			$table->string('fsUk');
			$table->date('birthday');
			$table->string('country');
			$table->string('timezone');
			$table->boolean('english');
			$table->boolean('discord');
			$table->boolean('mic');
			$table->boolean('otherServer');
			$table->boolean('experience');
			$table->boolean('donate');
			$table->text('about');
			$table->text('whyPartOfTeam');
			$table->boolean('member')->default(false);
			$table->unsignedTinyInteger('role')->default(3);
			$table->unsignedinteger('farm_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

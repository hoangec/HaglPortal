<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_profile', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string("image_url",255)->nullable();
			$table->string("address",255)->nullable();
			$table->string("phone",24)->nullable();
			$table->text("about")->nullable();
			$table->dateTime("deleted_at")->nullable();
			$table->integer("deleted_by")->unsigned()->nullable();
			$table->integer("created_by")->unsigned()->nullable();
			$table->timestamps();
			$table->foreign("id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_profile');
	}

}

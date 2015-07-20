<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectDb extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('nationals',function($table){
			$table->increments('id')	;
			$table->integer('quantity_real')->unsigned()->default(0);
			$table->integer('quantity_import')->unsigned()->default(0);
			$table->integer('quantity_export')->unsigned()->default(0);
			$table->integer('quantity_death')->unsigned()->default(0);
			$table->integer('quantity_transfer')->unsigned()->default(0);
			$table->timestamps();
		});
		Schema::create('companies',function($table){
			$table->increments('id')	;
			$table->integer('quantity_real')->unsigned()->default(0);
			$table->integer('quantity_import')->unsigned()->default(0);
			$table->integer('quantity_export')->unsigned()->default(0);
			$table->integer('quantity_death')->unsigned()->default(0);
			$table->integer('quantity_transfer')->unsigned()->default(0);
			$table->integer('nationalID')->unsigned()->default(0);
			$table->foreign('nationalID')->references('id')->on('nationals')->ondelete('cascade');
			$table->timestamps();
		});
		Schema::create('farms',function($table){
			$table->increments('id')	;
			$table->integer('quantity_real')->unsigned()->default(0);
			$table->integer('quantity_import')->unsigned()->default(0);
			$table->integer('quantity_export')->unsigned()->default(0);
			$table->integer('quantity_death')->unsigned()->default(0);
			$table->integer('quantity_transfer')->unsigned()->default(0);
			$table->integer('companyID')->unsigned()->default(0);
			$table->foreign('companyID')->references('id')->on('companies')->ondelete('cascade');
			$table->timestamps();
		});


		Schema::create('cowimports', function($table)
		{
			$table->increments('id');
			$table->datetime("import_date");
			$table->integer('quantity_steer')->unsigned()->default(0);
			$table->integer('quantity_heifer')->unsigned()->default(0);
			$table->integer('quantity_malebeef')->unsigned()->default(0);
			$table->integer('quantity_femalebeef')->unsigned()->default(0);
			$table->integer('batch_no')->unsigned()->default(0);
			$table->string('im_partner',255);	
			$table->integer('userID')->unsigned()->default(0);
			$table->integer('farmID')->unsigned()->default(0);
			$table->timestamps();
			$table->foreign('userID')->references('id')->on('users')->ondelete('cascade');
			$table->foreign('farmID')->references('id')->on('farms')->ondelete('cascade');
		});

		Schema::create('cowexports', function( $table)
		{
			$table->increments('id');
			$table->datetime("import_date");
			$table->integer('quantity_steer')->unsigned()->default(0);
			$table->integer('quantity_heifer')->unsigned()->default(0);
			$table->integer('quantity_malebeef')->unsigned()->default(0);
			$table->integer('quantity_femalebeef')->unsigned()->default(0);
			$table->integer('batch_no')->unsigned()->default(0);
			$table->string('im_partner',255);	
			$table->integer('userID')->unsigned()->default(0);
			$table->integer('farmID')->unsigned()->default(0);
			$table->timestamps();
			$table->foreign('userID')->references('id')->on('users')->ondelete('cascade');
			$table->foreign('farmID')->references('id')->on('farms')->ondelete('cascade');
		});

		Schema::create('cowdeath', function( $table)
		{
			$table->increments('id');
			$table->datetime("import_date");
			$table->integer('quantity_steer')->unsigned()->default(0);
			$table->integer('quantity_heifer')->unsigned()->default(0);
			$table->integer('quantity_malebeef')->unsigned()->default(0);
			$table->integer('quantity_femalebeef')->unsigned()->default(0);
			$table->integer('batch_no')->unsigned()->default(0);
			$table->string('im_partner',255);	
			$table->integer('userID')->unsigned()->default(0);
			$table->integer('farmID')->unsigned()->default(0);
			$table->timestamps();
			$table->foreign('userID')->references('id')->on('users')->ondelete('cascade');
			$table->foreign('farmID')->references('id')->on('farms')->ondelete('cascade');
		});


		Schema::create('cowtransfer', function( $table)
		{
			$table->increments('id');
			$table->datetime("transfer_date");
			$table->integer('form_farmID')->unsigned()->default(0);
			$table->integer('to_farmID')->unsigned()->default(0);
			$table->integer('quantity_beef')->unsigned()->default(0);
			$table->integer('quantity_steer')->unsigned()->default(0);
			$table->integer('quantity_heifer')->unsigned()->default(0);
			$table->integer('userID')->unsigned()->default(0);
			$table->timestamps();
			$table->foreign('userID')->references('id')->on('users')->ondelete('cascade');
			$table->foreign('form_farmID')->references('id')->on('farms')->ondelete('cascade');
			$table->foreign('to_farmID')->references('id')->on('farms')->ondelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('cowimport');
		Schema::drop('cowexport');
		Schema::drop('cowdeath');
		Schema::drop('cowtransfer');
		Schema::drop('farms');
		Schema::drop('companies');
		Schema::drop('nationals');

	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrestasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('prestasis', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('master_prestasi_id');
			$table->integer('nomor_un');
			$table->string('nama_lomba', 255)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down()
	{
		Schema::drop('prestasis');
	}
}

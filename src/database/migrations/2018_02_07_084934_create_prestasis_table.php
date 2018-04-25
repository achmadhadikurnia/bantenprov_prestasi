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
			$table->string('nomor_un');
			$table->integer('master_prestasi_id');
			$table->string('nama_lomba');
            $table->integer('nilai');
			$table->integer('user_id')->nullable();
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

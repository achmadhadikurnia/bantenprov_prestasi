<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterPrestasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_prestasis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('jenis_prestasi_id');
            $table->integer('juara');
            $table->integer('tingkat');
            $table->integer('nilai');
            $table->integer('kode_prestasi');
            $table->integer('user_id');
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
        Schema::dropIfExists('master_prestasis');
    }
}

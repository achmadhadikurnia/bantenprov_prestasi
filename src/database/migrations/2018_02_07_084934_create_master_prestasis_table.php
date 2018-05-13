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
            $table->integer('jenis_prestasi_id')->nullable();
            $table->integer('juara');
            $table->integer('tingkat');
            $table->double('nilai');
            $table->integer('kode');
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
        Schema::dropIfExists('master_prestasis');
    }
}

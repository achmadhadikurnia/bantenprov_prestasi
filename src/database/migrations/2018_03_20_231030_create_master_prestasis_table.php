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
            $table->string('juara');
            $table->string('tingkat');
            $table->integer('jenis_prestasi_id');
            $table->integer('nilai');
            $table->integer('bobot');
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

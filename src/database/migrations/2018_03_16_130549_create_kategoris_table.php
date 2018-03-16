<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKategorisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('kategoris', function(Blueprint $table) {
        $table->increments('id');
        $table->string('tingkat', 255);
        $table->string('juara', 255);
        $table->double('nilai');
        $table->double('bobot');
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
		  Schema::drop('kategoris');
    }
}

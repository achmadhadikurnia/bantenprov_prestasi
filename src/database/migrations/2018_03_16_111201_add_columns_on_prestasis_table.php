<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOnPrestasisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->integer('nomor_un')->after('id');
            $table->string('lomba', 255)->after('nomor_un');
            $table->integer('kategori_id')->nullable()->after('lomba');
            $table->integer('user_id')->nullable()->after('kategori_id');
            $table->dropColumn('label');
            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prestasis', function (Blueprint $table) {
            $table->dropColumn('nomor_un');
            $table->dropColumn('lomba');
            $table->dropColumn('kategori_id');
            $table->dropColumn('user_id');
			$table->string('label', 255)->after('id');
			$table->string('description', 255)->nullable()->after('label');
        });
    }
}

<?php

use Illuminate\Database\Seeder;

class BantenprovPrestasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BantenprovPrestasiSeederPrestasi::class);
    }
}

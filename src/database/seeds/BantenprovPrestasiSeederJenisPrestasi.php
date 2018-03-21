<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\JenisPrestasi;

class BantenprovPrestasiSeederJenisPrestasi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $jenis_prestasis = (object) [
            (object) [
                'user_id' => '1',
                'nama_jenis_prestasi' => '1'               
            ],
            (object) [
                'user_id' => '1',
                'nama_jenis_prestasi' => '2'            
            ]
        ];

        foreach ($jenis_prestasis as $jenis_prestasi) {
            $model = JenisPrestasi::updateOrCreate(
                [
                   'user_id' => $jenis_prestasi->user_id,
                   'nama_jenis_prestasi' => $jenis_prestasi->nama_jenis_prestasi

                ]
            );
            $model->save();
        }
	}
}



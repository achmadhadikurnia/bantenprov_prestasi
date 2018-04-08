<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\Prestasi;

class BantenprovPrestasiSeederPrestasi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
        Model::unguard();

        $prestasis = (object) [
            (object) [
                'user_id' => '1',
                'master_prestasi_id' => '1',
                'nomor_un' => '1',
                'nama_lomba' => 'Lomba 2'
            ],
            (object) [
                'user_id' => '2',
                'master_prestasi_id' => '2',
                'nomor_un' => '2',
                'nama_lomba' => 'Lomba 2'
            ]
        ];

        foreach ($prestasis as $prestasi) {
            $model = Prestasi::updateOrCreate(
                [
                   'user_id' => $prestasi->user_id,
                   'master_prestasi_id' => $prestasi->master_prestasi_id,
                   'nomor_un' => $prestasi->nomor_un,
                   'nama_lomba' => $prestasi->nama_lomba,
                ]
            );
            $model->save();
        }
	}
}



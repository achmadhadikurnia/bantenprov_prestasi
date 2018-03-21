<?php

/* Require */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/* Models */
use Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi;

class BantenprovPrestasiSeederMasterPrestasi extends Seeder
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
                'juara' => '1',
                'tingkat' => '1',
                'nama_lomba' => 'Lomba 1'              
                'nilai' => '12' 
                'bobot' => '1'                           
            ],
            (object) [
                'user_id' => '1',
                'juara' => '2',
                'tingkat' => '2',
                'nama_lomba' => 'Lomba 2'
                'nilai' => '13'  
                'bobot' => '2'                          
            ]
        ];

        foreach ($master_prestasis as $master_prestasi) {
            $model = MasterPrestasi::updateOrCreate(
                [
                   'user_id' => $master_prestasi->user_id,
                   'juara' => $master_prestasi->juara,
                   'tingkat' => $master_prestasi->tingkat,
                   'nilai' => $master_prestasi->nilai,
                   'nama_lomba' => $master_prestasi->nama_lomba,
                   'bobot' => $master_prestasi->bobot,

                ]
            );
            $model->save();
        }
	}
}



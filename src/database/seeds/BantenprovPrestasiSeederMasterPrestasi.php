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

        $master_prestasis = (object) [
            (object) [
                'user_id' => '1',
                'jenis_prestasi_id' => '1',
                'juara' => '1',
                'tingkat' => '1',
                'nilai' => '10',  
                'label' => 'Label 1',            
                'bobot' => '1'                           
            ],
            (object) [
                'user_id' => '1',
                'jenis_prestasi_id' => '2',
                'juara' => '2',
                'tingkat' => '2',
                'nilai' => '20', 
                'label' => 'Label 2',
                'bobot' => '2'                          
            ]
        ];

        foreach ($master_prestasis as $master_prestasi) {
            $model = MasterPrestasi::updateOrCreate(
                [
                   'user_id' => $master_prestasi->user_id,
                   'jenis_prestasi_id' => $master_prestasi->jenis_prestasi_id,
                   'juara' => $master_prestasi->juara,
                   'tingkat' => $master_prestasi->tingkat,
                   'nilai' => $master_prestasi->nilai,
                   'label' => $master_prestasi->label,
                   'bobot' => $master_prestasi->bobot,

                ]
            );
            $model->save();
        }
	}
}



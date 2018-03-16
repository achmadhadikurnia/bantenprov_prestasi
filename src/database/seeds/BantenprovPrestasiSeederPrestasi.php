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
                'label' => 'Sektor Sarana dan Prasarana',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Pemerintahan',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Pembangunan',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Pelayanan',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Legislatif',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Kewilayahan',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Keuangan',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Kepegawaian',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Kemasyarakatan',
                'description' => '',
            ],
            (object) [
                'label' => 'Sektor Administrasi dan Manajemen',
                'description' => '',
            ],
        ];

        foreach ($prestasis as $prestasi) {
            $model = Prestasi::updateOrCreate(
                [
                    'label' => $prestasi->label,
                ],
                [
                    'description' => $prestasi->description,
                ]
            );
            $model->save();
        }
	}
}

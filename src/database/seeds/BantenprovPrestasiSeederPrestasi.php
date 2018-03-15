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
                'label' => 'Prestasi 1',
                'description' => 'Prestasi 1',
            ],
            (object) [
                'label' => 'Prestasi 2',
                'description' => 'Prestasi 2',
            ]
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

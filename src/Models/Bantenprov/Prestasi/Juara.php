<?php

namespace Bantenprov\Prestasi\Models\Bantenprov\Prestasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Juara extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'juaras';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'juara'
    ];

    public function master_prestasi()
    {
        return $this->hasMany('Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi','juara');
    }
}
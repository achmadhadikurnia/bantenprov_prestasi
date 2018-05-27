<?php

namespace Bantenprov\Prestasi\Models\Bantenprov\Prestasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tingkat extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'tingkats';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'tingkat'
    ];

    public function master_prestasi()
    {
        return $this->hasMany('Bantenprov\Prestasi\Models\Bantenprov\Prestasi\MasterPrestasi','tingkat');
    }
}
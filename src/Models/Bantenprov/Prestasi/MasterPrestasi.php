<?php

namespace Bantenprov\Prestasi\Models\Bantenprov\Prestasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPrestasi extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'master_prestasis';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'jenis_prestasi_id',
        'juara',
        'tingkat',
        'nilai',
        'kode_prestasi',
        'user_id'
    ];

    public function jenis_prestasi()
    {
        return $this->belongsTo('Bantenprov\Prestasi\Models\Bantenprov\Prestasi\JenisPrestasi','jenis_prestasi_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
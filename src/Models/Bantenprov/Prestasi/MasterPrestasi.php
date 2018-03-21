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
        'user_id',
        'jenis_prestasi_id',
        'juara',
        'tingkat',
        'nama_lomba',
        'nilai',
        'bobot'
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
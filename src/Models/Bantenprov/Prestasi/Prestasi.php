<?php

namespace Bantenprov\Prestasi\Models\Bantenprov\Prestasi;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'prestasis';
    protected $dates = [
        'deleted_at'
    ];
    protected $fillable = [
        'label',
        'description',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = 'dokumentasi';

    protected $primaryKey = 'id_dokumentasi';

    public $timestamps = false;

    protected $fillable = [
        'id_event',
        'url_dokumentasi',
        'tgl_upload',
        'deskripsi_dokumentasi',
    ];

    protected $casts = [
        'tgl_upload' => 'datetime',
    ];

    /**
     * Relasi ke event
     */
    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }
}
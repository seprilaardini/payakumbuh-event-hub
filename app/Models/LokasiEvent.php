<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiEvent extends Model
{
    protected $table = 'lokasi_event';

    protected $primaryKey = 'id_lokasi';

    public $timestamps = false;

    protected $fillable = [
        'nama_lokasi',
        'alamat_lokasi',
        'deskripsi',
        'id_event',
    ];

    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }
}
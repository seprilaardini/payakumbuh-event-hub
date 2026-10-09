<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $primaryKey = 'id_pendaftaran';

    public $timestamps = false;

    protected $fillable = [
        'id_masyarakat',
        'id_event',
        'tanggal_daftar',
        'status',
        'kode_pendaftaran',
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
    ];

    public function masyarakat()
    {
        return $this->belongsTo(
            Masyarakat::class,
            'id_masyarakat',
            'id_masyarakat'
        );
    }

    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }

    public function pembayaran()
    {
        return $this->hasOne(
            Pembayaran::class,
            'id_pendaftaran',
            'id_pendaftaran'
        );
    }
}
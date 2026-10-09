<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $primaryKey = 'id_pembayaran';

    public $timestamps = false;

    protected $fillable = [
        'id_pendaftaran',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_pembayaran',
        'jumlah_bayar',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
        'jumlah_bayar' => 'decimal:2',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(
            Pendaftaran::class,
            'id_pendaftaran',
            'id_pendaftaran'
        );
    }
}
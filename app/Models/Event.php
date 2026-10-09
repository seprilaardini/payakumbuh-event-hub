<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'event';

    protected $primaryKey = 'id_event';

    public $timestamps = false;


    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'nama_event',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'biaya_pendaftaran',
        'id_kategori',
        'deskripsi_verifkasi',
        'poster',
        'id_admin',
        'id_sponsor',
        'id_lokasi_event',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'tanggal_mulai'     => 'datetime',
        'tanggal_selesai'   => 'datetime',
        'biaya_pendaftaran' => 'decimal:2',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI KATEGORI
    |--------------------------------------------------------------------------
    |
    | event.id_kategori
    |        ↓
    | kategori.id_kategori
    |
    */

    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'id_kategori',
            'id_kategori'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI LOKASI
    |--------------------------------------------------------------------------
    |
    | event.id_event
    |       ↓
    | lokasi_event.id_event
    |
    */

    public function lokasi()
    {
        return $this->hasOne(
            LokasiEvent::class,
            'id_event',
            'id_event'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI PENDAFTARAN
    |--------------------------------------------------------------------------
    |
    | event.id_event
    |       ↓
    | pendaftaran.id_event
    |
    */

    public function pendaftaran()
    {
        return $this->hasMany(
            Pendaftaran::class,
            'id_event',
            'id_event'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI PESERTA
    |--------------------------------------------------------------------------
    |
    | event.id_event
    |       ↓
    | peserta.id_event
    |
    */

    public function peserta()
    {
        return $this->hasMany(
            Peserta::class,
            'id_event',
            'id_event'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI DOKUMENTASI
    |--------------------------------------------------------------------------
    |
    | event.id_event
    |       ↓
    | dokumentasi.id_event
    |
    */

    public function dokumentasi()
    {
        return $this->hasMany(
            Dokumentasi::class,
            'id_event',
            'id_event'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RELASI ULASAN
    |--------------------------------------------------------------------------
    |
    | Struktur database:
    |
    | event
    |   ↓
    | peserta
    |   ↓
    | ulasan
    |
    | event.id_event
    |   = peserta.id_event
    |
    | peserta.id_peserta
    |   = ulasan.id_peserta
    |
    */

    public function ulasan()
    {
        return $this->hasManyThrough(
            Ulasan::class,
            Peserta::class,

            // Foreign key pada tabel peserta
            'id_event',

            // Foreign key pada tabel ulasan
            'id_peserta',

            // Local key pada tabel event
            'id_event',

            // Local key pada tabel peserta
            'id_peserta'
        );
    }
}
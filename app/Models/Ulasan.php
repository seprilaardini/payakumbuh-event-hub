<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL
    |--------------------------------------------------------------------------
    */

    protected $table = 'ulasan';


    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id_ulasan';


    /*
    |--------------------------------------------------------------------------
    | TIMESTAMP
    |--------------------------------------------------------------------------
    |
    | Tabel ulasan tidak menggunakan:
    | created_at
    | updated_at
    |
    */

    public $timestamps = false;


    /*
    |--------------------------------------------------------------------------
    | FIELD YANG BOLEH DIISI
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'id_peserta',
        'komentar',
        'rating',
        'tanggal_ulasan',
        'email',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAST DATA
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'rating' => 'integer',
        'tanggal_ulasan' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | RELASI KE PESERTA
    |--------------------------------------------------------------------------
    |
    | Setiap ulasan diberikan oleh satu peserta.
    |
    */

    public function peserta()
    {
        return $this->belongsTo(
            Peserta::class,
            'id_peserta',
            'id_peserta'
        );
    }
}
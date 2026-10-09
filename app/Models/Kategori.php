<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $primaryKey = 'id_kategori';

    public $timestamps = false;

    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori',
        'id_admin',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KATEGORI -> EVENT
    |--------------------------------------------------------------------------
    */

    public function events()
    {
        return $this->hasMany(
            Event::class,
            'id_kategori',
            'id_kategori'
        );
    }
}
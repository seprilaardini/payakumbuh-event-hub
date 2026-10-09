<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'peserta';

    protected $primaryKey = 'id_peserta';

    public $timestamps = false;

    protected $fillable = [
        'id_event',
        'nama_peserta',
        'email_peserta',
        'no_hp_peserta',
        'id_status_peserta',
    ];

    public function event()
    {
        return $this->belongsTo(
            Event::class,
            'id_event',
            'id_event'
        );
    }

    public function ulasan()
    {
        return $this->hasMany(
            Ulasan::class,
            'id_peserta',
            'id_peserta'
        );
    }
}
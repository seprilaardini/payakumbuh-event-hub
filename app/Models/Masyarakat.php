<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masyarakat extends Model
{
    protected $table = 'masyarakat';

    protected $primaryKey = 'id_masyarakat';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'email',
    ];

    public function pendaftaran()
    {
        return $this->hasMany(
            Pendaftaran::class,
            'id_masyarakat',
            'id_masyarakat'
        );
    }
}
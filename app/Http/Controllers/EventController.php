<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR EVENT MASYARAKAT
    |--------------------------------------------------------------------------
    |
    | URL:
    | /daftar-event
    |
    | View:
    | resources/views/masyarakat/daftar-event.blade.php
    |
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY EVENT
        |--------------------------------------------------------------------------
        */

        $query = Event::query()
            ->where('status', 'disetujui')
            ->with([
                'kategori',
                'lokasi',
            ])
            ->withCount('peserta')
            ->orderBy('tanggal_mulai', 'asc');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->input('search')
            );

            if ($search !== '') {

                $query->where(
                    'nama_event',
                    'like',
                    '%' . $search . '%'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        |
        | Nilai yang dikirim dari Blade:
        | id_kategori
        |
        */

        if (
            $request->filled('kategori')
            &&
            is_numeric($request->input('kategori'))
        ) {

            $query->where(
                'id_kategori',
                (int) $request->input('kategori')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER HARGA
        |--------------------------------------------------------------------------
        |
        | gratis   = biaya <= 0
        | berbayar = biaya > 0
        |
        */

        if ($request->filled('harga')) {

            $harga = $request->input('harga');

            if ($harga === 'gratis') {

                $query->where(
                    'biaya_pendaftaran',
                    '<=',
                    0
                );
            }

            elseif ($harga === 'berbayar') {

                $query->where(
                    'biaya_pendaftaran',
                    '>',
                    0
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        |
        | Mendukung:
        |
        | mendatang
        | hari_ini
        |
        | dan juga tanggal langsung jika dikirim dari form.
        |
        */

        if ($request->filled('tanggal')) {

            $tanggal = trim(
                $request->input('tanggal')
            );


            /*
            |--------------------------------------------------------------------------
            | EVENT MENDATANG
            |--------------------------------------------------------------------------
            */

            if ($tanggal === 'mendatang') {

                $query->where(
                    'tanggal_mulai',
                    '>=',
                    now()
                );
            }


            /*
            |--------------------------------------------------------------------------
            | EVENT HARI INI
            |--------------------------------------------------------------------------
            */

            elseif ($tanggal === 'hari_ini') {

                $query->whereDate(
                    'tanggal_mulai',
                    today()
                );
            }


            /*
            |--------------------------------------------------------------------------
            | TANGGAL SPESIFIK
            |--------------------------------------------------------------------------
            */

            elseif (
                preg_match(
                    '/^\d{4}-\d{2}-\d{2}$/',
                    $tanggal
                )
            ) {

                $query->whereDate(
                    'tanggal_mulai',
                    $tanggal
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL EVENT
        |--------------------------------------------------------------------------
        */

        $events = $query
            ->paginate(6)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        |
        | PENTING:
        | Nama variabel HARUS $kategori karena Blade
        | daftar-event.blade.php menggunakan:
        |
        | @foreach($kategori as $item)
        |
        */

        $kategori = Kategori::query()
            ->withCount([
                'events' => function ($query) {

                    $query->where(
                        'status',
                        'disetujui'
                    );

                }
            ])
            ->orderBy(
                'id_kategori',
                'asc'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE DAFTAR EVENT
        |--------------------------------------------------------------------------
        */

        return view(
            'masyarakat.daftar-event',
            compact(
                'events',
                'kategori'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL EVENT
    |--------------------------------------------------------------------------
    |
    | URL:
    | /event/{id}
    |
    | View:
    | resources/views/masyarakat/detail-event.blade.php
    |
    */

    public function detail($id)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL EVENT
        |--------------------------------------------------------------------------
        */

        $event = Event::query()
            ->where(
                'status',
                'disetujui'
            )
            ->with([
                'kategori',
                'lokasi',
                'peserta',
                'dokumentasi',
            ])
            ->withCount('peserta')
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PESERTA TERDAFTAR
        |--------------------------------------------------------------------------
        |
        | Hanya peserta dengan:
        |
        | id_status_peserta = terdaftar
        |
        | yang dihitung.
        |
        */

        $jumlahPeserta = $event
            ->peserta()
            ->where(
                'id_status_peserta',
                'terdaftar'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | SAMAKAN peserta_count DENGAN JUMLAH PESERTA TERDAFTAR
        |--------------------------------------------------------------------------
        |
        | Detail Event milik kamu menggunakan:
        |
        | $event->peserta_count
        |
        | Maka nilainya kita isi dengan jumlah peserta
        | berstatus terdaftar.
        |
        */

        $event->setAttribute(
            'peserta_count',
            $jumlahPeserta
        );


        /*
        |--------------------------------------------------------------------------
        | ULASAN EVENT
        |--------------------------------------------------------------------------
        |
        | Ulasan terhubung ke event melalui:
        |
        | ulasan
        |    ↓
        | id_peserta
        |    ↓
        | peserta
        |    ↓
        | id_event
        |
        */

        $ulasan = Ulasan::query()
            ->whereHas(
                'peserta',
                function ($query) use ($event) {

                    $query->where(
                        'id_event',
                        $event->id_event
                    );
                }
            )
            ->with('peserta')
            ->orderByDesc(
                'tanggal_ulasan'
            )
            ->limit(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH ULASAN
        |--------------------------------------------------------------------------
        */

        $jumlahUlasan = Ulasan::query()
            ->whereHas(
                'peserta',
                function ($query) use ($event) {

                    $query->where(
                        'id_event',
                        $event->id_event
                    );
                }
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA RATING
        |--------------------------------------------------------------------------
        */

        $rataRating = Ulasan::query()
            ->whereHas(
                'peserta',
                function ($query) use ($event) {

                    $query->where(
                        'id_event',
                        $event->id_event
                    );
                }
            )
            ->avg('rating');


        /*
        |--------------------------------------------------------------------------
        | JIKA BELUM ADA RATING
        |--------------------------------------------------------------------------
        */

        $rataRating = $rataRating !== null
            ? round(
                (float) $rataRating,
                1
            )
            : 0;


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE RATING
        |--------------------------------------------------------------------------
        |
        | Dipakai apabila nanti Detail Event membutuhkan
        | distribusi rating 1 sampai 5.
        |
        */

        $ratingPercents = [];


        for ($i = 1; $i <= 5; $i++) {

            $jumlahRating = Ulasan::query()
                ->where(
                    'rating',
                    $i
                )
                ->whereHas(
                    'peserta',
                    function ($query) use ($event) {

                        $query->where(
                            'id_event',
                            $event->id_event
                        );
                    }
                )
                ->count();


            $ratingPercents[$i] =
                $jumlahUlasan > 0
                    ? round(
                        (
                            $jumlahRating
                            /
                            $jumlahUlasan
                        ) * 100
                    )
                    : 0;
        }


        /*
        |--------------------------------------------------------------------------
        | EVENT LAINNYA
        |--------------------------------------------------------------------------
        */

        $eventLainnya = Event::query()
            ->where(
                'status',
                'disetujui'
            )
            ->where(
                'id_event',
                '!=',
                $event->id_event
            )
            ->with([
                'kategori',
                'lokasi',
            ])
            ->withCount('peserta')
            ->orderBy(
                'tanggal_mulai',
                'asc'
            )
            ->limit(3)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DOKUMENTASI EVENT
        |--------------------------------------------------------------------------
        */

        $dokumentasi = $event
            ->dokumentasi()
            ->orderByDesc(
                'tgl_upload'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE DETAIL EVENT
        |--------------------------------------------------------------------------
        */

        return view(
            'masyarakat.detail-event',
            compact(
                'event',
                'jumlahPeserta',
                'jumlahUlasan',
                'rataRating',
                'ratingPercents',
                'ulasan',
                'dokumentasi',
                'eventLainnya'
            )
        );
    }
}
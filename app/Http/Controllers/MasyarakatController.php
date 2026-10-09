<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Kategori;
use App\Models\Dokumentasi;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BERANDA
    |--------------------------------------------------------------------------
    */

    public function beranda()
    {
        /*
        |--------------------------------------------------------------------------
        | EVENT YANG SUDAH DISETUJUI
        |--------------------------------------------------------------------------
        */

        $events = Event::query()
            ->where('status', 'disetujui')
            ->with([
                'kategori',
                'lokasi',
            ])
            ->withCount('peserta')
            ->orderBy('tanggal_mulai', 'asc')
            ->limit(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH EVENT
        |--------------------------------------------------------------------------
        */

        $jumlahEvent = Event::query()
            ->where('status', 'disetujui')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH PESERTA
        |--------------------------------------------------------------------------
        */

        $jumlahPeserta = Event::query()
            ->where('status', 'disetujui')
            ->withCount('peserta')
            ->get()
            ->sum('peserta_count');


        /*
        |--------------------------------------------------------------------------
        | DATA KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori = Kategori::query()
            ->orderBy('nama_kategori', 'asc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | KIRIM DATA KE VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'masyarakat.beranda',
            compact(
                'events',
                'jumlahEvent',
                'jumlahPeserta',
                'kategori'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAFTAR EVENT
    |--------------------------------------------------------------------------
    */

    public function event(Request $request)
    {
        $query = Event::query()
            ->where('status', 'disetujui')
            ->with([
                'kategori',
                'lokasi',
            ])
            ->withCount('peserta');


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(
                'nama_event',
                'like',
                '%' . $search . '%'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER KATEGORI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kategori')) {

            $query->where(
                'id_kategori',
                $request->kategori
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER HARGA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('harga')) {

            if ($request->harga === 'gratis') {

                $query->where(
                    'biaya_pendaftaran',
                    0
                );

            } elseif ($request->harga === 'berbayar') {

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
        */

        if ($request->filled('tanggal')) {

            $query->whereDate(
                'tanggal_mulai',
                $request->tanggal
            );
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL EVENT
        |--------------------------------------------------------------------------
        */

        $events = $query
            ->orderBy(
                'tanggal_mulai',
                'asc'
            )
            ->paginate(9)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | KATEGORI
        |--------------------------------------------------------------------------
        */

        $kategori = Kategori::query()
            ->orderBy(
                'nama_kategori',
                'asc'
            )
            ->get();


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
    */

    public function detail($id)
    {
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
        | RATING
        |--------------------------------------------------------------------------
        */

        $rataRating = $event
            ->ulasan()
            ->avg('rating');


        /*
        |--------------------------------------------------------------------------
        | JUMLAH ULASAN
        |--------------------------------------------------------------------------
        */

        $jumlahUlasan = $event
            ->ulasan()
            ->count();


        return view(
            'masyarakat.detail-event',
            compact(
                'event',
                'rataRating',
                'jumlahUlasan'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DOKUMENTASI
    |--------------------------------------------------------------------------
    */

    public function dokumentasi(Request $request)
    {
        $query = Dokumentasi::query()
            ->with([
                'event.kategori',
            ])
            ->whereHas(
                'event',
                function ($query) {

                    $query->where(
                        'status',
                        'disetujui'
                    );
                }
            );


        /*
        |--------------------------------------------------------------------------
        | SEARCH DOKUMENTASI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->whereHas(
                'event',
                function ($query) use ($search) {

                    $query->where(
                        'nama_event',
                        'like',
                        '%' . $search . '%'
                    );
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TAHUN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tahun')) {

            $query->whereYear(
                'tgl_upload',
                $request->tahun
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA DOKUMENTASI
        |--------------------------------------------------------------------------
        */

        $dokumentasi = $query
            ->orderByDesc(
                'tgl_upload'
            )
            ->paginate(9)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DAFTAR TAHUN
        |--------------------------------------------------------------------------
        */

        $tahun = Dokumentasi::query()
            ->selectRaw(
                'YEAR(tgl_upload) as tahun'
            )
            ->whereNotNull(
                'tgl_upload'
            )
            ->distinct()
            ->orderByDesc(
                'tahun'
            )
            ->pluck(
                'tahun'
            );


        return view(
            'masyarakat.dokumentasi',
            compact(
                'dokumentasi',
                'tahun'
            )
        );
    }
}
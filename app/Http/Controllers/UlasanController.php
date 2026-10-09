<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Peserta;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * =========================================================
     * HALAMAN ULASAN EVENT
     * =========================================================
     */
    public function index($id)
    {
        /*
        |--------------------------------------------------------------------------
        | EVENT
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
            ])
            ->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ULASAN
        |--------------------------------------------------------------------------
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
            ->get();


        /*
        |--------------------------------------------------------------------------
        | JUMLAH
        |--------------------------------------------------------------------------
        */
        $jumlahUlasan =
            $ulasan->count();


        /*
        |--------------------------------------------------------------------------
        | RATA-RATA
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


        $rataRating =
            $rataRating !== null
                ? round(
                    (float) $rataRating,
                    1
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | PERSENTASE RATING
        |--------------------------------------------------------------------------
        */
        $ratingPercents = [];

        for (
            $i = 1;
            $i <= 5;
            $i++
        ) {

            $jumlahRating =
                Ulasan::query()
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
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view(
            'masyarakat.ulasan',
            compact(
                'event',
                'ulasan',
                'jumlahUlasan',
                'rataRating',
                'ratingPercents'
            )
        );
    }


    /**
     * =========================================================
     * SIMPAN ULASAN
     * =========================================================
     */
    public function store(
        Request $request
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $validated =
            $request->validate(
                [
                    'id_event' => [
                        'required',
                        'integer',
                        'exists:event,id_event',
                    ],

                    'nama' => [
                        'required',
                        'string',
                        'max:150',
                    ],

                    'email' => [
                        'required',
                        'email',
                        'max:150',
                    ],

                    'rating' => [
                        'required',
                        'integer',
                        'between:1,5',
                    ],

                    'komentar' => [
                        'required',
                        'string',
                        'max:1000',
                    ],
                ],
                [
                    'id_event.required' =>
                        'Event wajib dipilih.',

                    'id_event.exists' =>
                        'Event tidak ditemukan.',

                    'nama.required' =>
                        'Nama lengkap wajib diisi.',

                    'email.required' =>
                        'Email wajib diisi.',

                    'email.email' =>
                        'Format email tidak valid.',

                    'rating.required' =>
                        'Silakan pilih rating.',

                    'rating.between' =>
                        'Rating harus 1 sampai 5.',

                    'komentar.required' =>
                        'Komentar wajib diisi.',

                    'komentar.max' =>
                        'Komentar maksimal 1000 karakter.',
                ]
            );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI
        |--------------------------------------------------------------------------
        */
        $nama =
            trim(
                $validated['nama']
            );

        $email =
            strtolower(
                trim(
                    $validated['email']
                )
            );

        $komentar =
            trim(
                $validated['komentar']
            );


        /*
        |--------------------------------------------------------------------------
        | EVENT
        |--------------------------------------------------------------------------
        */
        $event = Event::query()
            ->where(
                'status',
                'disetujui'
            )
            ->findOrFail(
                $validated['id_event']
            );


        /*
        |--------------------------------------------------------------------------
        | CARI PESERTA
        |--------------------------------------------------------------------------
        |
        | Tidak menggunakan kode pendaftaran.
        |
        | Cukup:
        | id_event + email_peserta
        |
        */
        $peserta =
            Peserta::query()
                ->where(
                    'id_event',
                    $event->id_event
                )
                ->where(
                    'email_peserta',
                    $email
                )
                ->where(
                    'id_status_peserta',
                    'terdaftar'
                )
                ->latest(
                    'id_peserta'
                )
                ->first();


        /*
        |--------------------------------------------------------------------------
        | BUKAN PESERTA
        |--------------------------------------------------------------------------
        */
        if (!$peserta) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Email tersebut belum terdaftar sebagai peserta event ini.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK SUDAH MEMBERI ULASAN
        |--------------------------------------------------------------------------
        */
        $sudahUlasan =
            Ulasan::query()
                ->where(
                    'id_peserta',
                    $peserta->id_peserta
                )
                ->exists();


        if ($sudahUlasan) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Kamu sudah memberikan ulasan untuk event ini.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN
        |--------------------------------------------------------------------------
        */
        Ulasan::create([
            'id_peserta' =>
                $peserta->id_peserta,

            'komentar' =>
                $komentar,

            'rating' =>
                $validated['rating'],

            'tanggal_ulasan' =>
                now(),

            'email' =>
                $email,
        ]);


        /*
        |--------------------------------------------------------------------------
        | KEMBALI
        |--------------------------------------------------------------------------
        */
        return redirect()
            ->route(
                'masyarakat.ulasan',
                $event->id_event
            )
            ->with(
                'success',
                'Ulasan berhasil dikirim. Terima kasih sudah berbagi pengalaman.'
            );
    }
}
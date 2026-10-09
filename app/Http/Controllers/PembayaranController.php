<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * =========================================================
     * HALAMAN PEMBAYARAN
     * =========================================================
     */
    public function create($id)
    {
        $pendaftaran = Pendaftaran::query()
            ->with([
                'event.kategori',
                'event.lokasi',
                'masyarakat',
                'pembayaran',
            ])
            ->findOrFail($id);

        $event = $pendaftaran->event;

        /*
        |--------------------------------------------------------------------------
        | EVENT GRATIS
        |--------------------------------------------------------------------------
        */
        if ((float) $event->biaya_pendaftaran <= 0) {

            DB::transaction(function () use ($pendaftaran) {

                $pendaftaran->update([
                    'status' => 'terdaftar',
                ]);

                Peserta::query()
                    ->where(
                        'id_event',
                        $pendaftaran->id_event
                    )
                    ->where(
                        'email_peserta',
                        optional($pendaftaran->masyarakat)->email
                    )
                    ->update([
                        'id_status_peserta' => 'terdaftar',
                    ]);
            });

            return redirect()->route(
                'masyarakat.registrasi.berhasil',
                $pendaftaran->id_pendaftaran
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SUDAH BERHASIL DIBAYAR
        |--------------------------------------------------------------------------
        */
        if (
            $pendaftaran->pembayaran
            &&
            $pendaftaran->pembayaran->status_pembayaran === 'berhasil'
        ) {

            $pendaftaran->update([
                'status' => 'terdaftar',
            ]);

            Peserta::query()
                ->where(
                    'id_event',
                    $pendaftaran->id_event
                )
                ->where(
                    'email_peserta',
                    optional($pendaftaran->masyarakat)->email
                )
                ->update([
                    'id_status_peserta' => 'terdaftar',
                ]);

            return redirect()->route(
                'masyarakat.registrasi.berhasil',
                $pendaftaran->id_pendaftaran
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PASTIKAN STATUS MENUNGGU PEMBAYARAN
        |--------------------------------------------------------------------------
        */
        if ($pendaftaran->status !== 'menunggu_pembayaran') {

            $pendaftaran->update([
                'status' => 'menunggu_pembayaran',
            ]);

            Peserta::query()
                ->where(
                    'id_event',
                    $pendaftaran->id_event
                )
                ->where(
                    'email_peserta',
                    optional($pendaftaran->masyarakat)->email
                )
                ->update([
                    'id_status_peserta' =>
                        'menunggu_pembayaran',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN PEMBAYARAN
        |--------------------------------------------------------------------------
        */
        return view(
            'masyarakat.pembayaran',
            compact(
                'pendaftaran',
                'event'
            )
        );
    }


    /**
     * =========================================================
     * PROSES PEMBAYARAN
     * =========================================================
     */
    public function proses(
        Request $request,
        $id
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDASI UTAMA
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'metode_pembayaran' => [
                'required',
                'in:transfer,qris,e-wallet',
            ],
        ], [
            'metode_pembayaran.required' =>
                'Metode pembayaran wajib dipilih.',

            'metode_pembayaran.in' =>
                'Metode pembayaran tidak valid.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | VALIDASI TRANSFER BANK
        |--------------------------------------------------------------------------
        */
        if (
            $request->metode_pembayaran === 'transfer'
        ) {

            $request->validate([
                'bank' => [
                    'required',
                    'in:BCA,Mandiri,BRI,BNI',
                ],
            ], [
                'bank.required' =>
                    'Silakan pilih bank terlebih dahulu.',

                'bank.in' =>
                    'Bank yang dipilih tidak valid.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDASI E-WALLET
        |--------------------------------------------------------------------------
        */
        if (
            $request->metode_pembayaran === 'e-wallet'
        ) {

            $request->validate([
                'e_wallet' => [
                    'required',
                    'in:GoPay,OVO,DANA',
                ],
            ], [
                'e_wallet.required' =>
                    'Silakan pilih E-Wallet terlebih dahulu.',

                'e_wallet.in' =>
                    'E-Wallet yang dipilih tidak valid.',
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL PENDAFTARAN
        |--------------------------------------------------------------------------
        */
        $pendaftaran = Pendaftaran::query()
            ->with([
                'event',
                'masyarakat',
            ])
            ->findOrFail($id);

        $event = $pendaftaran->event;


        /*
        |--------------------------------------------------------------------------
        | EVENT GRATIS
        |--------------------------------------------------------------------------
        */
        if ((float) $event->biaya_pendaftaran <= 0) {

            DB::transaction(function () use ($pendaftaran) {

                $pendaftaran->update([
                    'status' => 'terdaftar',
                ]);

                Peserta::query()
                    ->where(
                        'id_event',
                        $pendaftaran->id_event
                    )
                    ->where(
                        'email_peserta',
                        optional($pendaftaran->masyarakat)->email
                    )
                    ->update([
                        'id_status_peserta' => 'terdaftar',
                    ]);
            });

            return redirect()->route(
                'masyarakat.registrasi.berhasil',
                $pendaftaran->id_pendaftaran
            );
        }


        /*
        |--------------------------------------------------------------------------
        | NOMINAL PEMBAYARAN
        |--------------------------------------------------------------------------
        */
        $jumlahBayar =
            (float) $event->biaya_pendaftaran;


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PEMBAYARAN
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $request,
            $pendaftaran,
            $jumlahBayar
        ) {

            Pembayaran::updateOrCreate(
                [
                    'id_pendaftaran' =>
                        $pendaftaran->id_pendaftaran,
                ],
                [
                    'metode_pembayaran' =>
                        $request->metode_pembayaran,

                    'status_pembayaran' =>
                        'berhasil',

                    'tanggal_pembayaran' =>
                        now(),

                    'jumlah_bayar' =>
                        $jumlahBayar,
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | UPDATE PENDAFTARAN
            |--------------------------------------------------------------------------
            */
            $pendaftaran->update([
                'status' => 'terdaftar',
            ]);


            /*
            |--------------------------------------------------------------------------
            | UPDATE PESERTA
            |--------------------------------------------------------------------------
            */
            Peserta::query()
                ->where(
                    'id_event',
                    $pendaftaran->id_event
                )
                ->where(
                    'email_peserta',
                    optional($pendaftaran->masyarakat)->email
                )
                ->update([
                    'id_status_peserta' =>
                        'terdaftar',
                ]);
        });


        /*
        |--------------------------------------------------------------------------
        | KE REGISTRASI BERHASIL
        |--------------------------------------------------------------------------
        */
        return redirect()->route(
            'masyarakat.registrasi.berhasil',
            $pendaftaran->id_pendaftaran
        )->with(
            'success',
            'Pembayaran berhasil. Pendaftaran kamu telah dikonfirmasi.'
        );
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Masyarakat;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    /**
     * =========================================================
     * FORM REGISTRASI
     * =========================================================
     */
    public function create($id)
    {
        $event = Event::query()
            ->where('status', 'disetujui')
            ->with([
                'kategori',
                'lokasi',
            ])
            ->findOrFail($id);

        return view(
            'masyarakat.form-registrasi',
            compact('event')
        );
    }

    /**
     * =========================================================
     * SIMPAN FORM REGISTRASI
     * =========================================================
     *
     * ALUR:
     *
     * GRATIS:
     * Form → langsung terdaftar → Registrasi Berhasil
     *
     * BERBAYAR:
     * Form → Session → Konfirmasi → Pembayaran
     *
     */
    public function simpanForm(Request $request)
    {
        /**
         * ---------------------------------------------------------
         * VALIDASI
         * ---------------------------------------------------------
         */
        $validated = $request->validate([
            'id_event' => [
                'required',
                'integer',
                'exists:event,id_event',
            ],

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:100',
            ],

            'no_hp' => [
                'required',
                'string',
                'max:20',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
            ],

            'jenis_kelamin' => [
                'required',
                'in:Laki-laki,Perempuan',
            ],

            'alamat' => [
                'required',
                'string',
            ],

            'setuju' => [
                'required',
                'accepted',
            ],
        ], [
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

            'no_hp.required' =>
                'Nomor telepon wajib diisi.',

            'tanggal_lahir.required' =>
                'Tanggal lahir wajib diisi.',

            'jenis_kelamin.required' =>
                'Jenis kelamin wajib dipilih.',

            'alamat.required' =>
                'Alamat wajib diisi.',

            'setuju.required' =>
                'Persetujuan wajib dicentang.',

            'setuju.accepted' =>
                'Kamu harus menyetujui syarat dan ketentuan.',
        ]);

        /**
         * ---------------------------------------------------------
         * NORMALISASI DATA
         * ---------------------------------------------------------
         */
        $validated['nama'] = trim(
            $validated['nama']
        );

        $validated['email'] = strtolower(
            trim($validated['email'])
        );

        $validated['no_hp'] = trim(
            $validated['no_hp']
        );

        $validated['alamat'] = trim(
            $validated['alamat']
        );

        /**
         * ---------------------------------------------------------
         * AMBIL EVENT
         * ---------------------------------------------------------
         */
        $event = Event::query()
            ->where('status', 'disetujui')
            ->with([
                'kategori',
                'lokasi',
            ])
            ->find(
                $validated['id_event']
            );

        if (!$event) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Event tidak ditemukan atau belum disetujui.'
                );
        }

        /**
         * ---------------------------------------------------------
         * DATA PENDAFTARAN
         * ---------------------------------------------------------
         */
        $dataPendaftaran = [
            'id_event' => $event->id_event,

            'nama' =>
                $validated['nama'],

            'email' =>
                $validated['email'],

            'no_hp' =>
                $validated['no_hp'],

            'tanggal_lahir' =>
                $validated['tanggal_lahir'],

            'jenis_kelamin' =>
                $validated['jenis_kelamin'],

            'alamat' =>
                $validated['alamat'],
        ];

        /**
         * ---------------------------------------------------------
         * CEK DATA MASYARAKAT
         * ---------------------------------------------------------
         */
        $masyarakat = Masyarakat::query()
            ->where(
                'email',
                $validated['email']
            )
            ->first();

        /**
         * ---------------------------------------------------------
         * CEK PENDAFTARAN LAMA
         * ---------------------------------------------------------
         */
        $pendaftaranLama = null;

        if ($masyarakat) {
            $pendaftaranLama = Pendaftaran::query()
                ->with('pembayaran')
                ->where(
                    'id_masyarakat',
                    $masyarakat->id_masyarakat
                )
                ->where(
                    'id_event',
                    $event->id_event
                )
                ->latest('id_pendaftaran')
                ->first();
        }

        /**
         * =========================================================
         * EVENT GRATIS
         * =========================================================
         */
        if (
            (float) $event->biaya_pendaftaran <= 0
        ) {
            /**
             * -----------------------------------------------------
             * JIKA SUDAH ADA PENDAFTARAN LAMA
             * -----------------------------------------------------
             */
            if ($pendaftaranLama) {

                $pendaftaranLama->update([
                    'status' => 'terdaftar',
                ]);

                /**
                 * Update peserta
                 */
                $peserta = Peserta::query()
                    ->where(
                        'id_event',
                        $event->id_event
                    )
                    ->where(
                        'email_peserta',
                        $validated['email']
                    )
                    ->latest('id_peserta')
                    ->first();

                if ($peserta) {

                    $peserta->update([
                        'nama_peserta' =>
                            $validated['nama'],

                        'no_hp_peserta' =>
                            $validated['no_hp'],

                        'id_status_peserta' =>
                            'terdaftar',
                    ]);

                } else {

                    Peserta::create([
                        'id_event' =>
                            $event->id_event,

                        'nama_peserta' =>
                            $validated['nama'],

                        'email_peserta' =>
                            $validated['email'],

                        'no_hp_peserta' =>
                            $validated['no_hp'],

                        'id_status_peserta' =>
                            'terdaftar',
                    ]);
                }

                session([
                    'pendaftaran_id' =>
                        $pendaftaranLama->id_pendaftaran,
                ]);

                return redirect()
                    ->route(
                        'masyarakat.registrasi.berhasil',
                        $pendaftaranLama->id_pendaftaran
                    );
            }

            /**
             * -----------------------------------------------------
             * PENDAFTARAN BARU GRATIS
             * -----------------------------------------------------
             */
            $pendaftaran =
                $this->simpanDataPendaftaran(
                    $dataPendaftaran,
                    'terdaftar'
                );

            session([
                'pendaftaran_id' =>
                    $pendaftaran->id_pendaftaran,
            ]);

            return redirect()
                ->route(
                    'masyarakat.registrasi.berhasil',
                    $pendaftaran->id_pendaftaran
                );
        }

        /**
         * =========================================================
         * EVENT BERBAYAR
         * =========================================================
         *
         * Form
         *   ↓
         * Konfirmasi
         *   ↓
         * Pembayaran
         *   ↓
         * Terdaftar
         */

        /**
         * ---------------------------------------------------------
         * JIKA ADA PENDAFTARAN LAMA
         * ---------------------------------------------------------
         */
        if ($pendaftaranLama) {

            /**
             * Cek pembayaran
             */
            $pembayaranBerhasil = false;

            if (
                $pendaftaranLama->pembayaran
                &&
                $pendaftaranLama->pembayaran
                    ->status_pembayaran === 'berhasil'
            ) {
                $pembayaranBerhasil = true;
            }

            /**
             * -----------------------------------------------------
             * SUDAH BAYAR
             * -----------------------------------------------------
             */
            if (
                $pendaftaranLama->status === 'terdaftar'
                &&
                $pembayaranBerhasil
            ) {
                session([
                    'pendaftaran_id' =>
                        $pendaftaranLama->id_pendaftaran,
                ]);

                return redirect()
                    ->route(
                        'masyarakat.registrasi.berhasil',
                        $pendaftaranLama->id_pendaftaran
                    );
            }

            /**
             * -----------------------------------------------------
             * BELUM BAYAR
             * -----------------------------------------------------
             *
             * Walaupun status lama pernah "terdaftar",
             * kalau pembayaran belum berhasil,
             * status dikembalikan menjadi menunggu_pembayaran.
             */
            $pendaftaranLama->update([
                'status' =>
                    'menunggu_pembayaran',
            ]);

            /**
             * Update peserta
             */
            $peserta = Peserta::query()
                ->where(
                    'id_event',
                    $event->id_event
                )
                ->where(
                    'email_peserta',
                    $validated['email']
                )
                ->latest('id_peserta')
                ->first();

            if ($peserta) {

                $peserta->update([
                    'nama_peserta' =>
                        $validated['nama'],

                    'no_hp_peserta' =>
                        $validated['no_hp'],

                    'id_status_peserta' =>
                        'menunggu_pembayaran',
                ]);

            } else {

                Peserta::create([
                    'id_event' =>
                        $event->id_event,

                    'nama_peserta' =>
                        $validated['nama'],

                    'email_peserta' =>
                        $validated['email'],

                    'no_hp_peserta' =>
                        $validated['no_hp'],

                    'id_status_peserta' =>
                        'menunggu_pembayaran',
                ]);
            }

            /**
             * Simpan ID pendaftaran ke session
             */
            session([
                'pendaftaran_id' =>
                    $pendaftaranLama->id_pendaftaran,
            ]);

            /**
             * Langsung ke pembayaran
             */
            return redirect()
                ->route(
                    'masyarakat.pembayaran.create',
                    $pendaftaranLama->id_pendaftaran
                );
        }

        /**
         * ---------------------------------------------------------
         * PENDAFTARAN BARU EVENT BERBAYAR
         * ---------------------------------------------------------
         *
         * Belum disimpan sebagai "terdaftar".
         * Data sementara disimpan di session.
         */
        session([
            'data_pendaftaran' =>
                $dataPendaftaran,
        ]);

        return redirect()
            ->route(
                'masyarakat.registrasi.konfirmasi'
            );
    }

    /**
     * =========================================================
     * KONFIRMASI DATA PENDAFTARAN
     * =========================================================
     */
    public function konfirmasi()
    {
        /**
         * Ambil session
         */
        $data = session(
            'data_pendaftaran'
        );

        /**
         * Session tidak ada
         */
        if (
            !$data
            ||
            empty($data['id_event'])
        ) {
            return redirect()
                ->route(
                    'masyarakat.event'
                )
                ->with(
                    'error',
                    'Data pendaftaran tidak ditemukan. Silakan isi formulir kembali.'
                );
        }

        /**
         * Ambil event
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
            ->find(
                $data['id_event']
            );

        /**
         * Event tidak ada
         */
        if (!$event) {

            session()->forget(
                'data_pendaftaran'
            );

            return redirect()
                ->route(
                    'masyarakat.event'
                )
                ->with(
                    'error',
                    'Event tidak ditemukan.'
                );
        }

        /**
         * =========================================================
         * EVENT GRATIS
         * =========================================================
         *
         * Pengaman apabila halaman konfirmasi dibuka
         * untuk event gratis.
         */
        if (
            (float) $event->biaya_pendaftaran <= 0
        ) {

            $pendaftaran =
                $this->simpanDataPendaftaran(
                    $data,
                    'terdaftar'
                );

            session([
                'pendaftaran_id' =>
                    $pendaftaran->id_pendaftaran,
            ]);

            session()->forget(
                'data_pendaftaran'
            );

            return redirect()
                ->route(
                    'masyarakat.registrasi.berhasil',
                    $pendaftaran->id_pendaftaran
                );
        }

        /**
         * Tampilkan konfirmasi
         */
        return view(
            'masyarakat.konfirmasi-pendaftaran',
            compact(
                'event',
                'data'
            )
        );
    }

    /**
     * =========================================================
     * SIMPAN PENDAFTARAN SETELAH KONFIRMASI
     * =========================================================
     */
    public function simpanPendaftaran()
    {
        /**
         * Ambil session
         */
        $data = session(
            'data_pendaftaran'
        );

        /**
         * Session kosong
         */
        if (
            !$data
            ||
            empty($data['id_event'])
        ) {

            return redirect()
                ->route(
                    'masyarakat.event'
                )
                ->with(
                    'error',
                    'Data pendaftaran tidak ditemukan.'
                );
        }

        /**
         * Ambil event
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
            ->find(
                $data['id_event']
            );

        /**
         * Event tidak ditemukan
         */
        if (!$event) {

            session()->forget(
                'data_pendaftaran'
            );

            return redirect()
                ->route(
                    'masyarakat.event'
                )
                ->with(
                    'error',
                    'Event tidak ditemukan.'
                );
        }

        /**
         * =========================================================
         * EVENT GRATIS
         * =========================================================
         */
        if (
            (float) $event->biaya_pendaftaran <= 0
        ) {

            $pendaftaran =
                $this->simpanDataPendaftaran(
                    $data,
                    'terdaftar'
                );

            session([
                'pendaftaran_id' =>
                    $pendaftaran->id_pendaftaran,
            ]);

            session()->forget(
                'data_pendaftaran'
            );

            return redirect()
                ->route(
                    'masyarakat.registrasi.berhasil',
                    $pendaftaran->id_pendaftaran
                );
        }

        /**
         * =========================================================
         * EVENT BERBAYAR
         * =========================================================
         *
         * Belum boleh menjadi "terdaftar".
         */
        $pendaftaran =
            $this->simpanDataPendaftaran(
                $data,
                'menunggu_pembayaran'
            );

        /**
         * Simpan ID
         */
        session([
            'pendaftaran_id' =>
                $pendaftaran->id_pendaftaran,
        ]);

        /**
         * Hapus session form
         */
        session()->forget(
            'data_pendaftaran'
        );

        /**
         * Ke pembayaran
         */
        return redirect()
            ->route(
                'masyarakat.pembayaran.create',
                $pendaftaran->id_pendaftaran
            );
    }

    /**
     * =========================================================
     * REGISTRASI BERHASIL
     * =========================================================
     */
    public function berhasil($id)
    {
        /**
         * Ambil data
         */
        $pendaftaran = Pendaftaran::query()
            ->with([
                'event.kategori',
                'event.lokasi',
                'masyarakat',
                'pembayaran',
            ])
            ->findOrFail($id);

        /**
         * ---------------------------------------------------------
         * HARUS TERDAFTAR
         * ---------------------------------------------------------
         */
        if (
            $pendaftaran->status !== 'terdaftar'
        ) {

            /**
             * Kalau masih menunggu pembayaran
             */
            if (
                $pendaftaran->status ===
                'menunggu_pembayaran'
            ) {

                return redirect()
                    ->route(
                        'masyarakat.pembayaran.create',
                        $pendaftaran->id_pendaftaran
                    )
                    ->with(
                        'error',
                        'Silakan selesaikan pembayaran terlebih dahulu.'
                    );
            }

            return redirect()
                ->route(
                    'masyarakat.cek'
                )
                ->with(
                    'error',
                    'Pendaftaran belum berhasil.'
                );
        }

        /**
         * =========================================================
         * PENGAMAN EVENT BERBAYAR
         * =========================================================
         */
        if (
            $pendaftaran->event
            &&
            (float)
                $pendaftaran
                    ->event
                    ->biaya_pendaftaran > 0
        ) {

            $pembayaranBerhasil =
                $pendaftaran->pembayaran
                &&
                $pendaftaran
                    ->pembayaran
                    ->status_pembayaran ===
                    'berhasil';

            /**
             * Kalau belum bayar
             */
            if (!$pembayaranBerhasil) {

                $pendaftaran->update([
                    'status' =>
                        'menunggu_pembayaran',
                ]);

                /**
                 * Update peserta
                 */
                Peserta::query()
                    ->where(
                        'id_event',
                        $pendaftaran->id_event
                    )
                    ->where(
                        'email_peserta',
                        optional(
                            $pendaftaran->masyarakat
                        )->email
                    )
                    ->update([
                        'id_status_peserta' =>
                            'menunggu_pembayaran',
                    ]);

                return redirect()
                    ->route(
                        'masyarakat.pembayaran.create',
                        $pendaftaran->id_pendaftaran
                    )
                    ->with(
                        'error',
                        'Pendaftaran belum dapat dianggap berhasil karena pembayaran belum berhasil.'
                    );
            }
        }

        /**
         * Tampilkan registrasi berhasil
         */
        return view(
            'masyarakat.registrasi-berhasil',
            compact(
                'pendaftaran'
            )
        );
    }

    /**
     * =========================================================
     * KODE PENDAFTARAN
     * =========================================================
     */
    public function kode($id)
    {
        /**
         * Ambil data
         */
        $pendaftaran = Pendaftaran::query()
            ->with([
                'event.kategori',
                'event.lokasi',
                'masyarakat',
                'pembayaran',
            ])
            ->findOrFail($id);

        /**
         * ---------------------------------------------------------
         * HARUS TERDAFTAR
         * ---------------------------------------------------------
         */
        if (
            $pendaftaran->status !== 'terdaftar'
        ) {

            if (
                $pendaftaran->status ===
                'menunggu_pembayaran'
            ) {

                return redirect()
                    ->route(
                        'masyarakat.pembayaran.create',
                        $pendaftaran->id_pendaftaran
                    )
                    ->with(
                        'error',
                        'Silakan selesaikan pembayaran terlebih dahulu.'
                    );
            }

            return redirect()
                ->route(
                    'masyarakat.cek'
                )
                ->with(
                    'error',
                    'Kode pendaftaran belum dapat ditampilkan.'
                );
        }

        /**
         * =========================================================
         * EVENT BERBAYAR
         * =========================================================
         */
        if (
            $pendaftaran->event
            &&
            (float)
                $pendaftaran
                    ->event
                    ->biaya_pendaftaran > 0
        ) {

            $pembayaranBerhasil =
                $pendaftaran->pembayaran
                &&
                $pendaftaran
                    ->pembayaran
                    ->status_pembayaran ===
                    'berhasil';

            if (!$pembayaranBerhasil) {

                $pendaftaran->update([
                    'status' =>
                        'menunggu_pembayaran',
                ]);

                return redirect()
                    ->route(
                        'masyarakat.pembayaran.create',
                        $pendaftaran->id_pendaftaran
                    )
                    ->with(
                        'error',
                        'Pembayaran belum berhasil.'
                    );
            }
        }

        /**
         * Tampilkan kode
         */
        return view(
            'masyarakat.kode-pendaftaran',
            compact(
                'pendaftaran'
            )
        );
    }

    /**
     * =========================================================
     * FORM CEK PENDAFTARAN
     * =========================================================
     */
    public function cek()
    {
        return view(
            'masyarakat.cek-pendaftaran'
        );
    }

    /**
     * =========================================================
     * HASIL CEK PENDAFTARAN
     * =========================================================
     */
    public function hasilCek(Request $request)
    {
        /**
         * Validasi
         */
        $request->validate([
            'kode_pendaftaran' => [
                'required',
                'string',
                'max:100',
            ],
        ], [
            'kode_pendaftaran.required' =>
                'Kode pendaftaran wajib diisi.',
        ]);

        /**
         * ---------------------------------------------------------
         * NORMALISASI KODE
         * ---------------------------------------------------------
         */
        $kode = strtoupper(
            preg_replace(
                '/\s+/',
                '',
                trim(
                    $request->kode_pendaftaran
                )
            )
        );

        /**
         * ---------------------------------------------------------
         * CARI PENDAFTARAN
         * ---------------------------------------------------------
         */
        $pendaftaran = Pendaftaran::query()
            ->with([
                'event.kategori',
                'event.lokasi',
                'masyarakat',
                'pembayaran',
            ])
            ->whereRaw(
                'UPPER(REPLACE(TRIM(kode_pendaftaran), " ", "")) = ?',
                [$kode]
            )
            ->first();

        /**
         * Tidak ditemukan
         */
        if (!$pendaftaran) {

            return redirect()
                ->route(
                    'masyarakat.cek'
                )
                ->withInput()
                ->with(
                    'error',
                    'Kode pendaftaran "' .
                    $kode .
                    '" tidak ditemukan.'
                );
        }

        /**
         * Tampilkan hasil
         */
        return view(
            'masyarakat.cek-pendaftaran',
            compact(
                'pendaftaran'
            )
        );
    }

    /**
     * =========================================================
     * SIMPAN DATA PENDAFTARAN
     * =========================================================
     */
    private function simpanDataPendaftaran(
        array $data,
        string $status
    ) {
        return DB::transaction(
            function () use (
                $data,
                $status
            ) {

                /**
                 * -------------------------------------------------
                 * CARI MASYARAKAT
                 * -------------------------------------------------
                 */
                $masyarakat =
                    Masyarakat::query()
                        ->where(
                            'email',
                            $data['email']
                        )
                        ->first();

                /**
                 * -------------------------------------------------
                 * UPDATE / CREATE MASYARAKAT
                 * -------------------------------------------------
                 */
                if ($masyarakat) {

                    $masyarakat->update([
                        'nama' =>
                            $data['nama'],

                        'alamat' =>
                            $data['alamat'],

                        'tanggal_lahir' =>
                            $data['tanggal_lahir'],

                        'jenis_kelamin' =>
                            $data['jenis_kelamin'],

                        'no_hp' =>
                            $data['no_hp'],

                        'email' =>
                            $data['email'],
                    ]);

                } else {

                    $masyarakat =
                        Masyarakat::create([
                            'nama' =>
                                $data['nama'],

                            'alamat' =>
                                $data['alamat'],

                            'tanggal_lahir' =>
                                $data['tanggal_lahir'],

                            'jenis_kelamin' =>
                                $data['jenis_kelamin'],

                            'no_hp' =>
                                $data['no_hp'],

                            'email' =>
                                $data['email'],
                        ]);
                }

                /**
                 * -------------------------------------------------
                 * CARI PENDAFTARAN EVENT INI
                 * -------------------------------------------------
                 */
                $pendaftaran =
                    Pendaftaran::query()
                        ->where(
                            'id_masyarakat',
                            $masyarakat
                                ->id_masyarakat
                        )
                        ->where(
                            'id_event',
                            $data['id_event']
                        )
                        ->latest('id_pendaftaran')
                        ->first();

                /**
                 * -------------------------------------------------
                 * JIKA SUDAH ADA
                 * -------------------------------------------------
                 */
                if ($pendaftaran) {

                    $pendaftaran->update([
                        'status' =>
                            $status,
                    ]);

                } else {

                    /**
                     * ---------------------------------------------
                     * GENERATE KODE UNIK
                     * ---------------------------------------------
                     */
                    do {

                        $kode =
                            'PEH-' .
                            now()->format('Ymd') .
                            '-' .
                            strtoupper(
                                Str::random(5)
                            );

                    } while (
                        Pendaftaran::query()
                            ->where(
                                'kode_pendaftaran',
                                $kode
                            )
                            ->exists()
                    );

                    /**
                     * ---------------------------------------------
                     * CREATE PENDAFTARAN
                     * ---------------------------------------------
                     */
                    $pendaftaran =
                        Pendaftaran::create([
                            'id_masyarakat' =>
                                $masyarakat
                                    ->id_masyarakat,

                            'id_event' =>
                                $data['id_event'],

                            'tanggal_daftar' =>
                                now(),

                            'status' =>
                                $status,

                            'kode_pendaftaran' =>
                                $kode,
                        ]);
                }

                /**
                 * -------------------------------------------------
                 * CARI PESERTA
                 * -------------------------------------------------
                 */
                $peserta =
                    Peserta::query()
                        ->where(
                            'id_event',
                            $data['id_event']
                        )
                        ->where(
                            'email_peserta',
                            $data['email']
                        )
                        ->latest('id_peserta')
                        ->first();

                /**
                 * -------------------------------------------------
                 * UPDATE / CREATE PESERTA
                 * -------------------------------------------------
                 */
                if ($peserta) {

                    $peserta->update([
                        'nama_peserta' =>
                            $data['nama'],

                        'email_peserta' =>
                            $data['email'],

                        'no_hp_peserta' =>
                            $data['no_hp'],

                        'id_status_peserta' =>
                            $status,
                    ]);

                } else {

                    Peserta::create([
                        'id_event' =>
                            $data['id_event'],

                        'nama_peserta' =>
                            $data['nama'],

                        'email_peserta' =>
                            $data['email'],

                        'no_hp_peserta' =>
                            $data['no_hp'],

                        'id_status_peserta' =>
                            $status,
                    ]);
                }

                /**
                 * -------------------------------------------------
                 * RETURN
                 * -------------------------------------------------
                 */
                return $pendaftaran;
            }
        );
    }
}
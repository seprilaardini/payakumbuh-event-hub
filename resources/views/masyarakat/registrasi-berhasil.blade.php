@extends('masyarakat.layout')

@section('title', 'Registrasi Berhasil')

@section('content')

@php
    $event = $pendaftaran->event;
    $masyarakat = $pendaftaran->masyarakat;
    $pembayaran = $pendaftaran->pembayaran;

    $hargaTiket = (float) ($event->biaya_pendaftaran ?? 0);

    $tanggalMulai = $event->tanggal_mulai
        ? \Carbon\Carbon::parse($event->tanggal_mulai)
        : null;

    $tanggalSelesai = $event->tanggal_selesai
        ? \Carbon\Carbon::parse($event->tanggal_selesai)
        : null;

    $statusPembayaran = strtolower(
        $pembayaran->status_pembayaran ?? ''
    );

    $statusPendaftaran = strtolower(
        $pendaftaran->status ?? ''
    );
@endphp


<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .success-page {
        max-width: 980px;
        margin: 0 auto;
        padding: 20px 0 60px;
    }


    /* =========================================================
       SUCCESS HEADER
    ========================================================= */

    .success-card {
        background: #ffffff;
        border: 1px solid #e7e0d0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 14px 40px rgba(23, 50, 77, .07);
    }


    .success-top {
        padding: 40px 35px 30px;
        text-align: center;
        background: #fffdf8;
        border-bottom: 1px solid #eee7d9;
    }


    .success-icon {
        width: 82px;
        height: 82px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #17324d;
        color: #ffffff;
        font-size: 38px;
        font-weight: 800;
        box-shadow:
            0 0 0 8px rgba(215, 169, 65, .14),
            0 10px 25px rgba(23, 50, 77, .14);
    }


    .success-title {
        margin: 0 0 10px;
        color: #17324d;
        font-size: 31px;
        line-height: 1.25;
        font-weight: 900;
    }


    .success-description {
        max-width: 650px;
        margin: 0 auto;
        color: #707c89;
        font-size: 14px;
        line-height: 1.75;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status-wrapper {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }


    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 13px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 850;
    }


    .status-success {
        color: #3f7047;
        background: #edf7ef;
        border: 1px solid #c9dfcd;
    }


    .status-paid {
        color: #8a691d;
        background: #fbf3dd;
        border: 1px solid #ead9a9;
    }


    /* =========================================================
       CONTENT
    ========================================================= */

    .success-content {
        padding: 30px;
    }


    .section-title {
        margin: 0 0 17px;
        color: #17324d;
        font-size: 18px;
        font-weight: 850;
    }


    /* =========================================================
       EVENT SUMMARY
    ========================================================= */

    .event-summary {
        display: grid;
        grid-template-columns: 190px minmax(0, 1fr);
        border: 1px solid #e7e0d5;
        border-radius: 17px;
        overflow: hidden;
    }


    .event-poster {
        min-height: 190px;
        background: linear-gradient(
            135deg,
            #17324d,
            #254d70
        );
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }


    .event-poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }


    .poster-placeholder {
        width: 68px;
        height: 68px;
        border-radius: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.28);
        color: #ffffff;
        font-size: 28px;
    }


    .event-info {
        padding: 22px;
    }


    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 7px 11px;
        border-radius: 999px;
        background: #f8f0dd;
        color: #966e17;
        font-size: 10px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 10px;
    }


    .event-title {
        margin: 0 0 16px;
        color: #17324d;
        font-size: 21px;
        line-height: 1.4;
        font-weight: 900;
    }


    /* =========================================================
       EVENT META
    ========================================================= */

    .event-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }


    .event-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        color: #687483;
        font-size: 12px;
        line-height: 1.55;
    }


    .event-meta-icon {
        width: 29px;
        height: 29px;
        flex: 0 0 29px;
        border-radius: 9px;
        background: #f6f2e9;
        color: #9b741e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
    }


    /* =========================================================
       PARTICIPANT
    ========================================================= */

    .participant-card {
        margin-top: 25px;
        border: 1px solid #e7e0d5;
        border-radius: 17px;
        overflow: hidden;
    }


    .participant-heading {
        padding: 17px 19px;
        background: #fffdf8;
        border-bottom: 1px solid #eee8db;
    }


    .participant-heading h3 {
        margin: 0;
        color: #17324d;
        font-size: 15px;
        font-weight: 850;
    }


    .participant-body {
        padding: 18px 19px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }


    .participant-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }


    .participant-label {
        color: #8a939e;
        font-size: 11px;
        font-weight: 600;
    }


    .participant-value {
        color: #2a394b;
        font-size: 13px;
        font-weight: 800;
        line-height: 1.5;
        word-break: break-word;
    }


    /* =========================================================
       PAYMENT
    ========================================================= */

    .payment-card {
        margin-top: 25px;
        padding: 19px;
        border-radius: 17px;
        background: #f9f6ee;
        border: 1px solid #ece2cf;
    }


    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 8px 0;
    }


    .payment-row span:first-child {
        color: #7f8994;
        font-size: 12px;
    }


    .payment-row span:last-child {
        color: #29384a;
        font-size: 12px;
        font-weight: 800;
        text-align: right;
    }


    .payment-divider {
        height: 1px;
        background: #e6ddcc;
        margin: 8px 0;
    }


    .payment-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding-top: 8px;
    }


    .payment-total-label {
        color: #17324d;
        font-size: 14px;
        font-weight: 850;
    }


    .payment-total-value {
        color: #17324d;
        font-size: 22px;
        font-weight: 900;
    }


    /* =========================================================
       IMPORTANT NOTICE
    ========================================================= */

    .important-note {
        margin-top: 25px;
        padding: 17px 18px;
        border-radius: 15px;
        background: #fff8e8;
        border: 1px solid #f1dfaa;
        color: #7b6325;
        font-size: 12px;
        line-height: 1.7;
    }


    .important-note strong {
        color: #6c5315;
    }


    /* =========================================================
       ACTIONS
    ========================================================= */

    .success-actions {
        display: flex;
        gap: 12px;
        margin-top: 27px;
    }


    .btn {
        min-height: 50px;
        padding: 0 20px;
        border: none;
        border-radius: 13px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-family: inherit;
        font-size: 14px;
        font-weight: 850;
        cursor: pointer;
        transition: .2s ease;
    }


    .btn-primary {
        flex: 1;
        background: #17324d;
        color: #ffffff;
        box-shadow: 0 8px 19px rgba(23, 50, 77, .17);
    }


    .btn-primary:hover {
        background: #10283e;
        transform: translateY(-1px);
    }


    .btn-secondary {
        background: #f2f0eb;
        color: #56616e;
    }


    .btn-secondary:hover {
        background: #e6e2da;
    }


    .bottom-note {
        margin-top: 14px;
        text-align: center;
        color: #9098a1;
        font-size: 11px;
        line-height: 1.6;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 760px) {

        .success-page {
            padding-top: 0;
        }


        .success-top {
            padding: 32px 20px 25px;
        }


        .success-title {
            font-size: 27px;
        }


        .success-content {
            padding: 22px;
        }


        .event-summary {
            grid-template-columns: 1fr;
        }


        .event-poster {
            min-height: 180px;
            height: 180px;
        }


        .event-meta {
            grid-template-columns: 1fr;
        }


        .participant-body {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 520px) {

        .success-page {
            padding-bottom: 35px;
        }


        .success-icon {
            width: 72px;
            height: 72px;
            font-size: 33px;
        }


        .success-title {
            font-size: 24px;
        }


        .success-description {
            font-size: 13px;
        }


        .success-content {
            padding: 18px;
        }


        .success-actions {
            flex-direction: column;
        }


        .btn-primary,
        .btn-secondary {
            width: 100%;
        }


        .payment-total-value {
            font-size: 19px;
        }
    }
</style>


<div class="success-page">

    <div class="success-card">

        {{-- =================================================
             BAGIAN SUKSES
        ================================================== --}}

        <div class="success-top">

            <div class="success-icon">
                ✓
            </div>


            <h1 class="success-title">
                Registrasi Berhasil!
            </h1>


            <p class="success-description">

                Selamat! Anda telah berhasil mendaftar
                pada event ini.

                @if($hargaTiket > 0)
                    Pembayaran Anda telah berhasil diproses.
                @else
                    Pendaftaran Anda tidak memerlukan pembayaran.
                @endif

            </p>


            {{-- STATUS --}}
            <div class="status-wrapper">

                <span class="status-badge status-success">
                    ✓ Terdaftar & Terverifikasi
                </span>


                @if($hargaTiket > 0)

                    <span class="status-badge status-paid">
                        ✓ Lunas
                    </span>

                @endif

            </div>

        </div>


        {{-- =================================================
             CONTENT
        ================================================== --}}

        <div class="success-content">


            {{-- =================================================
                 EVENT
            ================================================== --}}

            <h2 class="section-title">
                Rincian Event
            </h2>


            <div class="event-summary">

                {{-- POSTER --}}
                <div class="event-poster">

                    @if(!empty($event->poster))

                        <img
                            src="{{ asset('storage/' . $event->poster) }}"
                            alt="{{ $event->nama_event }}"
                        >

                    @else

                        <div class="poster-placeholder">
                            🎫
                        </div>

                    @endif

                </div>


                {{-- INFO EVENT --}}
                <div class="event-info">

                    <span class="category-badge">

                        {{ $event->kategori->nama_kategori ?? 'Event' }}

                    </span>


                    <h3 class="event-title">

                        {{ $event->nama_event }}

                    </h3>


                    <div class="event-meta">


                        {{-- TANGGAL --}}
                        <div class="event-meta-item">

                            <div class="event-meta-icon">
                                📅
                            </div>

                            <div>

                                @if($tanggalMulai)

                                    {{ $tanggalMulai->translatedFormat('l, d F Y') }}

                                    @if(
                                        $tanggalSelesai &&
                                        $tanggalSelesai->format('Y-m-d')
                                            !==
                                        $tanggalMulai->format('Y-m-d')
                                    )

                                        <br>

                                        s/d
                                        {{ $tanggalSelesai->translatedFormat('l, d F Y') }}

                                    @endif

                                @else

                                    Tanggal belum tersedia

                                @endif

                            </div>

                        </div>


                        {{-- WAKTU --}}
                        <div class="event-meta-item">

                            <div class="event-meta-icon">
                                🕐
                            </div>

                            <div>

                                @if($tanggalMulai)

                                    {{ $tanggalMulai->format('H:i') }}
                                    WIB

                                    @if($tanggalSelesai)

                                        —
                                        {{ $tanggalSelesai->format('H:i') }}
                                        WIB

                                    @endif

                                @else

                                    Waktu belum tersedia

                                @endif

                            </div>

                        </div>


                        {{-- LOKASI --}}
                        <div class="event-meta-item">

                            <div class="event-meta-icon">
                                📍
                            </div>

                            <div>

                                @if($event->lokasi)

                                    <strong>
                                        {{ $event->lokasi->nama_lokasi }}
                                    </strong>

                                    @if($event->lokasi->alamat_lokasi)

                                        <br>

                                        {{ $event->lokasi->alamat_lokasi }}

                                    @endif

                                @else

                                    Lokasi belum tersedia

                                @endif

                            </div>

                        </div>


                        {{-- HARGA --}}
                        <div class="event-meta-item">

                            <div class="event-meta-icon">
                                💰
                            </div>

                            <div>

                                @if($hargaTiket > 0)

                                    Rp {{ number_format($hargaTiket, 0, ',', '.') }}

                                @else

                                    Gratis

                                @endif

                            </div>

                        </div>


                    </div>

                </div>

            </div>


            {{-- =================================================
                 DATA PESERTA
            ================================================== --}}

            <div class="participant-card">

                <div class="participant-heading">

                    <h3>
                        Data Peserta
                    </h3>

                </div>


                <div class="participant-body">


                    <div class="participant-item">

                        <span class="participant-label">
                            Nama Peserta
                        </span>

                        <span class="participant-value">
                            {{ $masyarakat->nama ?? '-' }}
                        </span>

                    </div>


                    <div class="participant-item">

                        <span class="participant-label">
                            Email
                        </span>

                        <span class="participant-value">
                            {{ $masyarakat->email ?? '-' }}
                        </span>

                    </div>


                    <div class="participant-item">

                        <span class="participant-label">
                            No. Telepon
                        </span>

                        <span class="participant-value">
                            {{ $masyarakat->no_hp ?? '-' }}
                        </span>

                    </div>


                    <div class="participant-item">

                        <span class="participant-label">
                            Kode Pendaftaran
                        </span>

                        <span class="participant-value">
                            {{ $pendaftaran->kode_pendaftaran }}
                        </span>

                    </div>


                </div>

            </div>


            {{-- =================================================
                 PEMBAYARAN
            ================================================== --}}

            @if($hargaTiket > 0)

                <div class="payment-card">


                    <div class="payment-row">

                        <span>
                            Harga Tiket
                        </span>

                        <span>
                            Rp {{ number_format($hargaTiket, 0, ',', '.') }}
                        </span>

                    </div>


                    <div class="payment-row">

                        <span>
                            Metode Pembayaran
                        </span>

                        <span>

                            @if(($pembayaran->metode_pembayaran ?? '') === 'transfer')

                                Transfer Bank

                            @elseif(($pembayaran->metode_pembayaran ?? '') === 'qris')

                                QRIS

                            @elseif(($pembayaran->metode_pembayaran ?? '') === 'e-wallet')

                                E-Wallet

                            @else

                                {{ $pembayaran->metode_pembayaran ?? '-' }}

                            @endif

                        </span>

                    </div>


                    <div class="payment-row">

                        <span>
                            Status Pembayaran
                        </span>

                        <span>
                            {{ $pembayaran->status_pembayaran ?? 'Berhasil' }}
                        </span>

                    </div>


                    <div class="payment-divider"></div>


                    <div class="payment-total">

                        <span class="payment-total-label">
                            Total Bayar
                        </span>

                        <span class="payment-total-value">
                            Rp {{ number_format($hargaTiket, 0, ',', '.') }}
                        </span>

                    </div>


                </div>

            @else

                <div class="payment-card">

                    <div class="payment-total">

                        <span class="payment-total-label">
                            Total Bayar
                        </span>

                        <span class="payment-total-value">
                            Gratis
                        </span>

                    </div>

                </div>

            @endif


            {{-- =================================================
                 CATATAN PENTING
            ================================================== --}}

            <div class="important-note">

                <strong>
                    Penting:
                </strong>

                <br>

                Simpan kode pendaftaran Anda.

                Kode ini dapat digunakan untuk mengecek
                status pendaftaran melalui menu
                <strong>Cek Pendaftaran</strong>.

                Tunjukkan kode tersebut kepada panitia
                saat diperlukan.

            </div>


            {{-- =================================================
                 ACTION
            ================================================== --}}

            <div class="success-actions">


                <a
                    href="{{ route('masyarakat.beranda') }}"
                    class="btn btn-secondary"
                >
                    ← Kembali ke Beranda
                </a>


                <a
                    href="{{ route('masyarakat.registrasi.kode', $pendaftaran->id_pendaftaran) }}"
                    class="btn btn-primary"
                >
                    Lihat Kode Pendaftaran →
                </a>


            </div>


            <div class="bottom-note">

                Simpan kode pendaftaran sampai event selesai.

            </div>

        </div>

    </div>

</div>

@endsection
@extends('masyarakat.layout')

@section('title', 'Cek Pendaftaran')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | CEK APAKAH ADA HASIL PENDAFTARAN
    |--------------------------------------------------------------------------
    */

    $adaHasil = isset($pendaftaran) && $pendaftaran;


    /*
    |--------------------------------------------------------------------------
    | DATA HASIL
    |--------------------------------------------------------------------------
    */

    if ($adaHasil) {

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

        $statusPendaftaran = strtolower(
            trim($pendaftaran->status ?? '')
        );

        $statusPembayaran = strtolower(
            trim($pembayaran->status_pembayaran ?? '')
        );
    }
@endphp


<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .check-page {
        max-width: 1050px;
        margin: 0 auto;
        padding: 10px 0 55px;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .check-header {
        margin-bottom: 28px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #667281;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
        transition: .2s ease;
    }

    .back-link:hover {
        color: #17324d;
        transform: translateX(-2px);
    }

    .check-title {
        margin: 0 0 8px;
        color: #17324d;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 900;
    }

    .check-subtitle {
        margin: 0;
        color: #75808d;
        font-size: 14px;
        line-height: 1.7;
    }


    /* =========================================================
       SEARCH CARD
    ========================================================= */

    .search-card {
        background: #fff;
        border: 1px solid #e7e0d0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(23, 50, 77, .06);
    }

    .search-heading {
        padding: 25px 26px 20px;
        background: #fffdf8;
        border-bottom: 1px solid #eee8dc;
    }

    .search-heading h2 {
        margin: 0 0 7px;
        color: #17324d;
        font-size: 20px;
        font-weight: 850;
    }

    .search-heading p {
        margin: 0;
        color: #7b8592;
        font-size: 13px;
        line-height: 1.6;
    }

    .search-body {
        padding: 24px 26px;
    }


    /* =========================================================
       ERROR
    ========================================================= */

    .error-box {
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 13px;
        background: #fff4f4;
        border: 1px solid #e6baba;
        color: #963d3d;
        font-size: 13px;
        line-height: 1.6;
    }


    /* =========================================================
       SEARCH FORM
    ========================================================= */

    .search-form {
        display: flex;
        gap: 12px;
        align-items: stretch;
    }

    .search-input-wrap {
        flex: 1;
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #9a8450;
        font-size: 17px;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        height: 52px;
        box-sizing: border-box;
        padding: 0 16px 0 44px;
        border: 1px solid #dcd6ca;
        border-radius: 13px;
        background: #fff;
        color: #28384b;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        outline: none;
        text-transform: uppercase;
        transition: .2s ease;
    }

    .search-input::placeholder {
        color: #a0a7b0;
        text-transform: none;
        font-weight: 400;
    }

    .search-input:focus {
        border-color: #17324d;
        box-shadow: 0 0 0 3px rgba(23, 50, 77, .08);
    }

    .search-button {
        height: 52px;
        padding: 0 24px;
        border: 0;
        border-radius: 13px;
        background: #17324d;
        color: #fff;
        font-family: inherit;
        font-size: 14px;
        font-weight: 850;
        cursor: pointer;
        transition: .2s ease;
        white-space: nowrap;
    }

    .search-button:hover {
        background: #10283e;
        transform: translateY(-1px);
    }

    .search-help {
        margin-top: 10px;
        color: #8b949e;
        font-size: 11px;
        line-height: 1.6;
    }


    /* =========================================================
       RESULT
    ========================================================= */

    .result-wrapper {
        margin-top: 28px;
    }

    .result-card {
        background: #fff;
        border: 1px solid #e7e0d0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(23, 50, 77, .06);
    }

    .result-header {
        padding: 25px 26px;
        background: #17324d;
        color: #fff;
    }

    .result-header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
    }

    .result-header h2 {
        margin: 0 0 6px;
        font-size: 21px;
        font-weight: 900;
    }

    .result-header p {
        margin: 0;
        color: rgba(255,255,255,.72);
        font-size: 12px;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 8px 13px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 850;
        white-space: nowrap;
    }

    .status-green {
        background: #edf7ef;
        border: 1px solid #c9dfcd;
        color: #3f7047;
    }

    .status-yellow {
        background: #fbf3dd;
        border: 1px solid #ead9a9;
        color: #8a691d;
    }

    .status-red {
        background: #fff1f1;
        border: 1px solid #e8c1c1;
        color: #963d3d;
    }

    .status-grey {
        background: #f0f2f4;
        border: 1px solid #dce0e4;
        color: #66717d;
    }


    /* =========================================================
       RESULT CONTENT
    ========================================================= */

    .result-body {
        padding: 26px;
    }

    .section-title {
        margin: 0 0 16px;
        color: #17324d;
        font-size: 18px;
        font-weight: 850;
    }


    /* =========================================================
       KODE
    ========================================================= */

    .registration-code {
        margin-bottom: 25px;
        padding: 19px;
        text-align: center;
        background: #fbf8f0;
        border: 1px solid #ece2cf;
        border-radius: 16px;
    }

    .code-label {
        margin-bottom: 7px;
        color: #858e99;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .7px;
    }

    .code-value {
        color: #17324d;
        font-size: clamp(23px, 4vw, 34px);
        line-height: 1.3;
        font-weight: 950;
        letter-spacing: 3px;
        word-break: break-word;
    }


    /* =========================================================
       EVENT
    ========================================================= */

    .event-result {
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
        color: #fff;
        font-size: 28px;
    }

    .event-info {
        padding: 22px;
    }

    .category-badge {
        display: inline-flex;
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

    .event-name {
        margin: 0 0 17px;
        color: #17324d;
        font-size: 21px;
        line-height: 1.4;
        font-weight: 900;
    }


    /* =========================================================
       META
    ========================================================= */

    .event-meta {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .meta-item {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        color: #687483;
        font-size: 12px;
        line-height: 1.55;
    }

    .meta-icon {
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
       DATA PESERTA
    ========================================================= */

    .participant-section {
        margin-top: 25px;
    }

    .participant-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        border: 1px solid #e7e0d5;
        border-radius: 16px;
        overflow: hidden;
    }

    .participant-item {
        padding: 17px 19px;
        border-bottom: 1px solid #eee8df;
    }

    .participant-item:nth-child(odd) {
        border-right: 1px solid #eee8df;
    }

    .participant-item:nth-last-child(-n+2) {
        border-bottom: none;
    }

    .participant-label {
        display: block;
        margin-bottom: 5px;
        color: #8a939e;
        font-size: 11px;
        font-weight: 600;
    }

    .participant-value {
        color: #29384a;
        font-size: 13px;
        line-height: 1.5;
        font-weight: 800;
        word-break: break-word;
    }


    /* =========================================================
       PAYMENT
    ========================================================= */

    .payment-result {
        margin-top: 25px;
        padding: 18px;
        border-radius: 16px;
        background: #f9f6ee;
        border: 1px solid #ece2cf;
    }

    .payment-result-title {
        margin: 0 0 11px;
        color: #17324d;
        font-size: 15px;
        font-weight: 850;
    }

    .payment-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 7px 0;
        font-size: 12px;
    }

    .payment-row span:first-child {
        color: #808a95;
    }

    .payment-row span:last-child {
        color: #29384a;
        font-weight: 800;
        text-align: right;
    }


    /* =========================================================
       IMPORTANT
    ========================================================= */

    .important-box {
        margin-top: 25px;
        padding: 17px 18px;
        border-radius: 15px;
        background: #fff8e8;
        border: 1px solid #f1dfaa;
        color: #7b6325;
        font-size: 12px;
        line-height: 1.7;
    }

    .important-box strong {
        color: #6d5416;
    }


    /* =========================================================
       ACTION
    ========================================================= */

    .result-actions {
        display: flex;
        gap: 12px;
        margin-top: 26px;
    }

    .btn {
        min-height: 48px;
        padding: 0 19px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        font-family: inherit;
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-primary {
        flex: 1;
        background: #17324d;
        color: #fff;
        box-shadow: 0 8px 18px rgba(23, 50, 77, .16);
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


    /* =========================================================
       EMPTY INFO
    ========================================================= */

    .empty-info {
        margin-top: 28px;
        padding: 38px 25px;
        text-align: center;
        background: #fff;
        border: 1px solid #e7e0d0;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(23, 50, 77, .05);
    }

    .empty-icon {
        width: 62px;
        height: 62px;
        margin: 0 auto 15px;
        border-radius: 17px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f2e8;
        color: #99731e;
        font-size: 26px;
    }

    .empty-info h3 {
        margin: 0 0 7px;
        color: #17324d;
        font-size: 17px;
        font-weight: 850;
    }

    .empty-info p {
        max-width: 550px;
        margin: 0 auto;
        color: #7b8592;
        font-size: 12px;
        line-height: 1.7;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 760px) {

        .check-page {
            padding-top: 0;
        }

        .check-title {
            font-size: 25px;
        }

        .search-heading,
        .search-body {
            padding-left: 18px;
            padding-right: 18px;
        }

        .search-form {
            flex-direction: column;
        }

        .search-button {
            width: 100%;
        }

        .result-header {
            padding: 20px;
        }

        .result-header-top {
            flex-direction: column;
            gap: 12px;
        }

        .result-body {
            padding: 18px;
        }

        .event-result {
            grid-template-columns: 1fr;
        }

        .event-poster {
            height: 180px;
            min-height: 180px;
        }

        .event-meta {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 560px) {

        .participant-grid {
            grid-template-columns: 1fr;
        }

        .participant-item:nth-child(odd) {
            border-right: none;
        }

        .participant-item {
            border-bottom: 1px solid #eee8df !important;
        }

        .participant-item:last-child {
            border-bottom: none !important;
        }

        .result-actions {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
        }

        .code-value {
            font-size: 23px;
            letter-spacing: 2px;
        }
    }
</style>


<div class="check-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="check-header">

        <a
            href="{{ route('masyarakat.beranda') }}"
            class="back-link"
        >
            ← Kembali ke Beranda
        </a>


        <h1 class="check-title">
            Cek Pendaftaran
        </h1>


        <p class="check-subtitle">
            Masukkan kode pendaftaran untuk melihat status
            dan informasi pendaftaran event Anda.
        </p>

    </div>


    {{-- =====================================================
         FORM CEK
    ====================================================== --}}

    <div class="search-card">

        <div class="search-heading">

            <h2>
                Cek Status Pendaftaran Event Anda
            </h2>

            <p>
                Gunakan kode pendaftaran yang diberikan setelah
                proses registrasi berhasil.
            </p>

        </div>


        <div class="search-body">


            {{-- ERROR --}}
            @if(session('error'))

                <div class="error-box">
                    {{ session('error') }}
                </div>

            @endif


            @if($errors->any())

                <div class="error-box">

                    <strong>
                        Kode pendaftaran belum dapat diproses.
                    </strong>

                    <ul style="margin:7px 0 0 18px; padding:0;">

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('masyarakat.cek.hasil') }}"
                method="POST"
                class="search-form"
            >

                @csrf


                <div class="search-input-wrap">

                    <span class="search-icon">
                        🔎
                    </span>


                    <input
                        type="text"
                        name="kode_pendaftaran"
                        class="search-input"
                        value="{{ old('kode_pendaftaran') }}"
                        placeholder="Contoh: PEH-2026-XXXX"
                        autocomplete="off"
                        required
                    >

                </div>


                <button
                    type="submit"
                    class="search-button"
                >
                    Cek Status
                </button>

            </form>


            <div class="search-help">

                Contoh format kode:
                <strong>PEH-2026-XXXXX</strong>.
                Masukkan kode sesuai dengan yang Anda terima setelah registrasi.

            </div>

        </div>

    </div>


    {{-- =====================================================
         HASIL
    ====================================================== --}}

    @if($adaHasil)

        <div class="result-wrapper">

            <div class="result-card">


                {{-- =================================================
                     RESULT HEADER
                ================================================== --}}

                <div class="result-header">

                    <div class="result-header-top">

                        <div>

                            <h2>
                                Hasil Pencarian Status
                            </h2>

                            <p>
                                Informasi pendaftaran berdasarkan kode yang Anda masukkan.
                            </p>

                        </div>


                        {{-- STATUS PENDAFTARAN --}}
                        @if($statusPendaftaran === 'terdaftar')

                            <span class="status-badge status-green">
                                ✓ Terdaftar
                            </span>

                        @elseif(
                            $statusPendaftaran === 'menunggu_pembayaran'
                        )

                            <span class="status-badge status-yellow">
                                ⏳ Menunggu Pembayaran
                            </span>

                        @elseif(
                            $statusPendaftaran === 'dibatalkan'
                            ||
                            $statusPendaftaran === 'ditolak'
                        )

                            <span class="status-badge status-red">
                                ✕ {{ ucfirst(str_replace('_', ' ', $statusPendaftaran)) }}
                            </span>

                        @else

                            <span class="status-badge status-grey">
                                {{ ucfirst(str_replace('_', ' ', $statusPendaftaran ?: 'Belum Diproses')) }}
                            </span>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                     RESULT BODY
                ================================================== --}}

                <div class="result-body">


                    {{-- =================================================
                         KODE PENDAFTARAN
                    ================================================== --}}

                    <div class="registration-code">

                        <div class="code-label">
                            Kode Pendaftaran
                        </div>

                        <div class="code-value">
                            {{ $pendaftaran->kode_pendaftaran }}
                        </div>

                    </div>


                    {{-- =================================================
                         RINCIAN EVENT
                    ================================================== --}}

                    <h3 class="section-title">
                        Rincian Event
                    </h3>


                    <div class="event-result">


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


                        {{-- EVENT INFO --}}
                        <div class="event-info">

                            <span class="category-badge">

                                {{ $event->kategori->nama_kategori ?? 'Event' }}

                            </span>


                            <h3 class="event-name">

                                {{ $event->nama_event }}

                            </h3>


                            <div class="event-meta">


                                {{-- TANGGAL --}}
                                <div class="meta-item">

                                    <div class="meta-icon">
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
                                <div class="meta-item">

                                    <div class="meta-icon">
                                        🕐
                                    </div>

                                    <div>

                                        @if($tanggalMulai)

                                            {{ $tanggalMulai->format('H:i') }}
                                            WIB

                                        @else

                                            Waktu belum tersedia

                                        @endif

                                    </div>

                                </div>


                                {{-- LOKASI --}}
                                <div class="meta-item">

                                    <div class="meta-icon">
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
                                <div class="meta-item">

                                    <div class="meta-icon">
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

                    <div class="participant-section">

                        <h3 class="section-title">
                            Data Peserta
                        </h3>


                        <div class="participant-grid">


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
                                    Tanggal Daftar
                                </span>

                                <span class="participant-value">

                                    @if($pendaftaran->tanggal_daftar)

                                        {{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->translatedFormat('d F Y, H:i') }}
                                        WIB

                                    @else

                                        -

                                    @endif

                                </span>

                            </div>


                        </div>

                    </div>


                    {{-- =================================================
                         PEMBAYARAN
                    ================================================== --}}

                    @if($hargaTiket > 0)

                        <div class="payment-result">

                            <h3 class="payment-result-title">
                                Informasi Pembayaran
                            </h3>


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

                                    @if(
                                        ($pembayaran->metode_pembayaran ?? '')
                                        ===
                                        'transfer'
                                    )

                                        Transfer Bank

                                    @elseif(
                                        ($pembayaran->metode_pembayaran ?? '')
                                        ===
                                        'qris'
                                    )

                                        QRIS

                                    @elseif(
                                        ($pembayaran->metode_pembayaran ?? '')
                                        ===
                                        'e-wallet'
                                    )

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

                                    @if(
                                        $statusPembayaran === 'berhasil'
                                        ||
                                        $statusPembayaran === 'lunas'
                                    )

                                        Berhasil

                                    @elseif(
                                        $statusPembayaran === 'menunggu'
                                    )

                                        Menunggu Pembayaran

                                    @else

                                        {{ $pembayaran->status_pembayaran ?? 'Belum Dibayar' }}

                                    @endif

                                </span>

                            </div>


                            @if($pembayaran)

                                <div class="payment-row">

                                    <span>
                                        Tanggal Pembayaran
                                    </span>

                                    <span>

                                        @if($pembayaran->tanggal_pembayaran)

                                            {{ \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->translatedFormat('d F Y, H:i') }}
                                            WIB

                                        @else

                                            -

                                        @endif

                                    </span>

                                </div>

                            @endif


                        </div>

                    @else

                        <div class="payment-result">

                            <h3 class="payment-result-title">
                                Informasi Pembayaran
                            </h3>


                            <div class="payment-row">

                                <span>
                                    Harga Tiket
                                </span>

                                <span>
                                    Gratis
                                </span>

                            </div>


                            <div class="payment-row">

                                <span>
                                    Status
                                </span>

                                <span>
                                    Tidak memerlukan pembayaran
                                </span>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                         CATATAN
                    ================================================== --}}

                    <div class="important-box">

                        <strong>
                            Penting:
                        </strong>

                        <br>

                        Simpan kode
                        <strong>
                            {{ $pendaftaran->kode_pendaftaran }}
                        </strong>
                        untuk keperluan pengecekan pendaftaran.

                        Kode tersebut juga dapat ditunjukkan
                        kepada panitia saat diperlukan.

                    </div>


                    {{-- =================================================
                         ACTION
                    ================================================== --}}

                    <div class="result-actions">


                        @if($statusPendaftaran === 'terdaftar')

                            <a
                                href="{{ route('masyarakat.registrasi.kode', $pendaftaran->id_pendaftaran) }}"
                                class="btn btn-primary"
                            >
                                🎫 Lihat Kode Pendaftaran
                            </a>

                        @endif


                        <a
                            href="{{ route('masyarakat.beranda') }}"
                            class="btn btn-secondary"
                        >
                            ← Beranda
                        </a>

                    </div>

                </div>

            </div>

        </div>

    @else

        {{-- =====================================================
             INFORMASI AWAL
        ====================================================== --}}

        <div class="empty-info">

            <div class="empty-icon">
                🔎
            </div>


            <h3>
                Belum Ada Hasil Pencarian
            </h3>


            <p>

                Masukkan kode pendaftaran yang Anda terima
                setelah melakukan registrasi untuk melihat
                status pendaftaran event.

            </p>

        </div>

    @endif

</div>

@endsection
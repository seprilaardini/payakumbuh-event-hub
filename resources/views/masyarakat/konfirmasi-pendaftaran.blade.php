@extends('masyarakat.layout')

@section('title', 'Konfirmasi Pendaftaran')

@section('content')

@php
    $hargaTiket = (float) ($event->biaya_pendaftaran ?? 0);

    $nama = $data['nama'] ?? '';
    $email = $data['email'] ?? '';
    $noHp = $data['no_hp'] ?? '';
    $tanggalLahir = $data['tanggal_lahir'] ?? '';
    $jenisKelamin = $data['jenis_kelamin'] ?? '';
    $alamat = $data['alamat'] ?? '';

    $tanggalEvent = $event->tanggal_mulai
        ? \Carbon\Carbon::parse($event->tanggal_mulai)
        : null;

    $tanggalSelesai = $event->tanggal_selesai
        ? \Carbon\Carbon::parse($event->tanggal_selesai)
        : null;
@endphp

<style>
    .confirm-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 10px 0 50px;
    }

    .confirm-header {
        margin-bottom: 28px;
    }

    .confirm-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #5b6677;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 18px;
        transition: .2s ease;
    }

    .confirm-back:hover {
        color: #17324d;
        transform: translateX(-2px);
    }

    .confirm-title {
        font-size: 30px;
        line-height: 1.2;
        font-weight: 800;
        color: #17324d;
        margin: 0 0 8px;
    }

    .confirm-subtitle {
        margin: 0;
        color: #697586;
        font-size: 15px;
        line-height: 1.7;
    }

    .progress-wrap {
        background: #fff;
        border: 1px solid #e8e0cf;
        border-radius: 18px;
        padding: 20px 22px;
        margin-bottom: 28px;
        box-shadow: 0 8px 25px rgba(23, 50, 77, .05);
    }

    .progress {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .progress-item {
        position: relative;
        text-align: center;
    }

    .progress-item:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 18px;
        left: calc(50% + 20px);
        width: calc(100% - 40px);
        height: 2px;
        background: #ddd6c5;
    }

    .progress-item.done:not(:last-child)::after {
        background: #d7a941;
    }

    .progress-number {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        border: 2px solid #d9d2c2;
        background: #fff;
        color: #9aa2ae;
        position: relative;
        z-index: 2;
    }

    .progress-item.done .progress-number,
    .progress-item.active .progress-number {
        background: #17324d;
        border-color: #17324d;
        color: #fff;
    }

    .progress-item.active .progress-number {
        box-shadow: 0 0 0 5px rgba(215, 169, 65, .14);
    }

    .progress-label {
        display: block;
        margin-top: 9px;
        font-size: 13px;
        font-weight: 700;
        color: #9aa2ae;
    }

    .progress-item.done .progress-label,
    .progress-item.active .progress-label {
        color: #17324d;
    }

    .confirm-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(320px, .8fr);
        gap: 24px;
        align-items: start;
    }

    .confirm-card {
        background: #fff;
        border: 1px solid #e8e0cf;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(23, 50, 77, .06);
        overflow: hidden;
    }

    .card-heading {
        padding: 22px 24px;
        border-bottom: 1px solid #eee8da;
        background: #fffdf8;
    }

    .card-heading h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 800;
        color: #17324d;
    }

    .card-heading p {
        margin: 6px 0 0;
        color: #788392;
        font-size: 13px;
    }

    .card-body {
        padding: 24px;
    }

    .participant-box {
        border: 1px solid #ece6da;
        border-radius: 16px;
        overflow: hidden;
    }

    .info-row {
        display: grid;
        grid-template-columns: 170px minmax(0, 1fr);
        gap: 15px;
        padding: 16px 18px;
        border-bottom: 1px solid #eee8da;
    }

    .info-row:last-child {
        border-bottom: 0;
    }

    .info-label {
        color: #7c8794;
        font-size: 13px;
        font-weight: 600;
    }

    .info-value {
        color: #253346;
        font-size: 14px;
        font-weight: 700;
        word-break: break-word;
    }

    .event-card {
        overflow: hidden;
    }

    .event-poster {
        height: 190px;
        background:
            linear-gradient(135deg, rgba(23, 50, 77, .96), rgba(32, 71, 102, .92));
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        position: relative;
    }

    .event-poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .poster-placeholder {
        width: 72px;
        height: 72px;
        border: 1px solid rgba(255,255,255,.35);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        background: rgba(255,255,255,.08);
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
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 11px;
    }

    .event-name {
        font-size: 20px;
        line-height: 1.4;
        font-weight: 800;
        color: #17324d;
        margin: 0 0 16px;
    }

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 11px;
    }

    .event-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #667281;
        font-size: 13px;
        line-height: 1.5;
    }

    .event-meta-icon {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #f6f2e8;
        color: #9b741e;
        font-size: 13px;
    }

    .price-box {
        margin-top: 20px;
        padding: 16px;
        border-radius: 14px;
        background: #f9f6ee;
        border: 1px solid #eee5d2;
    }

    .price-label {
        display: block;
        font-size: 12px;
        color: #818b98;
        margin-bottom: 5px;
    }

    .price-value {
        color: #17324d;
        font-size: 23px;
        font-weight: 900;
    }

    .notice-box {
        margin-top: 20px;
        padding: 15px 16px;
        border-radius: 14px;
        background: #fff8e8;
        border: 1px solid #f1dfaa;
        color: #7d6426;
        font-size: 13px;
        line-height: 1.65;
    }

    .notice-box strong {
        color: #6d5416;
    }

    .confirm-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .btn {
        border: 0;
        border-radius: 12px;
        min-height: 48px;
        padding: 0 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
        font-weight: 800;
        transition: .2s ease;
    }

    .btn-back {
        background: #f3f1ec;
        color: #4f5b69;
    }

    .btn-back:hover {
        background: #e9e5dc;
    }

    .btn-primary {
        flex: 1;
        background: #17324d;
        color: #fff;
        box-shadow: 0 7px 18px rgba(23, 50, 77, .18);
    }

    .btn-primary:hover {
        background: #10283e;
        transform: translateY(-1px);
    }

    .secure-note {
        margin-top: 14px;
        text-align: center;
        color: #87919e;
        font-size: 12px;
    }

    @media (max-width: 900px) {
        .confirm-grid {
            grid-template-columns: 1fr;
        }

        .event-card {
            order: -1;
        }
    }

    @media (max-width: 640px) {
        .confirm-page {
            padding-top: 0;
        }

        .confirm-title {
            font-size: 25px;
        }

        .progress-wrap {
            padding: 16px 10px;
        }

        .progress {
            gap: 5px;
        }

        .progress-item:not(:last-child)::after {
            left: calc(50% + 18px);
            width: calc(100% - 36px);
        }

        .progress-number {
            width: 34px;
            height: 34px;
        }

        .progress-label {
            font-size: 11px;
        }

        .card-heading,
        .card-body {
            padding: 18px;
        }

        .info-row {
            grid-template-columns: 1fr;
            gap: 5px;
            padding: 14px 15px;
        }

        .confirm-actions {
            flex-direction: column;
        }

        .btn-back,
        .btn-primary {
            width: 100%;
        }
    }
</style>

<div class="confirm-page">

    {{-- Header --}}
    <div class="confirm-header">

        <a href="javascript:history.back()" class="confirm-back">
            ← Kembali ke Form Pendaftaran
        </a>

        <h1 class="confirm-title">
            Konfirmasi Data Pendaftaran
        </h1>

        <p class="confirm-subtitle">
            Periksa kembali data Anda sebelum melanjutkan ke pembayaran.
        </p>

    </div>


    {{-- Progress --}}
    <div class="progress-wrap">

        <div class="progress">

            <div class="progress-item done">
                <span class="progress-number">✓</span>
                <span class="progress-label">Data Peserta</span>
            </div>

            <div class="progress-item active">
                <span class="progress-number">2</span>
                <span class="progress-label">Konfirmasi</span>
            </div>

            <div class="progress-item">
                <span class="progress-number">3</span>
                <span class="progress-label">Pembayaran</span>
            </div>

        </div>

    </div>


    <div class="confirm-grid">

        {{-- =========================================
             DATA PENDAFTAR
        ========================================== --}}
        <div class="confirm-card">

            <div class="card-heading">
                <h2>Data Peserta</h2>
                <p>Pastikan seluruh informasi yang ditampilkan sudah benar.</p>
            </div>

            <div class="card-body">

                <div class="participant-box">

                    <div class="info-row">
                        <div class="info-label">
                            Nama Lengkap
                        </div>

                        <div class="info-value">
                            {{ $nama }}
                        </div>
                    </div>


                    <div class="info-row">
                        <div class="info-label">
                            Email
                        </div>

                        <div class="info-value">
                            {{ $email }}
                        </div>
                    </div>


                    <div class="info-row">
                        <div class="info-label">
                            No. Telepon
                        </div>

                        <div class="info-value">
                            {{ $noHp }}
                        </div>
                    </div>


                    <div class="info-row">
                        <div class="info-label">
                            Tanggal Lahir
                        </div>

                        <div class="info-value">

                            @if($tanggalLahir)
                                {{ \Carbon\Carbon::parse($tanggalLahir)->translatedFormat('d F Y') }}
                            @else
                                -
                            @endif

                        </div>
                    </div>


                    <div class="info-row">
                        <div class="info-label">
                            Jenis Kelamin
                        </div>

                        <div class="info-value">
                            {{ $jenisKelamin ?: '-' }}
                        </div>
                    </div>


                    <div class="info-row">
                        <div class="info-label">
                            Alamat
                        </div>

                        <div class="info-value">
                            {{ $alamat ?: '-' }}
                        </div>
                    </div>

                </div>


                {{-- Form konfirmasi --}}
                <form
                    action="{{ route('masyarakat.registrasi.simpanPendaftaran') }}"
                    method="POST"
                >

                    @csrf

                    <div class="notice-box">
                        <strong>Perhatian:</strong>
                        data yang sudah dikonfirmasi akan digunakan untuk proses
                        pendaftaran dan pembayaran event.
                    </div>


                    <div class="confirm-actions">

                        <a
                            href="javascript:history.back()"
                            class="btn btn-back"
                        >
                            ← Edit Data
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Konfirmasi & Lanjutkan
                            →
                        </button>

                    </div>

                    <div class="secure-note">
                        🔒 Data Anda digunakan hanya untuk keperluan pendaftaran event.
                    </div>

                </form>

            </div>

        </div>


        {{-- =========================================
             RINGKASAN EVENT
        ========================================== --}}
        <div class="confirm-card event-card">

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


            <div class="event-info">

                <span class="category-badge">
                    {{ $event->kategori->nama_kategori ?? 'Event' }}
                </span>


                <h2 class="event-name">
                    {{ $event->nama_event }}
                </h2>


                <div class="event-meta">

                    {{-- Tanggal --}}
                    <div class="event-meta-item">

                        <div class="event-meta-icon">
                            📅
                        </div>

                        <div>

                            @if($tanggalEvent)

                                {{ $tanggalEvent->translatedFormat('l, d F Y') }}

                                @if(
                                    $tanggalSelesai &&
                                    $tanggalSelesai->format('Y-m-d') !== $tanggalEvent->format('Y-m-d')
                                )
                                    <br>
                                    s/d {{ $tanggalSelesai->translatedFormat('l, d F Y') }}
                                @endif

                            @else
                                Tanggal belum tersedia
                            @endif

                        </div>

                    </div>


                    {{-- Waktu --}}
                    <div class="event-meta-item">

                        <div class="event-meta-icon">
                            🕐
                        </div>

                        <div>

                            @if($tanggalEvent)
                                {{ $tanggalEvent->format('H:i') }} WIB

                                @if($tanggalSelesai)
                                    — {{ $tanggalSelesai->format('H:i') }} WIB
                                @endif
                            @else
                                Waktu belum tersedia
                            @endif

                        </div>

                    </div>


                    {{-- Lokasi --}}
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

                </div>


                {{-- Harga --}}
                <div class="price-box">

                    <span class="price-label">
                        Harga Tiket
                    </span>

                    <div class="price-value">
                        Rp {{ number_format($hargaTiket, 0, ',', '.') }}
                    </div>

                </div>


                <div class="notice-box">
                    Setelah data dikonfirmasi, Anda akan diarahkan ke
                    <strong>halaman pembayaran</strong> untuk menyelesaikan
                    pendaftaran event.
                </div>

            </div>

        </div>

    </div>
@extends('masyarakat.layout')

@section('title', 'Konfirmasi Pendaftaran')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    | Data peserta berasal dari session:
    | session('data_pendaftaran')
    */

    $nama = $data['nama'] ?? '';
    $email = $data['email'] ?? '';
    $noHp = $data['no_hp'] ?? '';
    $tanggalLahir = $data['tanggal_lahir'] ?? '';
    $jenisKelamin = $data['jenis_kelamin'] ?? '';
    $alamat = $data['alamat'] ?? '';

    $hargaTiket = (float) ($event->biaya_pendaftaran ?? 0);

    $tanggalMulai = $event->tanggal_mulai
        ? \Carbon\Carbon::parse($event->tanggal_mulai)
        : null;

    $tanggalSelesai = $event->tanggal_selesai
        ? \Carbon\Carbon::parse($event->tanggal_selesai)
        : null;
@endphp


<style>
    /* =========================================================
       CONTAINER
    ========================================================= */

    .confirm-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 10px 0 55px;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .confirm-header {
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        color: #667281;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
        transition: .2s ease;
    }

    .back-link:hover {
        color: #17324d;
        transform: translateX(-2px);
    }

    .confirm-title {
        margin: 0 0 8px;
        color: #17324d;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 850;
    }

    .confirm-subtitle {
        margin: 0;
        color: #75808d;
        font-size: 14px;
        line-height: 1.7;
    }


    /* =========================================================
       PROGRESS
    ========================================================= */

    .progress-card {
        background: #fff;
        border: 1px solid #e7e0d0;
        border-radius: 18px;
        padding: 20px;
        margin-bottom: 28px;
        box-shadow: 0 8px 25px rgba(23, 50, 77, .05);
    }

    .progress {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
    }

    .progress-item {
        position: relative;
        text-align: center;
    }

    .progress-item:not(:last-child)::after {
        content: "";
        position: absolute;
        top: 18px;
        left: calc(50% + 20px);
        width: calc(100% - 40px);
        height: 2px;
        background: #ddd7ca;
    }

    .progress-item.done:not(:last-child)::after {
        background: #d7a941;
    }

    .progress-number {
        position: relative;
        z-index: 2;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #d7d1c4;
        background: #fff;
        color: #9ca4af;
        font-size: 14px;
        font-weight: 800;
    }

    .progress-item.done .progress-number,
    .progress-item.active .progress-number {
        background: #17324d;
        border-color: #17324d;
        color: #fff;
    }

    .progress-item.active .progress-number {
        box-shadow: 0 0 0 5px rgba(215, 169, 65, .14);
    }

    .progress-label {
        display: block;
        margin-top: 9px;
        font-size: 13px;
        font-weight: 750;
        color: #9ca4af;
    }

    .progress-item.done .progress-label,
    .progress-item.active .progress-label {
        color: #17324d;
    }


    /* =========================================================
       GRID
    ========================================================= */

    .confirm-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.4fr) minmax(320px, .8fr);
        gap: 24px;
        align-items: start;
    }


    /* =========================================================
       CARD
    ========================================================= */

    .confirm-card {
        background: #fff;
        border: 1px solid #e7e0d0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(23, 50, 77, .06);
    }

    .card-heading {
        padding: 22px 24px;
        background: #fffdf8;
        border-bottom: 1px solid #eee8dc;
    }

    .card-heading h2 {
        margin: 0;
        color: #17324d;
        font-size: 20px;
        font-weight: 850;
    }

    .card-heading p {
        margin: 6px 0 0;
        color: #7b8592;
        font-size: 13px;
    }

    .card-body {
        padding: 24px;
    }


    /* =========================================================
       DATA PESERTA
    ========================================================= */

    .data-list {
        border: 1px solid #e8e2d7;
        border-radius: 15px;
        overflow: hidden;
    }

    .data-row {
        display: grid;
        grid-template-columns: 175px minmax(0, 1fr);
        gap: 15px;
        padding: 16px 18px;
        border-bottom: 1px solid #eee9df;
    }

    .data-row:last-child {
        border-bottom: none;
    }

    .data-label {
        color: #7d8794;
        font-size: 13px;
        font-weight: 650;
    }

    .data-value {
        color: #29384a;
        font-size: 14px;
        font-weight: 750;
        line-height: 1.6;
        word-break: break-word;
    }


    /* =========================================================
       NOTICE
    ========================================================= */

    .notice {
        margin-top: 22px;
        padding: 16px;
        border-radius: 14px;
        background: #fff8e8;
        border: 1px solid #f1dfaa;
        color: #7c6425;
        font-size: 12px;
        line-height: 1.7;
    }

    .notice strong {
        color: #6d5415;
    }


    /* =========================================================
       EVENT
    ========================================================= */

    .event-poster {
        height: 190px;
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
    }

    .poster-placeholder {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.28);
        color: #fff;
        font-size: 28px;
    }

    .event-content {
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
        margin: 0 0 18px;
        color: #17324d;
        font-size: 20px;
        line-height: 1.4;
        font-weight: 850;
    }


    /* =========================================================
       EVENT META
    ========================================================= */

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .event-meta-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        color: #697482;
        font-size: 12px;
        line-height: 1.55;
    }

    .event-icon {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f6f2e9;
        color: #9b741e;
        font-size: 13px;
    }


    /* =========================================================
       PRICE
    ========================================================= */

    .price-box {
        margin-top: 20px;
        padding: 16px;
        background: #f9f6ee;
        border: 1px solid #eee4d3;
        border-radius: 14px;
    }

    .price-label {
        display: block;
        margin-bottom: 5px;
        color: #858e99;
        font-size: 11px;
    }

    .price-value {
        color: #17324d;
        font-size: 23px;
        font-weight: 900;
    }


    /* =========================================================
       PESAN PEMBAYARAN
    ========================================================= */

    .payment-info {
        margin-top: 17px;
        padding: 15px;
        border-radius: 14px;
        background: #f6f9fc;
        border: 1px solid #dde7ef;
        color: #617080;
        font-size: 12px;
        line-height: 1.7;
    }

    .payment-info strong {
        color: #17324d;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .btn {
        min-height: 49px;
        border-radius: 12px;
        padding: 0 20px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        font-family: inherit;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s ease;
    }

    .btn-back {
        background: #f2f0eb;
        color: #56616e;
    }

    .btn-back:hover {
        background: #e7e3da;
    }

    .btn-primary {
        flex: 1;
        background: #17324d;
        color: #fff;
        box-shadow: 0 8px 18px rgba(23, 50, 77, .17);
    }

    .btn-primary:hover {
        background: #10283e;
        transform: translateY(-1px);
    }

    .secure-note {
        margin-top: 12px;
        text-align: center;
        color: #89929d;
        font-size: 11px;
        line-height: 1.5;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {

        .confirm-grid {
            grid-template-columns: 1fr;
        }

        .event-summary {
            order: -1;
        }
    }


    @media (max-width: 640px) {

        .confirm-page {
            padding-top: 0;
        }

        .confirm-title {
            font-size: 25px;
        }

        .progress-card {
            padding: 16px 10px;
        }

        .progress {
            gap: 5px;
        }

        .progress-item:not(:last-child)::after {
            left: calc(50% + 18px);
            width: calc(100% - 36px);
        }

        .progress-number {
            width: 34px;
            height: 34px;
        }

        .progress-label {
            font-size: 11px;
        }

        .card-heading,
        .card-body,
        .event-content {
            padding: 18px;
        }

        .data-row {
            grid-template-columns: 1fr;
            gap: 5px;
            padding: 14px 15px;
        }

        .actions {
            flex-direction: column;
        }

        .btn-back,
        .btn-primary {
            width: 100%;
        }
    }
</style>


<div class="confirm-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="confirm-header">

        <a
            href="javascript:history.back()"
            class="back-link"
        >
            ← Kembali ke Form Pendaftaran
        </a>

        <h1 class="confirm-title">
            Konfirmasi Pendaftaran
        </h1>

        <p class="confirm-subtitle">
            Periksa kembali data peserta sebelum melanjutkan ke pembayaran.
        </p>

    </div>


    {{-- =====================================================
         PROGRESS
    ====================================================== --}}

    <div class="progress-card">

        <div class="progress">

            {{-- STEP 1 --}}
            <div class="progress-item done">

                <span class="progress-number">
                    ✓
                </span>

                <span class="progress-label">
                    Data Peserta
                </span>

            </div>


            {{-- STEP 2 --}}
            <div class="progress-item active">

                <span class="progress-number">
                    2
                </span>

                <span class="progress-label">
                    Konfirmasi
                </span>

            </div>


            {{-- STEP 3 --}}
            <div class="progress-item">

                <span class="progress-number">
                    3
                </span>

                <span class="progress-label">
                    Pembayaran
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         ERROR
    ====================================================== --}}

    @if($errors->any())

        <div class="notice"
             style="
                margin-top:0;
                margin-bottom:20px;
                background:#fff4f4;
                border-color:#e6bcbc;
                color:#963e3e;
             ">

            <strong>
                Data belum dapat diproses.
            </strong>

            <ul style="margin:8px 0 0 18px; padding:0;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- =====================================================
         GRID
    ====================================================== --}}

    <div class="confirm-grid">


        {{-- =================================================
             DATA PESERTA
        ================================================== --}}

        <div class="confirm-card">

            <div class="card-heading">

                <h2>
                    Data Peserta
                </h2>

                <p>
                    Pastikan informasi yang Anda masukkan sudah benar.
                </p>

            </div>


            <div class="card-body">

                <div class="data-list">


                    {{-- NAMA --}}
                    <div class="data-row">

                        <div class="data-label">
                            Nama Lengkap
                        </div>

                        <div class="data-value">
                            {{ $nama ?: '-' }}
                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="data-row">

                        <div class="data-label">
                            Email
                        </div>

                        <div class="data-value">
                            {{ $email ?: '-' }}
                        </div>

                    </div>


                    {{-- NO HP --}}
                    <div class="data-row">

                        <div class="data-label">
                            No. Telepon
                        </div>

                        <div class="data-value">
                            {{ $noHp ?: '-' }}
                        </div>

                    </div>


                    {{-- TANGGAL LAHIR --}}
                    <div class="data-row">

                        <div class="data-label">
                            Tanggal Lahir
                        </div>

                        <div class="data-value">

                            @if($tanggalLahir)

                                {{ \Carbon\Carbon::parse($tanggalLahir)->translatedFormat('d F Y') }}

                            @else

                                -

                            @endif

                        </div>

                    </div>


                    {{-- JENIS KELAMIN --}}
                    <div class="data-row">

                        <div class="data-label">
                            Jenis Kelamin
                        </div>

                        <div class="data-value">
                            {{ $jenisKelamin ?: '-' }}
                        </div>

                    </div>


                    {{-- ALAMAT --}}
                    <div class="data-row">

                        <div class="data-label">
                            Alamat Lengkap
                        </div>

                        <div class="data-value">
                            {{ $alamat ?: '-' }}
                        </div>

                    </div>


                </div>


                {{-- =================================================
                     INFORMASI
                ================================================== --}}

                <div class="notice">

                    <strong>
                        Perhatian
                    </strong>

                    <br>

                    Pastikan nama, email, nomor telepon, dan data lainnya
                    sudah benar. Data tersebut akan digunakan dalam proses
                    pendaftaran event.

                </div>


                {{-- =================================================
                     FORM
                ================================================== --}}

                <form
                    action="{{ route('masyarakat.registrasi.simpanPendaftaran') }}"
                    method="POST"
                >

                    @csrf


                    <div class="actions">

                        <a
                            href="javascript:history.back()"
                            class="btn btn-back"
                        >
                            ← Edit Data
                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Konfirmasi & Lanjutkan →
                        </button>

                    </div>


                    <div class="secure-note">

                        🔒 Data digunakan untuk keperluan pendaftaran event.

                    </div>

                </form>

            </div>

        </div>


        {{-- =================================================
             RINGKASAN EVENT
        ================================================== --}}

        <div class="confirm-card event-summary">


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


            <div class="event-content">


                {{-- KATEGORI --}}
                <span class="category-badge">

                    {{ $event->kategori->nama_kategori ?? 'Event' }}

                </span>


                {{-- NAMA EVENT --}}
                <h2 class="event-title">

                    {{ $event->nama_event }}

                </h2>


                <div class="event-meta">


                    {{-- TANGGAL --}}
                    <div class="event-meta-item">

                        <div class="event-icon">
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

                        <div class="event-icon">
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

                        <div class="event-icon">
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


                </div>


                {{-- HARGA --}}
                <div class="price-box">

                    <span class="price-label">
                        Harga Tiket
                    </span>

                    <div class="price-value">

                        @if($hargaTiket > 0)

                            Rp {{ number_format($hargaTiket, 0, ',', '.') }}

                        @else

                            Gratis

                        @endif

                    </div>

                </div>


                {{-- INFORMASI PEMBAYARAN --}}
                <div class="payment-info">

                    <strong>
                        Langkah berikutnya
                    </strong>

                    <br>

                    Setelah menekan tombol
                    <strong>Konfirmasi & Lanjutkan</strong>,
                    Anda akan diarahkan ke halaman pembayaran
                    untuk menyelesaikan pendaftaran.

                </div>


            </div>

        </div>

    </div>

</div>

@endsection
</div>

@endsection
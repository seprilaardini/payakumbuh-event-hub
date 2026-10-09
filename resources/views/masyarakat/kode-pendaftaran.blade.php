@extends('masyarakat.layout')

@section('title', 'Kode Pendaftaran')

@section('content')

@php
    $event = $pendaftaran->event;
    $masyarakat = $pendaftaran->masyarakat;

    $hargaTiket = (float) ($event->biaya_pendaftaran ?? 0);

    $tanggalMulai = $event->tanggal_mulai
        ? \Carbon\Carbon::parse($event->tanggal_mulai)
        : null;

    $tanggalSelesai = $event->tanggal_selesai
        ? \Carbon\Carbon::parse($event->tanggal_selesai)
        : null;

    $kode = $pendaftaran->kode_pendaftaran;
@endphp


<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .registration-code-page {
        max-width: 980px;
        margin: 0 auto;
        padding: 20px 0 60px;
    }


    /* =========================================================
       MAIN CARD
    ========================================================= */

    .code-card {
        background: #ffffff;
        border: 1px solid #e7e0d0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 14px 40px rgba(23, 50, 77, .07);
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .code-header {
        padding: 40px 30px 32px;
        text-align: center;
        background: #fffdf8;
        border-bottom: 1px solid #eee7d9;
    }


    .success-icon {
        width: 74px;
        height: 74px;
        margin: 0 auto 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #17324d;
        color: #ffffff;
        font-size: 32px;
        font-weight: 900;
        box-shadow:
            0 0 0 8px rgba(215, 169, 65, .13),
            0 10px 24px rgba(23, 50, 77, .14);
    }


    .code-heading {
        margin: 0 0 9px;
        color: #17324d;
        font-size: 30px;
        line-height: 1.25;
        font-weight: 900;
    }


    .code-description {
        max-width: 600px;
        margin: 0 auto;
        color: #73808e;
        font-size: 14px;
        line-height: 1.7;
    }


    /* =========================================================
       CONTENT
    ========================================================= */

    .code-content {
        padding: 30px;
    }


    /* =========================================================
       CODE BOX
    ========================================================= */

    .code-section {
        text-align: center;
    }


    .code-label {
        margin-bottom: 10px;
        color: #7f8995;
        font-size: 12px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .8px;
    }


    .code-box {
        max-width: 650px;
        margin: 0 auto;
        padding: 25px 20px;
        border-radius: 18px;
        background: #17324d;
        border: 2px solid #d7a941;
        box-shadow: 0 12px 30px rgba(23, 50, 77, .12);
    }


    .code-value {
        margin: 0;
        color: #ffffff;
        font-size: clamp(25px, 5vw, 42px);
        line-height: 1.25;
        font-weight: 950;
        letter-spacing: 4px;
        word-break: break-word;
    }


    .code-help {
        margin-top: 11px;
        color: rgba(255,255,255,.72);
        font-size: 11px;
    }


    /* =========================================================
       COPY
    ========================================================= */

    .copy-button {
        margin-top: 15px;
        min-height: 45px;
        padding: 0 18px;
        border: 1px solid #ddd5c5;
        border-radius: 11px;
        background: #ffffff;
        color: #17324d;
        font-family: inherit;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s ease;
    }


    .copy-button:hover {
        background: #f7f3eb;
        border-color: #c9b47e;
    }


    .copy-message {
        display: none;
        margin-top: 8px;
        color: #4a7a50;
        font-size: 11px;
        font-weight: 700;
    }


    /* =========================================================
       STATUS
    ========================================================= */

    .status-row {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
    }


    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 13px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 850;
    }


    .status-active {
        background: #edf7ef;
        border: 1px solid #c9dfcd;
        color: #3f7047;
    }


    .status-paid {
        background: #fbf3dd;
        border: 1px solid #ead9a9;
        color: #8a691d;
    }


    /* =========================================================
       EVENT CARD
    ========================================================= */

    .event-card {
        display: grid;
        grid-template-columns: 190px minmax(0, 1fr);
        margin-top: 30px;
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
        color: #ffffff;
        background: rgba(255,255,255,.08);
        border: 1px solid rgba(255,255,255,.28);
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


    .participant-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
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
       IMPORTANT
    ========================================================= */

    .important-box {
        margin-top: 25px;
        padding: 18px;
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
       ACTIONS
    ========================================================= */

    .actions {
        display: flex;
        gap: 12px;
        margin-top: 28px;
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
        font-size: 13px;
        font-weight: 850;
        cursor: pointer;
        transition: .2s ease;
    }


    .btn-primary {
        flex: 1;
        background: #17324d;
        color: #ffffff;
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
        background: #e7e3da;
    }


    .btn-outline {
        background: #ffffff;
        color: #17324d;
        border: 1px solid #dcd5c8;
    }


    .btn-outline:hover {
        background: #f8f5ef;
    }


    .bottom-note {
        margin-top: 15px;
        text-align: center;
        color: #929aa4;
        font-size: 11px;
        line-height: 1.6;
    }


    /* =========================================================
       PRINT
    ========================================================= */

    @media print {

        body * {
            visibility: hidden;
        }

        .registration-code-page,
        .registration-code-page * {
            visibility: visible;
        }

        .registration-code-page {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: none;
        }

        .actions,
        .bottom-note,
        .copy-button,
        .copy-message {
            display: none !important;
        }

        .code-card {
            box-shadow: none;
        }
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 760px) {

        .registration-code-page {
            padding-top: 0;
        }


        .code-header {
            padding: 32px 20px 27px;
        }


        .code-heading {
            font-size: 27px;
        }


        .code-content {
            padding: 22px;
        }


        .event-card {
            grid-template-columns: 1fr;
        }


        .event-poster {
            min-height: 180px;
            height: 180px;
        }


        .event-meta {
            grid-template-columns: 1fr;
        }
    }


    @media (max-width: 540px) {

        .code-header {
            padding-left: 17px;
            padding-right: 17px;
        }


        .code-content {
            padding: 17px;
        }


        .success-icon {
            width: 66px;
            height: 66px;
            font-size: 29px;
        }


        .code-heading {
            font-size: 24px;
        }


        .code-description {
            font-size: 13px;
        }


        .code-box {
            padding: 21px 12px;
        }


        .code-value {
            font-size: 24px;
            letter-spacing: 2px;
        }


        .participant-grid {
            grid-template-columns: 1fr;
        }


        .participant-item:nth-child(odd) {
            border-right: none;
        }


        .participant-item:nth-last-child(-n+2) {
            border-bottom: 1px solid #eee8df;
        }


        .participant-item:last-child {
            border-bottom: none;
        }


        .actions {
            flex-direction: column;
        }


        .btn-primary,
        .btn-secondary,
        .btn-outline {
            width: 100%;
        }
    }
</style>


<div class="registration-code-page">

    <div class="code-card">


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="code-header">

            <div class="success-icon">
                ✓
            </div>


            <h1 class="code-heading">
                Kode Pendaftaran
            </h1>


            <p class="code-description">

                Pendaftaran Anda telah berhasil.
                Simpan kode berikut untuk digunakan
                saat mengecek status pendaftaran.

            </p>


            <div class="status-row">

                <span class="status-badge status-active">
                    ✓ Terdaftar & Terverifikasi
                </span>


                @if($hargaTiket > 0)

                    <span class="status-badge status-paid">
                        ✓ Lunas
                    </span>

                @endif

            </div>

        </div>


        {{-- =====================================================
             CONTENT
        ====================================================== --}}

        <div class="code-content">


            {{-- =================================================
                 KODE
            ================================================== --}}

            <div class="code-section">

                <div class="code-label">
                    Kode Pendaftaran Anda
                </div>


                <div class="code-box">

                    <div
                        class="code-value"
                        id="registrationCode"
                    >
                        {{ $kode }}
                    </div>


                    <div class="code-help">
                        Gunakan kode ini untuk mengecek pendaftaran Anda.
                    </div>

                </div>


                {{-- COPY --}}
                <button
                    type="button"
                    class="copy-button"
                    id="copyButton"
                >
                    📋 Salin Kode
                </button>


                <div
                    id="copyMessage"
                    class="copy-message"
                >
                    ✓ Kode berhasil disalin
                </div>

            </div>


            {{-- =================================================
                 RINCIAN EVENT
            ================================================== --}}

            <div class="event-card">


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


                {{-- INFO --}}
                <div class="event-info">

                    <span class="category-badge">

                        {{ $event->kategori->nama_kategori ?? 'Event' }}

                    </span>


                    <h2 class="event-name">

                        {{ $event->nama_event }}

                    </h2>


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

            <div class="participant-card">

                <div class="participant-heading">

                    <h3>
                        Data Peserta
                    </h3>

                </div>


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
                            ID Pendaftaran
                        </span>

                        <span class="participant-value">
                            #{{ $pendaftaran->id_pendaftaran }}
                        </span>

                    </div>


                </div>

            </div>


            {{-- =================================================
                 CATATAN PENTING
            ================================================== --}}

            <div class="important-box">

                <strong>
                    Penting!
                </strong>

                <br>

                Jangan sampai kehilangan kode pendaftaran
                <strong>{{ $kode }}</strong>.

                Gunakan kode tersebut pada menu
                <strong>Cek Pendaftaran</strong>
                untuk melihat kembali informasi pendaftaran Anda.

                Simpan atau catat kode ini sampai event selesai.

            </div>


            {{-- =================================================
                 BUTTON
            ================================================== --}}

            <div class="actions">


                {{-- CEK PENDAFTARAN --}}
                <a
                    href="{{ route('masyarakat.cek') }}"
                    class="btn btn-primary"
                >
                    🔎 Cek Pendaftaran
                </a>


                {{-- PRINT --}}
                <button
                    type="button"
                    onclick="window.print()"
                    class="btn btn-outline"
                >
                    🖨 Cetak
                </button>


                {{-- BERANDA --}}
                <a
                    href="{{ route('masyarakat.beranda') }}"
                    class="btn btn-secondary"
                >
                    ← Beranda
                </a>


            </div>


            <div class="bottom-note">

                Simpan kode pendaftaran ini dengan baik.

            </div>

        </div>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const copyButton =
            document.getElementById('copyButton');

        const codeElement =
            document.getElementById('registrationCode');

        const copyMessage =
            document.getElementById('copyMessage');


        copyButton.addEventListener('click', async function () {

            const code =
                codeElement.textContent.trim();


            try {

                await navigator.clipboard.writeText(code);

                copyMessage.style.display = 'block';

                copyButton.textContent =
                    '✓ Kode Tersalin';


                setTimeout(function () {

                    copyMessage.style.display = 'none';

                    copyButton.textContent =
                        '📋 Salin Kode';

                }, 2500);


            } catch (error) {

                /*
                |--------------------------------------------------------------------------
                | FALLBACK UNTUK BROWSER YANG TIDAK MENDUKUNG CLIPBOARD API
                |--------------------------------------------------------------------------
                */

                const textarea =
                    document.createElement('textarea');

                textarea.value = code;

                document.body.appendChild(textarea);

                textarea.select();

                document.execCommand('copy');

                textarea.remove();

                copyMessage.style.display = 'block';

                copyButton.textContent =
                    '✓ Kode Tersalin';


                setTimeout(function () {

                    copyMessage.style.display = 'none';

                    copyButton.textContent =
                        '📋 Salin Kode';

                }, 2500);

            }

        });

    });
</script>

@endsection
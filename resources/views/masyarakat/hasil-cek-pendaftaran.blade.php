@extends('masyarakat.layout')

@section('content')

<style>
    .hasil-page {
        width: 100%;
        padding-bottom: 50px;
    }

    .hasil-header {
        margin-bottom: 25px;
    }

    .hasil-kicker {
        margin-bottom: 7px;
        color: #e58a00;
        font-size: 10px;
        font-weight: 800;
        letter-spacing: .8px;
    }

    .hasil-header h1 {
        margin: 0;
        color: #111b38;
        font-size: 30px;
        font-weight: 800;
    }

    .hasil-header p {
        margin: 8px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .hasil-container {
        max-width: 950px;
        margin: 0 auto;
    }

    /* =========================================================
       KODE DAN STATUS
    ========================================================= */

    .status-card {
        margin-bottom: 20px;
        padding: 26px;
        border-radius: 18px;
        background: #0b132b;
        color: white;
        box-shadow: 0 10px 30px rgba(11,19,43,.12);
    }

    .status-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
    }

    .status-label {
        margin-bottom: 7px;
        color: rgba(255,255,255,.62);
        font-size: 10px;
        font-weight: 700;
    }

    .status-code {
        color: white;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: .8px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 13px;
        border: 1px solid rgba(255,255,255,.15);
        border-radius: 9px;
        background: rgba(255,255,255,.10);
        color: white;
        font-size: 11px;
        font-weight: 700;
        text-transform: capitalize;
    }

    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #4ade80;
    }

    /* =========================================================
       GRID
    ========================================================= */

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
    }

    .info-card {
        padding: 23px;
        background: white;
        border: 1px solid #e8edf5;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(11,19,43,.05);
    }

    .info-card.full {
        grid-column: 1 / -1;
    }

    .info-card h2 {
        margin: 0 0 18px;
        color: #111b38;
        font-size: 16px;
        font-weight: 800;
    }

    /* =========================================================
       ROW
    ========================================================= */

    .info-row {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 12px 0;
        border-bottom: 1px solid #edf0f4;
    }

    .info-row:first-child {
        padding-top: 0;
    }

    .info-row:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-row span.label {
        color: #9ca3af;
        font-size: 11px;
    }

    .info-row strong {
        max-width: 65%;
        color: #111827;
        font-size: 12px;
        line-height: 1.5;
        text-align: right;
    }

    .payment-status {
        display: inline-flex;
        padding: 5px 9px;
        border-radius: 7px;
        background: #eef3fb;
        color: #31527d;
        font-size: 10px;
        font-weight: 800;
        text-transform: capitalize;
    }

    /* =========================================================
       ACTION
    ========================================================= */

    .action-area {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 20px;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 43px;
        padding: 0 18px;
        border-radius: 10px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
    }

    .btn-outline {
        border: 1px solid #d8e0eb;
        background: white;
        color: #0b132b;
    }

    .btn-dark {
        background: #0b132b;
        color: white;
    }

    .btn-dark:hover {
        background: #16264d;
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 700px) {

        .info-grid {
            grid-template-columns: 1fr;
        }

        .info-card.full {
            grid-column: auto;
        }

        .status-card-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .action-area {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }

        .info-row {
            flex-direction: column;
            gap: 5px;
        }

        .info-row strong {
            max-width: 100%;
            text-align: left;
        }
    }
</style>


<div class="hasil-page">

    <div class="hasil-header">

        <div class="hasil-kicker">
            HASIL CEK PENDAFTARAN
        </div>

        <h1>
            Detail Pendaftaran
        </h1>

        <p>
            Data pendaftaran yang sesuai dengan kode
            berhasil ditemukan.
        </p>

    </div>


    <div class="hasil-container">

        {{-- =================================================
             KODE DAN STATUS
        ================================================== --}}

        <div class="status-card">

            <div class="status-card-top">

                <div>

                    <div class="status-label">
                        KODE PENDAFTARAN
                    </div>

                    <div class="status-code">
                        {{ $pendaftaran->kode_pendaftaran }}
                    </div>

                </div>


                <div class="status-badge">

                    <span class="status-dot"></span>

                    {{ $pendaftaran->status ?? 'Belum tersedia' }}

                </div>

            </div>

        </div>


        {{-- =================================================
             DATA
        ================================================== --}}

        <div class="info-grid">

            {{-- DATA PESERTA --}}
            <div class="info-card">

                <h2>
                    Data Peserta
                </h2>


                <div class="info-row">

                    <span class="label">
                        Nama
                    </span>

                    <strong>
                        {{ $pendaftaran->masyarakat->nama ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Email
                    </span>

                    <strong>
                        {{ $pendaftaran->masyarakat->email ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        No. HP
                    </span>

                    <strong>
                        {{ $pendaftaran->masyarakat->no_hp ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Jenis Kelamin
                    </span>

                    <strong>
                        {{ $pendaftaran->masyarakat->jenis_kelamin ?? '-' }}
                    </strong>

                </div>

            </div>


            {{-- INFORMASI EVENT --}}
            <div class="info-card">

                <h2>
                    Informasi Event
                </h2>


                <div class="info-row">

                    <span class="label">
                        Nama Event
                    </span>

                    <strong>
                        {{ $pendaftaran->event->nama_event ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Kategori
                    </span>

                    <strong>
                        {{ $pendaftaran->event->kategori->nama_kategori ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Lokasi
                    </span>

                    <strong>
                        {{ $pendaftaran->event->lokasi->nama_lokasi ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Tanggal Event
                    </span>

                    <strong>

                        @if(
                            $pendaftaran->event &&
                            $pendaftaran->event->tanggal_mulai
                        )

                            {{ \Carbon\Carbon::parse(
                                $pendaftaran->event->tanggal_mulai
                            )->translatedFormat('d F Y') }}

                        @else

                            -

                        @endif

                    </strong>

                </div>

            </div>


            {{-- DATA PENDAFTARAN --}}
            <div class="info-card">

                <h2>
                    Informasi Pendaftaran
                </h2>


                <div class="info-row">

                    <span class="label">
                        Tanggal Daftar
                    </span>

                    <strong>

                        @if($pendaftaran->tanggal_daftar)

                            {{ \Carbon\Carbon::parse(
                                $pendaftaran->tanggal_daftar
                            )->translatedFormat('d F Y H:i') }}
                            WIB

                        @else

                            -

                        @endif

                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Status
                    </span>

                    <strong>
                        {{ $pendaftaran->status ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Kode
                    </span>

                    <strong>
                        {{ $pendaftaran->kode_pendaftaran }}
                    </strong>

                </div>

            </div>


            {{-- PEMBAYARAN --}}
            <div class="info-card">

                <h2>
                    Informasi Pembayaran
                </h2>


                @if($pendaftaran->pembayaran)

                    <div class="info-row">

                        <span class="label">
                            Metode
                        </span>

                        <strong>
                            {{ $pendaftaran->pembayaran->metode_pembayaran ?? '-' }}
                        </strong>

                    </div>


                    <div class="info-row">

                        <span class="label">
                            Status Pembayaran
                        </span>

                        <strong>

                            <span class="payment-status">
                                {{ $pendaftaran->pembayaran->status_pembayaran ?? '-' }}
                            </span>

                        </strong>

                    </div>


                    <div class="info-row">

                        <span class="label">
                            Jumlah Bayar
                        </span>

                        <strong>

                            @if(
                                $pendaftaran->pembayaran->jumlah_bayar !== null
                            )

                                Rp
                                {{ number_format(
                                    $pendaftaran->pembayaran->jumlah_bayar,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            @else

                                -

                            @endif

                        </strong>

                    </div>


                    <div class="info-row">

                        <span class="label">
                            Tanggal Pembayaran
                        </span>

                        <strong>

                            @if(
                                $pendaftaran->pembayaran->tanggal_pembayaran
                            )

                                {{ \Carbon\Carbon::parse(
                                    $pendaftaran->pembayaran->tanggal_pembayaran
                                )->translatedFormat('d F Y H:i') }}
                                WIB

                            @else

                                -

                            @endif

                        </strong>

                    </div>

                @else

                    <div style="
                        color:#6b7280;
                        font-size:12px;
                        line-height:1.7;
                    ">
                        Belum ada data pembayaran.
                    </div>

                @endif

            </div>


            {{-- LOKASI --}}
            <div class="info-card full">

                <h2>
                    Lokasi Event
                </h2>


                <div class="info-row">

                    <span class="label">
                        Nama Lokasi
                    </span>

                    <strong>
                        {{ $pendaftaran->event->lokasi->nama_lokasi ?? '-' }}
                    </strong>

                </div>


                <div class="info-row">

                    <span class="label">
                        Alamat
                    </span>

                    <strong>
                        {{ $pendaftaran->event->lokasi->alamat_lokasi ?? '-' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =================================================
             BUTTON
        ================================================== --}}

        <div class="action-area">

            <a
                href="{{ route('masyarakat.cek') }}"
                class="btn-action btn-outline"
            >
                ← Cek Lagi
            </a>


            <a
                href="{{ route('masyarakat.eventSaya') }}"
                class="btn-action btn-dark"
            >
                Event Saya →
            </a>

        </div>

    </div>

</div>

@endsection
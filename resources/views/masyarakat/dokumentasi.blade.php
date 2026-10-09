@extends('masyarakat.layout')

@section('title', 'Dokumentasi Event')

@section('content')

<style>
    /* =========================================================
       PAGE
    ========================================================= */

    .documentation-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 10px 0 55px;
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .documentation-header {
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

    .documentation-title {
        margin: 0 0 8px;
        color: #17324d;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 900;
    }

    .documentation-subtitle {
        margin: 0;
        color: #75808d;
        font-size: 14px;
        line-height: 1.7;
    }


    /* =========================================================
       FILTER CARD
    ========================================================= */

    .filter-card {
        background: #ffffff;
        border: 1px solid #e7e0d0;
        border-radius: 20px;
        padding: 21px;
        margin-bottom: 28px;
        box-shadow: 0 10px 30px rgba(23, 50, 77, .05);
    }

    .filter-form {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 180px auto;
        gap: 12px;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        margin-bottom: 7px;
        color: #29384a;
        font-size: 12px;
        font-weight: 800;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        height: 47px;
        box-sizing: border-box;
        padding: 0 13px;
        border: 1px solid #dcd6ca;
        border-radius: 12px;
        background: #ffffff;
        color: #29384a;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s ease;
    }

    .filter-input:focus,
    .filter-select:focus {
        border-color: #17324d;
        box-shadow: 0 0 0 3px rgba(23, 50, 77, .08);
    }

    .filter-input::placeholder {
        color: #a0a7b0;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }

    .btn-filter,
    .btn-reset {
        height: 47px;
        padding: 0 17px;
        border-radius: 12px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
        font-family: inherit;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        white-space: nowrap;
        transition: .2s ease;
    }

    .btn-filter {
        background: #17324d;
        color: #ffffff;
    }

    .btn-filter:hover {
        background: #10283e;
    }

    .btn-reset {
        background: #f1efe9;
        color: #56616e;
    }

    .btn-reset:hover {
        background: #e6e2d9;
    }


    /* =========================================================
       INFO
    ========================================================= */

    .result-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 18px;
    }

    .result-title {
        margin: 0;
        color: #17324d;
        font-size: 19px;
        font-weight: 850;
    }

    .result-count {
        color: #87919d;
        font-size: 12px;
    }


    /* =========================================================
       GRID
    ========================================================= */

    .documentation-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }


    /* =========================================================
       CARD
    ========================================================= */

    .documentation-card {
        background: #ffffff;
        border: 1px solid #e7e0d0;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(23, 50, 77, .055);
        transition: .2s ease;
    }

    .documentation-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 13px 30px rgba(23, 50, 77, .09);
    }


    /* =========================================================
       MEDIA
    ========================================================= */

    .documentation-media {
        height: 205px;
        position: relative;
        background: linear-gradient(
            135deg,
            #17324d,
            #254d70
        );
        overflow: hidden;
    }

    .documentation-media img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
    }

    .documentation-placeholder {
        width: 70px;
        height: 70px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,.28);
        background: rgba(255,255,255,.08);
        color: #ffffff;
        font-size: 29px;
    }

    .upload-date {
        position: absolute;
        left: 14px;
        bottom: 14px;
        padding: 7px 10px;
        border-radius: 999px;
        background: rgba(23, 50, 77, .88);
        color: #ffffff;
        font-size: 10px;
        font-weight: 750;
        backdrop-filter: blur(5px);
    }


    /* =========================================================
       CARD BODY
    ========================================================= */

    .documentation-body {
        padding: 18px;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f8f0dd;
        color: #966e17;
        font-size: 10px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 9px;
    }

    .documentation-event {
        margin: 0 0 9px;
        color: #17324d;
        font-size: 17px;
        line-height: 1.4;
        font-weight: 850;
    }

    .documentation-description {
        min-height: 46px;
        margin: 0 0 17px;
        color: #74808d;
        font-size: 12px;
        line-height: 1.65;
    }


    /* =========================================================
       BUTTON
    ========================================================= */

    .documentation-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 14px;
        border-top: 1px solid #eee8dc;
    }

    .documentation-date {
        color: #8b949e;
        font-size: 10px;
        line-height: 1.4;
    }

    .btn-documentation {
        min-height: 38px;
        padding: 0 13px;
        border-radius: 10px;
        background: #17324d;
        color: #ffffff;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 800;
        transition: .2s ease;
        white-space: nowrap;
    }

    .btn-documentation:hover {
        background: #10283e;
        transform: translateY(-1px);
    }


    /* =========================================================
       EMPTY
    ========================================================= */

    .empty-state {
        grid-column: 1 / -1;
        padding: 55px 25px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e7e0d0;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(23, 50, 77, .05);
    }

    .empty-icon {
        width: 68px;
        height: 68px;
        margin: 0 auto 16px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f7f2e8;
        color: #99731e;
        font-size: 28px;
    }

    .empty-state h3 {
        margin: 0 0 7px;
        color: #17324d;
        font-size: 18px;
        font-weight: 850;
    }

    .empty-state p {
        max-width: 530px;
        margin: 0 auto;
        color: #7b8592;
        font-size: 12px;
        line-height: 1.7;
    }


    /* =========================================================
       PAGINATION
    ========================================================= */

    .pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        margin-top: 30px;
    }

    .pagination-button {
        min-width: 38px;
        height: 38px;
        padding: 0 11px;
        border-radius: 10px;
        border: 1px solid #ddd6c9;
        background: #ffffff;
        color: #56616e;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 750;
    }

    .pagination-button:hover {
        background: #f7f3eb;
        border-color: #c9b47e;
    }

    .pagination-disabled {
        opacity: .45;
        pointer-events: none;
    }

    .pagination-info {
        color: #89929d;
        font-size: 11px;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 980px) {

        .documentation-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .filter-form {
            grid-template-columns: 1fr 180px;
        }

        .filter-actions {
            grid-column: 1 / -1;
        }

        .btn-filter,
        .btn-reset {
            flex: 1;
        }
    }


    @media (max-width: 640px) {

        .documentation-page {
            padding-top: 0;
        }

        .documentation-title {
            font-size: 25px;
        }

        .filter-card {
            padding: 17px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-actions {
            grid-column: auto;
        }

        .documentation-grid {
            grid-template-columns: 1fr;
        }

        .result-info {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

        .documentation-media {
            height: 220px;
        }
    }
</style>


<div class="documentation-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="documentation-header">

        <a
            href="{{ route('masyarakat.beranda') }}"
            class="back-link"
        >
            ← Kembali ke Beranda
        </a>


        <h1 class="documentation-title">
            Dokumentasi Event
        </h1>


        <p class="documentation-subtitle">

            Lihat dokumentasi kegiatan event yang telah
            dilaksanakan di Kota Payakumbuh.

        </p>

    </div>


    {{-- =====================================================
         FILTER
    ====================================================== --}}

    <div class="filter-card">

        <form
            action="{{ route('masyarakat.dokumentasi') }}"
            method="GET"
            class="filter-form"
        >


            {{-- SEARCH --}}
            <div class="filter-group">

                <label
                    for="search"
                    class="filter-label"
                >
                    Cari Dokumentasi
                </label>


                <input
                    type="text"
                    id="search"
                    name="search"
                    class="filter-input"
                    value="{{ request('search') }}"
                    placeholder="Cari berdasarkan nama event..."
                >

            </div>


            {{-- TAHUN --}}
            <div class="filter-group">

                <label
                    for="tahun"
                    class="filter-label"
                >
                    Tahun
                </label>


                <select
                    id="tahun"
                    name="tahun"
                    class="filter-select"
                >

                    <option value="">
                        Semua Tahun
                    </option>

                    @for($tahun = now()->year; $tahun >= 2020; $tahun--)

                        <option
                            value="{{ $tahun }}"
                            {{ request('tahun') == $tahun ? 'selected' : '' }}
                        >
                            {{ $tahun }}
                        </option>

                    @endfor

                </select>

            </div>


            {{-- BUTTON --}}
            <div class="filter-actions">

                <button
                    type="submit"
                    class="btn-filter"
                >
                    🔎 Cari
                </button>


                @if(request('search') || request('tahun'))

                    <a
                        href="{{ route('masyarakat.dokumentasi') }}"
                        class="btn-reset"
                    >
                        ↺ Reset
                    </a>

                @endif

            </div>

        </form>

    </div>


    {{-- =====================================================
         INFO HASIL
    ====================================================== --}}

    <div class="result-info">

        <h2 class="result-title">
            Dokumentasi Kegiatan
        </h2>


        @if(isset($dokumentasi) && method_exists($dokumentasi, 'total'))

            <div class="result-count">

                Menampilkan
                {{ $dokumentasi->count() }}
                dari
                {{ $dokumentasi->total() }}
                dokumentasi

            </div>

        @elseif(isset($dokumentasi))

            <div class="result-count">

                {{ $dokumentasi->count() }}
                dokumentasi

            </div>

        @endif

    </div>


    {{-- =====================================================
         GRID
    ====================================================== --}}

    <div class="documentation-grid">


        @forelse($dokumentasi as $item)

            @php

                $event = $item->event ?? null;

                $url = $item->url_dokumentasi ?? '';

                $isImage = false;

                if ($url) {

                    $extension = strtolower(
                        pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION)
                    );

                    $isImage = in_array(
                        $extension,
                        ['jpg', 'jpeg', 'png', 'webp', 'gif']
                    );

                }

                $tanggalUpload = $item->tgl_upload
                    ? \Carbon\Carbon::parse($item->tgl_upload)
                    : null;

            @endphp


            <article class="documentation-card">


                {{-- =================================================
                     MEDIA
                ================================================== --}}

                <div class="documentation-media">

                    @if($isImage)

                        <img
                            src="{{ $url }}"
                            alt="{{ $event->nama_event ?? 'Dokumentasi Event' }}"
                        >

                    @else

                        <div class="documentation-placeholder">
                            📷
                        </div>

                    @endif


                    @if($tanggalUpload)

                        <div class="upload-date">

                            📅
                            {{ $tanggalUpload->translatedFormat('d F Y') }}

                        </div>

                    @endif

                </div>


                {{-- =================================================
                     BODY
                ================================================== --}}

                <div class="documentation-body">


                    {{-- KATEGORI --}}
                    @if($event && $event->kategori)

                        <span class="category-badge">

                            {{ $event->kategori->nama_kategori }}

                        </span>

                    @else

                        <span class="category-badge">
                            Event
                        </span>

                    @endif


                    {{-- EVENT --}}
                    <h3 class="documentation-event">

                        {{ $event->nama_event ?? 'Dokumentasi Event' }}

                    </h3>


                    {{-- DESKRIPSI --}}
                    <p class="documentation-description">

                        {{ $item->deskripsi_dokumentasi
                            ?: 'Dokumentasi kegiatan event Kota Payakumbuh.' }}

                    </p>


                    {{-- FOOTER --}}
                    <div class="documentation-footer">


                        @if($tanggalUpload)

                            <div class="documentation-date">

                                Diunggah
                                <br>

                                {{ $tanggalUpload->translatedFormat('d F Y') }}

                            </div>

                        @else

                            <div class="documentation-date">
                                Dokumentasi kegiatan
                            </div>

                        @endif


                        @if($url)

                            <a
                                href="{{ $url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="btn-documentation"
                            >
                                📷 Lihat Dokumentasi
                            </a>

                        @else

                            <span class="documentation-date">
                                Belum tersedia
                            </span>

                        @endif

                    </div>

                </div>

            </article>

        @empty


            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="empty-state">

                <div class="empty-icon">
                    📷
                </div>


                <h3>
                    Belum Ada Dokumentasi
                </h3>


                <p>

                    Belum terdapat dokumentasi event yang dapat
                    ditampilkan.

                    @if(request('search') || request('tahun'))
                        Coba ubah kata pencarian atau filter tahun Anda.
                    @else
                        Dokumentasi akan ditampilkan setelah kegiatan
                        event selesai dan dokumentasinya tersedia.
                    @endif

                </p>

            </div>

        @endforelse

    </div>


    {{-- =====================================================
         PAGINATION
    ====================================================== --}}

    @if(
        isset($dokumentasi)
        &&
        method_exists($dokumentasi, 'hasPages')
        &&
        $dokumentasi->hasPages()
    )

        <div class="pagination-wrapper">


            {{-- PREVIOUS --}}
            @if($dokumentasi->onFirstPage())

                <span class="pagination-button pagination-disabled">
                    ←
                </span>

            @else

                <a
                    href="{{ $dokumentasi->previousPageUrl() }}"
                    class="pagination-button"
                >
                    ←
                </a>

            @endif


            {{-- INFO --}}
            <span class="pagination-info">

                Halaman
                {{ $dokumentasi->currentPage() }}
                dari
                {{ $dokumentasi->lastPage() }}

            </span>


            {{-- NEXT --}}
            @if($dokumentasi->hasMorePages())

                <a
                    href="{{ $dokumentasi->nextPageUrl() }}"
                    class="pagination-button"
                >
                    →
                </a>

            @else

                <span class="pagination-button pagination-disabled">
                    →
                </span>

            @endif

        </div>

    @endif

</div>

@endsection
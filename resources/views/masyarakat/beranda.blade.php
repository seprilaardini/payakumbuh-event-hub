@extends('masyarakat.layout')

@section('title', 'Beranda - Payakumbuh Event Hub')


@section('content')


{{-- =========================================================
     HERO
========================================================= --}}

<section class="home-hero">

    <div class="hero-overlay"></div>

    <div class="hero-content">

        <div class="hero-label">
            PORTAL EVENT RESMI KOTA PAYAKUMBUH
        </div>

        <h1>
            Temukan Event<br>
            Terbaik di Kota Payakumbuh
        </h1>

        <p>
            Jelajahi berbagai event seni, budaya, olahraga,
            pendidikan, kuliner, dan musik di Kota Payakumbuh.
        </p>


        {{-- SEARCH --}}

        <form
            action="{{ route('masyarakat.event') }}"
            method="GET"
            class="hero-search"
        >

            <div class="search-icon">
                ⌕
            </div>

            <input
                type="text"
                name="search"
                placeholder="Cari event seni, olahraga, budaya..."
            >

            <button
                type="submit"
            >
                Cari Event
            </button>

        </form>

    </div>

</section>



{{-- =========================================================
     STATISTIK
========================================================= --}}

<section class="stats-section">

    <div class="stats-grid">


        {{-- EVENT --}}

        <div class="stat-card">

            <div class="stat-icon stat-icon-gold">
                ◈
            </div>

            <div class="stat-text">

                <div class="stat-number">
                    {{ $jumlahEvent }}
                </div>

                <div class="stat-label">
                    Event Tersedia
                </div>

            </div>

        </div>



        {{-- PESERTA --}}

        <div class="stat-card">

            <div class="stat-icon stat-icon-blue">
                ♙
            </div>

            <div class="stat-text">

                <div class="stat-number">
                    {{ $jumlahPeserta }}
                </div>

                <div class="stat-label">
                    Peserta Terdaftar
                </div>

            </div>

        </div>



        {{-- KATEGORI --}}

        <div class="stat-card">

            <div class="stat-icon stat-icon-green">
                ▦
            </div>

            <div class="stat-text">

                <div class="stat-number">
                    {{ $kategori->count() }}
                </div>

                <div class="stat-label">
                    Pilihan Kategori
                </div>

            </div>

        </div>



        {{-- STATUS --}}

        <div class="stat-card">

            <div class="stat-icon stat-icon-dark">
                ✓
            </div>

            <div class="stat-text">

                <div class="stat-number">
                    {{ $jumlahEvent }}
                </div>

                <div class="stat-label">
                    Event Resmi
                </div>

            </div>

        </div>


    </div>

</section>



{{-- =========================================================
     KATEGORI
========================================================= --}}

<section class="home-section">

    <div class="section-heading">

        <div>

            <span class="section-kicker">
                EKSPLORASI MINAT
            </span>

            <h2>
                Kategori Terpopuler
            </h2>

            <p>
                Temukan event sesuai minat dan kegiatan yang kamu sukai.
            </p>

        </div>


        <a
            href="{{ route('masyarakat.event') }}"
            class="section-link"
        >
            Lihat Semua Event →
        </a>

    </div>



    <div class="category-grid">


        @foreach($kategori as $item)

            <a
                href="{{ route('masyarakat.event', [
                    'kategori' => $item->id_kategori
                ]) }}"
                class="category-card"
            >

                <div class="category-icon">

                    @php

                        $namaKategori =
                            strtolower(
                                $item->nama_kategori
                            );

                    @endphp


                    @if(str_contains($namaKategori, 'musik'))

                        ♪

                    @elseif(str_contains($namaKategori, 'olahraga'))

                        ⚽

                    @elseif(str_contains($namaKategori, 'budaya'))

                        ◈

                    @elseif(str_contains($namaKategori, 'pendidikan'))

                        ✎

                    @elseif(str_contains($namaKategori, 'kuliner'))

                        ♨

                    @elseif(str_contains($namaKategori, 'seni'))

                        ✦

                    @else

                        ◆

                    @endif

                </div>


                <div class="category-name">
                    {{ $item->nama_kategori }}
                </div>


                <div class="category-arrow">
                    →
                </div>

            </a>

        @endforeach


    </div>

</section>



{{-- =========================================================
     EVENT UNGGULAN
========================================================= --}}

<section class="home-section featured-section">

    <div class="section-heading">

        <div>

            <span class="section-kicker">
                PILIHAN HARI INI
            </span>

            <h2>
                Event Unggulan
            </h2>

            <p>
                Event yang sudah disetujui dan siap diikuti masyarakat.
            </p>

        </div>


        <a
            href="{{ route('masyarakat.event') }}"
            class="section-link"
        >
            Lihat Semua →
        </a>

    </div>



    @if($events->count())


        <div class="featured-grid">


            @foreach($events->take(3) as $event)


                <article class="featured-card">


                    {{-- POSTER --}}

                    <div class="event-image">


                        @if($event->poster)

                            <img
                                src="{{ asset(
                                    'storage/' . $event->poster
                                ) }}"
                                alt="{{ $event->nama_event }}"
                            >

                        @else

                            <div class="event-placeholder">

                                <div class="placeholder-logo">
                                    PEH
                                </div>

                                <div class="placeholder-text">
                                    Payakumbuh Event Hub
                                </div>

                            </div>

                        @endif


                        {{-- CATEGORY BADGE --}}

                        <div class="event-category">

                            {{ $event->kategori->nama_kategori ?? 'Event' }}

                        </div>


                    </div>



                    {{-- CONTENT --}}

                    <div class="event-content">


                        <h3>
                            {{ $event->nama_event }}
                        </h3>


                        <div class="event-info">


                            <div class="event-info-row">

                                <span class="info-icon">
                                    ◷
                                </span>

                                <span>

                                    {{ $event->tanggal_mulai->translatedFormat('d F Y') }}

                                    ·

                                    {{ $event->tanggal_mulai->format('H:i') }}
                                    WIB

                                </span>

                            </div>


                            <div class="event-info-row">

                                <span class="info-icon">
                                    ◎
                                </span>

                                <span>
                                    {{ $event->lokasi->nama_lokasi ?? 'Lokasi belum tersedia' }}
                                </span>

                            </div>


                            <div class="event-info-row">

                                <span class="info-icon">
                                    ♙
                                </span>

                                <span>
                                    {{ $event->peserta_count }} peserta
                                </span>

                            </div>


                        </div>



                        <div class="event-bottom">


                            <div class="event-price">

                                <span class="price-label">
                                    Harga Pendaftaran
                                </span>


                                <strong>

                                    @if(
                                        (float)
                                        $event->biaya_pendaftaran <= 0
                                    )

                                        Gratis

                                    @else

                                        Rp
                                        {{
                                            number_format(
                                                $event->biaya_pendaftaran,
                                                0,
                                                ',',
                                                '.'
                                            )
                                        }}

                                    @endif

                                </strong>

                            </div>


                            <a
                                href="{{ route(
                                    'masyarakat.detail',
                                    $event->id_event
                                ) }}"
                                class="event-button"
                            >
                                Lihat Event
                            </a>


                        </div>


                    </div>


                </article>


            @endforeach


        </div>


    @else


        <div class="empty-home">

            <div class="empty-home-icon">
                ◈
            </div>

            <h3>
                Belum ada event
            </h3>

            <p>
                Event yang sudah disetujui akan tampil di halaman ini.
            </p>

        </div>


    @endif


</section>



{{-- =========================================================
     EVENT MENDATANG
========================================================= --}}

<section class="home-section upcoming-section">


    <div class="section-heading">

        <div>

            <span class="section-kicker">
                JANGAN SAMPAI TERLEWAT
            </span>

            <h2>
                Event Mendatang Unggulan
            </h2>

            <p>
                Lihat agenda event yang akan berlangsung di Payakumbuh.
            </p>

        </div>

    </div>



    @if($events->count())


        <div class="upcoming-list">


            @foreach($events->take(5) as $event)


                <div class="upcoming-card">


                    {{-- DATE BOX --}}

                    <div class="date-box">

                        <span>
                            {{ $event->tanggal_mulai->translatedFormat('M') }}
                        </span>

                        <strong>
                            {{ $event->tanggal_mulai->format('d') }}
                        </strong>

                    </div>



                    {{-- EVENT --}}

                    <div class="upcoming-main">


                        <div class="upcoming-top">

                            <span class="mini-category">
                                {{ $event->kategori->nama_kategori ?? 'Event' }}
                            </span>

                            <span class="mini-status">
                                Terdaftar Resmi
                            </span>

                        </div>


                        <h3>
                            {{ $event->nama_event }}
                        </h3>


                        <div class="upcoming-meta">

                            <span>
                                ◷
                                {{ $event->tanggal_mulai->format('H:i') }}
                                WIB
                            </span>

                            <span>
                                ◎
                                {{ $event->lokasi->nama_lokasi ?? 'Lokasi belum tersedia' }}
                            </span>

                        </div>


                    </div>



                    {{-- PRICE --}}

                    <div class="upcoming-right">


                        <div class="upcoming-price">

                            @if(
                                (float)
                                $event->biaya_pendaftaran <= 0
                            )

                                Gratis

                            @else

                                Rp
                                {{
                                    number_format(
                                        $event->biaya_pendaftaran,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            @endif

                        </div>


                        <a
                            href="{{ route(
                                'masyarakat.detail',
                                $event->id_event
                            ) }}"
                            class="outline-button"
                        >
                            Detail
                        </a>


                    </div>


                </div>


            @endforeach


        </div>


    @else


        <div class="empty-home">

            <div class="empty-home-icon">
                ◷
            </div>

            <h3>
                Belum ada agenda
            </h3>

            <p>
                Agenda event mendatang akan tampil di sini.
            </p>

        </div>


    @endif


</section>



{{-- =========================================================
     CTA
========================================================= --}}

<section class="home-cta">


    <div class="cta-content">


        <div class="cta-kicker">
            PAYAKUMBUH EVENT HUB
        </div>


        <h2>
            Siap menemukan event favoritmu?
        </h2>


        <p>
            Jelajahi daftar event resmi dan temukan
            kegiatan menarik di Kota Payakumbuh.
        </p>


        <div class="cta-buttons">


            <a
                href="{{ route('masyarakat.event') }}"
                class="cta-primary"
            >
                Jelajahi Semua Event
            </a>


            <a
                href="{{ route('masyarakat.cek') }}"
                class="cta-secondary"
            >
                Cek Pendaftaran
            </a>


        </div>


    </div>


</section>



{{-- =========================================================
     FOOTER INFORMASI
========================================================= --}}

<section class="home-footer-info">


    <div class="footer-info-grid">


        {{-- BRAND --}}

        <div class="footer-info-brand">


            <div class="footer-logo">
                P
            </div>


            <div>

                <div class="footer-title">
                    PAYAKUMBUH EVENT HUB
                </div>

                <p>
                    Sistem Informasi Event Kota Payakumbuh.
                    Portal informasi, pendaftaran, dan ulasan
                    berbagai agenda seni, budaya, olahraga,
                    pendidikan, dan kuliner.
                </p>

            </div>


        </div>



        {{-- KATEGORI --}}

        <div class="footer-column">


            <h4>
                Kategori Utama
            </h4>


            @foreach($kategori->take(6) as $item)

                <a
                    href="{{ route('masyarakat.event', [
                        'kategori' => $item->id_kategori
                    ]) }}"
                >
                    {{ $item->nama_kategori }}
                </a>

            @endforeach


        </div>



        {{-- INFORMASI --}}

        <div class="footer-column">


            <h4>
                Pemerintahan
            </h4>


            <div class="footer-contact">

                <strong>
                    Disparpora Payakumbuh
                </strong>

                <span>
                    Jl. Soekarno-Hatta No. 12,
                    Koto Nan IV, Kec. Payakumbuh Barat,
                    Kota Payakumbuh,
                    Sumatera Barat 26223
                </span>

            </div>


        </div>



        {{-- HUBUNGI --}}

        <div class="footer-column">


            <h4>
                Hubungi Kami
            </h4>


            <div class="footer-contact">

                <span>
                    hub@payakumbuhevent.go.id
                </span>

                <span>
                    (0752) 902231
                </span>

                <span>
                    Payakumbuh, Sumatera Barat
                </span>

            </div>


        </div>


    </div>


    <div class="footer-bottom">

        <span>
            © {{ date('Y') }} Payakumbuh Event Hub.
            All rights reserved.
        </span>


        <span>
            Portal Event Kota Payakumbuh
        </span>

    </div>


</section>



@endsection



{{-- =========================================================
     CSS BERANDA
========================================================= --}}

@push('styles')

<style>


    /* =========================================================
       HERO
    ========================================================== */

    .home-hero {

        position: relative;

        min-height: 430px;

        margin:
            -32px -32px 0;

        display: flex;

        align-items: center;

        overflow: hidden;

        background:

            linear-gradient(
                135deg,
                #17120b 0%,
                #2c2112 45%,
                #5a3c12 100%
            );

    }


    .home-hero::before {

        content: '';

        position: absolute;

        width: 500px;

        height: 500px;

        right: -120px;

        top: -160px;

        border-radius: 50%;

        background:
            rgba(245,158,11,.12);

    }


    .home-hero::after {

        content: '';

        position: absolute;

        width: 300px;

        height: 300px;

        left: -100px;

        bottom: -160px;

        border-radius: 50%;

        background:
            rgba(255,255,255,.04);

    }


    .hero-overlay {

        position: absolute;

        inset: 0;

        background:
            linear-gradient(
                90deg,
                rgba(17,24,39,.35),
                transparent
            );

    }


    .hero-content {

        position: relative;

        z-index: 2;

        width: 100%;

        max-width: 760px;

        padding:
            55px 55px;

    }


    .hero-label {

        display: inline-block;

        padding:
            7px 11px;

        border:
            1px solid
            rgba(245,158,11,.35);

        border-radius: 999px;

        color:
            #fbbf24;

        background:
            rgba(245,158,11,.08);

        font-size:
            9px;

        font-weight:
            800;

        letter-spacing:
            1px;

    }


    .hero-content h1 {

        margin-top:
            16px;

        color:
            #ffffff;

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            45px;

        font-weight:
            700;

        line-height:
            1.14;

        letter-spacing:
            -.5px;

    }


    .hero-content p {

        max-width:
            620px;

        margin-top:
            14px;

        color:
            #d1d5db;

        font-size:
            13px;

        line-height:
            1.8;

    }


    .hero-search {

        max-width:
            650px;

        margin-top:
            24px;

        padding:
            7px;

        display:
            flex;

        align-items:
            center;

        gap:
            8px;

        background:
            white;

        border-radius:
            12px;

        box-shadow:
            0 12px 35px
            rgba(0,0,0,.20);

    }


    .search-icon {

        width:
            35px;

        height:
            35px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        color:
            #9ca3af;

        font-size:
            17px;

    }


    .hero-search input {

        flex:
            1;

        min-width:
            0;

        height:
            38px;

        border:
            none;

        outline:
            none;

        color:
            #1f2937;

        font-size:
            11px;

    }


    .hero-search input::placeholder {

        color:
            #9ca3af;

    }


    .hero-search button {

        height:
            38px;

        padding:
            0 17px;

        border:
            none;

        border-radius:
            9px;

        background:
            #f59e0b;

        color:
            #111827;

        font-size:
            10px;

        font-weight:
            800;

        cursor:
            pointer;

        transition:
            .2s ease;

    }


    .hero-search button:hover {

        background:
            #d97706;

        color:
            white;

    }



    /* =========================================================
       STATS
    ========================================================== */

    .stats-section {

        position:
            relative;

        margin-top:
            -24px;

        padding:
            0 25px;

        z-index:
            5;

    }


    .stats-grid {

        display:
            grid;

        grid-template-columns:
            repeat(4,1fr);

        gap:
            13px;

    }


    .stat-card {

        min-height:
            90px;

        padding:
            17px;

        display:
            flex;

        align-items:
            center;

        gap:
            12px;

        background:
            white;

        border:
            1px solid #ebe8e0;

        border-radius:
            13px;

        box-shadow:
            0 7px 22px
            rgba(17,24,39,.07);

    }


    .stat-icon {

        width:
            43px;

        height:
            43px;

        flex-shrink:
            0;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            11px;

        font-size:
            18px;

        font-weight:
            800;

    }


    .stat-icon-gold {

        background:
            #fff7e6;

        color:
            #d97706;

    }


    .stat-icon-blue {

        background:
            #eff6ff;

        color:
            #2563eb;

    }


    .stat-icon-green {

        background:
            #ecfdf5;

        color:
            #059669;

    }


    .stat-icon-dark {

        background:
            #f3f4f6;

        color:
            #111827;

    }


    .stat-number {

        color:
            #111827;

        font-size:
            22px;

        font-weight:
            800;

        line-height:
            1;

    }


    .stat-label {

        margin-top:
            4px;

        color:
            #9ca3af;

        font-size:
            9px;

        font-weight:
            600;

    }



    /* =========================================================
       SECTION
    ========================================================== */

    .home-section {

        margin-top:
            45px;

    }


    .section-heading {

        display:
            flex;

        align-items:
            flex-end;

        justify-content:
            space-between;

        gap:
            20px;

        margin-bottom:
            18px;

    }


    .section-kicker {

        display:
            block;

        color:
            #d97706;

        font-size:
            8px;

        font-weight:
            800;

        letter-spacing:
            1.1px;

    }


    .section-heading h2 {

        margin-top:
            5px;

        color:
            #111827;

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            24px;

        font-weight:
            700;

        line-height:
            1.25;

    }


    .section-heading p {

        margin-top:
            5px;

        color:
            #6b7280;

        font-size:
            11px;

    }


    .section-link {

        flex-shrink:
            0;

        color:
            #b45309;

        font-size:
            10px;

        font-weight:
            800;

    }


    .section-link:hover {

        color:
            #92400e;

    }



    /* =========================================================
       CATEGORY
    ========================================================== */

    .category-grid {

        display:
            grid;

        grid-template-columns:
            repeat(6,1fr);

        gap:
            10px;

    }


    .category-card {

        position:
            relative;

        min-height:
            115px;

        padding:
            16px;

        display:
            flex;

        flex-direction:
            column;

        justify-content:
            space-between;

        background:
            white;

        border:
            1px solid #ebe8e0;

        border-radius:
            13px;

        transition:
            all .2s ease;

    }


    .category-card:hover {

        border-color:
            #f3c05d;

        transform:
            translateY(-3px);

        box-shadow:
            0 10px 23px
            rgba(17,24,39,.07);

    }


    .category-icon {

        width:
            36px;

        height:
            36px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            10px;

        background:
            #fff7e6;

        color:
            #d97706;

        font-size:
            17px;

    }


    .category-name {

        margin-top:
            13px;

        color:
            #1f2937;

        font-size:
            11px;

        font-weight:
            800;

        line-height:
            1.4;

    }


    .category-arrow {

        position:
            absolute;

        right:
            13px;

        bottom:
            12px;

        color:
            #d1d5db;

        font-size:
            14px;

    }



    /* =========================================================
       FEATURED EVENT
    ========================================================== */

    .featured-section {

        padding-top:
            3px;

    }


    .featured-grid {

        display:
            grid;

        grid-template-columns:
            repeat(3,minmax(0,1fr));

        gap:
            17px;

    }


    .featured-card {

        overflow:
            hidden;

        background:
            white;

        border:
            1px solid #ebe8e0;

        border-radius:
            15px;

        box-shadow:
            0 4px 15px
            rgba(17,24,39,.04);

        transition:
            all .2s ease;

    }


    .featured-card:hover {

        transform:
            translateY(-3px);

        box-shadow:
            0 13px 28px
            rgba(17,24,39,.08);

    }


    .event-image {

        position:
            relative;

        height:
            195px;

        overflow:
            hidden;

        background:
            #edeae3;

    }


    .event-image img {

        width:
            100%;

        height:
            100%;

        object-fit:
            cover;

        transition:
            transform .3s ease;

    }


    .featured-card:hover
    .event-image img {

        transform:
            scale(1.04);

    }


    .event-placeholder {

        width:
            100%;

        height:
            100%;

        display:
            flex;

        flex-direction:
            column;

        align-items:
            center;

        justify-content:
            center;

        background:
            linear-gradient(
                135deg,
                #241b0f,
                #604114
            );

        color:
            white;

    }


    .placeholder-logo {

        width:
            55px;

        height:
            55px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border:
            2px solid #f59e0b;

        border-radius:
            13px;

        color:
            #f59e0b;

        font-size:
            17px;

        font-weight:
            800;

    }


    .placeholder-text {

        margin-top:
            9px;

        color:
            #d1d5db;

        font-size:
            8px;

        font-weight:
            600;

    }


    .event-category {

        position:
            absolute;

        top:
            12px;

        left:
            12px;

        padding:
            5px 8px;

        border-radius:
            999px;

        background:
            rgba(17,24,39,.82);

        color:
            #fbbf24;

        font-size:
            8px;

        font-weight:
            800;

        backdrop-filter:
            blur(5px);

    }


    .event-content {

        padding:
            16px;

    }


    .event-content h3 {

        min-height:
            44px;

        color:
            #111827;

        font-size:
            14px;

        font-weight:
            800;

        line-height:
            1.5;

    }


    .event-info {

        margin-top:
            11px;

    }


    .event-info-row {

        display:
            flex;

        align-items:
            flex-start;

        gap:
            7px;

        margin-bottom:
            6px;

        color:
            #6b7280;

        font-size:
            9px;

        line-height:
            1.5;

    }


    .info-icon {

        color:
            #d97706;

        flex-shrink:
            0;

    }


    .event-bottom {

        margin-top:
            15px;

        padding-top:
            13px;

        display:
            flex;

        align-items:
            flex-end;

        justify-content:
            space-between;

        gap:
            10px;

        border-top:
            1px solid #f0eee9;

    }


    .price-label {

        display:
            block;

        color:
            #9ca3af;

        font-size:
            8px;

    }


    .event-price strong {

        display:
            block;

        margin-top:
            2px;

        color:
            #111827;

        font-size:
            13px;

        font-weight:
            800;

    }


    .event-button {

        padding:
            8px 11px;

        border-radius:
            8px;

        background:
            #111827;

        color:
            white;

        font-size:
            9px;

        font-weight:
            800;

        transition:
            .2s ease;

    }


    .event-button:hover {

        background:
            #f59e0b;

        color:
            #111827;

    }



    /* =========================================================
       UPCOMING
    ========================================================== */

    .upcoming-section {

        padding:
            28px;

        margin-left:
            -5px;

        margin-right:
            -5px;

        border-radius:
            17px;

        background:
            #f4f1ea;

    }


    .upcoming-list {

        display:
            flex;

        flex-direction:
            column;

        gap:
            9px;

    }


    .upcoming-card {

        min-height:
            89px;

        padding:
            12px 14px;

        display:
            grid;

        grid-template-columns:
            60px 1fr auto;

        align-items:
            center;

        gap:
            15px;

        background:
            white;

        border:
            1px solid #e9e5dc;

        border-radius:
            12px;

    }


    .date-box {

        width:
            60px;

        height:
            60px;

        display:
            flex;

        flex-direction:
            column;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            11px;

        background:
            #111827;

        color:
            white;

    }


    .date-box span {

        color:
            #fbbf24;

        font-size:
            8px;

        font-weight:
            800;

        text-transform:
            uppercase;

    }


    .date-box strong {

        margin-top:
            2px;

        font-size:
            22px;

        line-height:
            1;

    }


    .upcoming-top {

        display:
            flex;

        align-items:
            center;

        gap:
            7px;

        margin-bottom:
            4px;

    }


    .mini-category {

        color:
            #b45309;

        font-size:
            8px;

        font-weight:
            800;

    }


    .mini-status {

        padding:
            3px 6px;

        border-radius:
            999px;

        background:
            #ecfdf5;

        color:
            #047857;

        font-size:
            7px;

        font-weight:
            700;

    }


    .upcoming-main h3 {

        color:
            #111827;

        font-size:
            13px;

        font-weight:
            800;

    }


    .upcoming-meta {

        display:
            flex;

        flex-wrap:
            wrap;

        gap:
            12px;

        margin-top:
            4px;

        color:
            #9ca3af;

        font-size:
            8px;

    }


    .upcoming-right {

        min-width:
            105px;

        text-align:
            right;

    }


    .upcoming-price {

        margin-bottom:
            7px;

        color:
            #111827;

        font-size:
            12px;

        font-weight:
            800;

    }


    .outline-button {

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        padding:
            7px 10px;

        border:
            1px solid #d6d3cd;

        border-radius:
            8px;

        color:
            #374151;

        font-size:
            8px;

        font-weight:
            800;

    }


    .outline-button:hover {

        border-color:
            #f59e0b;

        color:
            #b45309;

    }



    /* =========================================================
       EMPTY
    ========================================================== */

    .empty-home {

        padding:
            45px 20px;

        text-align:
            center;

        background:
            white;

        border:
            1px solid #ebe8e0;

        border-radius:
            15px;

    }


    .empty-home-icon {

        width:
            50px;

        height:
            50px;

        margin:
            0 auto 12px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border-radius:
            13px;

        background:
            #fff7e6;

        color:
            #d97706;

        font-size:
            22px;

    }


    .empty-home h3 {

        color:
            #111827;

        font-size:
            14px;

        font-weight:
            800;

    }


    .empty-home p {

        margin-top:
            5px;

        color:
            #9ca3af;

        font-size:
            10px;

    }



    /* =========================================================
       CTA
    ========================================================== */

    .home-cta {

        position:
            relative;

        overflow:
            hidden;

        margin-top:
            40px;

        border-radius:
            17px;

        background:
            linear-gradient(
                135deg,
                #18130c,
                #3b2a12
            );

    }


    .home-cta::after {

        content:
            '';

        position:
            absolute;

        width:
            280px;

        height:
            280px;

        right:
            -90px;

        top:
            -150px;

        border-radius:
            50%;

        background:
            rgba(245,158,11,.12);

    }


    .cta-content {

        position:
            relative;

        z-index:
            2;

        padding:
            34px;

        max-width:
            700px;

    }


    .cta-kicker {

        color:
            #fbbf24;

        font-size:
            8px;

        font-weight:
            800;

        letter-spacing:
            1px;

    }


    .cta-content h2 {

        margin-top:
            7px;

        color:
            white;

        font-family:
            'Playfair Display',
            Georgia,
            serif;

        font-size:
            27px;

    }


    .cta-content p {

        margin-top:
            7px;

        color:
            #d1d5db;

        font-size:
            11px;

        line-height:
            1.7;

    }


    .cta-buttons {

        margin-top:
            18px;

        display:
            flex;

        gap:
            8px;

        flex-wrap:
            wrap;

    }


    .cta-primary,
    .cta-secondary {

        display:
            inline-flex;

        align-items:
            center;

        justify-content:
            center;

        min-height:
            39px;

        padding:
            0 14px;

        border-radius:
            9px;

        font-size:
            9px;

        font-weight:
            800;

    }


    .cta-primary {

        background:
            #f59e0b;

        color:
            #111827;

    }


    .cta-secondary {

        border:
            1px solid rgba(255,255,255,.22);

        color:
            white;

        background:
            rgba(255,255,255,.06);

    }



    /* =========================================================
       FOOTER INFO
    ========================================================== */

    .home-footer-info {

        margin:
            40px -32px -32px;

        padding:
            35px 32px 18px;

        background:
            #111827;

    }


    .footer-info-grid {

        display:
            grid;

        grid-template-columns:
            1.5fr 1fr 1.25fr 1fr;

        gap:
            28px;

        max-width:
            1450px;

        margin:
            0 auto;

    }


    .footer-info-brand {

        display:
            flex;

        align-items:
            flex-start;

        gap:
            11px;

    }


    .footer-logo {

        width:
            38px;

        height:
            38px;

        flex-shrink:
            0;

        display:
            flex;

        align-items:
            center;

        justify-content:
            center;

        border:
            1px solid #f59e0b;

        border-radius:
            9px;

        color:
            #f59e0b;

        font-size:
            12px;

        font-weight:
            800;

    }


    .footer-title {

        color:
            white;

        font-size:
            11px;

        font-weight:
            800;

        letter-spacing:
            .4px;

    }


    .footer-info-brand p {

        max-width:
            300px;

        margin-top:
            7px;

        color:
            #9ca3af;

        font-size:
            9px;

        line-height:
            1.75;

    }


    .footer-column h4 {

        margin-bottom:
            10px;

        color:
            #fbbf24;

        font-size:
            9px;

        font-weight:
            800;

        text-transform:
            uppercase;

        letter-spacing:
            .6px;

    }


    .footer-column a {

        display:
            block;

        margin-bottom:
            7px;

        color:
            #d1d5db;

        font-size:
            9px;

    }


    .footer-column a:hover {

        color:
            #fbbf24;

    }


    .footer-contact {

        display:
            flex;

        flex-direction:
            column;

        gap:
            7px;

    }


    .footer-contact strong {

        color:
            white;

        font-size:
            9px;

    }


    .footer-contact span {

        color:
            #9ca3af;

        font-size:
            9px;

        line-height:
            1.6;

    }


    .footer-bottom {

        max-width:
            1450px;

        margin:
            25px auto 0;

        padding-top:
            15px;

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        gap:
            15px;

        border-top:
            1px solid rgba(255,255,255,.09);

        color:
            #6b7280;

        font-size:
            8px;

    }



    /* =========================================================
       TABLET
    ========================================================== */

    @media (max-width: 1100px) {

        .stats-grid {

            grid-template-columns:
                repeat(2,1fr);

        }


        .category-grid {

            grid-template-columns:
                repeat(3,1fr);

        }


        .featured-grid {

            grid-template-columns:
                repeat(2,1fr);

        }


        .footer-info-grid {

            grid-template-columns:
                repeat(2,1fr);

        }

    }



    /* =========================================================
       MOBILE
    ========================================================== */

    @media (max-width: 900px) {

        .home-hero {

            margin:
                -24px -20px 0;

        }


        .hero-content {

            padding:
                45px 30px;

        }


        .home-footer-info {

            margin:
                35px -20px -24px;

            padding:
                30px 20px 18px;

        }

    }


    @media (max-width: 650px) {

        .home-hero {

            min-height:
                430px;

        }


        .hero-content {

            padding:
                40px 22px;

        }


        .hero-content h1 {

            font-size:
                34px;

        }


        .hero-content p {

            font-size:
                11px;

        }


        .hero-search {

            flex-wrap:
                wrap;

            padding:
                7px;

        }


        .hero-search input {

            width:
                calc(100% - 45px);

            flex:
                none;

        }


        .hero-search button {

            width:
                100%;

            margin-top:
                3px;

        }


        .stats-section {

            padding:
                0 10px;

        }


        .stats-grid {

            grid-template-columns:
                1fr 1fr;

        }


        .stat-card {

            padding:
                13px;

        }


        .stat-icon {

            width:
                38px;

            height:
                38px;

        }


        .stat-number {

            font-size:
                18px;

        }


        .section-heading {

            align-items:
                flex-start;

            flex-direction:
                column;

        }


        .category-grid {

            grid-template-columns:
                repeat(2,1fr);

        }


        .featured-grid {

            grid-template-columns:
                1fr;

        }


        .upcoming-section {

            padding:
                18px;

        }


        .upcoming-card {

            grid-template-columns:
                52px 1fr;

            gap:
                10px;

        }


        .date-box {

            width:
                52px;

            height:
                52px;

        }


        .upcoming-right {

            grid-column:
                2;

            min-width:
                0;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            text-align:
                left;

        }


        .upcoming-price {

            margin:
                0;

        }


        .footer-info-grid {

            grid-template-columns:
                1fr;

        }


        .footer-bottom {

            align-items:
                flex-start;

            flex-direction:
                column;

        }

    }

</style>

@endpush
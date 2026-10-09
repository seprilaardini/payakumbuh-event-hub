@extends('masyarakat.layout')

@section('title', 'Daftar Event - Payakumbuh Event Hub')


@section('content')


{{-- =========================================================
     HEADER
========================================================= --}}

<div class="event-page-header">

    <div class="event-header-left">

        <span class="event-kicker">
            PORTAL AGENDA RESMI KOTA PAYAKUMBUH
        </span>

        <h1>
            Jelajahi Semua Event Resmi
        </h1>

        <p>
            Temukan berbagai event menarik yang sedang dan akan berlangsung
            di Kota Payakumbuh.
        </p>

    </div>


    <div class="event-total">

        <strong>
            {{ $events->total() }}
        </strong>

        <span>
            Event
        </span>

    </div>

</div>



{{-- =========================================================
     SEARCH & FILTER
========================================================= --}}

<section class="filter-box">

    <form
        action="{{ route('masyarakat.event') }}"
        method="GET"
    >

        {{-- BARIS PENCARIAN --}}

        <div class="search-row">


            <div class="event-search">

                <span class="search-symbol">
                    ⌕
                </span>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Ketik nama event atau kata kunci..."
                >

            </div>


            <button
                type="submit"
                class="search-button"
            >
                Cari Event
            </button>


        </div>



        {{-- FILTER --}}

        <div class="filter-row">


            {{-- TANGGAL --}}

            <div class="filter-item">

                <label>
                    Pilih Tanggal
                </label>

                <input
                    type="date"
                    name="tanggal"
                    value="{{ request('tanggal') }}"
                >

            </div>



            {{-- HARGA --}}

            <div class="filter-item">

                <label>
                    Semua Harga
                </label>

                <select name="harga">

                    <option value="">
                        Semua Harga
                    </option>

                    <option
                        value="gratis"
                        @selected(request('harga') === 'gratis')
                    >
                        Gratis
                    </option>

                    <option
                        value="berbayar"
                        @selected(request('harga') === 'berbayar')
                    >
                        Berbayar
                    </option>

                </select>

            </div>



            {{-- KATEGORI --}}

            <div class="filter-item">

                <label>
                    Kategori
                </label>

                <select name="kategori">

                    <option value="">
                        Semua Kategori
                    </option>

                    @foreach($kategori as $item)

                        <option
                            value="{{ $item->id_kategori }}"
                            @selected(
                                request('kategori') == $item->id_kategori
                            )
                        >
                            {{ $item->nama_kategori }}
                        </option>

                    @endforeach

                </select>

            </div>



            {{-- RESET --}}

            <a
                href="{{ route('masyarakat.event') }}"
                class="reset-filter"
            >
                Reset Filter
            </a>


        </div>

    </form>

</section>



{{-- =========================================================
     KATEGORI QUICK FILTER
========================================================= --}}

<section class="quick-category">

    <div class="quick-title">
        Pilihan Kategori
    </div>


    <div class="quick-list">


        <a
            href="{{ route('masyarakat.event') }}"
            class="quick-chip {{ !request('kategori') ? 'selected' : '' }}"
        >
            Semua
        </a>


        @foreach($kategori as $item)

            <a
                href="{{ route('masyarakat.event', [
                    'kategori' => $item->id_kategori
                ]) }}"
                class="quick-chip
                    {{
                        request('kategori') == $item->id_kategori
                        ? 'selected'
                        : ''
                    }}"
            >

                {{ $item->nama_kategori }}

            </a>

        @endforeach


    </div>

</section>



{{-- =========================================================
     ACTIVE FILTER INFO
========================================================= --}}

@if(
    request('search')
    ||
    request('tanggal')
    ||
    request('harga')
    ||
    request('kategori')
)

<div class="active-filter">

    <div>

        <span class="active-filter-label">
            Filter aktif:
        </span>


        @if(request('search'))

            <span class="active-filter-tag">
                "{{ request('search') }}"
            </span>

        @endif


        @if(request('tanggal'))

            <span class="active-filter-tag">
                {{ \Carbon\Carbon::parse(request('tanggal'))->format('d M Y') }}
            </span>

        @endif


        @if(request('harga') === 'gratis')

            <span class="active-filter-tag">
                Gratis
            </span>

        @elseif(request('harga') === 'berbayar')

            <span class="active-filter-tag">
                Berbayar
            </span>

        @endif


        @if(request('kategori'))

            @php

                $kategoriAktif =
                    $kategori->firstWhere(
                        'id_kategori',
                        request('kategori')
                    );

            @endphp


            @if($kategoriAktif)

                <span class="active-filter-tag">
                    {{ $kategoriAktif->nama_kategori }}
                </span>

            @endif

        @endif

    </div>


    <a
        href="{{ route('masyarakat.event') }}"
        class="remove-filter"
    >
        Hapus semua
    </a>

</div>

@endif



{{-- =========================================================
     EVENT LIST HEADER
========================================================= --}}

<div class="event-list-header">

    <div>

        <span class="event-kicker">
            DAFTAR EVENT
        </span>

        <h2>
            Event Tersedia
        </h2>

    </div>


    <div class="result-info">

        Menampilkan
        <strong>
            {{ $events->firstItem() ?? 0 }}
            –
            {{ $events->lastItem() ?? 0 }}
        </strong>
        dari
        <strong>
            {{ $events->total() }}
        </strong>
        event

    </div>

</div>



{{-- =========================================================
     EVENT GRID
========================================================= --}}

@if($events->count())


<div class="event-grid">


    @foreach($events as $event)


    <article class="event-card">


        {{-- =================================================
             POSTER
        ================================================== --}}

        <div class="event-poster">


            @if($event->poster)

                <img
                    src="{{ asset('storage/' . $event->poster) }}"
                    alt="{{ $event->nama_event }}"
                >

            @else

                <div class="poster-placeholder">

                    <span class="placeholder-small">
                        PAYAKUMBUH
                    </span>

                    <strong>
                        EVENT HUB
                    </strong>

                </div>

            @endif


            {{-- KATEGORI --}}

            <span class="poster-category">

                {{ $event->kategori->nama_kategori ?? 'Event' }}

            </span>


            {{-- HARGA --}}

            <span class="poster-price">

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

            </span>


        </div>



        {{-- =================================================
             CONTENT
        ================================================== --}}

        <div class="event-card-body">


            <h3 class="event-card-title">

                {{ $event->nama_event }}

            </h3>



            {{-- TANGGAL --}}

            <div class="event-detail-row">

                <span class="event-detail-icon">
                    ◷
                </span>

                <span>

                    {{ $event->tanggal_mulai->format('d M Y') }}

                    ·

                    {{ $event->tanggal_mulai->format('H:i') }}

                    WIB

                </span>

            </div>



            {{-- LOKASI --}}

            <div class="event-detail-row">

                <span class="event-detail-icon">
                    ◎
                </span>

                <span>

                    {{ $event->lokasi->nama_lokasi
                        ?? 'Lokasi belum tersedia'
                    }}

                </span>

            </div>



            {{-- PESERTA --}}

            <div class="event-detail-row">

                <span class="event-detail-icon">
                    ♙
                </span>

                <span>

                    {{ $event->peserta_count }}

                    peserta terdaftar

                </span>

            </div>



            {{-- DESKRIPSI --}}

            <p class="event-description">

                {{
                    \Illuminate\Support\Str::limit(
                        $event->deskripsi_verifkasi
                        ?: 'Informasi event belum tersedia.',
                        100
                    )
                }}

            </p>



            {{-- FOOTER CARD --}}

            <div class="event-card-footer">


                <div class="event-organizer">

                    <span class="organizer-label">
                        Penyelenggara
                    </span>

                    <strong>
                        Payakumbuh Event Hub
                    </strong>

                </div>


                <a
                    href="{{ route(
                        'masyarakat.detail',
                        $event->id_event
                    ) }}"
                    class="detail-button"
                >
                    Detail
                </a>


            </div>


        </div>


    </article>


    @endforeach


</div>


{{-- =========================================================
     PAGINATION
========================================================= --}}

@if($events->hasPages())

    <div class="pagination-wrapper">

        {{ $events->links() }}

    </div>

@endif


@else


{{-- =========================================================
     EMPTY
========================================================= --}}

<div class="empty-events">


    <div class="empty-icon">
        ⌕
    </div>


    <h2>
        Event Tidak Ditemukan
    </h2>


    <p>
        Belum ada event yang sesuai dengan pencarian
        atau filter yang kamu pilih.
    </p>


    <a
        href="{{ route('masyarakat.event') }}"
        class="empty-button"
    >
        Lihat Semua Event
    </a>


</div>


@endif



@endsection



{{-- =========================================================
     CSS DAFTAR EVENT
========================================================= --}}

@push('styles')

<style>


/* =========================================================
   HEADER
========================================================= */

.event-page-header {

    display:
        flex;

    align-items:
        flex-end;

    justify-content:
        space-between;

    gap:
        20px;

    margin-bottom:
        24px;

}


.event-header-left {

    max-width:
        760px;

}


.event-kicker {

    display:
        block;

    color:
        #b45309;

    font-size:
        8px;

    font-weight:
        800;

    letter-spacing:
        1px;

}


.event-page-header h1 {

    margin-top:
        6px;

    color:
        #111827;

    font-family:
        'Playfair Display',
        Georgia,
        serif;

    font-size:
        30px;

    font-weight:
        700;

    line-height:
        1.25;

}


.event-page-header p {

    margin-top:
        6px;

    color:
        #6b7280;

    font-size:
        11px;

    line-height:
        1.7;

}


.event-total {

    min-width:
        100px;

    padding:
        13px 15px;

    border:
        1px solid #e8e3d8;

    border-radius:
        12px;

    background:
        white;

    text-align:
        center;

}


.event-total strong {

    display:
        block;

    color:
        #111827;

    font-size:
        22px;

    font-weight:
        800;

}


.event-total span {

    color:
        #9ca3af;

    font-size:
        9px;

}



/* =========================================================
   FILTER BOX
========================================================= */

.filter-box {

    padding:
        18px;

    background:
        white;

    border:
        1px solid #e8e3d8;

    border-radius:
        14px;

    box-shadow:
        0 5px 17px
        rgba(17,24,39,.04);

}


.search-row {

    display:
        flex;

    align-items:
        center;

    gap:
        9px;

}


.event-search {

    flex:
        1;

    min-width:
        0;

    height:
        43px;

    display:
        flex;

    align-items:
        center;

    gap:
        8px;

    padding:
        0 12px;

    border:
        1px solid #dedbd3;

    border-radius:
        9px;

    background:
        white;

}


.search-symbol {

    flex-shrink:
        0;

    color:
        #9ca3af;

    font-size:
        16px;

}


.event-search input {

    flex:
        1;

    min-width:
        0;

    height:
        100%;

    border:
        none;

    outline:
        none;

    color:
        #374151;

    font-size:
        10px;

}


.event-search input::placeholder {

    color:
        #9ca3af;

}


.search-button {

    height:
        43px;

    padding:
        0 18px;

    border:
        none;

    border-radius:
        9px;

    background:
        #111827;

    color:
        white;

    font-size:
        10px;

    font-weight:
        800;

    cursor:
        pointer;

    transition:
        .2s ease;

}


.search-button:hover {

    background:
        #f59e0b;

    color:
        #111827;

}



/* =========================================================
   FILTER ROW
========================================================= */

.filter-row {

    margin-top:
        12px;

    display:
        grid;

    grid-template-columns:
        1fr 1fr 1fr auto;

    gap:
        9px;

    align-items:
        end;

}


.filter-item {

    min-width:
        0;

}


.filter-item label {

    display:
        block;

    margin-bottom:
        5px;

    color:
        #6b7280;

    font-size:
        8px;

    font-weight:
        700;

}


.filter-item input,
.filter-item select {

    width:
        100%;

    height:
        39px;

    padding:
        0 10px;

    border:
        1px solid #dedbd3;

    border-radius:
        8px;

    outline:
        none;

    background:
        white;

    color:
        #374151;

    font-size:
        9px;

}


.filter-item input:focus,
.filter-item select:focus {

    border-color:
        #f59e0b;

    box-shadow:
        0 0 0 3px
        rgba(245,158,11,.08);

}


.reset-filter {

    height:
        39px;

    padding:
        0 12px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    border:
        1px solid #dedbd3;

    border-radius:
        8px;

    color:
        #6b7280;

    background:
        #faf9f6;

    font-size:
        9px;

    font-weight:
        700;

}


.reset-filter:hover {

    color:
        #b45309;

    border-color:
        #f3c05d;

}



/* =========================================================
   QUICK CATEGORY
========================================================= */

.quick-category {

    margin-top:
        17px;

}


.quick-title {

    margin-bottom:
        8px;

    color:
        #9ca3af;

    font-size:
        8px;

    font-weight:
        800;

    text-transform:
        uppercase;

    letter-spacing:
        .7px;

}


.quick-list {

    display:
        flex;

    flex-wrap:
        wrap;

    gap:
        7px;

}


.quick-chip {

    padding:
        7px 12px;

    border:
        1px solid #e5e1d8;

    border-radius:
        999px;

    background:
        white;

    color:
        #6b7280;

    font-size:
        9px;

    font-weight:
        700;

    transition:
        .2s ease;

}


.quick-chip:hover {

    border-color:
        #f3c05d;

    color:
        #b45309;

}


.quick-chip.selected {

    background:
        #111827;

    border-color:
        #111827;

    color:
        #fbbf24;

}



/* =========================================================
   ACTIVE FILTER
========================================================= */

.active-filter {

    margin-top:
        14px;

    padding:
        10px 12px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        space-between;

    gap:
        10px;

    border:
        1px solid #f3dfb0;

    border-radius:
        9px;

    background:
        #fffaf0;

    color:
        #6b7280;

    font-size:
        9px;

}


.active-filter > div {

    display:
        flex;

    align-items:
        center;

    flex-wrap:
        wrap;

    gap:
        5px;

}


.active-filter-label {

    color:
        #b45309;

    font-weight:
        800;

}


.active-filter-tag {

    padding:
        4px 7px;

    border-radius:
        999px;

    background:
        #fef3c7;

    color:
        #92400e;

    font-size:
        8px;

    font-weight:
        700;

}


.remove-filter {

    flex-shrink:
        0;

    color:
        #b45309;

    font-size:
        8px;

    font-weight:
        800;

}



/* =========================================================
   LIST HEADER
========================================================= */

.event-list-header {

    margin-top:
        32px;

    margin-bottom:
        17px;

    display:
        flex;

    align-items:
        flex-end;

    justify-content:
        space-between;

    gap:
        15px;

}


.event-list-header h2 {

    margin-top:
        5px;

    color:
        #111827;

    font-family:
        'Playfair Display',
        Georgia,
        serif;

    font-size:
        23px;

}


.result-info {

    color:
        #9ca3af;

    font-size:
        9px;

}


.result-info strong {

    color:
        #374151;

}



/* =========================================================
   EVENT GRID
========================================================= */

.event-grid {

    display:
        grid;

    grid-template-columns:
        repeat(3,minmax(0,1fr));

    gap:
        17px;

}


.event-card {

    overflow:
        hidden;

    display:
        flex;

    flex-direction:
        column;

    background:
        white;

    border:
        1px solid #e8e3d8;

    border-radius:
        14px;

    box-shadow:
        0 4px 13px
        rgba(17,24,39,.035);

    transition:
        transform .2s ease,
        box-shadow .2s ease;

}


.event-card:hover {

    transform:
        translateY(-3px);

    box-shadow:
        0 13px 28px
        rgba(17,24,39,.08);

}



/* =========================================================
   POSTER
========================================================= */

.event-poster {

    position:
        relative;

    height:
        190px;

    overflow:
        hidden;

    background:
        #ede9df;

}


.event-poster img {

    width:
        100%;

    height:
        100%;

    object-fit:
        cover;

    transition:
        transform .3s ease;

}


.event-card:hover
.event-poster img {

    transform:
        scale(1.04);

}


.poster-placeholder {

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
            #21180d,
            #5a3c11
        );

    color:
        white;

}


.placeholder-small {

    color:
        #fbbf24;

    font-size:
        7px;

    font-weight:
        800;

    letter-spacing:
        1.2px;

}


.poster-placeholder strong {

    margin-top:
        3px;

    color:
        white;

    font-size:
        22px;

    font-weight:
        800;

    letter-spacing:
        1px;

}


.poster-category {

    position:
        absolute;

    left:
        11px;

    top:
        11px;

    padding:
        5px 8px;

    border-radius:
        999px;

    background:
        rgba(17,24,39,.84);

    color:
        #fbbf24;

    font-size:
        8px;

    font-weight:
        800;

    backdrop-filter:
        blur(5px);

}


.poster-price {

    position:
        absolute;

    right:
        11px;

    bottom:
        11px;

    padding:
        5px 8px;

    border-radius:
        6px;

    background:
        white;

    color:
        #111827;

    font-size:
        8px;

    font-weight:
        800;

    box-shadow:
        0 4px 10px
        rgba(0,0,0,.12);

}



/* =========================================================
   CARD BODY
========================================================= */

.event-card-body {

    flex:
        1;

    padding:
        15px;

    display:
        flex;

    flex-direction:
        column;

}


.event-card-title {

    min-height:
        41px;

    color:
        #111827;

    font-size:
        14px;

    font-weight:
        800;

    line-height:
        1.45;

}


.event-detail-row {

    display:
        flex;

    align-items:
        flex-start;

    gap:
        7px;

    margin-top:
        7px;

    color:
        #6b7280;

    font-size:
        9px;

    line-height:
        1.5;

}


.event-detail-icon {

    flex-shrink:
        0;

    color:
        #d97706;

    font-size:
        11px;

}


.event-description {

    margin-top:
        11px;

    min-height:
        39px;

    color:
        #9ca3af;

    font-size:
        9px;

    line-height:
        1.65;

}


.event-card-footer {

    margin-top:
        15px;

    padding-top:
        12px;

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


.event-organizer {

    min-width:
        0;

}


.organizer-label {

    display:
        block;

    color:
        #b0b2b5;

    font-size:
        7px;

}


.event-organizer strong {

    display:
        block;

    margin-top:
        2px;

    overflow:
        hidden;

    color:
        #4b5563;

    font-size:
        8px;

    font-weight:
        700;

    text-overflow:
        ellipsis;

    white-space:
        nowrap;

}


.detail-button {

    flex-shrink:
        0;

    padding:
        8px 12px;

    border-radius:
        8px;

    background:
        #111827;

    color:
        white;

    font-size:
        8px;

    font-weight:
        800;

    transition:
        .2s ease;

}


.detail-button:hover {

    background:
        #f59e0b;

    color:
        #111827;

}



/* =========================================================
   PAGINATION
========================================================= */

.pagination-wrapper {

    margin-top:
        27px;

    padding:
        5px 0;

    display:
        flex;

    justify-content:
        center;

}


.pagination-wrapper nav {

    display:
        flex;

    align-items:
        center;

    gap:
        5px;

}


.pagination-wrapper a,
.pagination-wrapper span {

    min-width:
        32px;

    height:
        32px;

    display:
        inline-flex;

    align-items:
        center;

    justify-content:
        center;

    padding:
        0 8px;

    border:
        1px solid #e5e1d8;

    border-radius:
        7px;

    background:
        white;

    color:
        #6b7280;

    font-size:
        9px;

}


.pagination-wrapper span[aria-current="page"] {

    background:
        #111827;

    border-color:
        #111827;

    color:
        #fbbf24;

    font-weight:
        800;

}



/* =========================================================
   EMPTY
========================================================= */

.empty-events {

    padding:
        70px 20px;

    text-align:
        center;

    background:
        white;

    border:
        1px solid #e8e3d8;

    border-radius:
        15px;

}


.empty-icon {

    width:
        56px;

    height:
        56px;

    margin:
        0 auto 13px;

    display:
        flex;

    align-items:
        center;

    justify-content:
        center;

    border-radius:
        15px;

    background:
        #fff7e6;

    color:
        #d97706;

    font-size:
        24px;

}


.empty-events h2 {

    color:
        #111827;

    font-family:
        'Playfair Display',
        Georgia,
        serif;

    font-size:
        22px;

}


.empty-events p {

    max-width:
        450px;

    margin:
        6px auto 0;

    color:
        #9ca3af;

    font-size:
        10px;

    line-height:
        1.7;

}


.empty-button {

    display:
        inline-flex;

    margin-top:
        17px;

    padding:
        9px 13px;

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

}



/* =========================================================
   TABLET
========================================================= */

@media (max-width: 1100px) {

    .event-grid {

        grid-template-columns:
            repeat(2,minmax(0,1fr));

    }


    .filter-row {

        grid-template-columns:
            repeat(2,1fr);

    }


    .reset-filter {

        grid-column:
            1 / -1;

        justify-self:
            start;

    }

}



/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 650px) {

    .event-page-header {

        align-items:
            flex-start;

        flex-direction:
            column;

    }


    .event-page-header h1 {

        font-size:
            27px;

    }


    .event-total {

        width:
            100%;

        display:
            flex;

        align-items:
            center;

        justify-content:
            space-between;

        text-align:
            left;

    }


    .event-total strong {

        font-size:
            19px;

    }


    .search-row {

        flex-direction:
            column;

        align-items:
            stretch;

    }


    .event-search {

        width:
            100%;

    }


    .search-button {

        width:
            100%;

    }


    .filter-row {

        grid-template-columns:
            1fr;

    }


    .reset-filter {

        grid-column:
            auto;

        width:
            100%;

    }


    .event-list-header {

        align-items:
            flex-start;

        flex-direction:
            column;

    }


    .event-grid {

        grid-template-columns:
            1fr;

    }


    .event-poster {

        height:
            205px;

    }


    .active-filter {

        align-items:
            flex-start;

        flex-direction:
            column;

    }

</style>

@endpush
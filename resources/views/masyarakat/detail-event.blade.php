@extends('masyarakat.layout')

@section(
    'title',
    $event->nama_event .
    ' - Payakumbuh Event Hub'
)

@section('content')

@php

    $rating = (float) (
        $rataRating ?? 0
    );

    $ratingBulat =
        (int) round($rating);

@endphp


<div class="detail-page">

    <div class="detail-container">


        {{-- =====================================================
             BACK
        ====================================================== --}}

        <a
            href="{{ route('masyarakat.event') }}"
            class="back-link"
        >
            ← Kembali ke Daftar Event
        </a>


        {{-- =====================================================
             HERO EVENT
        ====================================================== --}}

        <section class="detail-hero">


            {{-- POSTER --}}

            <div class="detail-poster">

                @if($event->poster)

                    <img
                        src="{{
                            asset(
                                'storage/' .
                                $event->poster
                            )
                        }}"
                        alt="{{ $event->nama_event }}"
                    >

                @else

                    <div class="poster-placeholder">

                        <span>
                            PAYAKUMBUH
                        </span>

                        <strong>
                            EVENT HUB
                        </strong>

                        <small>
                            EVENT RESMI KOTA PAYAKUMBUH
                        </small>

                    </div>

                @endif


                <div class="poster-category">

                    {{
                        $event
                            ->kategori
                            ->nama_kategori
                        ?? 'Event'
                    }}

                </div>

            </div>


            {{-- INFO --}}

            <div class="detail-info">

                <div class="kicker">
                    EVENT RESMI KOTA PAYAKUMBUH
                </div>


                <h1>
                    {{ $event->nama_event }}
                </h1>


                {{-- RATING --}}

                <div class="rating-head">

                    <div class="stars">

                        @for(
                            $i = 1;
                            $i <= 5;
                            $i++
                        )

                            <span
                                class="{{
                                    $i <= $ratingBulat
                                        ? 'active'
                                        : ''
                                }}"
                            >
                                ★
                            </span>

                        @endfor

                    </div>


                    <strong>
                        {{ number_format(
                            $rating,
                            1
                        ) }}
                    </strong>


                    <span>
                        {{ $jumlahUlasan }}
                        ulasan
                    </span>

                </div>


                {{-- META --}}

                <div class="meta-grid">


                    <div class="meta-item">

                        <span class="meta-icon">
                            📅
                        </span>

                        <div>

                            <small>
                                Tanggal
                            </small>

                            <strong>

                                @if(
                                    $event->tanggal_mulai
                                )

                                    {{
                                        $event
                                            ->tanggal_mulai
                                            ->translatedFormat(
                                                'd F Y'
                                            )
                                    }}

                                    @if(
                                        $event->tanggal_selesai
                                        &&
                                        $event
                                            ->tanggal_selesai
                                            ->format('Y-m-d')
                                        !==
                                        $event
                                            ->tanggal_mulai
                                            ->format('Y-m-d')
                                    )

                                        –
                                        {{
                                            $event
                                                ->tanggal_selesai
                                                ->translatedFormat(
                                                    'd F Y'
                                                )
                                        }}

                                    @endif

                                @else

                                    -

                                @endif

                            </strong>

                        </div>

                    </div>


                    <div class="meta-item">

                        <span class="meta-icon">
                            ⏰
                        </span>

                        <div>

                            <small>
                                Waktu
                            </small>

                            <strong>

                                @if(
                                    $event->tanggal_mulai
                                )

                                    {{
                                        $event
                                            ->tanggal_mulai
                                            ->format('H:i')
                                    }}

                                    WIB

                                    @if(
                                        $event->tanggal_selesai
                                    )

                                        –
                                        {{
                                            $event
                                                ->tanggal_selesai
                                                ->format('H:i')
                                        }}
                                        WIB

                                    @endif

                                @else

                                    -

                                @endif

                            </strong>

                        </div>

                    </div>


                    <div class="meta-item">

                        <span class="meta-icon">
                            📍
                        </span>

                        <div>

                            <small>
                                Lokasi
                            </small>

                            <strong>

                                {{
                                    $event
                                        ->lokasi
                                        ->nama_lokasi
                                    ?? 'Belum tersedia'
                                }}

                            </strong>

                        </div>

                    </div>


                    <div class="meta-item">

                        <span class="meta-icon">
                            👥
                        </span>

                        <div>

                            <small>
                                Peserta
                            </small>

                            <strong>
                                {{ $jumlahPeserta }}
                                peserta
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- PRICE --}}

                <div class="price-box">

                    <div>

                        <small>
                            Harga Tiket
                        </small>

                        <strong>

                            @if(
                                (float)
                                $event
                                    ->biaya_pendaftaran
                                <= 0
                            )

                                Gratis

                            @else

                                Rp
                                {{
                                    number_format(
                                        $event
                                            ->biaya_pendaftaran,
                                        0,
                                        ',',
                                        '.'
                                    )
                                }}

                            @endif

                        </strong>

                    </div>


                    <a
                        href="{{
                            route(
                                'masyarakat.registrasi.create',
                                $event->id_event
                            )
                        }}"
                        class="register-button"
                    >
                        Daftar Sekarang
                    </a>

                </div>

            </div>

        </section>


        {{-- =====================================================
             CONTENT GRID
        ====================================================== --}}

        <div class="detail-grid">


            {{-- =================================================
                 MAIN COLUMN
            ================================================== --}}

            <div>


                {{-- DESKRIPSI --}}

                <section class="detail-section">

                    <div class="section-title">

                        <span>
                            01
                        </span>

                        <div>

                            <small>
                                INFORMASI EVENT
                            </small>

                            <h2>
                                Deskripsi Event
                            </h2>

                        </div>

                    </div>


                    <div class="description">

                        @if(
                            $event
                                ->deskripsi_verifkasi
                        )

                            {!! nl2br(
                                e(
                                    $event
                                        ->deskripsi_verifkasi
                                )
                            ) !!}

                        @else

                            <p class="muted">
                                Deskripsi event belum tersedia.
                            </p>

                        @endif

                    </div>

                </section>


                {{-- LOKASI --}}

                <section class="detail-section">

                    <div class="section-title">

                        <span>
                            02
                        </span>

                        <div>

                            <small>
                                TEMPAT PELAKSANAAN
                            </small>

                            <h2>
                                Lokasi Event
                            </h2>

                        </div>

                    </div>


                    <div class="location-box">

                        <div class="location-icon">
                            📍
                        </div>

                        <div>

                            <h3>

                                {{
                                    $event
                                        ->lokasi
                                        ->nama_lokasi
                                    ?? 'Lokasi belum tersedia'
                                }}

                            </h3>

                            <p>

                                {{
                                    $event
                                        ->lokasi
                                        ->alamat_lokasi
                                    ?? 'Alamat belum tersedia.'
                                }}

                            </p>


                            @if(
                                $event->lokasi
                                &&
                                $event->lokasi->deskripsi
                            )

                                <small>

                                    {{
                                        $event
                                            ->lokasi
                                            ->deskripsi
                                    }}

                                </small>

                            @endif

                        </div>

                    </div>

                </section>


                {{-- DOKUMENTASI --}}

                @if(
                    isset($dokumentasi)
                    &&
                    $dokumentasi->count()
                )

                    <section class="detail-section">

                        <div class="section-title">

                            <span>
                                03
                            </span>

                            <div>

                                <small>
                                    ARSIP KEGIATAN
                                </small>

                                <h2>
                                    Dokumentasi Event
                                </h2>

                            </div>

                        </div>


                        <div class="documentation-list">

                            @foreach(
                                $dokumentasi
                                as $item
                            )

                                <div
                                    class="documentation-item"
                                >

                                    <div
                                        class="doc-icon"
                                    >
                                        🖼️
                                    </div>


                                    <div>

                                        <strong>

                                            {{
                                                $item
                                                    ->deskripsi_dokumentasi
                                                ?:
                                                'Dokumentasi Event'
                                            }}

                                        </strong>


                                        @if(
                                            $item->tgl_upload
                                        )

                                            <small>

                                                {{
                                                    $item
                                                        ->tgl_upload
                                                        ->translatedFormat(
                                                            'd F Y'
                                                        )
                                                }}

                                            </small>

                                        @endif

                                    </div>


                                    @if(
                                        $item->url_dokumentasi
                                    )

                                        <a
                                            href="{{
                                                $item
                                                    ->url_dokumentasi
                                            }}"
                                            target="_blank"
                                            rel="noopener"
                                        >
                                            Lihat
                                        </a>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    </section>

                @endif


                {{-- =================================================
                     ULASAN
                ================================================== --}}

                <section class="detail-section">

                    <div class="section-title">

                        <span>
                            04
                        </span>

                        <div>

                            <small>
                                SUARA PESERTA
                            </small>

                            <h2>
                                Ulasan & Rating
                            </h2>

                        </div>

                    </div>


                    {{-- REVIEW SUMMARY --}}

                    <div class="review-summary">

                        <div class="review-score">

                            <strong>
                                {{
                                    number_format(
                                        $rating,
                                        1
                                    )
                                }}
                            </strong>


                            <div>

                                <div
                                    class="review-stars"
                                >

                                    @for(
                                        $i = 1;
                                        $i <= 5;
                                        $i++
                                    )

                                        <span
                                            class="{{
                                                $i <=
                                                $ratingBulat
                                                    ? 'filled'
                                                    : ''
                                            }}"
                                        >
                                            ★
                                        </span>

                                    @endfor

                                </div>


                                <small>

                                    Berdasarkan
                                    {{ $jumlahUlasan }}
                                    ulasan

                                </small>

                            </div>

                        </div>


                        {{-- TULIS ULASAN --}}

                        <a
                            href="{{
                                route(
                                    'masyarakat.ulasan',
                                    $event->id_event
                                )
                            }}"
                            class="review-button"
                        >
                            Tulis Ulasan
                        </a>

                    </div>


                    {{-- REVIEW LIST --}}

                    @if(
                        isset($ulasan)
                        &&
                        $ulasan->count()
                    )

                        <div class="review-list">

                            @foreach(
                                $ulasan
                                as $review
                            )

                                <div class="review-card">


                                    <div
                                        class="review-avatar"
                                    >

                                        {{
                                            strtoupper(
                                                substr(
                                                    $review
                                                        ->peserta
                                                        ->nama_peserta
                                                    ?? 'P',
                                                    0,
                                                    1
                                                )
                                            )
                                        }}

                                    </div>


                                    <div
                                        class="review-content"
                                    >

                                        <div
                                            class="review-top"
                                        >

                                            <strong>

                                                {{
                                                    $review
                                                        ->peserta
                                                        ->nama_peserta
                                                    ?? 'Peserta'
                                                }}

                                            </strong>


                                            @if(
                                                $review->tanggal_ulasan
                                            )

                                                <small>

                                                    {{
                                                        $review
                                                            ->tanggal_ulasan
                                                            ->translatedFormat(
                                                                'd F Y'
                                                            )
                                                    }}

                                                </small>

                                            @endif

                                        </div>


                                        <div
                                            class="review-stars-small"
                                        >

                                            @for(
                                                $i = 1;
                                                $i <= 5;
                                                $i++
                                            )

                                                @if(
                                                    $i <=
                                                    (int)
                                                    $review->rating
                                                )

                                                    ★

                                                @else

                                                    ☆

                                                @endif

                                            @endfor

                                        </div>


                                        <p>

                                            “{{
                                                $review->komentar
                                            }}”

                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="empty-review">

                            <div>
                                ⭐
                            </div>

                            <h3>
                                Belum ada ulasan
                            </h3>

                            <p>
                                Jadilah peserta pertama
                                yang memberikan ulasan.
                            </p>

                        </div>

                    @endif

                </section>

            </div>


            {{-- =================================================
                 SIDE COLUMN
            ================================================== --}}

            <aside>


                {{-- PRICE --}}

                <div class="side-card dark-card">

                    <small>
                        HARGA TIKET
                    </small>

                    <strong>

                        @if(
                            (float)
                            $event
                                ->biaya_pendaftaran
                            <= 0
                        )

                            Gratis

                        @else

                            Rp
                            {{
                                number_format(
                                    $event
                                        ->biaya_pendaftaran,
                                    0,
                                    ',',
                                    '.'
                                )
                            }}

                        @endif

                    </strong>


                    <a
                        href="{{
                            route(
                                'masyarakat.registrasi.create',
                                $event->id_event
                            )
                        }}"
                    >
                        Daftar Sekarang
                    </a>

                </div>


                {{-- DETAIL --}}

                <div class="side-card">

                    <div class="side-title">
                        DETAIL EVENT
                    </div>


                    <div class="side-row">

                        <span>
                            Kategori
                        </span>

                        <strong>

                            {{
                                $event
                                    ->kategori
                                    ->nama_kategori
                                ?? '-'
                            }}

                        </strong>

                    </div>


                    <div class="side-row">

                        <span>
                            Peserta
                        </span>

                        <strong>
                            {{ $jumlahPeserta }}
                        </strong>

                    </div>


                    <div class="side-row">

                        <span>
                            Ulasan
                        </span>

                        <strong>
                            {{ $jumlahUlasan }}
                        </strong>

                    </div>

                </div>


                {{-- EVENT LAINNYA --}}

                @if(
                    isset($eventLainnya)
                    &&
                    $eventLainnya->count()
                )

                    <div class="side-card">

                        <div class="side-title">
                            EVENT LAINNYA
                        </div>


                        @foreach(
                            $eventLainnya
                            as $other
                        )

                            <a
                                href="{{
                                    route(
                                        'masyarakat.detail',
                                        $other->id_event
                                    )
                                }}"
                                class="other-event"
                            >

                                <small>

                                    {{
                                        $other
                                            ->kategori
                                            ->nama_kategori
                                        ?? 'Event'
                                    }}

                                </small>


                                <strong>
                                    {{
                                        $other->nama_event
                                    }}
                                </strong>


                                @if(
                                    $other->tanggal_mulai
                                )

                                    <span>

                                        {{
                                            $other
                                                ->tanggal_mulai
                                                ->translatedFormat(
                                                    'd F Y'
                                                )
                                        }}

                                    </span>

                                @endif

                            </a>

                        @endforeach

                    </div>

                @endif

            </aside>

        </div>

    </div>

</div>


@push('styles')

<style>

.detail-page {
    min-height: 100vh;
    padding: 35px 20px 70px;
    background: #f5f7fb;
}

.detail-container {
    max-width: 1180px;
    margin: 0 auto;
}

.back-link {
    display: inline-flex;
    margin-bottom: 25px;
    color: #172b4d;
    font-size: 14px;
    font-weight: 700;
}

.detail-hero {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 32px;
    padding: 28px;
    margin-bottom: 25px;
    border: 1px solid #e2e6ec;
    border-radius: 24px;
    background: white;
}

.detail-poster {
    position: relative;
    min-height: 420px;
    overflow: hidden;
    border-radius: 19px;
    background: #e8edf3;
}

.detail-poster > img {
    width: 100%;
    height: 100%;
    min-height: 420px;
    object-fit: cover;
}

.poster-placeholder {
    min-height: 420px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background: #193956;
    color: white;
    text-align: center;
}

.poster-placeholder span {
    color: #e6b33d;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 2px;
}

.poster-placeholder strong {
    margin-top: 10px;
    font-size: 38px;
}

.poster-placeholder small {
    margin-top: 12px;
    color: #d7e0e8;
}

.poster-category {
    position: absolute;
    top: 14px;
    left: 14px;
    padding: 8px 11px;
    border-radius: 9px;
    background: white;
    color: #ad7d1c;
    font-size: 11px;
    font-weight: 800;
}

.detail-info {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.kicker {
    color: #b98828;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.4px;
}

.detail-info h1 {
    margin: 10px 0 15px;
    color: #172b4d;
    font-size: 38px;
    line-height: 1.2;
}

.rating-head {
    display: flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 23px;
}

.stars span {
    color: #d9dde3;
    font-size: 19px;
}

.stars span.active {
    color: #e3b13b;
}

.rating-head strong {
    color: #172b4d;
    font-size: 17px;
}

.rating-head > span {
    color: #8993a1;
    font-size: 13px;
}

.meta-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 23px;
}

.meta-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 14px;
    border: 1px solid #e5e9ee;
    border-radius: 13px;
    background: #fafbfc;
}

.meta-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 8px;
    background: #edf2f8;
    font-size: 13px;
}

.meta-item small {
    display: block;
    color: #9aa2ad;
    font-size: 10px;
}

.meta-item strong {
    display: block;
    margin-top: 4px;
    color: #172b4d;
    font-size: 12px;
    line-height: 1.5;
}

.price-box {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding-top: 20px;
    border-top: 1px solid #edf0f3;
}

.price-box small {
    display: block;
    color: #9ba3ae;
    font-size: 10px;
}

.price-box strong {
    display: block;
    margin-top: 4px;
    color: #172b4d;
    font-size: 27px;
}

.register-button {
    padding: 13px 19px;
    border-radius: 11px;
    background: #172b4d;
    color: white;
    font-size: 13px;
    font-weight: 800;
}

.detail-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 290px;
    gap: 24px;
}

.detail-section,
.side-card {
    margin-bottom: 24px;
    padding: 26px;
    border: 1px solid #e2e6ec;
    border-radius: 21px;
    background: white;
}

.section-title {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    margin-bottom: 22px;
}

.section-title > span {
    color: #bd8c30;
    font-size: 12px;
    font-weight: 800;
}

.section-title small {
    display: block;
    color: #9aa3ad;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.2px;
}

.section-title h2 {
    margin-top: 4px;
    color: #172b4d;
    font-size: 23px;
}

.description {
    color: #6d7888;
    font-size: 14px;
    line-height: 1.9;
}

.muted {
    color: #9ca4ae;
}

.location-box {
    display: flex;
    gap: 14px;
    padding: 18px;
    border-radius: 14px;
    background: #fafbfc;
    border: 1px solid #e5e9ee;
}

.location-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 11px;
    background: #edf3fa;
}

.location-box h3 {
    color: #172b4d;
    font-size: 15px;
}

.location-box p {
    margin-top: 5px;
    color: #7d8796;
    font-size: 13px;
    line-height: 1.6;
}

.location-box small {
    display: block;
    margin-top: 8px;
    color: #929ba7;
}

.documentation-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.documentation-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px;
    border: 1px solid #e5e9ee;
    border-radius: 13px;
    background: #fafbfc;
}

.doc-icon {
    width: 39px;
    height: 39px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: #edf2f8;
}

.documentation-item strong {
    display: block;
    color: #172b4d;
    font-size: 12px;
}

.documentation-item small {
    display: block;
    margin-top: 4px;
    color: #97a0ab;
}

.documentation-item a {
    margin-left: auto;
    padding: 8px 11px;
    border-radius: 8px;
    background: #172b4d;
    color: white;
    font-size: 11px;
    font-weight: 800;
}

.review-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 19px;
    border: 1px solid #eee2c1;
    border-radius: 15px;
    background: #fffaf0;
}

.review-score {
    display: flex;
    align-items: center;
    gap: 14px;
}

.review-score > strong {
    color: #172b4d;
    font-size: 39px;
}

.review-stars span {
    color: #d9dde3;
    font-size: 19px;
}

.review-stars span.filled {
    color: #e6b33e;
}

.review-score small {
    display: block;
    margin-top: 4px;
    color: #909aa7;
    font-size: 10px;
}

.review-button {
    padding: 11px 15px;
    border-radius: 10px;
    background: #172b4d;
    color: white;
    font-size: 12px;
    font-weight: 800;
}

.review-list {
    margin-top: 18px;
}

.review-card {
    display: flex;
    gap: 12px;
    padding: 17px 0;
    border-bottom: 1px solid #edf0f3;
}

.review-avatar {
    width: 39px;
    height: 39px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 50%;
    background: #172b4d;
    color: white;
    font-size: 13px;
    font-weight: 800;
}

.review-content {
    flex: 1;
}

.review-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
}

.review-top strong {
    color: #172b4d;
    font-size: 13px;
}

.review-top small {
    color: #9aa3ae;
    font-size: 10px;
}

.review-stars-small {
    margin-top: 4px;
    color: #e4b13b;
    font-size: 12px;
    letter-spacing: 1px;
}

.review-content p {
    margin-top: 8px;
    color: #728093;
    font-size: 13px;
    line-height: 1.7;
}

.empty-review {
    padding: 35px 15px;
    text-align: center;
}

.empty-review > div {
    font-size: 38px;
}

.empty-review h3 {
    margin-top: 8px;
    color: #172b4d;
}

.empty-review p {
    margin-top: 5px;
    color: #8e98a6;
    font-size: 12px;
}

.dark-card {
    background: #172b4d;
    border-color: #172b4d;
}

.dark-card small {
    color: #cbd4df;
    font-size: 10px;
    font-weight: 800;
}

.dark-card > strong {
    display: block;
    margin: 8px 0 18px;
    color: white;
    font-size: 27px;
}

.dark-card > a {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
    border-radius: 10px;
    background: #e6b23e;
    color: #172b4d;
    font-size: 12px;
    font-weight: 800;
}

.side-title {
    margin-bottom: 8px;
    color: #9aa3ad;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.3px;
}

.side-row {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    padding: 12px 0;
    border-bottom: 1px solid #edf0f3;
}

.side-row:last-child {
    border-bottom: 0;
}

.side-row span {
    color: #8993a0;
    font-size: 11px;
}

.side-row strong {
    color: #172b4d;
    font-size: 11px;
    text-align: right;
}

.other-event {
    display: block;
    padding: 12px 0;
    border-bottom: 1px solid #edf0f3;
}

.other-event:last-child {
    border-bottom: 0;
}

.other-event small {
    display: block;
    color: #b78729;
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
}

.other-event strong {
    display: block;
    margin-top: 4px;
    color: #172b4d;
    font-size: 12px;
    line-height: 1.4;
}

.other-event span {
    display: block;
    margin-top: 4px;
    color: #9ba3ae;
    font-size: 10px;
}

@media (max-width: 950px) {

    .detail-hero {
        grid-template-columns: 300px 1fr;
    }

    .detail-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 750px) {

    .detail-hero {
        grid-template-columns: 1fr;
    }

    .detail-poster {
        min-height: 320px;
    }

    .detail-poster > img,
    .poster-placeholder {
        min-height: 320px;
    }

    .detail-info h1 {
        font-size: 30px;
    }

    .meta-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 550px) {

    .detail-page {
        padding: 25px 12px 50px;
    }

    .detail-hero,
    .detail-section,
    .side-card {
        padding: 20px;
    }

    .price-box {
        flex-direction: column;
        align-items: stretch;
    }

    .register-button {
        width: 100%;
        text-align: center;
    }

    .review-summary {
        flex-direction: column;
        align-items: stretch;
    }

    .review-button {
        text-align: center;
    }

}

</style>

@endpush

@endsection
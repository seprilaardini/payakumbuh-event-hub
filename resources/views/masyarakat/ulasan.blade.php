@extends('masyarakat.layout')

@section(
    'title',
    'Ulasan - ' . $event->nama_event
)

@section('content')

<div class="review-page">

    <div class="review-container">

        {{-- =====================================================
             KEMBALI
        ====================================================== --}}

        <a
            href="{{ route('masyarakat.detail', $event->id_event) }}"
            class="back-link"
        >
            ← Kembali ke Detail Event
        </a>


        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="review-header">

            <div class="eyebrow">
                PAYAKUMBUH EVENT HUB
            </div>

            <h1>
                Ulasan & Rating
            </h1>

            <p>
                Bagikan pengalamanmu setelah mengikuti event
                di Kota Payakumbuh.
            </p>

        </div>


        {{-- =====================================================
             ALERT SUCCESS
        ====================================================== --}}

        @if(session('success'))

            <div class="alert success">
                {{ session('success') }}
            </div>

        @endif


        {{-- =====================================================
             ALERT ERROR
        ====================================================== --}}

        @if(session('error'))

            <div class="alert error">
                {{ session('error') }}
            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERROR
        ====================================================== --}}

        @if($errors->any())

            <div class="alert error">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        {{-- =====================================================
             EVENT YANG DIULAS
        ====================================================== --}}

        <div class="event-card">

            <div class="event-label">
                EVENT YANG DIULAS
            </div>

            <h2>
                {{ $event->nama_event }}
            </h2>

            <div class="event-meta">

                <span>
                    {{ $event->kategori->nama_kategori ?? '-' }}
                </span>

                @if($event->tanggal_mulai)

                    <span>
                        📅
                        {{
                            $event->tanggal_mulai
                                ->translatedFormat('d F Y')
                        }}
                    </span>

                @endif

                <span>
                    📍
                    {{ $event->lokasi->nama_lokasi ?? '-' }}
                </span>

            </div>

        </div>


        {{-- =====================================================
             GRID
        ====================================================== --}}

        <div class="review-grid">


            {{-- =================================================
                 RATING
            ================================================== --}}

            <div class="rating-card">

                <div class="rating-title">
                    RATING KESELURUHAN
                </div>


                <div class="rating-top">

                    <div class="rating-number">
                        {{ number_format($rataRating, 1) }}
                    </div>

                    <div>

                        <div class="big-stars">
                            ★ ★ ★ ★ ★
                        </div>

                        <div class="rating-count">
                            {{ $jumlahUlasan }}
                            ulasan masyarakat
                        </div>

                    </div>

                </div>


                {{-- RATING 5-1 --}}

                @for($i = 5; $i >= 1; $i--)

                    <div class="rating-row">

                        <span>
                            {{ $i }} ★
                        </span>

                        <div class="rating-bar">

                            <div
                                class="rating-fill"
                                style="
                                    width: {{ $ratingPercents[$i] ?? 0 }}%;
                                "
                            ></div>

                        </div>

                        <span class="rating-percent">
                            {{ $ratingPercents[$i] ?? 0 }}%
                        </span>

                    </div>

                @endfor


                <div class="rating-note">

                    Ulasan dari peserta membantu masyarakat
                    mendapatkan gambaran pengalaman sebelum
                    mengikuti event.

                </div>

            </div>


            {{-- =================================================
                 FORM ULASAN
            ================================================== --}}

            <div class="review-form-card">

                <div class="form-header">

                    <h2>
                        Tulis Ulasan
                    </h2>

                    <p>
                        Tidak perlu kode pendaftaran.
                        Gunakan email yang kamu gunakan
                        saat mendaftar event.
                    </p>

                </div>


                <form
                    action="{{ route('masyarakat.ulasan.simpan') }}"
                    method="POST"
                >

                    @csrf


                    {{-- EVENT --}}

                    <input
                        type="hidden"
                        name="id_event"
                        value="{{ $event->id_event }}"
                    >


                    {{-- NAMA --}}

                    <div class="form-group">

                        <label for="nama">
                            Nama Lengkap
                            <span>*</span>
                        </label>

                        <input
                            id="nama"
                            type="text"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                    </div>


                    {{-- EMAIL --}}

                    <div class="form-group">

                        <label for="email">
                            Email
                            <span>*</span>
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Email saat mendaftar"
                            required
                        >

                        <small>
                            Gunakan email yang sama dengan
                            email saat pendaftaran.
                        </small>

                    </div>


                    {{-- RATING --}}

                    <div class="form-group">

                        <label>
                            Rating
                            <span>*</span>
                        </label>

                        <div class="star-input">

                            <input
                                type="radio"
                                name="rating"
                                id="star5"
                                value="5"
                                @checked(old('rating') == 5)
                                required
                            >

                            <label for="star5">
                                ★
                            </label>


                            <input
                                type="radio"
                                name="rating"
                                id="star4"
                                value="4"
                                @checked(old('rating') == 4)
                            >

                            <label for="star4">
                                ★
                            </label>


                            <input
                                type="radio"
                                name="rating"
                                id="star3"
                                value="3"
                                @checked(old('rating') == 3)
                            >

                            <label for="star3">
                                ★
                            </label>


                            <input
                                type="radio"
                                name="rating"
                                id="star2"
                                value="2"
                                @checked(old('rating') == 2)
                            >

                            <label for="star2">
                                ★
                            </label>


                            <input
                                type="radio"
                                name="rating"
                                id="star1"
                                value="1"
                                @checked(old('rating') == 1)
                            >

                            <label for="star1">
                                ★
                            </label>

                        </div>

                    </div>


                    {{-- KOMENTAR --}}

                    <div class="form-group">

                        <label for="komentar">
                            Komentar
                            <span>*</span>
                        </label>

                        <textarea
                            id="komentar"
                            name="komentar"
                            rows="6"
                            placeholder="Bagaimana pengalaman kamu mengikuti event ini?"
                            required
                        >{{ old('komentar') }}</textarea>

                    </div>


                    {{-- SUBMIT --}}

                    <button
                        type="submit"
                        class="btn-submit"
                    >

                        <span>
                            Kirim Ulasan
                        </span>

                        <span>
                            →
                        </span>

                    </button>

                </form>

            </div>

        </div>


        {{-- =====================================================
             ULASAN TERBARU
        ====================================================== --}}

        <section class="latest-reviews">

            <div class="latest-header">

                <div>

                    <div class="eyebrow">
                        SUARA PESERTA
                    </div>

                    <h2>
                        Ulasan Terbaru
                    </h2>

                </div>

                <span>
                    {{ $jumlahUlasan }} ulasan
                </span>

            </div>


            @if($ulasan->count() > 0)

                <div class="review-list">

                    @foreach($ulasan as $item)

                        <article class="review-item">

                            <div class="avatar">

                                {{
                                    strtoupper(
                                        substr(
                                            $item->peserta->nama_peserta ?? 'P',
                                            0,
                                            1
                                        )
                                    )
                                }}

                            </div>


                            <div class="review-content">

                                <div class="review-top">

                                    <strong>
                                        {{
                                            $item->peserta->nama_peserta
                                            ?? 'Peserta'
                                        }}
                                    </strong>

                                    <span>

                                        @if($item->tanggal_ulasan)

                                            {{
                                                $item->tanggal_ulasan
                                                    ->translatedFormat(
                                                        'd F Y'
                                                    )
                                            }}

                                        @endif

                                    </span>

                                </div>


                                <div class="review-stars">

                                    @for($i = 1; $i <= 5; $i++)

                                        @if($i <= $item->rating)

                                            <span>
                                                ★
                                            </span>

                                        @else

                                            <span class="empty-star">
                                                ★
                                            </span>

                                        @endif

                                    @endfor

                                </div>


                                <p>
                                    "{{ $item->komentar }}"
                                </p>

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="empty-review">

                    <div class="empty-icon">
                        ⭐
                    </div>

                    <h3>
                        Belum ada ulasan
                    </h3>

                    <p>
                        Jadilah peserta pertama yang memberikan
                        ulasan untuk event ini.
                    </p>

                </div>

            @endif

        </section>

    </div>

</div>


{{-- =========================================================
     STYLE
========================================================= --}}

@push('styles')

<style>

.review-page {
    min-height: 100vh;
    padding: 45px 20px 70px;
    background: #f6f7fa;
}

.review-container {
    max-width: 1200px;
    margin: 0 auto;
}

.back-link {
    display: inline-flex;
    margin-bottom: 25px;
    color: #182657;
    text-decoration: none;
    font-weight: 700;
}

.back-link:hover {
    text-decoration: underline;
}


/* HEADER */

.review-header {
    margin-bottom: 25px;
}

.eyebrow {
    margin-bottom: 9px;
    color: #bc8e32;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.8px;
}

.review-header h1 {
    margin: 0;
    color: #17345f;
    font-size: 40px;
}

.review-header > p {
    margin: 10px 0 0;
    color: #8490a2;
    font-size: 16px;
}


/* ALERT */

.alert {
    padding: 15px 18px;
    margin-bottom: 20px;
    border-radius: 13px;
}

.alert.success {
    background: #eef9f1;
    border: 1px solid #badfc2;
    color: #2d7140;
}

.alert.error {
    background: #fff1f1;
    border: 1px solid #edb9b9;
    color: #a13939;
}


/* EVENT */

.event-card {
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid #e1e5eb;
    border-radius: 22px;
    background: white;
}

.event-label {
    color: #969fad;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.4px;
}

.event-card h2 {
    margin: 7px 0 13px;
    color: #17345f;
    font-size: 24px;
}

.event-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.event-meta span {
    padding: 8px 11px;
    border-radius: 10px;
    background: #f2f4f7;
    color: #738095;
    font-size: 13px;
}


/* GRID */

.review-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}


/* RATING */

.rating-card {
    padding: 30px;
    border-radius: 24px;
    background: #193956;
    color: white;
}

.rating-title {
    color: #d6dce5;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 1.5px;
}

.rating-top {
    display: flex;
    align-items: center;
    gap: 22px;
    margin: 16px 0 25px;
}

.rating-number {
    font-size: 62px;
    font-weight: 800;
    line-height: 1;
}

.big-stars {
    color: #efbb3e;
    font-size: 24px;
    letter-spacing: 1px;
}

.rating-count {
    margin-top: 6px;
    color: #d3dbe5;
    font-size: 14px;
}

.rating-row {
    display: grid;
    grid-template-columns: 45px 1fr 45px;
    align-items: center;
    gap: 10px;
    margin: 15px 0;
}

.rating-row > span {
    color: #dde4eb;
    font-size: 13px;
}

.rating-percent {
    text-align: right;
}

.rating-bar {
    height: 9px;
    overflow: hidden;
    border-radius: 30px;
    background: rgba(255,255,255,.13);
}

.rating-fill {
    height: 100%;
    border-radius: 30px;
    background: #e5b53e;
}

.rating-note {
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,.15);
    color: #d5dde6;
    line-height: 1.7;
}


/* FORM */

.review-form-card {
    overflow: hidden;
    border: 1px solid #e5dfd3;
    border-radius: 24px;
    background: white;
}

.form-header {
    padding: 28px 30px;
    border-bottom: 1px solid #eee7da;
    background: #fffcf7;
}

.form-header h2 {
    margin: 0 0 8px;
    color: #17345f;
    font-size: 28px;
}

.form-header p {
    margin: 0;
    color: #8b95a5;
    line-height: 1.6;
}

.review-form-card form {
    padding: 28px 30px;
}

.form-group {
    margin-bottom: 22px;
}

.form-group > label {
    display: block;
    margin-bottom: 8px;
    color: #17345f;
    font-size: 14px;
    font-weight: 800;
}

.form-group > label span {
    color: #d33;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 14px 15px;
    border: 1px solid #dce0e6;
    border-radius: 13px;
    outline: none;
    background: white;
    color: #17345f;
    font-size: 14px;
}

.form-group input[type="text"]:focus,
.form-group input[type="email"]:focus,
.form-group textarea:focus {
    border-color: #182657;
}

.form-group textarea {
    resize: vertical;
}

.form-group small {
    display: block;
    margin-top: 7px;
    color: #939dab;
    font-size: 12px;
    line-height: 1.5;
}


/* STAR */

.star-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 3px;
}

.star-input input {
    display: none;
}

.star-input label {
    color: #d8dce2;
    font-size: 37px;
    line-height: 1;
    cursor: pointer;
    transition: .15s ease;
}

.star-input label:hover,
.star-input label:hover ~ label,
.star-input input:checked ~ label {
    color: #efb83f;
}


/* BUTTON */

.btn-submit {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
    padding: 17px;
    border: 0;
    border-radius: 15px;
    background: #182657;
    color: white;
    font-size: 16px;
    font-weight: 800;
    cursor: pointer;
}

.btn-submit:hover {
    background: #122047;
}


/* LATEST */

.latest-reviews {
    margin-top: 30px;
    padding: 30px;
    border: 1px solid #e2e6ec;
    border-radius: 24px;
    background: white;
}

.latest-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 20px;
}

.latest-header h2 {
    margin: 0;
    color: #17345f;
    font-size: 27px;
}

.latest-header > span {
    color: #8c96a5;
    font-size: 14px;
}

.review-item {
    display: flex;
    gap: 15px;
    padding: 20px 0;
    border-top: 1px solid #edf0f4;
}

.avatar {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border-radius: 50%;
    background: #182657;
    color: white;
    font-weight: 800;
}

.review-content {
    flex: 1;
}

.review-top {
    display: flex;
    justify-content: space-between;
    gap: 15px;
}

.review-top strong {
    color: #17345f;
}

.review-top span {
    color: #9aa3af;
    font-size: 12px;
}

.review-stars {
    margin-top: 5px;
    color: #efb83f;
    letter-spacing: 2px;
}

.empty-star {
    color: #dfe2e7;
}

.review-content p {
    margin: 8px 0 0;
    color: #738094;
    line-height: 1.7;
}


/* EMPTY */

.empty-review {
    padding: 50px 20px;
    text-align: center;
}

.empty-icon {
    font-size: 45px;
}

.empty-review h3 {
    margin: 10px 0 5px;
    color: #17345f;
}

.empty-review p {
    margin: 0;
    color: #8c97a6;
}


/* RESPONSIVE */

@media (max-width: 850px) {

    .review-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .review-page {
        padding: 30px 12px 50px;
    }

    .review-header h1 {
        font-size: 31px;
    }

    .rating-card,
    .form-header,
    .review-form-card form,
    .latest-reviews {
        padding: 22px;
    }

    .latest-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .review-top {
        flex-direction: column;
        gap: 4px;
    }

}

</style>

@endpush

@endsection
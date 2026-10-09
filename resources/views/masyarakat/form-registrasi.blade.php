@extends('masyarakat.layout')

@section('title', 'Form Pendaftaran')

@section('content')

@php
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
       HALAMAN FORM PENDAFTARAN
    ========================================================= */

    .registration-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 10px 0 55px;
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .registration-header {
        margin-bottom: 25px;
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

    .registration-title {
        margin: 0 0 8px;
        color: #17324d;
        font-size: 30px;
        line-height: 1.2;
        font-weight: 850;
    }

    .registration-subtitle {
        margin: 0;
        color: #75808d;
        font-size: 14px;
        line-height: 1.7;
    }

    /* =========================================================
       PROGRESS
    ========================================================= */

    .progress-card {
        background: #ffffff;
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

    .progress-item.active:not(:last-child)::after {
        background: #d7a941;
    }

    .progress-number {
        position: relative;
        z-index: 2;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 2px solid #17324d;
        background: #17324d;
        color: #ffffff;
        font-size: 14px;
        font-weight: 800;
        box-shadow: 0 0 0 5px rgba(215, 169, 65, .12);
    }

    .progress-item:not(.active) .progress-number {
        background: #ffffff;
        color: #9ca4af;
        border-color: #d7d1c4;
        box-shadow: none;
    }

    .progress-label {
        display: block;
        margin-top: 9px;
        color: #17324d;
        font-size: 13px;
        font-weight: 750;
    }

    .progress-item:not(.active) .progress-label {
        color: #9ca4af;
    }

    /* =========================================================
       GRID
    ========================================================= */

    .registration-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(320px, .8fr);
        gap: 24px;
        align-items: start;
    }

    /* =========================================================
       CARD
    ========================================================= */

    .registration-card {
        background: #ffffff;
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
       ALERT
    ========================================================= */

    .alert-error {
        margin-bottom: 22px;
        padding: 15px 17px;
        border-radius: 13px;
        background: #fff4f4;
        border: 1px solid #e7bcbc;
        color: #9a3e3e;
        font-size: 13px;
        line-height: 1.6;
    }

    .alert-error ul {
        margin: 7px 0 0 18px;
        padding: 0;
    }

    .alert-success {
        margin-bottom: 22px;
        padding: 15px 17px;
        border-radius: 13px;
        background: #f1f8f2;
        border: 1px solid #b9d8bd;
        color: #3e7446;
        font-size: 13px;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        margin-bottom: 8px;
        color: #29384a;
        font-size: 13px;
        font-weight: 800;
    }

    .required {
        color: #b23c3c;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        border: 1px solid #dcd6ca;
        border-radius: 12px;
        background: #ffffff;
        color: #29384a;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: .2s ease;
        box-sizing: border-box;
    }

    .form-input,
    .form-select {
        height: 48px;
        padding: 0 14px;
    }

    .form-textarea {
        min-height: 115px;
        padding: 13px 14px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #17324d;
        box-shadow: 0 0 0 3px rgba(23, 50, 77, .08);
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #a0a7b0;
    }

    .field-error {
        margin-top: 6px;
        color: #b13d3d;
        font-size: 12px;
    }

    .field-help {
        margin-top: 6px;
        color: #89929d;
        font-size: 11px;
        line-height: 1.5;
    }

    /* =========================================================
       CHECKBOX
    ========================================================= */

    .agreement-box {
        margin-top: 22px;
        padding: 16px;
        border-radius: 14px;
        background: #fbf8f0;
        border: 1px solid #ece3d2;
    }

    .agreement-label {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        cursor: pointer;
    }

    .agreement-checkbox {
        width: 18px;
        height: 18px;
        flex: 0 0 18px;
        margin-top: 2px;
        accent-color: #17324d;
        cursor: pointer;
    }

    .agreement-text {
        color: #596574;
        font-size: 12px;
        line-height: 1.65;
    }

    .agreement-text strong {
        color: #29384a;
    }

    /* =========================================================
       BUTTON AREA
    ========================================================= */

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
    }

    .btn {
        min-height: 49px;
        border-radius: 12px;
        padding: 0 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        border: 0;
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
        background: #e8e4dc;
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

    /* =========================================================
       EVENT SUMMARY
    ========================================================= */

    .summary-poster {
        height: 190px;
        background: linear-gradient(
            135deg,
            #17324d,
            #254d70
        );
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        overflow: hidden;
    }

    .summary-poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
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
        font-size: 29px;
    }

    .summary-body {
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
        letter-spacing: .4px;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .summary-title {
        margin: 0 0 18px;
        color: #17324d;
        font-size: 20px;
        line-height: 1.4;
        font-weight: 850;
    }

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

    .event-meta-icon {
        width: 30px;
        height: 30px;
        flex: 0 0 30px;
        border-radius: 9px;
        background: #f6f2e9;
        color: #9b741e;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
    }

    .price-box {
        margin-top: 20px;
        padding: 16px;
        border-radius: 14px;
        background: #f9f6ee;
        border: 1px solid #eee4d3;
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

    .payment-info {
        margin-top: 18px;
        padding: 15px;
        border-radius: 14px;
        background: #fff8e8;
        border: 1px solid #f1dfaa;
        color: #7e6526;
        font-size: 12px;
        line-height: 1.65;
    }

    .payment-info strong {
        color: #6d5416;
    }

    /* =========================================================
       MOBILE
    ========================================================= */

    @media (max-width: 900px) {

        .registration-grid {
            grid-template-columns: 1fr;
        }

        .event-summary {
            order: -1;
        }
    }

    @media (max-width: 640px) {

        .registration-page {
            padding-top: 0;
        }

        .registration-title {
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
        .summary-body {
            padding: 18px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-back,
        .btn-primary {
            width: 100%;
        }
    }
</style>


<div class="registration-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="registration-header">

        <a
            href="{{ route('masyarakat.detail', $event->id_event) }}"
            class="back-link"
        >
            ← Kembali ke Detail Event
        </a>

        <h1 class="registration-title">
            Form Pendaftaran
        </h1>

        <p class="registration-subtitle">
            Isi data diri Anda dengan benar untuk melakukan pendaftaran event.
        </p>

    </div>


    {{-- =====================================================
         PROGRESS
    ====================================================== --}}

    <div class="progress-card">

        <div class="progress">

            {{-- STEP 1 --}}
            <div class="progress-item active">

                <span class="progress-number">
                    1
                </span>

                <span class="progress-label">
                    Data Peserta
                </span>

            </div>


            {{-- STEP 2 --}}
            <div class="progress-item">

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
         PESAN ERROR VALIDASI
    ====================================================== --}}

    @if($errors->any())

        <div class="alert-error">

            <strong>
                Data belum dapat diproses.
            </strong>

            <ul>
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

    <div class="registration-grid">


        {{-- =================================================
             FORM DATA PESERTA
        ================================================== --}}

        <div class="registration-card">

            <div class="card-heading">

                <h2>
                    Data Peserta
                </h2>

                <p>
                    Masukkan informasi sesuai dengan data diri Anda.
                </p>

            </div>


            <div class="card-body">

                <form
                    action="{{ route('masyarakat.registrasi.simpanForm') }}"
                    method="POST"
                >

                    @csrf


                    {{-- ID EVENT --}}
                    <input
                        type="hidden"
                        name="id_event"
                        value="{{ $event->id_event }}"
                    >


                    <div class="form-grid">


                        {{-- =================================
                             NAMA
                        ================================== --}}

                        <div class="form-group">

                            <label
                                for="nama"
                                class="form-label"
                            >
                                Nama Lengkap
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama"
                                name="nama"
                                class="form-input"
                                value="{{ old('nama') }}"
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                required
                            >

                            @error('nama')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================
                             EMAIL
                        ================================== --}}

                        <div class="form-group">

                            <label
                                for="email"
                                class="form-label"
                            >
                                Email
                                <span class="required">*</span>
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-input"
                                value="{{ old('email') }}"
                                placeholder="contoh@email.com"
                                autocomplete="email"
                                required
                            >

                            <div class="field-help">
                                Email digunakan untuk kebutuhan informasi pendaftaran.
                            </div>

                            @error('email')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================
                             NO HP
                        ================================== --}}

                        <div class="form-group">

                            <label
                                for="no_hp"
                                class="form-label"
                            >
                                No. Telepon
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="no_hp"
                                name="no_hp"
                                class="form-input"
                                value="{{ old('no_hp') }}"
                                placeholder="081234567890"
                                autocomplete="tel"
                                required
                            >

                            @error('no_hp')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================
                             TANGGAL LAHIR
                        ================================== --}}

                        <div class="form-group">

                            <label
                                for="tanggal_lahir"
                                class="form-label"
                            >
                                Tanggal Lahir
                                <span class="required">*</span>
                            </label>

                            <input
                                type="date"
                                id="tanggal_lahir"
                                name="tanggal_lahir"
                                class="form-input"
                                value="{{ old('tanggal_lahir') }}"
                                required
                            >

                            @error('tanggal_lahir')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================
                             JENIS KELAMIN
                        ================================== --}}

                        <div class="form-group">

                            <label
                                for="jenis_kelamin"
                                class="form-label"
                            >
                                Jenis Kelamin
                                <span class="required">*</span>
                            </label>

                            <select
                                id="jenis_kelamin"
                                name="jenis_kelamin"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Pilih Jenis Kelamin
                                </option>

                                <option
                                    value="Laki-laki"
                                    {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}
                                >
                                    Laki-laki
                                </option>

                                <option
                                    value="Perempuan"
                                    {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}
                                >
                                    Perempuan
                                </option>

                            </select>

                            @error('jenis_kelamin')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- =================================
                             ALAMAT
                        ================================== --}}

                        <div class="form-group full">

                            <label
                                for="alamat"
                                class="form-label"
                            >
                                Alamat Lengkap
                                <span class="required">*</span>
                            </label>

                            <textarea
                                id="alamat"
                                name="alamat"
                                class="form-textarea"
                                placeholder="Masukkan alamat lengkap Anda"
                                required
                            >{{ old('alamat') }}</textarea>

                            @error('alamat')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>


                    {{-- =====================================
                         PERSETUJUAN
                    ====================================== --}}

                    <div class="agreement-box">

                        <label
                            for="setuju"
                            class="agreement-label"
                        >

                            <input
                                type="checkbox"
                                id="setuju"
                                name="setuju"
                                value="1"
                                class="agreement-checkbox"
                                {{ old('setuju') ? 'checked' : '' }}
                                required
                            >

                            <span class="agreement-text">

                                Saya menyatakan bahwa data yang diisi adalah benar
                                dan menyetujui seluruh syarat dan ketentuan
                                pendaftaran event yang berlaku.

                                <strong>*</strong>

                            </span>

                        </label>

                        @error('setuju')
                            <div class="field-error">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- =====================================
                         ACTION
                    ====================================== --}}

                    <div class="form-actions">

                        <a
                            href="{{ route('masyarakat.detail', $event->id_event) }}"
                            class="btn btn-back"
                        >
                            ← Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-primary"
                        >

                            Lanjutkan
                            →

                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =================================================
             RINGKASAN EVENT
        ================================================== --}}

        <div class="registration-card event-summary">


            {{-- POSTER --}}
            <div class="summary-poster">

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


            <div class="summary-body">


                {{-- KATEGORI --}}
                <span class="category-badge">

                    {{ $event->kategori->nama_kategori ?? 'Event' }}

                </span>


                {{-- NAMA EVENT --}}
                <h2 class="summary-title">

                    {{ $event->nama_event }}

                </h2>


                {{-- META EVENT --}}
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

                </div>


                {{-- =========================================
                     HARGA
                ========================================== --}}

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


                {{-- =========================================
                     INFO ALUR PEMBAYARAN
                ========================================== --}}

                @if($hargaTiket > 0)

                    <div class="payment-info">

                        <strong>
                            Event Berbayar
                        </strong>

                        <br>

                        Setelah mengisi form, Anda akan masuk ke
                        halaman <strong>Konfirmasi</strong>.
                        Setelah data dikonfirmasi, Anda akan diarahkan
                        ke halaman <strong>Pembayaran</strong>.

                    </div>

                @else

                    <div class="payment-info">

                        <strong>
                            Event Gratis
                        </strong>

                        <br>

                        Setelah form dikirim dan data berhasil diproses,
                        pendaftaran akan langsung dibuat tanpa pembayaran.

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection
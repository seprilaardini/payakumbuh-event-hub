@extends('masyarakat.layout')

@section('content')

<style>
    .registration-page {
        max-width: 1180px;
        margin: 0 auto;
        padding: 35px 20px 70px;
    }

    /* ==============================
       HEADER
    ============================== */
    .page-header {
        margin-bottom: 25px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .back-link:hover {
        color: #0f172a;
    }

    .page-title {
        margin: 0;
        color: #0f172a;
        font-size: 30px;
        font-weight: 800;
    }

    .page-subtitle {
        margin-top: 8px;
        margin-bottom: 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    /* ==============================
       STEP
    ============================== */
    .steps {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 25px;
    }

    .step {
        background: #f1f5f9;
        color: #94a3b8;
        border-radius: 12px;
        padding: 14px 12px;
        text-align: center;
        font-size: 13px;
        font-weight: 800;
    }

    .step.active {
        background: #0f172a;
        color: #ffffff;
    }

    /* ==============================
       MAIN GRID
    ============================== */
    .registration-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 350px;
        gap: 24px;
        align-items: start;
    }

    /* ==============================
       CARD
    ============================== */
    .card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, 0.04);
    }

    .card-title {
        margin: 0;
        color: #0f172a;
        font-size: 22px;
        font-weight: 800;
    }

    .card-description {
        margin: 8px 0 25px;
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
    }

    /* ==============================
       ALERT
    ============================== */
    .alert-error {
        margin-bottom: 22px;
        padding: 15px 17px;
        border-radius: 12px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        font-size: 13px;
        line-height: 1.6;
    }

    .alert-error strong {
        display: block;
        margin-bottom: 6px;
    }

    .alert-error ul {
        margin: 6px 0 0 20px;
        padding: 0;
    }

    .alert-session {
        margin-bottom: 22px;
        padding: 15px 17px;
        border-radius: 12px;
        background: #fff7ed;
        border: 1px solid #fed7aa;
        color: #9a3412;
        font-size: 13px;
        line-height: 1.6;
    }

    /* ==============================
       FORM
    ============================== */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 800;
    }

    .required {
        color: #dc2626;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #cbd5e1;
        border-radius: 11px;
        padding: 13px 14px;
        background: #ffffff;
        color: #0f172a;
        font-family: inherit;
        font-size: 14px;
        outline: none;
        transition: 0.2s ease;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #94a3b8;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: #64748b;
        box-shadow: 0 0 0 3px rgba(100, 116, 139, 0.10);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .input-error {
        margin-top: 7px;
        color: #dc2626;
        font-size: 12px;
    }

    /* ==============================
       GENDER
    ============================== */
    .gender-list {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .gender-option {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #475569;
        font-size: 14px;
        cursor: pointer;
    }

    .gender-option input {
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    /* ==============================
       AGREEMENT
    ============================== */
    .agreement-box {
        display: flex;
        gap: 10px;
        align-items: flex-start;
        padding: 15px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        margin-top: 5px;
    }

    .agreement-box input {
        width: 17px;
        height: 17px;
        margin-top: 2px;
        flex-shrink: 0;
        cursor: pointer;
    }

    .agreement-box label {
        color: #475569;
        font-size: 13px;
        line-height: 1.6;
        cursor: pointer;
    }

    /* ==============================
       BUTTON
    ============================== */
    .button-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 130px;
        padding: 13px 18px;
        border-radius: 11px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #334155;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }

    .btn-back:hover {
        background: #f8fafc;
    }

    .btn-submit {
        min-width: 170px;
        border: none;
        border-radius: 11px;
        padding: 13px 20px;
        background: #0f172a;
        color: #ffffff;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .btn-submit:hover {
        background: #1e293b;
        transform: translateY(-1px);
    }

    /* ==============================
       EVENT SUMMARY
    ============================== */
    .event-summary {
        position: sticky;
        top: 95px;
    }

    .poster {
        width: 100%;
        height: 205px;
        border-radius: 15px;
        overflow: hidden;
        background: #f1f5f9;
        margin-bottom: 18px;
    }

    .poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .poster-empty {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        color: #94a3b8;
        font-size: 13px;
        text-align: center;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 11px;
        border-radius: 999px;
        background: #fff7ed;
        color: #c2410c;
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .event-name {
        margin: 12px 0 18px;
        color: #0f172a;
        font-size: 21px;
        line-height: 1.4;
        font-weight: 800;
    }

    .summary-item {
        padding: 13px 0;
        border-bottom: 1px solid #eef2f7;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-label {
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .summary-value {
        color: #334155;
        font-size: 13px;
        font-weight: 700;
        line-height: 1.6;
    }

    .price-box {
        margin-top: 18px;
        padding: 17px;
        border-radius: 14px;
        background: #f8fafc;
    }

    .price-label {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .price-value {
        margin-top: 4px;
        color: #0f172a;
        font-size: 24px;
        font-weight: 900;
    }

    .price-free {
        color: #059669;
    }

    /* ==============================
       RESPONSIVE
    ============================== */
    @media (max-width: 900px) {
        .registration-grid {
            grid-template-columns: 1fr;
        }

        .event-summary {
            position: static;
        }
    }

    @media (max-width: 650px) {
        .registration-page {
            padding: 25px 14px 50px;
        }

        .card {
            padding: 21px;
        }

        .page-title {
            font-size: 25px;
        }

        .steps {
            grid-template-columns: 1fr;
        }

        .button-row {
            flex-direction: column-reverse;
        }

        .btn-back,
        .btn-submit {
            width: 100%;
        }
    }
</style>


<div class="registration-page">

    {{-- ==========================================
         HEADER
    =========================================== --}}

    <div class="page-header">

        <a
            href="{{ route('masyarakat.detail', $event->id_event) }}"
            class="back-link"
        >
            ← Kembali ke Detail Event
        </a>

        <h1 class="page-title">
            Form Registrasi
        </h1>

        <p class="page-subtitle">
            Isi data diri Anda dengan lengkap dan benar untuk mengikuti event ini.
        </p>

    </div>


    {{-- ==========================================
         STEP
    =========================================== --}}

    <div class="steps">

        <div class="step active">
            1. Data Peserta
        </div>

        <div class="step">
            2. Konfirmasi
        </div>

        <div class="step">
            @if((float) $event->biaya_pendaftaran > 0)
                3. Pembayaran
            @else
                3. Selesai
            @endif
        </div>

    </div>


    {{-- ==========================================
         GRID
    =========================================== --}}

    <div class="registration-grid">


        {{-- =========================================
             FORM DATA MASYARAKAT
        ========================================== --}}

        <div class="card">

            <h2 class="card-title">
                Data Diri
            </h2>

            <p class="card-description">
                Data berikut digunakan untuk kebutuhan registrasi peserta event.
            </p>


            {{-- ERROR VALIDASI --}}

            @if($errors->any())

                <div class="alert-error">

                    <strong>
                        Terdapat kesalahan pada data yang Anda masukkan.
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


            {{-- ERROR SESSION --}}

            @if(session('error'))

                <div class="alert-session">

                    {{ session('error') }}

                </div>

            @endif


            {{-- SUCCESS SESSION --}}

            @if(session('success'))

                <div class="alert-session">

                    {{ session('success') }}

                </div>

            @endif


            {{-- ======================================
                 FORM
            ======================================= --}}

            <form
                method="POST"
                action="{{ route(
                    'masyarakat.registrasi.simpan',
                    $event->id_event
                ) }}"
            >

                @csrf


                {{-- ================================
                     NAMA
                ================================= --}}

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
                        maxlength="100"
                        autocomplete="name"
                        required
                    >

                    @error('nama')

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     EMAIL
                ================================= --}}

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
                        maxlength="100"
                        autocomplete="email"
                        required
                    >

                    @error('email')

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     NO HP
                ================================= --}}

                <div class="form-group">

                    <label
                        for="no_hp"
                        class="form-label"
                    >
                        Nomor HP
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        class="form-input"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        maxlength="20"
                        autocomplete="tel"
                        required
                    >

                    @error('no_hp')

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     JENIS KELAMIN
                ================================= --}}

                <div class="form-group">

                    <label class="form-label">

                        Jenis Kelamin
                        <span class="required">*</span>

                    </label>


                    <div class="gender-list">

                        <label class="gender-option">

                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Laki-laki"
                                @checked(
                                    old('jenis_kelamin') === 'Laki-laki'
                                )
                                required
                            >

                            <span>
                                Laki-laki
                            </span>

                        </label>


                        <label class="gender-option">

                            <input
                                type="radio"
                                name="jenis_kelamin"
                                value="Perempuan"
                                @checked(
                                    old('jenis_kelamin') === 'Perempuan'
                                )
                            >

                            <span>
                                Perempuan
                            </span>

                        </label>

                    </div>


                    @error('jenis_kelamin')

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     TANGGAL LAHIR
                ================================= --}}

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

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     ALAMAT
                ================================= --}}

                <div class="form-group">

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
                        placeholder="Masukkan alamat lengkap"
                        required
                    >{{ old('alamat') }}</textarea>


                    @error('alamat')

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     PERSETUJUAN
                ================================= --}}

                <div class="form-group">

                    <div class="agreement-box">

                        <input
                            type="checkbox"
                            id="persetujuan"
                            name="persetujuan"
                            value="1"
                            required
                        >

                        <label for="persetujuan">

                            Saya menyatakan bahwa seluruh data yang saya
                            masukkan adalah benar dan dapat dipertanggungjawabkan.

                        </label>

                    </div>

                    @error('persetujuan')

                        <div class="input-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================
                     BUTTON
                ================================= --}}

                <div class="button-row">

                    <a
                        href="{{ route(
                            'masyarakat.detail',
                            $event->id_event
                        ) }}"
                        class="btn-back"
                    >
                        Batal
                    </a>


                    <button
                        type="submit"
                        class="btn-submit"
                    >

                        @if((float) $event->biaya_pendaftaran > 0)

                            Lanjutkan

                        @else

                            Daftar Sekarang

                        @endif

                    </button>

                </div>

            </form>

        </div>


        {{-- =========================================
             RINGKASAN EVENT
        ========================================== --}}

        <div class="card event-summary">

            {{-- POSTER --}}

            <div class="poster">

                @if($event->poster)

                    @if(
                        \Illuminate\Support\Str::startsWith(
                            $event->poster,
                            [
                                'http://',
                                'https://'
                            ]
                        )
                    )

                        <img
                            src="{{ $event->poster }}"
                            alt="{{ $event->nama_event }}"
                        >

                    @else

                        <img
                            src="{{ asset(
                                'storage/' .
                                ltrim(
                                    $event->poster,
                                    '/'
                                )
                            ) }}"
                            alt="{{ $event->nama_event }}"
                        >

                    @endif

                @else

                    <div class="poster-empty">

                        Poster event belum tersedia

                    </div>

                @endif

            </div>


            {{-- KATEGORI --}}

            @if($event->kategori)

                <span class="category-badge">

                    {{ $event->kategori->nama_kategori }}

                </span>

            @endif


            {{-- NAMA EVENT --}}

            <h2 class="event-name">

                {{ $event->nama_event }}

            </h2>


            {{-- TANGGAL --}}

            @if($event->tanggal_mulai)

                <div class="summary-item">

                    <div class="summary-label">
                        Tanggal
                    </div>

                    <div class="summary-value">

                        {{ $event->tanggal_mulai
                            ->locale('id')
                            ->translatedFormat('l, d F Y')
                        }}

                    </div>

                </div>

            @endif


            {{-- WAKTU --}}

            @if($event->tanggal_mulai)

                <div class="summary-item">

                    <div class="summary-label">
                        Waktu
                    </div>

                    <div class="summary-value">

                        {{ $event->tanggal_mulai->format('H:i') }}
                        WIB

                        @if($event->tanggal_selesai)

                            -
                            {{ $event->tanggal_selesai->format('H:i') }}
                            WIB

                        @endif

                    </div>

                </div>

            @endif


            {{-- LOKASI --}}

            @if($event->lokasi)

                <div class="summary-item">

                    <div class="summary-label">
                        Lokasi
                    </div>

                    <div class="summary-value">

                        {{ $event->lokasi->nama_lokasi }}

                        @if($event->lokasi->alamat_lokasi)

                            <br>

                            {{ $event->lokasi->alamat_lokasi }}

                        @endif

                    </div>

                </div>

            @endif


            {{-- DESKRIPSI --}}

            @if($event->deskripsi_verifkasi)

                <div class="summary-item">

                    <div class="summary-label">
                        Tentang Event
                    </div>

                    <div class="summary-value">

                        {{ $event->deskripsi_verifkasi }}

                    </div>

                </div>

            @endif


            {{-- HARGA --}}

            <div class="price-box">

                <div class="price-label">

                    Biaya Pendaftaran

                </div>


                @if(
                    (float) $event->biaya_pendaftaran > 0
                )

                    <div class="price-value">

                        Rp
                        {{
                            number_format(
                                (float) $event->biaya_pendaftaran,
                                0,
                                ',',
                                '.'
                            )
                        }}

                    </div>

                @else

                    <div class="price-value price-free">

                        GRATIS

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection
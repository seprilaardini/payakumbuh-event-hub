@extends('masyarakat.layout')

@section('title', 'Pembayaran - Payakumbuh Event Hub')

@section('content')

{{-- =========================================================
    HEADER
========================================================= --}}
<section class="payment-page">

    <div class="payment-container">

        {{-- BACK --}}
        <a
            href="{{ route('masyarakat.detail', $event->id_event) }}"
            class="back-link"
        >
            ← Kembali ke Detail Event
        </a>

        {{-- HEADER --}}
        <div class="payment-header">

            <div class="brand-small">
                PAYAKUMBUH EVENT HUB
            </div>

            <h1>Pembayaran Pendaftaran</h1>

            <p>
                Pilih metode pembayaran yang kamu inginkan
                untuk menyelesaikan pendaftaran.
            </p>

        </div>


        {{-- =====================================================
            ALERT
        ====================================================== --}}
        @if(session('error'))

            <div class="alert alert-error">
                {{ session('error') }}
            </div>

        @endif


        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        {{-- VALIDATION ERROR --}}
        @if($errors->any())

            <div class="alert alert-error">

                <strong>Terjadi kesalahan:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        {{-- =====================================================
            PROGRESS
        ====================================================== --}}
        <div class="progress-wrapper">

            <div class="progress-item completed">

                <div class="progress-circle">
                    ✓
                </div>

                <div class="progress-text">
                    <strong>Data Peserta</strong>
                    <span>Selesai</span>
                </div>

            </div>


            <div class="progress-line completed"></div>


            <div class="progress-item completed">

                <div class="progress-circle">
                    ✓
                </div>

                <div class="progress-text">
                    <strong>Konfirmasi</strong>
                    <span>Selesai</span>
                </div>

            </div>


            <div class="progress-line active"></div>


            <div class="progress-item active">

                <div class="progress-circle">
                    3
                </div>

                <div class="progress-text">
                    <strong>Pembayaran</strong>
                    <span>Sekarang</span>
                </div>

            </div>

        </div>


        {{-- =====================================================
            MAIN GRID
        ====================================================== --}}
        <div class="payment-grid">


            {{-- =================================================
                KOLOM KIRI
            ================================================== --}}
            <div class="payment-main">

                <div class="section-title">

                    <span>PILIH METODE PEMBAYARAN</span>

                    <h2>
                        Bayar dengan metode pilihanmu
                    </h2>

                    <p>
                        Pilih salah satu metode pembayaran di bawah ini.
                    </p>

                </div>


                {{-- =================================================
                    FORM PEMBAYARAN
                ================================================== --}}
                <form
                    id="formPembayaran"
                    action="{{ route('masyarakat.pembayaran.proses', $pendaftaran->id_pendaftaran) }}"
                    method="POST"
                >

                    @csrf


                    {{-- =================================================
                        TRANSFER BANK
                    ================================================== --}}
                    <label
                        for="metode_transfer"
                        class="payment-card"
                        id="card-transfer"
                    >

                        <div class="payment-icon">
                            🏦
                        </div>

                        <div class="payment-info">

                            <h3>
                                Transfer Bank
                            </h3>

                            <p>
                                Transfer melalui rekening bank.
                            </p>

                        </div>

                        <input
                            type="radio"
                            name="metode_pembayaran"
                            id="metode_transfer"
                            value="transfer"
                            required
                        >

                    </label>


                    {{-- =================================================
                        DETAIL TRANSFER BANK
                    ================================================== --}}
                    <div
                        class="method-detail"
                        id="detail-transfer"
                    >

                        <h4>
                            Pilih Bank
                        </h4>

                        <p class="detail-description">
                            Pilih rekening bank yang akan kamu gunakan.
                        </p>


                        <div class="sub-options">

                            <label class="sub-option">

                                <input
                                    type="radio"
                                    name="bank"
                                    value="BCA"
                                >

                                <div>
                                    <strong>
                                        Bank Central Asia (BCA)
                                    </strong>

                                    <span>
                                        Transfer melalui ATM / Mobile Banking
                                    </span>
                                </div>

                            </label>


                            <label class="sub-option">

                                <input
                                    type="radio"
                                    name="bank"
                                    value="Mandiri"
                                >

                                <div>
                                    <strong>
                                        Bank Mandiri
                                    </strong>

                                    <span>
                                        Transfer melalui ATM / Livin' by Mandiri
                                    </span>
                                </div>

                            </label>


                            <label class="sub-option">

                                <input
                                    type="radio"
                                    name="bank"
                                    value="BRI"
                                >

                                <div>
                                    <strong>
                                        Bank Rakyat Indonesia (BRI)
                                    </strong>

                                    <span>
                                        Transfer melalui ATM / BRImo
                                    </span>
                                </div>

                            </label>


                            <label class="sub-option">

                                <input
                                    type="radio"
                                    name="bank"
                                    value="BNI"
                                >

                                <div>
                                    <strong>
                                        Bank Negara Indonesia (BNI)
                                    </strong>

                                    <span>
                                        Transfer melalui ATM / wondr by BNI
                                    </span>
                                </div>

                            </label>

                        </div>


                        {{-- REKENING --}}
                        <div class="rekening-box">

                            <div class="rekening-label">
                                Nomor Rekening
                            </div>

                            <div class="rekening-number">
                                1234567890
                            </div>

                            <div class="rekening-name">
                                a.n. Payakumbuh Event Hub
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        QRIS
                    ================================================== --}}
                    <label
                        for="metode_qris"
                        class="payment-card"
                        id="card-qris"
                    >

                        <div class="payment-icon">
                            ▣
                        </div>

                        <div class="payment-info">

                            <h3>
                                QRIS
                            </h3>

                            <p>
                                Scan QR menggunakan aplikasi pembayaran.
                            </p>

                        </div>

                        <input
                            type="radio"
                            name="metode_pembayaran"
                            id="metode_qris"
                            value="qris"
                        >

                    </label>


                    {{-- =================================================
                        DETAIL QRIS
                    ================================================== --}}
                    <div
                        class="method-detail"
                        id="detail-qris"
                    >

                        <h4>
                            Scan QRIS
                        </h4>

                        <p class="detail-description">
                            Gunakan aplikasi pembayaran yang mendukung QRIS.
                        </p>


                        <div class="qris-wrapper">

                            <div class="qris-card">

                                <img
                                    src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data={{ urlencode('PAYAKUMBUH EVENT HUB | KODE: '.$pendaftaran->kode_pendaftaran.' | TOTAL: Rp '.number_format($event->biaya_pendaftaran, 0, ',', '.')) }}"
                                    alt="QRIS Payakumbuh Event Hub"
                                    class="qris-image"
                                >

                            </div>

                        </div>


                        <div class="qris-information">

                            <div>
                                <span>Total Pembayaran</span>

                                <strong>
                                    Rp {{ number_format($event->biaya_pendaftaran, 0, ',', '.') }}
                                </strong>
                            </div>

                            <div>
                                <span>Kode Pendaftaran</span>

                                <strong>
                                    {{ $pendaftaran->kode_pendaftaran }}
                                </strong>
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        E-WALLET
                    ================================================== --}}
                    <label
                        for="metode_ewallet"
                        class="payment-card"
                        id="card-ewallet"
                    >

                        <div class="payment-icon">
                            📱
                        </div>

                        <div class="payment-info">

                            <h3>
                                E-Wallet
                            </h3>

                            <p>
                                Bayar menggunakan dompet digital.
                            </p>

                        </div>

                        <input
                            type="radio"
                            name="metode_pembayaran"
                            id="metode_ewallet"
                            value="e-wallet"
                        >

                    </label>


                    {{-- =================================================
                        DETAIL E-WALLET
                    ================================================== --}}
                    <div
                        class="method-detail"
                        id="detail-ewallet"
                    >

                        <h4>
                            Pilih E-Wallet
                        </h4>

                        <p class="detail-description">
                            Pilih dompet digital yang akan digunakan.
                        </p>


                        <div class="sub-options">

                            <label class="wallet-option">

                                <input
                                    type="radio"
                                    name="e_wallet"
                                    value="GoPay"
                                >

                                <div class="wallet-logo gopay-logo">
                                    GoPay
                                </div>

                                <div class="wallet-info">
                                    <strong>
                                        GoPay
                                    </strong>

                                    <span>
                                        Pembayaran melalui GoPay
                                    </span>
                                </div>

                            </label>


                            <label class="wallet-option">

                                <input
                                    type="radio"
                                    name="e_wallet"
                                    value="OVO"
                                >

                                <div class="wallet-logo ovo-logo">
                                    OVO
                                </div>

                                <div class="wallet-info">
                                    <strong>
                                        OVO
                                    </strong>

                                    <span>
                                        Pembayaran melalui OVO
                                    </span>
                                </div>

                            </label>


                            <label class="wallet-option">

                                <input
                                    type="radio"
                                    name="e_wallet"
                                    value="DANA"
                                >

                                <div class="wallet-logo dana-logo">
                                    DANA
                                </div>

                                <div class="wallet-info">
                                    <strong>
                                        DANA
                                    </strong>

                                    <span>
                                        Pembayaran melalui DANA
                                    </span>
                                </div>

                            </label>

                        </div>


                        {{-- NOMOR --}}
                        <div class="rekening-box">

                            <div class="rekening-label">
                                Nomor Pembayaran
                            </div>

                            <div class="rekening-number">
                                0812 3456 7890
                            </div>

                            <div class="rekening-name">
                                Payakumbuh Event Hub
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        TOTAL
                    ================================================== --}}
                    <div class="payment-total">

                        <div class="total-text">

                            <h3>
                                Total yang harus dibayar
                            </h3>

                            <p>
                                Sesuai biaya pendaftaran event
                            </p>

                        </div>

                        <div class="total-price">

                            Rp
                            {{ number_format($event->biaya_pendaftaran, 0, ',', '.') }}

                        </div>

                    </div>


                    {{-- =================================================
                        BUTTON
                    ================================================== --}}
                    <button
                        type="submit"
                        class="btn-payment"
                        id="btnBayar"
                    >

                        <span>
                            Bayar Sekarang
                        </span>

                        <span class="btn-arrow">
                            →
                        </span>

                    </button>


                    {{-- SECURITY --}}
                    <div class="payment-security">

                        🔒

                        <span>
                            Pembayaran aman dan data pendaftaran dilindungi
                            oleh Payakumbuh Event Hub.
                        </span>

                    </div>

                </form>

            </div>


            {{-- =================================================
                KOLOM KANAN
            ================================================== --}}
            <aside class="payment-sidebar">


                {{-- =================================================
                    RINGKASAN EVENT
                ================================================== --}}
                <div class="sidebar-card">

                    <div class="sidebar-title">
                        RINGKASAN EVENT
                    </div>

                    <h3 class="event-name">
                        {{ $event->nama_event }}
                    </h3>


                    <div class="summary-row">

                        <span>
                            Kategori
                        </span>

                        <strong>
                            {{ $event->kategori->nama_kategori ?? '-' }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Tanggal
                        </span>

                        <strong>

                            @if($event->tanggal_mulai)

                                {{ $event->tanggal_mulai->translatedFormat('d F Y') }}

                            @else

                                -

                            @endif

                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Lokasi
                        </span>

                        <strong>
                            {{ $event->lokasi->nama_lokasi ?? '-' }}
                        </strong>

                    </div>

                </div>


                {{-- =================================================
                    DATA PENDAFTAR
                ================================================== --}}
                <div class="sidebar-card">

                    <div class="sidebar-title">
                        DATA PENDAFTAR
                    </div>


                    <div class="summary-row">

                        <span>
                            Nama
                        </span>

                        <strong>
                            {{ $pendaftaran->masyarakat->nama ?? '-' }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            Email
                        </span>

                        <strong>
                            {{ $pendaftaran->masyarakat->email ?? '-' }}
                        </strong>

                    </div>


                    <div class="summary-row">

                        <span>
                            No. HP
                        </span>

                        <strong>
                            {{ $pendaftaran->masyarakat->no_hp ?? '-' }}
                        </strong>

                    </div>

                </div>


                {{-- =================================================
                    KODE PENDAFTARAN
                ================================================== --}}
                <div class="sidebar-card code-card">

                    <div class="sidebar-title">
                        Kode Pendaftaran
                    </div>

                    <div class="registration-code">

                        {{ $pendaftaran->kode_pendaftaran }}

                    </div>

                    <p>
                        Simpan kode ini untuk mengecek
                        status pendaftaran.
                    </p>

                </div>


                {{-- =================================================
                    TOTAL SIDEBAR
                ================================================== --}}
                <div class="sidebar-card sidebar-total">

                    <div class="sidebar-title">
                        TOTAL PEMBAYARAN
                    </div>

                    <div class="sidebar-price">

                        Rp
                        {{ number_format($event->biaya_pendaftaran, 0, ',', '.') }}

                    </div>

                </div>

            </aside>

        </div>

    </div>

</section>


{{-- =========================================================
    STYLE
========================================================= --}}
@push('styles')

<style>

.payment-page {
    min-height: 100vh;
    background: #f5f7fa;
    padding: 40px 20px 70px;
}

.payment-container {
    max-width: 1280px;
    margin: 0 auto;
}

.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #17345f;
    text-decoration: none;
    font-weight: 700;
    margin-bottom: 28px;
}

.back-link:hover {
    text-decoration: underline;
}


/* =========================================================
   HEADER
========================================================= */

.payment-header {
    margin-bottom: 32px;
}

.brand-small {
    color: #c69a3b;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 2px;
    margin-bottom: 10px;
}

.payment-header h1 {
    margin: 0;
    color: #17345f;
    font-size: 38px;
    line-height: 1.2;
}

.payment-header p {
    margin: 12px 0 0;
    color: #8490a3;
    font-size: 16px;
}


/* =========================================================
   ALERT
========================================================= */

.alert {
    border-radius: 15px;
    padding: 15px 18px;
    margin-bottom: 25px;
    font-size: 15px;
}

.alert-error {
    background: #fff1f1;
    border: 1px solid #efb4b4;
    color: #a33a3a;
}

.alert-success {
    background: #effaf2;
    border: 1px solid #b8dfbf;
    color: #27713a;
}

.alert ul {
    margin: 8px 0 0 20px;
}


/* =========================================================
   PROGRESS
========================================================= */

.progress-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 35px;
    padding: 20px 24px;
    background: white;
    border-radius: 22px;
    border: 1px solid #e7eaf0;
}

.progress-item {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 180px;
}

.progress-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-weight: 800;
}

.progress-item.completed .progress-circle {
    background: #e9f4ec;
    color: #317442;
}

.progress-item.active .progress-circle {
    background: #182657;
    color: white;
}

.progress-text {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.progress-text strong {
    color: #17345f;
    font-size: 14px;
}

.progress-text span {
    color: #929dad;
    font-size: 12px;
}

.progress-line {
    height: 2px;
    flex: 1;
    margin: 0 12px;
    background: #dfe4eb;
}

.progress-line.completed,
.progress-line.active {
    background: #182657;
}


/* =========================================================
   MAIN GRID
========================================================= */

.payment-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.8fr) minmax(320px, 0.9fr);
    gap: 28px;
    align-items: start;
}

.payment-main {
    background: white;
    border: 1px solid #e4e8ef;
    border-radius: 28px;
    padding: 34px;
}

.payment-sidebar {
    display: flex;
    flex-direction: column;
    gap: 22px;
}


/* =========================================================
   SECTION TITLE
========================================================= */

.section-title {
    margin-bottom: 28px;
}

.section-title > span {
    color: #b48727;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 1.6px;
}

.section-title h2 {
    margin: 9px 0 8px;
    color: #17345f;
    font-size: 25px;
}

.section-title p {
    margin: 0;
    color: #8b96a7;
}


/* =========================================================
   PAYMENT CARD
========================================================= */

.payment-card {
    position: relative;
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 24px;
    margin-bottom: 18px;
    border: 2px solid #e0e5ec;
    border-radius: 23px;
    background: white;
    cursor: pointer;
    transition: all .2s ease;
}

.payment-card:hover {
    border-color: #182657;
    background: #fbfcff;
}

.payment-card.selected {
    border-color: #182657;
    background: #f7f9ff;
    box-shadow: 0 8px 22px rgba(24, 38, 87, .06);
}

.payment-card input[type="radio"] {
    width: 20px;
    height: 20px;
    margin-left: auto;
    accent-color: #182657;
    cursor: pointer;
    flex-shrink: 0;
}

.payment-icon {
    width: 68px;
    height: 68px;
    border-radius: 19px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f4fa;
    font-size: 31px;
    flex-shrink: 0;
}

.payment-info {
    flex: 1;
}

.payment-info h3 {
    margin: 0 0 7px;
    color: #17345f;
    font-size: 20px;
}

.payment-info p {
    margin: 0;
    color: #8591a3;
    line-height: 1.5;
}


/* =========================================================
   METHOD DETAIL
========================================================= */

.method-detail {
    display: none;
    margin: -2px 0 20px;
    padding: 25px;
    background: #f8f9fc;
    border: 1px solid #e6e9ef;
    border-radius: 20px;
}

.method-detail.show {
    display: block;
}

.method-detail h4 {
    margin: 0 0 7px;
    color: #17345f;
    font-size: 18px;
}

.detail-description {
    margin: 0 0 19px;
    color: #8994a5;
    font-size: 14px;
}


/* =========================================================
   SUB OPTIONS
========================================================= */

.sub-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sub-option {
    display: flex;
    align-items: center;
    gap: 13px;
    padding: 15px;
    border: 1px solid #dfe4eb;
    border-radius: 14px;
    background: white;
    cursor: pointer;
    transition: .2s ease;
}

.sub-option:hover {
    border-color: #182657;
}

.sub-option:has(input:checked) {
    border-color: #182657;
    background: #f7f9ff;
}

.sub-option input {
    width: 18px;
    height: 18px;
    accent-color: #182657;
    flex-shrink: 0;
}

.sub-option strong {
    display: block;
    color: #17345f;
    font-size: 14px;
}

.sub-option span {
    display: block;
    margin-top: 4px;
    color: #919baa;
    font-size: 12px;
}


/* =========================================================
   REKENING
========================================================= */

.rekening-box {
    margin-top: 18px;
    padding: 18px;
    background: white;
    border: 1px solid #e1e5ec;
    border-radius: 15px;
}

.rekening-label {
    color: #8994a5;
    font-size: 13px;
    margin-bottom: 5px;
}

.rekening-number {
    color: #17345f;
    font-size: 23px;
    font-weight: 800;
    letter-spacing: 1px;
}

.rekening-name {
    margin-top: 4px;
    color: #7d8797;
    font-size: 13px;
}


/* =========================================================
   QRIS
========================================================= */

.qris-wrapper {
    display: flex;
    justify-content: center;
    padding: 10px 0 22px;
}

.qris-card {
    padding: 16px;
    background: white;
    border: 1px solid #dde3ea;
    border-radius: 18px;
}

.qris-image {
    display: block;
    width: 240px;
    height: 240px;
    object-fit: contain;
}

.qris-information {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.qris-information > div {
    padding: 15px;
    border-radius: 14px;
    background: white;
    border: 1px solid #e0e5ec;
}

.qris-information span {
    display: block;
    color: #8c97a7;
    font-size: 12px;
    margin-bottom: 6px;
}

.qris-information strong {
    display: block;
    color: #17345f;
    font-size: 15px;
}


/* =========================================================
   WALLET
========================================================= */

.wallet-option {
    display: grid;
    grid-template-columns: auto 70px 1fr;
    align-items: center;
    gap: 14px;
    padding: 15px;
    border: 1px solid #dfe4eb;
    border-radius: 14px;
    background: white;
    cursor: pointer;
    transition: .2s ease;
}

.wallet-option:hover {
    border-color: #182657;
}

.wallet-option:has(input:checked) {
    border-color: #182657;
    background: #f7f9ff;
}

.wallet-option input {
    width: 18px;
    height: 18px;
    accent-color: #182657;
}

.wallet-logo {
    width: 70px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
}

.gopay-logo {
    background: #e9f5ee;
    color: #1f7544;
}

.ovo-logo {
    background: #f0e9fb;
    color: #684298;
}

.dana-logo {
    background: #eaf1ff;
    color: #2460ba;
}

.wallet-info strong {
    display: block;
    color: #17345f;
}

.wallet-info span {
    display: block;
    margin-top: 3px;
    color: #919baa;
    font-size: 12px;
}


/* =========================================================
   TOTAL
========================================================= */

.payment-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 24px;
    margin-top: 25px;
    border-radius: 21px;
    background: #f5f7fa;
}

.total-text h3 {
    margin: 0 0 7px;
    color: #17345f;
    font-size: 20px;
}

.total-text p {
    margin: 0;
    color: #8b96a7;
    font-size: 14px;
}

.total-price {
    color: #17345f;
    font-size: 32px;
    font-weight: 800;
    white-space: nowrap;
}


/* =========================================================
   BUTTON
========================================================= */

.btn-payment {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin-top: 25px;
    padding: 19px 22px;
    border: 0;
    border-radius: 18px;
    background: #182657;
    color: white;
    font-size: 18px;
    font-weight: 800;
    cursor: pointer;
    transition: .2s ease;
}

.btn-payment:hover {
    background: #13204b;
    transform: translateY(-1px);
}

.btn-payment:disabled {
    opacity: .7;
    cursor: not-allowed;
    transform: none;
}

.btn-arrow {
    font-size: 23px;
}


/* =========================================================
   SECURITY
========================================================= */

.payment-security {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 7px;
    margin-top: 19px;
    color: #9ca6b4;
    font-size: 13px;
    line-height: 1.5;
    text-align: center;
}


/* =========================================================
   SIDEBAR
========================================================= */

.sidebar-card {
    background: white;
    border: 1px solid #e4e8ef;
    border-radius: 25px;
    padding: 26px;
}

.sidebar-title {
    color: #9099a8;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 1.5px;
    margin-bottom: 16px;
}

.event-name {
    margin: 0 0 18px;
    color: #17345f;
    font-size: 20px;
    line-height: 1.4;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    gap: 18px;
    padding: 15px 0;
    border-top: 1px solid #edf0f4;
}

.summary-row span {
    color: #8b96a7;
}

.summary-row strong {
    color: #17345f;
    text-align: right;
    max-width: 60%;
    line-height: 1.5;
}


/* =========================================================
   CODE
========================================================= */

.code-card {
    background: #fffaf0;
    border-color: #f0dcae;
}

.registration-code {
    display: inline-block;
    padding: 11px 14px;
    border-radius: 10px;
    background: #f0e4c5;
    color: #17345f;
    font-size: 17px;
    font-weight: 800;
    letter-spacing: 1px;
    word-break: break-word;
}

.code-card p {
    margin: 12px 0 0;
    color: #847968;
    font-size: 13px;
    line-height: 1.6;
}


/* =========================================================
   SIDEBAR TOTAL
========================================================= */

.sidebar-total {
    background: #182657;
    border-color: #182657;
}

.sidebar-total .sidebar-title {
    color: #cbd2e3;
}

.sidebar-price {
    color: white;
    font-size: 30px;
    font-weight: 800;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

    .payment-grid {
        grid-template-columns: 1fr;
    }

    .payment-sidebar {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .sidebar-total {
        grid-column: 1 / -1;
    }

}


@media (max-width: 700px) {

    .payment-page {
        padding: 25px 12px 50px;
    }

    .payment-main {
        padding: 22px;
        border-radius: 22px;
    }

    .payment-header h1 {
        font-size: 30px;
    }

    .progress-wrapper {
        overflow-x: auto;
        padding: 15px;
    }

    .progress-item {
        min-width: 140px;
    }

    .progress-line {
        min-width: 25px;
    }

    .payment-card {
        padding: 18px;
        gap: 13px;
    }

    .payment-icon {
        width: 54px;
        height: 54px;
        font-size: 25px;
    }

    .payment-info h3 {
        font-size: 17px;
    }

    .payment-info p {
        font-size: 13px;
    }

    .payment-total {
        flex-direction: column;
        align-items: flex-start;
    }

    .total-price {
        font-size: 28px;
    }

    .payment-sidebar {
        display: flex;
    }

    .qris-information {
        grid-template-columns: 1fr;
    }

    .wallet-option {
        grid-template-columns: auto 60px 1fr;
    }

    .wallet-logo {
        width: 60px;
    }

}

</style>

@endpush


{{-- =========================================================
    JAVASCRIPT
========================================================= --}}
@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('formPembayaran');

    const paymentMethods = document.querySelectorAll(
        'input[name="metode_pembayaran"]'
    );

    const detailTransfer =
        document.getElementById('detail-transfer');

    const detailQris =
        document.getElementById('detail-qris');

    const detailEwallet =
        document.getElementById('detail-ewallet');


    /*
    |--------------------------------------------------------------------------
    | SEMBUNYIKAN SEMUA DETAIL
    |--------------------------------------------------------------------------
    */
    function hideAllDetails() {

        detailTransfer.classList.remove('show');
        detailQris.classList.remove('show');
        detailEwallet.classList.remove('show');

    }


    /*
    |--------------------------------------------------------------------------
    | HIGHLIGHT CARD
    |--------------------------------------------------------------------------
    */
    function updateSelectedCard(value) {

        const cards = [
            document.getElementById('card-transfer'),
            document.getElementById('card-qris'),
            document.getElementById('card-ewallet')
        ];

        cards.forEach(function (card) {

            if (card) {
                card.classList.remove('selected');
            }

        });


        if (value === 'transfer') {

            document
                .getElementById('card-transfer')
                .classList.add('selected');

        }


        if (value === 'qris') {

            document
                .getElementById('card-qris')
                .classList.add('selected');

        }


        if (value === 'e-wallet') {

            document
                .getElementById('card-ewallet')
                .classList.add('selected');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN DETAIL
    |--------------------------------------------------------------------------
    */
    function showMethod(value) {

        hideAllDetails();

        updateSelectedCard(value);


        if (value === 'transfer') {

            detailTransfer.classList.add('show');

        }


        if (value === 'qris') {

            detailQris.classList.add('show');

        }


        if (value === 'e-wallet') {

            detailEwallet.classList.add('show');

        }

    }


    /*
    |--------------------------------------------------------------------------
    | EVENT RADIO
    |--------------------------------------------------------------------------
    */
    paymentMethods.forEach(function (radio) {

        radio.addEventListener('change', function () {

            showMethod(this.value);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | FORM SUBMIT
    |--------------------------------------------------------------------------
    */
    form.addEventListener('submit', function (event) {

        const selectedMethod =
            document.querySelector(
                'input[name="metode_pembayaran"]:checked'
            );


        /*
        ---------------------------------------------------------------
        | BELUM PILIH METODE
        ---------------------------------------------------------------
        */
        if (!selectedMethod) {

            event.preventDefault();

            alert(
                'Silakan pilih metode pembayaran terlebih dahulu.'
            );

            return;

        }


        /*
        ---------------------------------------------------------------
        | TRANSFER BANK
        ---------------------------------------------------------------
        */
        if (
            selectedMethod.value === 'transfer'
        ) {

            const selectedBank =
                document.querySelector(
                    'input[name="bank"]:checked'
                );

            if (!selectedBank) {

                event.preventDefault();

                alert(
                    'Silakan pilih bank terlebih dahulu.'
                );

                return;

            }

        }


        /*
        ---------------------------------------------------------------
        | E-WALLET
        ---------------------------------------------------------------
        */
        if (
            selectedMethod.value === 'e-wallet'
        ) {

            const selectedWallet =
                document.querySelector(
                    'input[name="e_wallet"]:checked'
                );

            if (!selectedWallet) {

                event.preventDefault();

                alert(
                    'Silakan pilih E-Wallet terlebih dahulu.'
                );

                return;

            }

        }


        /*
        ---------------------------------------------------------------
        | DISABLE BUTTON
        ---------------------------------------------------------------
        */
        const button =
            document.getElementById('btnBayar');

        if (button) {

            button.disabled = true;

            button.innerHTML =
                '<span>Memproses Pembayaran...</span>';

        }

    });


    /*
    |--------------------------------------------------------------------------
    | KLIK CARD = PILIH RADIO
    |--------------------------------------------------------------------------
    */
    const cards = document.querySelectorAll(
        '.payment-card'
    );

    cards.forEach(function (card) {

        card.addEventListener('click', function (event) {

            if (
                event.target.tagName.toLowerCase() ===
                'input'
            ) {
                return;
            }

            const radio =
                card.querySelector(
                    'input[type="radio"]'
                );

            if (radio) {

                radio.checked = true;

                radio.dispatchEvent(
                    new Event('change', {
                        bubbles: true
                    })
                );

            }

        });

    });


});

</script>

@endpush

@endsection
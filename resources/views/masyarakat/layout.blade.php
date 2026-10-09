<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield(
            'title',
            'Payakumbuh Event Hub'
        )
    </title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f5f7fb;

            color: #172b4d;

            min-height: 100vh;
        }


        a {
            text-decoration: none;
        }


        button,
        input,
        textarea,
        select {
            font-family: inherit;
        }


        /* =====================================================
           APP
        ====================================================== */

        .app-layout {
            min-height: 100vh;

            display: flex;
        }


        /* =====================================================
           SIDEBAR
        ====================================================== */

        .sidebar {
            position: fixed;

            top: 0;
            left: 0;
            bottom: 0;

            width: 220px;

            background: #ffffff;

            border-right:
                1px solid
                #e5e7eb;

            z-index: 1000;

            overflow-y: auto;
        }


        .sidebar-logo {
            display: flex;

            align-items: center;

            gap: 10px;

            padding:
                24px
                20px
                20px;

            border-bottom:
                1px solid
                #eef0f3;
        }


        .logo-icon {
            width: 38px;
            height: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #f5b52e;

            color: #172b4d;

            font-size: 17px;

            font-weight: 800;
        }


        .logo-text strong {
            display: block;

            color: #172b4d;

            font-size: 17px;
        }


        .logo-text span {
            display: block;

            margin-top: 4px;

            color: #8c96a4;

            font-size: 8px;

            font-weight: 700;

            letter-spacing: 1px;
        }


        /* =====================================================
           MENU
        ====================================================== */

        .sidebar-menu {
            padding: 22px 14px;
        }


        .sidebar-menu-title {
            margin:
                0
                10px
                9px
                10px;

            color: #a0a8b3;

            font-size: 10px;

            font-weight: 800;

            letter-spacing: 1.1px;

            text-transform: uppercase;
        }


        .sidebar-link {
            display: flex;

            align-items: center;

            gap: 11px;

            width: 100%;

            padding: 12px;

            margin-bottom: 6px;

            border-radius: 10px;

            color: #526074;

            font-size: 13px;

            font-weight: 600;

            transition: .2s;
        }


        .sidebar-link:hover {
            background: #fff7e5;

            color: #bd891d;
        }


        .sidebar-link.active {
            background: #fff4dc;

            color: #b77f13;

            font-weight: 800;
        }


        .sidebar-icon {
            width: 22px;

            display: flex;

            justify-content: center;

            font-size: 16px;
        }


        /* =====================================================
           FOOTER SIDEBAR
        ====================================================== */

        .sidebar-footer {
            position: absolute;

            left: 14px;
            right: 14px;
            bottom: 18px;

            padding:
                15px
                10px;

            border-top:
                1px solid
                #eef0f3;
        }


        .sidebar-footer small {
            display: block;

            color: #a0a8b3;

            font-size: 9px;

            font-weight: 700;

            letter-spacing: 1px;
        }


        .sidebar-footer strong {
            display: block;

            margin-top: 5px;

            color: #647083;

            font-size: 10px;

            line-height: 1.5;
        }


        /* =====================================================
           MAIN
        ====================================================== */

        .main-area {
            width:
                calc(
                    100% - 220px
                );

            min-height: 100vh;

            margin-left: 220px;
        }


        /* =====================================================
           TOPBAR
        ====================================================== */

        .topbar {
            position: sticky;

            top: 0;

            z-index: 900;

            min-height: 70px;

            display: flex;

            align-items: center;

            justify-content:
                space-between;

            padding:
                0
                28px;

            background:
                rgba(
                    255,
                    255,
                    255,
                    .97
                );

            border-bottom:
                1px solid
                #e6e9ee;

            backdrop-filter:
                blur(10px);
        }


        .topbar-title {
            color: #172b4d;

            font-size: 15px;

            font-weight: 800;
        }


        .topbar-subtitle {
            margin-top: 3px;

            color: #969fac;

            font-size: 11px;
        }


        .topbar-brand {
            color: #bd891d;

            font-size: 11px;

            font-weight: 800;

            letter-spacing: 1px;
        }


        .mobile-toggle {
            display: none;

            width: 40px;
            height: 40px;

            align-items: center;
            justify-content: center;

            margin-right: 10px;

            border:
                1px solid
                #dde2e8;

            border-radius: 10px;

            background: white;

            color: #172b4d;

            cursor: pointer;
        }


        .topbar-left {
            display: flex;

            align-items: center;
        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .content {
            min-height:
                calc(
                    100vh - 70px
                );
        }


        /* =====================================================
           OVERLAY
        ====================================================== */

        .sidebar-overlay {
            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(
                    0,
                    0,
                    0,
                    .28
                );

            z-index: 950;
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (
            max-width: 900px
        ) {

            .sidebar {
                transform:
                    translateX(-100%);

                transition: .25s ease;
            }


            .sidebar.open {
                transform:
                    translateX(0);
            }


            .main-area {
                width: 100%;

                margin-left: 0;
            }


            .mobile-toggle {
                display: flex;
            }


            .sidebar-overlay.show {
                display: block;
            }

        }


        @media (
            max-width: 600px
        ) {

            .topbar {
                min-height: 62px;

                padding:
                    0
                    15px;
            }


            .content {
                min-height:
                    calc(
                        100vh - 62px
                    );
            }


            .topbar-subtitle {
                display: none;
            }


            .topbar-brand {
                display: none;
            }

        }

    </style>

    @stack('styles')

</head>


<body>


<div class="app-layout">


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}

    <aside
        class="sidebar"
        id="sidebar"
    >

        <div class="sidebar-logo">

            <div class="logo-icon">
                P
            </div>

            <div class="logo-text">

                <strong>
                    PEH
                </strong>

                <span>
                    PAYAKUMBUH EVENT HUB
                </span>

            </div>

        </div>


        <div class="sidebar-menu">

            <div class="sidebar-menu-title">
                Warga Payakumbuh
            </div>


            {{-- BERANDA --}}

            <a
                href="{{ route('masyarakat.beranda') }}"
                class="sidebar-link
                    {{
                        request()->routeIs(
                            'masyarakat.beranda'
                        )
                        ? 'active'
                        : ''
                    }}"
            >

                <span class="sidebar-icon">
                    🏠
                </span>

                <span>
                    Beranda
                </span>

            </a>


            {{-- DAFTAR EVENT --}}

            <a
                href="{{ route('masyarakat.event') }}"
                class="sidebar-link
                    {{
                        request()->routeIs(
                            'masyarakat.event'
                        )
                        ||
                        request()->routeIs(
                            'masyarakat.detail'
                        )
                        ||
                        request()->routeIs(
                            'masyarakat.detail.event'
                        )
                        ||
                        request()->routeIs(
                            'masyarakat.registrasi.*'
                        )
                        ||
                        request()->routeIs(
                            'masyarakat.pembayaran.*'
                        )
                        ? 'active'
                        : ''
                    }}"
            >

                <span class="sidebar-icon">
                    📅
                </span>

                <span>
                    Daftar Event
                </span>

            </a>


            {{-- DOKUMENTASI --}}

            <a
                href="{{ route('masyarakat.dokumentasi') }}"
                class="sidebar-link
                    {{
                        request()->routeIs(
                            'masyarakat.dokumentasi'
                        )
                        ? 'active'
                        : ''
                    }}"
            >

                <span class="sidebar-icon">
                    🖼️
                </span>

                <span>
                    Dokumentasi
                </span>

            </a>


            {{-- CEK PENDAFTARAN --}}

            <a
                href="{{ route('masyarakat.cek') }}"
                class="sidebar-link
                    {{
                        request()->routeIs(
                            'masyarakat.cek'
                        )
                        ||
                        request()->routeIs(
                            'masyarakat.cek.hasil'
                        )
                        ? 'active'
                        : ''
                    }}"
            >

                <span class="sidebar-icon">
                    🎫
                </span>

                <span>
                    Cek Pendaftaran
                </span>

            </a>


        </div>


        {{-- SIDEBAR FOOTER --}}

        <div class="sidebar-footer">

            <small>
                PORTAL RESMI
            </small>

            <strong>
                Sistem Informasi Event
                Kota Payakumbuh
            </strong>

        </div>

    </aside>


    {{-- OVERLAY --}}

    <div
        class="sidebar-overlay"
        id="sidebarOverlay"
    ></div>


    {{-- =====================================================
         MAIN
    ====================================================== --}}

    <div class="main-area">


        <header class="topbar">

            <div class="topbar-left">

                <button
                    type="button"
                    class="mobile-toggle"
                    id="mobileToggle"
                >
                    ☰
                </button>


                <div>

                    <div class="topbar-title">
                        Payakumbuh Event Hub
                    </div>

                    <div class="topbar-subtitle">
                        Portal informasi event Kota Payakumbuh
                    </div>

                </div>

            </div>


            <div class="topbar-brand">
                WARGA PAYAKUMBUH
            </div>

        </header>


        <main class="content">

            @yield('content')

        </main>

    </div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const sidebar =
            document.getElementById(
                'sidebar'
            );

        const overlay =
            document.getElementById(
                'sidebarOverlay'
            );

        const toggle =
            document.getElementById(
                'mobileToggle'
            );


        function openSidebar() {

            if (sidebar) {

                sidebar.classList.add(
                    'open'
                );

            }

            if (overlay) {

                overlay.classList.add(
                    'show'
                );

            }

        }


        function closeSidebar() {

            if (sidebar) {

                sidebar.classList.remove(
                    'open'
                );

            }

            if (overlay) {

                overlay.classList.remove(
                    'show'
                );

            }

        }


        if (toggle) {

            toggle.addEventListener(
                'click',
                function () {

                    if (
                        sidebar &&
                        sidebar.classList.contains(
                            'open'
                        )
                    ) {

                        closeSidebar();

                    } else {

                        openSidebar();

                    }

                }
            );

        }


        if (overlay) {

            overlay.addEventListener(
                'click',
                closeSidebar
            );

        }


        document
            .querySelectorAll(
                '.sidebar-link'
            )
            .forEach(
                function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            if (
                                window.innerWidth
                                <= 900
                            ) {

                                closeSidebar();

                            }

                        }
                    );

                }
            );

    }
);

</script>


@stack('scripts')


</body>

</html>
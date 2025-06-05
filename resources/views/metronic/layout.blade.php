<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Metronic Global Stylesheets Bundle -->
    <link rel="stylesheet" href="{{ asset('metronic/assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('metronic/assets/css/style.bundle.css') }}">
</head>
<body id="kt_body" @class([$blank ? 'app-blank' : 'app-default'])>
    @if($blank)
        {{ $slot }}
    @else
        <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div class="app-page flex-column flex-row-fluid" id="kt_app_page">
                <!--begin::Header-->
                <div id="kt_app_header" class="app-header">
                    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
                        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2">
                            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>
                        <div class="d-flex align-items-stretch justify-content-end flex-grow-1">
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                            </form>
                            <a href="#" class="btn btn-sm btn-light" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </div>
                    </div>
                </div>
                <!--end::Header-->
                <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                    <!--begin::Sidebar-->
                    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
                            <a href="/">
                                <img alt="Logo" src="{{ asset('metronic/assets/media/logos/default-small.svg') }}" class="h-20px" />
                            </a>
                            <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                                <i class="ki-duotone ki-black-left-line fs-3 rotate-180"><span class="path1"></span><span class="path2"></span></i>
                            </div>
                        </div>
                        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
                            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
                                <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
                                    <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="kt_app_sidebar_menu" data-kt-menu="true">
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                                <span class="menu-title">Dashboard</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                                <span class="menu-title">Usuários</span>
                                            </a>
                                        </div>
                                        <div class="menu-item">
                                            <a class="menu-link {{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">
                                                <span class="menu-title">Profile</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Sidebar-->
                    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                        <main class="py-10">
                            {{ $slot }}
                        </main>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Metronic Global Javascript Bundle -->
    <script src="{{ asset('metronic/assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('metronic/assets/js/scripts.bundle.js') }}"></script>

    @stack('scripts')
</body>
</html>

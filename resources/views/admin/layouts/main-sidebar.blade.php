@php

        @endphp
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('admin.dashboard') }}">
            <h3>Oxygen </h3>
            <!-- <img src="" class="main-logo" alt="logo"> -->
        </a>
        <a class="desktop-logo logo-dark active" href="{{ route('admin.dashboard') }}">
            <h3>Oxygen </h3>
            <!-- <img src="" class="main-logo dark-theme" alt="logo"> -->
        </a>
        <a class="logo-icon mobile-logo icon-light active" href="{{ route('admin.dashboard') }}">
            <h3>Oxygen </h3>
            <!-- <img src="" class="logo-icon" alt="logo"> -->
        </a>
        <a class="logo-icon mobile-logo icon-dark active" href="{{ route('admin.dashboard') }}">
            <h3>Oxygen </h3>
            <!-- <img src="" class="logo-icon dark-theme" alt="logo"> -->
        </a>
    </div>

    <div class="main-sidemenu">
        <ul class="side-menu mt-3">

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-tachometer-alt side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.dashboard') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.nationality.index') }}">
                    <i class="fa fa-globe side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.nationality') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.payment-merchant-detail.index') }}">
                    <i class="fa fa-dollar-sign side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.payment_merchant') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" href="{{ route('admin.paymentSettings.index') }}">
                    <i class="fa fa-cog side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.payment_settings') }}</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#') }}">
                    <i class="fa fa-language side-menu__icon"></i>
                    <span class="side-menu__label">{{ config('languageString.language_admin') }}</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item"
                           href="{{ route('admin.language.index') }}">{{ config('languageString.languages') }}</a>
                    </li>
                    <li>
                        <a class="slide-item" href="{{ route('admin.language-screen.index') }}">
                            {{ config('languageString.language_screen') }}
                        </a>
                    </li>
                    <li>
                        <a class="slide-item" href="{{ route('admin.language-string.index') }}">
                            {{ config('languageString.language_string') }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</aside>
<!-- main-sidebar -->

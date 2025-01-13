<!-- main-header -->
<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left ">
            <div class="app-sidebar__toggle" data-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>

        </div>
        <div class="main-header-right">
            <div class="nav nav-item  navbar-nav-right ml-auto">
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs feather feather-maximize" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                        </svg>
                    </a>
                </div>
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="">
                        <img alt="" src="{{URL::asset(Auth::user()->image)}}">
                    </a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user">
                                    <img alt="" src="{{URL::asset(Auth::user()->image)}}" class="">
                                </div>
                                <div class="ml-3 my-auto">
                                    <h6>{{ Auth::user()->name }}</h6>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{ route('admin.profile',[1]) }}"><i
                                class="bx bx-slider-alt"></i> {{ config('languageString.profile') }}</a>
                        @if(Auth::user()->panel_mode==2)
                                <a class="dropdown-item" href="{{ route('admin.changeThemes',[1]) }}"><i
                                        class="bx bx-slider-alt"></i> {{ config('languageString.dark_theme') }}</a>
                        @else
                                <a class="dropdown-item" href="{{ route('admin.changeThemes',[2]) }}"><i
                                        class="bx bx-slider-alt"></i> {{ config('languageString.light_theme') }}</a>
                        @endif

                        @if(Auth::user()->locale=='en')
                                <a class="dropdown-item" href="{{ route('admin.changeThemesMode',['ar']) }}"><i
                                        class="bx bx-slider-alt"></i> العربية</a>
                        @else
                                <a class="dropdown-item" href="{{ route('admin.changeThemesMode',['en']) }}"><i
                                        class="bx bx-slider-alt"></i> English</a>
                        @endif
                            <a class="dropdown-item" href="{{ route('admin.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="bx bx-log-out"></i>
                                {{ config('languageString.sign_out') }}
                            </a>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- /main-header -->

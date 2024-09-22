<!-- Navbar-->
<header class="app-header">
    <a class="app-header__logo" style="font-family: 'Cairo', 'sans-serif';" href="{{ route('dashboard.admin.index') }}">
        {{ getTransSetting('websit_title', app()->getLocale()) }}
    </a>

    <!-- Sidebar toggle button-->
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>

    <!-- Navbar Right Menu-->
    <ul class="app-nav">

        {{--user menu--}}
        <li class="dropdown">
            <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
                <i class="fa fa-flag fa-lg"></i>
            </a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">

                @foreach(getLanguages() as $language)

                    <li>
                        <a class="dropdown-item" href="{{ route('dashboard.admin.changeLanguage', $language->code) }}">
                            {{-- <i class="fa fa-sign-out fa-lg"></i> --}}
                            {{ $language->name }}
                        </a>
                    </li>

                @endforeach

            </ul>
        </li>

        <li class="dropdown">
            <a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">
                <i class="fa fa-user fa-lg"></i>
            </a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li>
                    <a class="dropdown-item" href="page-login.html" href="{{ route('dashboard.admin.auth.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out fa-lg"></i>
                        @lang('admin.auth.logout')
                        <form id="logout-form" action="{{ route('dashboard.admin.auth.logout') }}" method="POST" style="display: none;">
                            @csrf
                            @method('post')
                        </form>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</header>

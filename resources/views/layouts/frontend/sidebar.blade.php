<div class="vertical-nav bg-white" id="sidebar">
    <ul class="nav flex-column bg-white mb-0">
        <li class="nav-item">
            <a href="#" class="nav-link text-dark" data-toggle="modal" data-target="#profileModal">
                <i class="fas fa-address-card mr-3 text-dark fa-fw"></i>
                LINK HERE
            </a>
        </li>
        <li class="nav-item">
            <div class="dropdown-divider"></div>
        </li>
        @guest
            <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link text-dark">
                    <i class="fas fa-sign-in-alt mr-3 text-dark fa-fw"></i>
                    {{ __('Login / Register') }}
                </a>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ route('web_dashboard') }}" class="nav-link text-dark">{{ Auth::user()->name }}</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('web_dashboard') }}" class="nav-link text-dark"><i class="fas fa-image mr-3 text-dark fa-fw"></i>{{ __('My Images') }}</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link text-dark" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
                    <i class="fas fa-sign-out-alt mr-3 text-dark fa-fw"></i>
                    {{ __('Logout') }}
                </a>
                <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        @endguest
    </ul>
</div>

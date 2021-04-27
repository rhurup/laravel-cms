<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" id="sidebarCollapse" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class=" ml-3 navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
            </ul>
        </div>
    </div>
</nav>

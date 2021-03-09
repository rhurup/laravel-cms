<div class="wrapper-background" id="sidebar-wrapper">

    <div class="sidebar-heading">
        @if(\App\Models\Settings\Settings::getValue("default.logo"))
            <a href="/" class="logo-link text-light"><img src="{{\App\Models\Settings\Settings::getValue("default.logo")}}" class="d-block m-auto img-fluid"></a>
        @else
            <a href="/" class="logo-link text-light">{{ config("app.name") }}</a>
        @endif
    </div>
    <div class="just-padding">
        <div class="list-group list-group-root">
            @includeIf("layouts.admin.custom_sidebar")
            <a href="#settings" onclick="" class="list-group-item @if(Request::segment(1) == 'settings') active @endif" data-toggle="collapse" aria-expanded="false">
                <i class="fas menuicon fa-cog"></i>{{__("generic.settings")}}
            </a>
            <div class="list-group collapse @if(in_array(Request::segment(1), ['settings', 'countries','countries','languages','timezones','users','roles','information'])) show @endif" id="settings">
                @if(Auth::user()->hasPermission("browse", "countries"))
                    <a href="/countries" class="list-group-item @if(Request::segment(1) == 'countries') active @endif">
                        <i class="fas menuicon fa-globe"></i>{{__("generic.countries")}}
                    </a>
                @endif
                @if(Auth::user()->hasPermission("browse", "languages"))
                    <a href="/languages" class="list-group-item @if(Request::segment(1) == 'languages') active @endif">
                        <i class="fas menuicon fa-language"></i>{{__("generic.languages")}}
                    </a>
                @endif
                @if(Auth::user()->hasPermission("browse", "timezones"))
                    <a href="/timezones" class="list-group-item @if(Request::segment(1) == 'timezones') active @endif">
                        <i class="fas menuicon fa-user-clock"></i>{{__("generic.timezones")}}
                    </a>
                @endif
                @if(Auth::user()->hasPermission("browse", "users"))
                    <a href="/users" class="list-group-item @if(Request::segment(1) == 'users') active @endif">
                        <i class="fas menuicon fa-users"></i>{{__("generic.users")}}
                    </a>
                @endif
                @if(Auth::user()->hasPermission("browse", "roles"))
                    <a href="/roles" class="list-group-item @if(Request::segment(1) == 'roles') active @endif">
                        <i class="fas menuicon fa-lock"></i>{{__("generic.roles")}}
                    </a>
                @endif
                @if(Auth::user()->hasPermission("browse", "settings"))
                    <a href="/information" class="list-group-item @if(Request::segment(1) == 'information') active @endif">
                        <i class="fas menuicon fa-info"></i>{{__("generic.information")}}
                    </a>
                @endif
                @if(Auth::user()->hasPermission("browse", "settings"))
                    <a href="/settings" class="list-group-item @if(Request::segment(1) == 'settings') active @endif">
                        <i class="fas menuicon fa-cog"></i>{{__("generic.settings")}}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

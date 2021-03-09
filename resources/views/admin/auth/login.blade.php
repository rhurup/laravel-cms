@extends('layouts.admin_login')

@section('content')
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-lg-9 col-md-7 h-100 d-none d-sm-none d-md-block">
            <div class="bottom">
                @if(\App\Models\Settings\Settings::getValue("default.logo"))
                    <img src="{{\App\Models\Settings\Settings::getValue("default.logo")}}" class="float-left img-fluid">
                @else
                    {{ config("app.name") }}
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-md-5 transparent">
            <h3 class="text-center mb-4 mt-4">{{ __('Login with') }}</h3>
            <div class="row">
                <div class="col-4"><img src="images/github-logo.png" class="img-fluid"></div>
                <div class="col-4"><img src="images/facebook-logo.png" class="img-fluid"></div>
                <div class="col-4"><img src="images/google-logo.png" class="img-fluid"></div>
            </div>
            <h3 class="text-center mb-4 mt-4">{{ __('Or') }}</h3>
            <form method="POST" action="{{ url('/login') }}" class="align-middle">
                @csrf
                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="email" type="email" placeholder="{{ __('E-Mail Address') }}" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="password" placeholder="{{ __('Password') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

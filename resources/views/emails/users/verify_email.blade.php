@extends('layouts.email')

@section('content')
    <h1>@lang('users.welcome_new_user')</h1>
    <div
        style="color: #003853;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size: 14px;text-align: left;">
        <p><a href="{{ env('APP_URL') }}?confirm-account={{ $token }}" target="_blank">{{ env('APP_URL') }}?confirm-account={{ $token }}</a></p>
        <p>@lang('generic.best_regards')<br>{{env('APP_CONTACT_NAME')}}</p>
    </div>
@endsection

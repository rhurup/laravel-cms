@extends('layouts.email')

@section('content')

    <h1>Ny adgangskode</h1>

    <p style="color: #003853;font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;font-size: 14px;text-align: left;">
        Kære {{ $name }},
        <br>
        <br/>
        For at ændre din adgangskode klik på dette link:
        <br/>
        <a href="{{ env('APP_URL') }}?confirm-reset-password={{ $token }}" target="_blank">{{ env('APP_URL') }}/?confirm-reset-password={{ $token }}</a>
    </p>

@endsection

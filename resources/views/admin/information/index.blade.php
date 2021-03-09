@extends('layouts.admin')

@section('title', 'Information')
@section('content')
<div class="row">
    <div class="col-md-4">
        <legend>Laravel information</legend>
        <table class="table table-fit">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Current</th>
                    <th>Latest</th>
                </tr>
            </thead>
            <tr>
                <td>@if($requirements->compare_laravel_versions)<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                <td>Laravel/framework</td>
                <td>{{$requirements->laravel_version}}</td>
                <td>{{$requirements->laravel_packagist->version}}</td>
            </tr>
            <tr>
                <td>@if($requirements->laravel_horizon)<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                <td>Laravel/horizon</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>@if($requirements->laravel_telescope)<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                <td>Laravel/telescope</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>@if($requirements->laravel_scheduler_diff < 5)<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                <td>Laravel scheduler (CRON)</td>
                <td colspan="2">{{$requirements->laravel_scheduler_diff}} mins ago</td>
            </tr>
        </table>
    </div>
    <div class="col-md-4">
        <legend>Laravel requirements</legend>
        <table class="table table-fit">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Version</th>
                <th>Installed</th>
            </tr>
            </thead>
            @foreach($requirements->required_modules as $connection => $requirement)
                <tr>
                    <td>@if($requirement['loaded'])<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                    <td>{{$connection}}</td>
                    <td>{{$requirement['v']}}</td>
                    <td>@if($requirement['loaded'])Installed @else Not installed @endif</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-md-4">
        <legend>Services</legend>
        <table class="table table-fit">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Running</th>
            </tr>
            </thead>
            @foreach($requirements->required_connections as $connection => $requirement)
                <tr>
                    <td>@if($requirement)<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                    <td>{{$connection}}</td>
                    <td>@if($requirement)Running @else Not Running @endif</td>
                </tr>
            @endforeach
        </table>
        <legend>Modules</legend>
        <table class="table table-fit">
            <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Installed</th>
            </tr>
            </thead>
            @foreach($requirements->required_services as $connection => $requirement)
                <tr>
                    <td>@if($requirement)<i class="fas fa-check text-success"></i> @else <i class="fas fa-times text-danger"></i> @endif</td>
                    <td>{{$connection}}</td>
                    <td>@if($requirement)Installed @else Not installed @endif</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
    </div>
</div>

@endsection
@extends('layouts.admin')

@section('content')
<form id="settingsForm" action="#" method="post" >
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="defaultCountry">@lang("generic.default") @lang("generic.country")</label>
                <select class="form-control" name="default[country]" id="default_country">

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="defaultTimezone">@lang("generic.default") @lang("generic.language")</label>
                <select class="form-control" name="default[language]" id="default_language">

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="defaultTimezone">@lang("generic.default") @lang("generic.timezone")</label>
                <select class="form-control" name="default[timezone]" id="default_timezone">

                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="default_admin_view">@lang("generic.admin_home_view")</label>
                <input type="text" class="form-control" name="default[admin_view]" id="default_admin_view" />
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="default_frontend_view">@lang("generic.frontend_home_view")</label>
                <input type="text" class="form-control" name="default[frontend_view]" id="default_frontend_view" />
            </div>
        </div>
        <div class="col-md-4">

        </div>
        <div class="col-md-4">
            <div class="custom-file">
                <input class="custom-file-input" name="default[logo]" id="default_logo" type="file" />
                <label class="custom-file-label" for="default_logo">@lang("generic.logo")</label>
            </div>
            <img src="#" class="img-fluid mt-2" id="default_logo_image">
        </div>
        <div class="col-md-4">
            <div class="custom-file">
                <input class="custom-file-input" name="default[admin_login_background]" id="default_admin_login_background" type="file" />
                <label class="custom-file-label" for="default_admin_login_background">@lang("generic.admin_login_background")</label>
            </div>
            <img src="#" class="img-fluid mt-2" id="default_admin_login_background_image">
        </div>
        <div class="col-md-4">
            <div class="custom-file">
                <input class="custom-file-input" name="default[frontend_login_background]" id="default_frontend_login_background" type="file" />
                <label class="custom-file-label" for="default_frontend_login_background">@lang("generic.frontend_login_background")</label>
            </div>
            <img src="#" class="img-fluid mt-2" id="default_frontend_login_background_image">
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-4">
            <table class="table table-sm">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang("generic.key")</th>
                    <th scope="col">@lang("generic.value")</th>
                    <th scope="col">@lang("generic.description")</th>
                    <th scope="col">@lang("generic.actions")</th>
                </tr>
                </thead>
                <tbody id="customsettings">

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-2">
            <button id="saveSettings" type="button" class="btn btn-success float-right">@lang("generic.save") @lang("generic.settings")</button>
            <button id="addSettings" type="button" class="btn btn-primary float-right mr-2">@lang("generic.add") @lang("generic.settings")</button>
        </div>
    </div>
</form>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="application/javascript">
        showLoader();


        function getSettings(){
            return jQuery.ajax({
                url: restUrl + "/settings",
                method: "GET",
                headers: restHeader
            }).done(function (response, textStatus, jqXHR) {
                $("#customsettings").html('');
                $.each(response.data, function(key, value){
                    var cleankey =value.key.replace(".", "_");
                    if(cleankey.includes("default_")){
                        if(cleankey == 'default_logo'){
                            $("#default_logo_image").attr("src", value.value);
                            return;
                        }
                        if(cleankey == 'default_admin_login_background'){
                            $("#default_admin_login_background_image").attr("src", value.value);
                            return;
                        }
                        if(cleankey == 'default_frontend_login_background'){
                            $("#default_frontend_login_background_image").attr("src", value.value);
                            return;
                        }
                        if($("#"+cleankey).length){
                            $("#"+cleankey).val(value.value)
                        }
                    }else{
                        console.log(value.value);
                        $("#customsettings").append('' +
                            '<tr>' +
                            '<td scope="row">'+value.id+'</td>' +
                            '<td><input type="text" placeholder="@lang("generic.key")" class="form-control" name="custom['+value.id+'][key]" value="'+value.key+'"></td>' +
                            '<td><input type="text" placeholder="@lang("generic.value")" class="form-control" name="custom['+value.id+'][value]" value="'+value.value+'"></td>' +
                            '<td><input type="text" placeholder="@lang("generic.description")" class="form-control" name="custom['+value.id+'][description]" value="'+value.description+'"></td>' +
                            '<td><button type="button" class="btn btn-sm btn-danger deleteSetting float-right" data-id="'+value.id+'">@lang("generic.delete")</button</td>' +
                            '</tr>');
                    }
                });
                hideLoader();
            });
        }

        function getTimezones(){
            return jQuery.ajax({
                url: restUrl + "/timezones",
                method: "GET",
                headers: restHeader
            });
        }

        function getLanguages(){
            return jQuery.ajax({
                url: restUrl + "/languages",
                method: "GET",
                headers: restHeader
            });
        }

        jQuery.ajax({
            url: restUrl + "/countries",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $.each(response.data, function(key, value){
                $("#default_country").append('<option value="'+value.country+'">'+value.country+'</option>');
            });
            getTimezones().done(function (Timezoneresponse, textStatus, jqXHR) {
                $.each(Timezoneresponse.data, function(Timezoneresponsekey, Timezoneresponsevalue){
                    $("#default_timezone").append('<option value="'+Timezoneresponsevalue.zone_name+'">'+Timezoneresponsevalue.zone_name+'</option>');
                });
                getLanguages().done(function (Languagesresponse, textStatus, jqXHR) {
                    $.each(Languagesresponse.data, function(Languageskey, Languagesvalue){
                        $("#default_language").append('<option value="'+Languagesvalue.lang+'">'+Languagesvalue.countries.country+' ('+Languagesvalue.lang+')</option>');
                    });
                    getSettings();
                });
            });
        });


        $("#saveSettings").click(function(){
            var notification = addNotification('Saving settings');

            var formdata = new FormData($("#settingsForm")[0])

            jQuery.ajax({
                url: restUrl + "/settings",
                method: "POST",
                headers: restHeader,
                data: formdata,
                processData: false,
                contentType: false,
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
                getSettings();
            }).fail(function (response, textStatus, jqXHR) {
                notification.update({'type': 'danger', 'message': '<strong>Failed</strong> '+response.responseJSON.message});
            });
        });
        $("#customsettings").on("click", ".deleteSetting", function(){
            var notification = addNotification('Deleting settings');
            var parentElement = $(this).parent().parent();
            if($(this).data("id")){
                jQuery.ajax({
                    url: restUrl + "/settings/"+$(this).data("id"),
                    method: "DELETE",
                    headers: restHeader
                }).done(function (response, textStatus, jqXHR) {
                    notification.update({'type': 'success', 'message': '<strong>Deleted</strong>'});
                    parentElement.remove();
                }).fail(function (response, textStatus, jqXHR) {
                    notification.update({'type': 'danger', 'message': '<strong>Failed</strong> '+response.responseJSON.message});
                });
            }else{
                parentElement.remove();
            }
        });
        $("#addSettings").click(function(){
            var randomId = Math.floor(Math.random() * 444) + 1000;
            $("#customsettings").append('' +
                '<tr>' +
                    '<td scope="row">'+randomId+'</td>' +
                    '<td><input type="text" placeholder="@lang("generic.key")" class="form-control" name="custom['+randomId+'][key]" value=""></td>' +
                    '<td><input type="text" placeholder="@lang("generic.value")" class="form-control" name="custom['+randomId+'][value]" value=""></td>' +
                    '<td><input type="text" placeholder="@lang("generic.description")" class="form-control" name="custom['+randomId+'][description]" value=""></td>' +
                    '<td><button type="button" class="btn btn-sm btn-danger deleteSetting float-right" data-id="0">@lang("generic.delete")</button</td>' +
                '</tr>');
        });

    </script>
@endpush
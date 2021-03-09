@extends('layouts.admin')

@section('title', 'User')
@section('content')
<div class="row">
    <div class="col-2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link active" id="v-pills-generel-tab" data-toggle="pill" href="#v-pills-generel" role="tab" aria-controls="v-pills-generel" aria-selected="true">Generel</a>
        </div>
    </div>
    <div class="col-10">
        <div class="col-12">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-generel" role="tabpanel" aria-labelledby="v-pills-generel-tab">
                    <div class="row">
                        <div class="col-12 mt-2">
                            <div class="card" id="user_generel">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a data-toggle="collapse" href="#collapse-user" aria-expanded="true" aria-controls="collapse-content" id="heading-user" class="d-block">
                                            Generel<i class="fa fa-chevron-down float-right"></i>
                                        </a>
                                    </h5>
                                    <div class="collapse-container collapse show" id="collapse-user" aria-labelledby="heading-content">
                                        <div class="form-group row">
                                            <label for="inputPageTitle" class="col-md-2 col-form-label">Name:</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="name" id="inputUser">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-md-2 col-form-label">Email:</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="email" id="inputEmail" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputNewPassword" class="col-md-2 col-form-label">New password:</label>
                                            <div class="col-md-7">
                                                <input type="password" class="form-control" name="newpassword" id="inputNewPassword">
                                            </div>
                                            <div class="col-md-3">
                                                <button id="sendResetPasswordLink" class="btn btn-warning btn-block">Send reset password email</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputVerifiedAt" class="col-md-2 col-form-label">Verified at:</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" id="inputVerifiedAtField" value="">
                                                <input type="hidden" name="verified_at" id="inputVerifiedAt" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputCreatedAt" class="col-md-2 col-form-label">Created at:</label>
                                            <div class="col-md-10">
                                                <input type="text" id="inputCreatedAt" class="form-control" value="" disabled="disabled" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputUpdatedAt" class="col-md-2 col-form-label">Updated at:</label>
                                            <div class="col-md-10">
                                                <input type="text" id="inputUpdatedAt" class="form-control" value="" disabled="disabled" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputLoggedInAt" class="col-md-2 col-form-label">Logged in at:</label>
                                            <div class="col-md-10">
                                                <input type="text" id="inputLoggedInAt" class="form-control" value="" disabled="disabled" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputTimezoneId" class="col-md-2 col-form-label">Timezone:</label>
                                            <div class="col-md-10">
                                                <select name="timezone_id" class="form-control" id="inputTimezoneId">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputLanguageId" class="col-md-2 col-form-label">Language:</label>
                                            <div class="col-md-10">
                                                <select name="language_id" class="form-control" id="inputLanguageId">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputRolesId" class="col-md-2 col-form-label">Roles:</label>
                                            <div class="col-md-10">
                                                <select name="roles[]" class="form-control" id="inputRolesId" multiple="multiple">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="userRolePermissions">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-2">
            <button id="saveUser" class="btn btn-success float-right">Gem bruger</button>
        </div>
    </div>
</div>
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="application/javascript">
        var user_email = '';
        showLoader();

        function getUser(){
            return jQuery.ajax({
                url: restUrl + "/users/<?php echo $id;?>",
                method: "GET",
                headers: restHeader
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
            url: restUrl + "/roles",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $.each(response.data, function(key, value){
                $("#inputRolesId").append('<option value="'+value.id+'">'+value.display_name+'</option>');
            });

            getTimezones().done(function (Timezoneresponse, textStatus, jqXHR) {
                $.each(Timezoneresponse.data, function(Timezoneresponsekey, Timezoneresponsevalue){
                    $("#inputTimezoneId").append('<option value="'+Timezoneresponsevalue.id+'">'+Timezoneresponsevalue.zone_name+'</option>');
                });

                getLanguages().done(function (Languagesresponse, textStatus, jqXHR) {
                    $.each(Languagesresponse.data, function(Languageskey, Languagesvalue){
                        $("#inputLanguageId").append('<option value="'+Languagesvalue.id+'">'+Languagesvalue.countries.country+' ('+Languagesvalue.lang+')</option>');
                    });

                    getUser().done(function (response, textStatus, jqXHR) {
                        user_email = response.data.email;

                        $("#inputUser").val(response.data.name);
                        $("#inputEmail").val(response.data.email);

                        $("#inputVerifiedAtField").val(moment(response.data.email_verified_at).format('YYYY-MM-DDTHH:mm:ss[Z]'));
                        $("#inputVerifiedAt").val(moment(response.data.email_verified_at).format('YYYY-MM-DDTHH:mm:ss[Z]'));

                        $("#inputUpdatedAt").val(response.data.updated_at);
                        $("#inputCreatedAt").val(response.data.created_at);
                        $("#inputLoggedInAt").val(response.data.logged_in_at);
                        $("#inputTimezoneId").val(response.data.timezone_id);
                        $("#inputLanguageId").val(response.data.language_id);
                        $.each(response.data.roles, function(key, value){
                            $("#inputRolesId option[value='" + value.id + "']").prop("selected", true);

                            var permission_html = '';
                            $.each(value.permissions, function(permissionkey, permissionvalue){
                                permission_html += '<span class="badge badge-secondary ml-1">'+permissionvalue.group+' - '+permissionvalue.key+'</span>'
                            });
                            $("#userRolePermissions").append(permission_html);
                        });

                        hideLoader();
                    });
                });
            });
        });

        $("#sendResetPasswordLink").click(function(){
            var notification = addNotification('Sending reset password link');
            jQuery.ajax({
                url: restUrl + "/send-reset-password-link",
                method: "POST",
                headers: restHeader,
                data: {email: user_email}
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> Email is sent.'});
            });
        });

        $("#saveUser").click(function(){
            var notification = addNotification('Saving user');
            var formdata = $("#user_generel").find("input,select").serializeArray();

            jQuery.ajax({
                url: restUrl + "/users/<?php echo $id;?>",
                method: "PUT",
                headers: restHeader,
                data: formdata
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
            });
        });


        $('#inputVerifiedAtField').daterangepicker({
            opens: 'right',
            singleDatePicker: true,
            timePicker: true,
            timePicker24Hour: true,
            showWeekNumbers: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoApply: true,
            ranges: {
                'Idag': [moment(), moment()],
                'Igår': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Sidste 7 dage': [moment().subtract(6, 'days'), moment()],
                'Sidste 30 dage': [moment().subtract(29, 'days'), moment()],
                'Denne md': [moment().startOf('month'), moment().endOf('month')],
                'Sidste md': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            "locale": {
                "format": "YYYY-MM-DDTHH:mm:ss[Z]",
                "separator": " - ",
                "applyLabel": "Gem",
                "cancelLabel": "Annuller",
                "fromLabel": "Fra",
                "toLabel": "til",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "Sø",
                    "Ma",
                    "Ti",
                    "On",
                    "To",
                    "Fr",
                    "Lø"
                ],
                "monthNames": [
                    "Januar",
                    "Februar",
                    "Marts",
                    "April",
                    "Maj",
                    "Juni",
                    "Juli",
                    "August",
                    "September",
                    "Oktober",
                    "November",
                    "December"
                ],
                "firstDay": 1
            }
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD'));
            $("#inputVerifiedAt").val(start.format('YYYY-MM-DDTHH:mm:ss[Z]'));
        });

    </script>
@endpush

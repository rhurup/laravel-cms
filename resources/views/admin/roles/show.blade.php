@extends('layouts.admin')

@section('title', 'Role')
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
                            <div class="card" id="role_generel">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a data-toggle="collapse" href="#collapse-role" aria-expanded="true" aria-controls="collapse-content" id="heading-role" class="d-block">
                                            Generel<i class="fa fa-chevron-down float-right"></i>
                                        </a>
                                    </h5>
                                    <div class="collapse-container collapse show" id="collapse-role" aria-labelledby="heading-content">
                                        <div class="form-group row">
                                            <label for="inputPageTitle" class="col-md-2 col-form-label">Name:</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="name" id="inputName">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-md-2 col-form-label">Display name:</label>
                                            <div class="col-md-10">
                                                <input type="text" class="form-control" name="display_name" id="inputDisplayName" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>Group</th>
                                                        <th></th>
                                                        <th>Permission</th>
                                                        <th>Description</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="rolePermissions">

                                                </tbody>
                                            </table>
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
            <button id="saveRole" class="btn btn-success float-right">Gem rolle</button>
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
        jQuery.ajax({
            url: restUrl + "/roles/<?php echo $id;?>",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            var role_obj = response;
            $("#inputName").val(response.data.name);
            $("#inputDisplayName").val(response.data.display_name);

            var current_permissions = [];
            $.each(response.data.permissions, function(key, value){
                current_permissions.push(value.id);
            });

            jQuery.ajax({
                url: restUrl + "/roles/permissions",
                method: "GET",
                headers: restHeader
            }).done(function (response, textStatus, jqXHR) {
                var permissions = {};
                $.each(response.data, function(key, value){
                    if(permissions[value.group] === undefined){
                        permissions[value.group] = [];
                    }
                    permissions[value.group].push([value.id, value.key, value.description]);
                });
                $.each(permissions, function(key, value){
                    var group = key;
                    var permission_html = '<tr><td><button class="btn btn-sm btn-outline-primary check_permissions" data-group="'+group+'" data-state="0">'+group+'</button></td><td></td><td></td><td></td></tr>';
                    $.each(value, function(key, value){
                        if(current_permissions.indexOf(value[0]) >= 0){
                            permission_html += '<tr>' +
                                '<td></td>' +
                                '<td><input type="checkbox" name="permissions[]" id="permission'+value[0]+'" class="checkall check'+group+'" value="'+value[0]+'" checked="checked"></td>' +
                                '<td><label for="permission'+value[0]+'">'+value[1]+'</label></td>' +
                                '<td><label for="permission'+value[0]+'">'+value[2]+'</label></td>' +
                                '</tr>';
                        }else{
                            permission_html += '<tr>' +
                                '<td></td>' +
                                '<td><input type="checkbox" name="permissions[]" id="permission'+value[0]+'" class="checkall check'+group+'" value="'+value[0]+'"></td>' +
                                '<td><label for="permission'+value[0]+'">'+value[1]+'</label></td>' +
                                '<td><label for="permission'+value[0]+'">'+value[2]+'</label></td>' +
                                '</tr>';
                        }
                    });
                    $("#rolePermissions").append(permission_html);
                });
                hideLoader();
            });
        });



        $("#saveRole").click(function(){
            var notification = addNotification('Saving role');
            var formdata = $("#role_generel").find("input,select").serializeArray();

            jQuery.ajax({
                url: restUrl + "/roles/<?php echo $id;?>",
                method: "PUT",
                headers: restHeader,
                data: formdata
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
            });
        });

        $("#rolePermissions").on("click", ".check_permissions", function(){
            var state = $(this).data("state");
            var group = $(this).data("group");

            console.log(".check"+group);
            console.log(state);

            if(state == "1"){ // All is checked.
                $(".check"+group).prop("checked", false);
                $(this).data("state", 0);
            }
            if(state == "0"){ // All is not checked.
                $(".check"+group).prop("checked", true);
                $(this).data("state", 1);
            }
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

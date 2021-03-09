@extends('layouts.admin')

@section('title', 'Users')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-condensed dataTable" id="tbl_Users">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.name")}}</th>
                    <th>{{__("generic.email")}}</th>
                    <th>{{__("generic.roles")}}</th>
                    <th>{{__("users.email_verified_at")}}</th>
                    <th>{{__("generic.actions")}}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.name")}}</th>
                    <th>{{__("generic.email")}}</th>
                    <th>{{__("generic.role")}}</th>
                    <th data-search="false">{{__("users.email_verified_at")}}</th>
                    <th data-search="false">{{__("generic.actions")}}</th>
                </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
    @if(Auth::user()->hasPermission("create", "users"))
    <!-- Modal -->
    <div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">New user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                        <div class="col-md-10">
                            <input type="password" class="form-control" name="newpassword" id="inputNewPassword">
                        </div>
                    </div>

                    <div class="form-group row form-check">
                        <input type="checkbox" name="notify" value="1" id="inputNotify" checked="">
                        <label for="inputNotify" class="form-check-label">Yes notify by email</label>
                    </div>
                    <div class="form-group row">
                        <label for="inputRoleId" class="col-md-2 col-form-label">Role:</label>
                        <div class="col-md-10">
                            <select name="role_id" class="form-control" id="inputRoleId">

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
                        <label for="inputTimezoneId" class="col-md-2 col-form-label">Timezone:</label>
                        <div class="col-md-10">
                            <select name="timezone_id" class="form-control" id="inputTimezoneId">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveNewUser">Save</button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/datatables.min.css"/>
@endpush
@push('scripts')

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/datatables.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="application/javascript">

        jQuery.ajax({
            url: restUrl + "/roles",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $.each(response.data, function(key, value){
                $("#inputRoleId").append('<option value="'+value.id+'">'+value.display_name+'</option>');
            });
        });
        jQuery.ajax({
            url: restUrl + "/languages",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $.each(response.data, function(key, value){
                $("#inputLanguageId").append('<option value="'+value.id+'">'+value.countries.country+' ('+value.lang+')</option>');
            });
        });
        jQuery.ajax({
            url: restUrl + "/timezones",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $.each(response.data, function(key, value){
                $("#inputTimezoneId").append('<option value="'+value.id+'">'+value.zone_name+'</option>');
            });
        });

        $("#saveNewUser").click(function(){
            var formdata = $("#newModal").find("input,select");
            var notification = addNotification('Saving user');
            jQuery.ajax({
                url: restUrl + "/users",
                method: "POST",
                headers: restHeader,
                data: formdata
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
                $("#newModal").modal("hide");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                notification.update({'type': 'danger', 'message': '<strong>ERROR</strong> '+jqXHR.responseJSON.message});
            })
        });

        var tableCols = [
            {"data": "id"},
            {"data": "name"},
            {"data": "email"},
            {
                data: null,
                className: "center",
                defaultContent: '',
                render: function ( data, type, row, meta ) {
                    return row.roles[0].id+' - '+row.roles[0].name;
                }
            },
            {
                data: 'email_verified_at',
                className: "center",
                defaultContent: '',
                render: function ( data, type, row, meta ) {
                    if(row.email_verified_at !== null){
                        return '<span class="badge badge-success disabled">{{__("generic.yes")}}</span>';
                    }else{
                        return '<span class="badge badge-danger disabled">{{__("generic.no")}}</span>';
                    }

                }
            },
            {
                data: 'id',
                className: "center",
                defaultContent: '<div class="btn-group-xs"><button class="btn btn-xs btn-info">Edit</button>',
                render: function ( data, type, row, meta ) {
                    var returnhtml = '';
                    @if(Auth::user()->hasPermission("update", "users"))
                        returnhtml += '<a href="/users/'+row.id+'" class="btn btn-sm btn-info float-left">{{__("generic.edit")}}</a>';
                    @endif
                    @if(Auth::user()->hasPermission("delete", "users"))
                        returnhtml += '<a href="/users/'+row.id+'" class="btn btn-sm btn-danger float-right">{{__("generic.delete")}}</a>';
                    @endif
                    return returnhtml;
                }
            }
        ];
        $(document).ready(function () {
            generateTable($('#tbl_Users'), "/users", true);
        });
    </script>
@endpush


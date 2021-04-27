@extends('layouts.admin')

@section('title', 'Permissions')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-condensed dataTable" id="tbl_permissions">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.group")}}</th>
                    <th>{{__("generic.name")}}</th>
                    <th>{{__("generic.description")}}</th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.group")}}</th>
                    <th>{{__("generic.name")}}</th>
                    <th>{{__("generic.description")}}</th>
                </tr>
                </tfoot>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserModalLabel">New permission</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="inputPageTitle" class="col-md-2 col-form-label">Group:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="group" id="inputGroup">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-md-2 col-form-label">Key:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="key" id="inputKey" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-md-2 col-form-label">Description:</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="description" id="inputDescription" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveNew">Save</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/datatables.min.css"/>
@endpush
@push('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/datatables.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="application/javascript">
        $("#saveNew").click(function(){
            var formdata = $("#newModal").find("input,select");
            var notification = addNotification('Saving user');
            jQuery.ajax({
                url: restUrl + "/permissions",
                method: "POST",
                headers: restHeader,
                data: formdata
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
                $("#saveNew").modal("hide");
            }).fail(function (jqXHR, textStatus, errorThrown) {
                notification.update({'type': 'danger', 'message': '<strong>ERROR</strong> '+jqXHR.responseJSON.message});
            })
        });

        var tableCols = [
            {"data": "id"},
            {"data": "group"},
            {"data": "key"},
            {"data": "description"},
            {
                data: 'id',
                className: "center",
                defaultContent: '<div class="btn-group-xs"><button class="btn btn-xs btn-info">Edit</button>',
                render: function ( data, type, row, meta ) {
                    var returnhtml = '';
                    @if(Auth::user()->hasPermission("update", "permissions"))
                        returnhtml += '<a href="/permissions/'+row.id+'" class="btn btn-sm btn-info float-left">{{__("generic.edit")}}</a>';
                    @endif
                    @if(Auth::user()->hasPermission("delete", "permissions"))
                        returnhtml += '<a href="/permissions/'+row.id+'" class="btn btn-sm btn-danger float-right">{{__("generic.delete")}}</a>';
                    @endif
                    return returnhtml;
                }
            }
        ];
        $(document).ready(function () {
            generateTable($('#tbl_permissions'), "/permissions", true);
        });
    </script>
@endpush


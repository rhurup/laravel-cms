@extends('layouts.admin')

@section('title', 'Roles')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-condensed dataTable" id="tbl_Users">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.name")}}</th>
                    <th>{{__("generic.role")}}</th>
                    <th>{{__("generic.permissions")}}</th>
                    <th>{{__("generic.users")}}</th>
                    <th>{{__("generic.actions")}}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.name")}}</th>
                    <th>{{__("generic.role")}}</th>
                    <th>{{__("generic.permissions")}}</th>
                    <th>{{__("generic.users")}}</th>
                    <th data-search="false">{{__("generic.actions")}}</th>
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
                <h5 class="modal-title" id="newUserModalLabel">New role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveNewUser">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script type="application/javascript">
        var tableCols = [
            {"data": "id"},
            {"data": "name"},
            {"data": "display_name"},
            {
                data: 'id',
                className: "center",
                defaultContent: '',
                render: function ( data, type, row, meta ) {
                    var permission = '';
                    $.each(row.permissions, function(key, value){
                        permission += '<span class="badge badge-secondary ml-1" data-toggle="tooltip" data-placement="top" title="'+value.description+'">'+value.key+'</span>'
                    });
                    return permission;
                }
            },
            {
                data: null,
                className: "center",
                render: function ( data, type, row, meta ) {
                    return row.users_count;
                }
            },
            {
                data: 'id',
                className: "center",
                defaultContent: '<div class="btn-group-xs"><button class="btn btn-xs btn-info">Edit</button>',
                render: function ( data, type, row, meta ) {

                    var returnhtml = '';
                    @if(Auth::user()->hasPermission("update", "roles"))
                        returnhtml += '<a href="/roles/'+row.id+'" class="btn btn-sm btn-info float-left">{{__("generic.edit")}}</a>';
                    @endif
                    @if(Auth::user()->hasPermission("delete", "roles"))
                        returnhtml += '<a href="/roles/'+row.id+'" class="btn btn-sm btn-danger float-right">{{__("generic.delete")}}</a>';
                    @endif
                    return returnhtml;
                }
            }
        ];
        $(document).ready(function () {
            generateTable($('#tbl_Users'), "/roles", true);
        });
    </script>
@endpush


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
                    <th>{{__("generic.country")}}</th>
                    <th>{{__("generic.timezone")}}</th>
                    <th>{{__("generic.actions")}}</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>{{__("generic.country")}}</th>
                    <th>{{__("generic.timezone")}}</th>
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
@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/datatables.min.css"/>
@endpush
@push('scripts')

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/dt-1.10.20/b-1.6.1/b-html5-1.6.1/b-print-1.6.1/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/datatables.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="application/javascript">
        var tableCols = [
            {"data": "id"},
            {
                data: 'country_id',
                className: "center",
                render: function ( data, type, row, meta ) {
                    return row.country_id+' - '+row.countries.country;
                }
            },
            {"data": "zone_name"},
            {
                data: 'id',
                className: "center",
                defaultContent: '',
                render: function ( data, type, row, meta ) {
                    var returnhtml = '';
                    @if(Auth::user()->hasPermission("update", "timezones"))
                        returnhtml += '<a href="/timezones/'+row.id+'" class="btn btn-sm btn-info float-left">{{__("generic.edit")}}</a>';
                    @endif
                            @if(Auth::user()->hasPermission("delete", "timezones"))
                        returnhtml += '<a href="/timezones/'+row.id+'" class="btn btn-sm btn-danger float-right">{{__("generic.delete")}}</a>';
                    @endif
                        return returnhtml;
                }
            }
        ];
        $(document).ready(function () {
            generateTable($('#tbl_Users'), "/timezones", true);
        });
    </script>
@endpush


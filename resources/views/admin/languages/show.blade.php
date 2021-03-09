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
                                <div class="card" id="language_generel">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a data-toggle="collapse" href="#collapse-role" aria-expanded="true" aria-controls="collapse-content" id="heading-role" class="d-block">
                                                Generel<i class="fa fa-chevron-down float-right"></i>
                                            </a>
                                        </h5>
                                        <div class="collapse-container collapse show" id="collapse-role" aria-labelledby="heading-content">
                                            <div class="form-group row">
                                                <label for="inputCountryId" class="col-md-2 col-form-label">Country:</label>
                                                <div class="col-md-10">
                                                    <select name="country_id" class="form-control" id="inputCountryId">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputLang" class="col-md-2 col-form-label">@lang("generic.timezone"):</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="lang" id="inputLang" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputLangType" class="col-md-2 col-form-label">@lang("generic.type"):</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="langType" id="inputLangType" required>
                                                </div>
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
                <button id="saveRole" class="btn btn-success float-right">@lang('generic.save') @lang('generic.timezone')</button>
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
        showLoader();
        jQuery.ajax({
            url: restUrl + "/countries",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $.each(response.data, function(key, value){
                $("#inputCountryId").append('<option value="'+value.id+'">'+value.country+'</option>');
            });

            jQuery.ajax({
                url: restUrl + "/languages/<?php echo $id;?>",
                method: "GET",
                headers: restHeader
            }).done(function (response, textStatus, jqXHR) {
                $("#inputLang").val(response.data.lang)
                $("#inputLangType").val(response.data.langType)
                $("#inputCountryId").val(response.data.country_id)
                hideLoader();
            });
        });

        $("#saveRole").click(function(){
            var notification = addNotification('Saving role');
            var formdata = $("#language_generel").find("input,select").serializeArray();

            jQuery.ajax({
                url: restUrl + "/languages/<?php echo $id;?>",
                method: "PUT",
                headers: restHeader,
                data: formdata
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
            });
        });

    </script>
@endpush

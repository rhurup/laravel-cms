@extends('layouts.admin')

@section('title', 'Country')
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
                                <div class="card" id="country_generel">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a data-toggle="collapse" href="#collapse-role" aria-expanded="true" aria-controls="collapse-content" id="heading-role" class="d-block">
                                                Generel<i class="fa fa-chevron-down float-right"></i>
                                            </a>
                                        </h5>
                                        <div class="collapse-container collapse show" id="collapse-role" aria-labelledby="heading-content">
                                            <div class="form-group row">
                                                <label for="inputCountry" class="col-md-2 col-form-label">@lang("generic.country"):</label>
                                                <div class="col-md-10">
                                                    <input type="text" class="form-control" name="country" id="inputCountry" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputCode" class="col-md-2 col-form-label">@lang("generic.country_code"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="code" id="inputCode" required>
                                                </div>
                                                <label for="inputIsoCode" class="col-md-2 col-form-label">@lang("generic.country_iso_code"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="iso_code" id="inputIsoCode" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputPhoneCode" class="col-md-2 col-form-label">@lang("generic.country_phone_code"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="phone_code" id="inputPhoneCode" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputCurrencyCode" class="col-md-2 col-form-label">@lang("generic.country_currency_code"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="currency_code" id="inputCurrencyCode" required>
                                                </div>
                                                <label for="inputCurrencyAlign" class="col-md-2 col-form-label">@lang("generic.country_currency_align"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="currency_align" id="inputCurrencyAlign" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputCurrencyName" class="col-md-2 col-form-label">@lang("generic.country_currency_name"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="currency_name" id="inputCurrencyName" required>
                                                </div>
                                                <label for="inputCurrencySymbol" class="col-md-2 col-form-label">@lang("generic.country_currency_symbol"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="currency_symbol" id="inputCurrencySymbol" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputISO639_1" class="col-md-2 col-form-label">@lang("generic.country_iso_639_1"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="iso_639_1" id="inputISO639_1" required>
                                                </div>
                                                <label for="inputISO639_2b" class="col-md-2 col-form-label">@lang("generic.country_iso_639_2b"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="iso_639_2b" id="inputISO639_2b" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputISO639_2t" class="col-md-2 col-form-label">@lang("generic.country_iso_639_2t"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="iso_639_2t" id="inputISO639_2t" required>
                                                </div>
                                                <label for="inputISO639_3" class="col-md-2 col-form-label">@lang("generic.country_iso_639_3"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="iso_639_3" id="inputISO639_3" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputISO639_6" class="col-md-2 col-form-label">@lang("generic.country_iso_639_6"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="iso_639_6" id="inputISO639_6" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="inputDecPoint" class="col-md-2 col-form-label">@lang("generic.country_dec_point"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="dec_point" id="inputDecPoint" required>
                                                </div>
                                                <label for="inputThousandsSep" class="col-md-2 col-form-label">@lang("generic.country_thousands_sep"):</label>
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control" name="thousands_sep" id="inputThousandsSep" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Timezones</h3>
                                                </div>
                                                <div class="col-md-12" id="timezones">

                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h3>Languages</h3>
                                                </div>
                                                <div class="col-md-12" id="languages">

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
                <button id="saveCountry" type="button" class="btn btn-success float-right">@lang('generic.save') @lang('generic.timezone')</button>
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
            url: restUrl + "/countries/<?php echo $id?>",
            method: "GET",
            headers: restHeader
        }).done(function (response, textStatus, jqXHR) {
            $("#inputCountry").val(response.data.country);
            $("#inputCode").val(response.data.code);
            $("#inputIsoCode").val(response.data.iso_code);
            $("#inputPhoneCode").val(response.data.phone_code);
            $("#inputCurrencyCode").val(response.data.currency_code);
            $("#inputCurrencyAlign").val(response.data.currency_align);
            $("#inputCurrencyName").val(response.data.currency_name);
            $("#inputCurrencySymbol").val(response.data.currency_symbol);
            $("#inputISO639_1").val(response.data.iso_639_1);
            $("#inputISO639_2b").val(response.data.iso_639_2b);
            $("#inputISO639_2t").val(response.data.iso_639_2t);
            $("#inputISO639_3").val(response.data.iso_639_3);
            $("#inputISO639_6").val(response.data.iso_639_6);

            $("#inputDecPoint").val(response.data.dec_point);
            $("#inputThousandsSep").val(response.data.thousands_sep);

            $.each(response.data.languages, function(key, value){
                $("#languages").append('<a href="/languages/'+value.id+'" class="btn btn-outline-primary mr-1 mb-1">'+value.lang+'</a>');
            });
            $.each(response.data.timezones, function(key, value){
                $("#timezones").append('<a href="/timezones/'+value.id+'" class="btn btn-outline-primary mr-1 mb-1">'+value.zone_name+'</a>');
            });
        });

        $("#saveCountry").click(function(){
            var notification = addNotification('Saving role');
            var formdata = $("#country_generel").find("input,select").serializeArray();

            jQuery.ajax({
                url: restUrl + "/countries/<?php echo $id;?>",
                method: "PUT",
                headers: restHeader,
                data: formdata
            }).done(function (response, textStatus, jqXHR) {
                notification.update({'type': 'success', 'message': '<strong>Success</strong> User updated.'});
            });
        });

    </script>
@endpush

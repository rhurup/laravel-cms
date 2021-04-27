@extends('layouts.frontend')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">My Images (Last 100 photos) <a href="#upload" class="btn btn-success float-right" data-toggle="modal" data-target="#newImageModal">Upload image</a></div>
                <div class="card-body">
                    <table id="myImages" class="table table-sm">
                        <thead>
                            <tr>
                                <td>{{__("Image")}}</td>
                                <td>{{__("Species")}}</td>
                                <td>{{__("Type")}}</td>
                                <td>{{__("Copyright")}}</td>
                                <td>{{__("Date")}}</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="newImageModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newUserModalLabel">New image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newForm">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select class="form-control" id="imagesTypes"></select>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="typeahead__container">
                                <div class="typeahead__field">
                                    <div class="typeahead__query ">
                                        <input class="species form-control" data-parent="inputPlantId" placeholder="Search species" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <input name="plant_id" id="inputPlantId" type="hidden"/>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input class="form-control" id="inputPlantCopyright" placeholder="Copyright">
                        </div>
                    </div>
                </form>
                <form action="#" class="dropzone" id="dropzoneImages" enctype="multipart/form-data">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </form>
                <div class="privacy mt-3">
                    <blockquote class="blockquote">
                        <p class="mb-0"><small>By uploading images you agree <br/>(1) that you are the original creator of the image, or have the consent of the original creator to upload the image; and <br/>(2) that you consent to use of the image on this database and web site, or have the consent of the original creator for such use.</small></p>
                        <p class="mb-0"><small>All images are to remain copyright of the original creator. <br/>A copyright watermark may be included in the image as long as it is not obtrusive and does not obscure the image.</small></p>
                        <p class="mb-0"><small>Uploaded images will not be actively given to third parties by the owner of this database and web site, nor will they be used for commercial purposes by the owner of the database and web site. <br/>Please be aware, however, that third party web crawlers or search engines may index uploaded images.</small></p>
                    </blockquote>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('css')
    <link href="{{ env("ADMIN_URL").'/css/dropzone.css' }}" rel="stylesheet">
@endpush
@push('scripts')
    <script type="application/javascript">
        let token = document.head.querySelector('meta[name="csrf-token"]');
        var restUrl = '{{ e(env("API_URL")) }}';
        var restUserId = {{ e(Auth::user()->id) }};
        var restHeader = {
            "Accept": "application/json",
            "Authorization": "Bearer {{  e( Auth::user()->api_token ) }}"
        };
        var restToken = "{{  e( Auth::user()->api_token ) }}";
    </script>
    <script type="application/javascript">
        var myDropzoneEle = false;
    </script>
    <script src="{{ env("APP_URL").'/js/dropzone.js' }}" defer></script>
    <script src="{{ env("APP_URL").'/js/user.js' }}" defer></script>
@endpush



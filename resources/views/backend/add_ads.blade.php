@extends('backend.layout.app')

@section('page_title')
    Add Advertising
@endsection

@section('buttons')

@endsection

@section('content')
    <form method="post" action="/admin/ads/add" id="add-ads-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Position</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <select name="position" class="form-control">
                    <option value="home_center">home_center</option>
                    <option value="home_right">home_right</option>
                    <option value="post_details">post_details</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Script</label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <textarea name="script_text" cols="30" rows="10" class="ckeditor"></textarea>
                </div>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-success col-6 col-sm-6 col-xs-12 col-md-offset-3">Save</button>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="/backend/vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css"> <!-- Select2 -->
    <link rel="stylesheet" href="/css/sweetalert2.min.css"> <!-- Select2 -->
@endsection

@section('js')
    <script src="/backend/vendors/select2/dist/js/select2.full.min.js"></script>
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_az.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/ckeditor/config.js"></script>
    <!-- jQuery Tags Input -->
    <script src="/backend/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <script src="/backend/vendors/moment/min/moment.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.az.js"></script>
    <script src="/js/bootstrap-datetimepicker.ru.js"></script>
    <script src="/js/bootstrap-datetimepicker.uk.js"></script>

    <script>
        $(document).ready(function () {
            $('#add-ads-form').validate();
            $('#add-ads-form').ajaxForm({
                beforeSubmit: function () {
                    Swal.fire({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>',
                        text: 'Loading...',
                        showConfirmButton: false
                    });
                },
                beforeSerialize: function () {
                    for (instance in CKEDITOR.instances) CKEDITOR.instances[instance].updateElement();
                },
                success: function (response) {
                    Swal.fire(
                        response.title,
                        response.description,
                        response.status
                    );
                    if (response.status == 'success')
                        location.href = '/admin/ads/edit/'+response.id;
                }
            });
        });
    </script>
@endsection
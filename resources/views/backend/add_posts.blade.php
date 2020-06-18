@extends('backend.layout.app')

@section('page_title')
    Xəbər elavə et
@endsection

@section('content')
    <form method="post" action="/admin/posts/add" id="add-posts-form"
          class="form-horizontal form-label-left" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                {{csrf_field()}}
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <select name="category" class="form-control" placeholder="Menular">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea name="title" id="ckeditor2" placeholder="Title"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="short_title" class="form-control" placeholder="Red title"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <textarea name="content" cols="30" rows="10" id="ckeditor1"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" name="date" class="form-control" id="date" value="{{$date}}"/>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            <select class="select2_multiple form-control" name="positions[]" multiple="multiple">
                                @foreach($positions as $position)
                                    <option value="{{$position->id}}">{{$position->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                {{--<div class="form-group">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="author" class="form-control" placeholder="Author"/>
                        </div>
                    </div>
                </div>--}}

                <div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-success col-6 col-sm-6 col-xs-12 col-md-offset-3">Save</button>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <div class="form-group input-file-container">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-file-design">
                            <label for="file2"> <i class="fa fa-upload"></i> Əsas şəkli yüklə </label>
                            <input type="file" name="base_image_file" id="file2">
                        </div>
                    </div>
                    <div id="img-base-upload" class="col-md-12 col-sm-12 col-xs-12 mb-2">

                    </div>
                    <div class="form-group input-file-container">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-file-design">
                            <label for="file"> <i class="fa fa-upload"></i> Şəkil yüklə </label>
                            <input type="file" name="images[]" id="file" multiple>
                        </div>
                    </div>
                    <div id="img-upload" class="col-md-12 col-sm-12 col-xs-12">

                    </div>
                </div>
                <div class="form-group">
                    <div class="row pt-2 pb-2" style="padding: 10px 0px;">
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-2">
                            <textarea name="tags" cols="30" rows="5" id="tags" placeholder="Tags"></textarea>
                        </div>
                    </div>
                    <div class="row pt-2 pb-2">
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-2">
                            <textarea name="description" class="form-control" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('css')
    <link rel="stylesheet" href="/backend/vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css"> <!-- Select2 -->
    <link rel="stylesheet" href="/css/sweetalert2.min.css"> <!-- Select2 -->
    <style>
        .img-thumbnail {
            border-radius: 0px !important;
            width: 100% !important;
        }

        .select2-container * {
            border-radius: 0px !important;
        }

        .input-file-container {
            margin: 0px;
            padding: 10px;
            border: 1px solid #ddd !important;
        }

        .input-file-design label {
            padding: 0px;
            margin: 0px;
            width: 100%;
            height: 34px !important;
            background-color: #00a65a !important;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            line-height: 34px;
            cursor: pointer;
        }

        .input-file-design input {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .text-center-des {
            text-align: left;
            font-size: 14px;
            line-height: 38px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .border-row {
            margin: 0px;
            padding: 3px;
            border: 1px solid #ddd !important;
        }

        #img-upload, #img-base-upload {
            margin: 0px;
            padding: 10px;
            border: 1px solid #ddd !important;
        }

        .ln_solid {
            border: 6px solid #2b579a !important;
        }

        #cke_bottom_detail, .cke_bottom { display: none; }
    </style>
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
            $('#add-posts-form').validate();
            $('#add-posts-form').ajaxForm({
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
                        location.href = '/admin/posts';
                }
            });

            $('#tags').tagsInput({
                width: 'auto'
            });

            $('#date').datetimepicker({
                format: 'yyyy-mm-dd hh:ii:ss',
                todayBtn: true
            });

            $(".select2_multiple").select2({
                allowClear: true,
                placeholder:'Yoxdur'
            });

            CKEDITOR.replace('ckeditor1',{
                extraPlugins: 'colorbutton',
                width: "100%",
                height: "200px"
            });
            CKEDITOR.replace('ckeditor2',{
                toolbar :
                    [
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline'] },
                    ],
                width: "100%",
                height: "50px",
                extraPlugins: 'colorbutton',
                autoParagraph: false
            });
        });

        function readURL(input, selector) {
            if (input.files && input.files[0]) {
                selector.html("");
                for (var i = 0; i < input.files.length; i++) {
                    var reader = new FileReader();
                    reader.fileName = input.files[i].name;

                    reader.onload = function (e) {
                        selector.append(`<div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3 p-0">
                                <img src="` + e.target.result + `" class="img-thumbnail"/>
                            </div>
                        </div>`);
                    }

                    reader.readAsDataURL(input.files[i]);
                }

            }
        }

        $("input[name='images[]']").change(function () {
            readURL(this, $('#img-upload'));
        });

        $("input[name='base_image_file']").change(function () {
            readURL(this, $('#img-base-upload'));
        });
    </script>
@endsection
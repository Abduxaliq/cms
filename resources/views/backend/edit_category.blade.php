@extends('backend.layout.app')

@section('page_title')
    Edit Category
@endsection

@section('buttons')

@endsection

@section('content')
    <div class="row">
        <div id="img-upload" class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12 p-3">
            @if($baseCategory->image != '')
                <div class="col-md-6">
                    <div class="thumbnail">
                        <div class="view view-first">
                            <img style="width: 200px; height: 100px;" src="/uploads/img/category/{{$baseCategory->image}}" alt="image">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <form method="post" action="/admin/category/edit/{{$baseCategory->slug}}" id="add-menu-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        {{ Form::bsText('name', 'Name', $baseCategory->name, ['required' => 'required']) }}
        <input type="hidden" name="last_image" value="{{$baseCategory->image}}"/>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" name="imageUpl" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="parent_id" class="form-control">
                    <option value="0">Main category</option>
                    @foreach($categories as $category)
                        @php $select = ($baseCategory->parent_id==$category->id)?'selected':''; @endphp
                        <option value="{{$category->id}}" {{$select}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="active" class="form-control">
                    @foreach(['Deactive','Active'] as $key => $options)
                        @php $select = ($baseCategory->active==$key)?'selected':''; @endphp
                        <option value="{{$key}}" {{$select}}>{{$options}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Style</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="style" class="form-control">
                    @foreach(['List','Items'] as $key => $options)
                        @php $select = ($baseCategory->style==$key)?'selected':''; @endphp
                        <option value="{{$key}}" {{$select}}>{{$options}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css"> <!-- Select2 -->
    <link href="/backend/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <style>
        .img-thumbnail {
            width:200px!important;
            height:100px!important;
            padding: 10px!important;
        }
        .select2-container--default .select2-selection--single {
            border-radius: 0px!important;
        }
    </style>
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_az.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#add-menu-form').validate();
            $('#add-menu-form').ajaxForm({
                beforeSubmit: function () {

                },
                success: function (response) {
                    Swal.fire(
                        response.title,
                        response.description,
                        response.status
                    )
                }
            });
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                $('#img-upload .new').remove();
                for (var i=0; i<input.files.length; i++) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('#img-upload').html('<img src="'+e.target.result+'" class="img-thumbnail new"/>');
                    }

                    reader.readAsDataURL(input.files[i]);
                }

            }
        }

        $("input[name='imageUpl']").change(function(){
            readURL(this);
        });

    </script>
@endsection
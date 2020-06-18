@extends('backend.layout.app')

@section('page_title')
    Add Category
@endsection

@section('buttons')

@endsection

@section('content')
    <form method="post" action="/admin/category/add" id="add-menu-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        {{ Form::bsText('name', 'Name', '', ['required' => 'required']) }}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Image</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" name="imageUpl" class="form-control">
            </div>
            <div id="img-upload" class="col-md-offset-3 col-sm-offset-3 col-md-6 col-sm-6 col-xs-12 p-3"></div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Select</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="parent_id" class="form-control">
                    <option value="0">Main category</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Style</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="style" class="form-control">
                    <option value="1">Items</option>
                    <option value="0">List</option>
                </select>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css"> <!-- Select2 -->
    <link href="/backend/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
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
                    if(response.status == 'success')
                        location.href = '/admin/category';
                }
            });
        });
    </script>
@endsection
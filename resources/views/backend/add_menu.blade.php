@extends('backend.layout.app')

@section('page_title')
    Add menu
@endsection

@section('buttons')

@endsection

@section('content')
    <form method="post" action="/admin/menus/add" id="add-menu-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        {{ Form::bsText('name', 'Name', '', ['required' => 'required']) }}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Parent</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="parent_id" class="form-control">
                    <option value="0">Main menu</option>
                    @foreach($menus as $menu)
                        <option value="{{$menu->id}}">{{$menu->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Menu type</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="checkbox" id="menu-type"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Page</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="foreign_key1" class="form-control">
                    <option value="0">Nothings</option>
                    @foreach($forUrl[0] as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="foreign_key2" class="form-control">
                    <option value="0">Nothings</option>
                    @foreach($forUrl[1] as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{ Form::bsText('rank', 'Rank') }}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="active" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Deactive</option>
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
        function menuType(e){
            if(e){
                $('select[name=foreign_key1]').closest('.form-group').show();
                $('select[name=foreign_key2]').closest('.form-group').hide();
            } else {
                $('select[name=foreign_key1]').closest('.form-group').hide();
                $('select[name=foreign_key2]').closest('.form-group').show();
            }
        }

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
                        location.href = '/admin/menus';
                }
            });

            $('#menu-type').change(function(){
                menuType($('#menu-type').is(":checked"));
            });

            menuType($('#menu-type').is(":checked"));
        });
    </script>
@endsection
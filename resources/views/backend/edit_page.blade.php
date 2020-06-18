@extends('backend.layout.app')

@section('page_title')
    Edit Page
@endsection

@section('buttons')

@endsection

@section('content')
    <form method="post" action="/admin/page/edit/{{$basePage->slug}}" id="edit-page-form"
          class="form-horizontal form-label-left" enctype="multipart/form-data">
        {{csrf_field()}}
        {{ Form::bsTextPosts('title', 'Title', $basePage->title, ['required' => 'required']) }}
        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Content</label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <textarea name="content" cols="30" rows="10" class="ckeditor">{{$basePage->content}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Status</label>
            <div class="col-md-10 col-sm-10 col-xs-12">
                <select name="active" class="form-control">
                    @foreach(['Deactive','Active'] as $key => $options)
                        @php $select = ($basePage->active==$key)?'selected':''; @endphp
                        <option value="{{$key}}" {{$select}}>{{$options}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2">
                <button type="submit" class="btn btn-success">Save changes</button>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/sweetalert2.min.css"> <!-- Select2 -->
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_az.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>
    <script src="/js/ckeditor/ckeditor.js"></script>
    <script src="/js/ckeditor/config.js"></script>

    <script>
        $(document).ready(function () {
            $('#edit-page-form').validate();
            $('#edit-page-form').ajaxForm({
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
                    if(response.status=='success')
                        location.href='/admin/page';
                }
            });
        });
    </script>
@endsection
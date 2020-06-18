@extends('backend.layout.app')

@section('page_title')
    Edit PDF
@endsection

@section('buttons')

@endsection

@section('content')
    <form method="post" action="/admin/document/edit/{{$baseDocument->id}}" id="add-document-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <input type="hidden" name="path" value="{{$baseDocument->path}}"/>
        {{ Form::bsText( 'name', 'Name', $baseDocument->name ) }}
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">PDF</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" name="pdfUpl" class="form-control">
                <span>{{$baseDocument->path}}</span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Active</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select name="active" class="form-control">
                    @foreach(['Deactive','Active'] as $key => $options)
                        @php $select = ($baseDocument->active==$key)?'selected':''; @endphp
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
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_az.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#add-document-form').validate();
            $('#add-document-form').ajaxForm({
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
    </script>
@endsection
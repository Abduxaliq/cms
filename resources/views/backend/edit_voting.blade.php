@extends('backend.layout.app')

@section('page_title')
    Səsverməyə düzəliş et
@endsection

@section('buttons')

@endsection

@section('content')
    <form method="post" action="/admin/voting/edit/{{$baseVoting->id}}" id="add-voting-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        {{ Form::bsText('text', 'Sual :', $baseVoting->text, ['required' => 'required']) }}
        <div class="form-group">
            <label class="control-label text-center col-md-12 col-sm-12 col-xs-12">
                Cavabların sayı : <span id="count-answer"></span>
            </label><br/>
            <label class="control-label col-md-3 col-sm-3 col-xs-10">Cavablar : </label>
            <div class="col-md-offset-3">
                @foreach($baseVoting->answers_data as $sn => $answer)
                    @if($sn == 0)
                    <div class="col-md-9 col-sm-9 col-xs-10">
                        <div id="base-input">
                            <input type="text" name="answer_text[{{$sn}}][text]" class="form-control answer"
                                   style="width: 90%; float: left" value="{{$answer->text}}">
                            <input type="hidden" name="answer_text[{{$sn}}][id]" value="{{$answer->id}}"/>
                        </div>
                        <div class="plus-btn" style="width: 10%; float: left"> <i class="fa fa-plus"></i></div>
                    </div>
                    @else
                        <div class="col-md-9 col-sm-9 col-xs-10">
                            <input type="text" name="answer_text[{{$sn}}][text]" class="form-control answer"
                               style="width: 90%; float: left; margin-top:5px;" value="{{$answer->text}}">
                            <input type="hidden" name="answer_text[{{$sn}}][id]" value="{{$answer->id}}"/>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="append-div col-md-offset-3">
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <button type="submit" class="btn btn-success col-6 col-sm-6 col-xs-12 col-md-offset-3">Save changes</button>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="/backend/vendors/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/css/bootstrap-datetimepicker.min.css"> <!-- Select2 -->
    <link rel="stylesheet" href="/css/sweetalert2.min.css"> <!-- Select2 -->
    <style>
        .plus-btn .fa {
            font-size: 34px;
            cursor: pointer;
            color: #26b99a;
            padding-left: 5px;
        }

        .text-center {
            text-align: center!important;
        }
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

    <script type="text/html" id="base-input-for-clone">
        <input type="text" name="answer_text[$index$][text]" class="form-control answer" style="width: 90%; float: left">
        <input type="hidden" name="answer_text[$index$][id]" value="0"/>
    </script>
    <script>
        $(document).ready(function () {
            $('#add-voting-form').validate();
            $('#add-voting-form').ajaxForm({
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
                        location.href = '/admin/voting/edit/'+response.id;
                }
            });

            $('.plus-btn .fa.fa-plus').click(function () {
                var index = $("input[type=hidden]").length;
                var html = $('#base-input-for-clone').text().replace(/\$index\$/g, index);
                $(".append-div").append(
                    '<div class="col-md-9 col-sm-9 col-xs-10 cloned" style="margin-top: 5px;">' + html +
                    '<div class="plus-btn" style="width: 10%; float: left;"><i class="fa fa-trash"></i></div>' +
                    '</div>'
                );

                $('.plus-btn .fa.fa-trash').click(function () {
                    $(this).closest('.cloned').remove();
                    count_answer();
                });
                count_answer();
            });

            function count_answer() {
                $('#count-answer').html($('input.answer').length);
            }
            count_answer();
        });
    </script>
@endsection
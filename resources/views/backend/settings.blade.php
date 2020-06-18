@extends('backend.layout.app')

@section('page_title')
    Settings
@endsection

@section('content')
    <form method="post" action="/admin/settings" id="settings-form" class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#genel_ayarlar" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">
                        Genel Ayarlar
                    </a>
                </li>
                <li role="presentation" class="">
                    <a href="#elaqe_ayarlari" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">
                        Əlaqə Ayarları
                    </a>
                </li>
                <li role="presentation" class="">
                    <a href="#sosial_media" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">
                        Sosial Media
                    </a>
                </li>
                <li role="presentation" class="">
                    <a href="#google_api" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">
                        Google API
                    </a>
                </li>
                <li role="presentation" class="">
                    <a href="#mail_ayarlari" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">
                        Mail Ayarları
                    </a>
                </li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="genel_ayarlar" aria-labelledby="home-tab">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Mövcud logo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <img src="/uploads/img/{{ $settings->logo }}" alt="{{ $settings->logo }}" id="logo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">
                            Sayt logo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="file"  class="form-control col-md-7 col-xs-12"
                                   name="logo">
                            <input type="hidden" name="last_logo" value="{{ $settings->logo }}">
                        </div>
                    </div>

                    {{ Form::bsText('video', 'Tanıtım video linki', $settings->video) }}
                    {{ Form::bsText('title', 'Sayt Başlığı', $settings->title) }}
                    {{ Form::bsText('keywords', 'Sayt açar sözlər', $settings->keywords) }}
                    {{ Form::bsText('description', 'Sayt açıqlaması', $settings->description) }}

                </div>

                <div role="tabpanel" class="tab-pane fade" id="elaqe_ayarlari" aria-labelledby="profile-tab">

                    {{ Form::bsText('phone1', 'Telefon 1', $settings->phone1) }}
                    {{ Form::bsText('phone2', 'Telefon 2', $settings->phone2) }}
                    {{ Form::bsText('address', 'Ünvan', $settings->address) }}

                </div>

                <div role="tabpanel" class="tab-pane fade" id="sosial_media" aria-labelledby="profile-tab">

                    {{ Form::bsText('instagram', 'Instagram', $settings->instagram) }}
                    {{ Form::bsText('facebook', 'Facebook', $settings->facebook) }}
                    {{ Form::bsText('youtube', 'Youtube', $settings->youtube) }}

                </div>

                <div role="tabpanel" class="tab-pane fade" id="google_api" aria-labelledby="profile-tab">

                    {{ Form::bsText('maps', 'Maps', $settings->maps) }}
                    {{ Form::bsText('analystic', 'Analystic', $settings->analystic) }}
                    {{ Form::bsText('zopim', 'Zopim', $settings->zopim) }}

                </div>

                <div role="tabpanel" class="tab-pane fade" id="mail_ayarlari" aria-labelledby="profile-tab">

                    {{ Form::bsText('smtp_host', 'SMTP host', $settings->smtp_host) }}
                    {{ Form::bsText('smtp_user', 'SMTP user', $settings->smtp_user) }}
                    {{ Form::bsPassword('smtp_pass', 'SMTP password', $settings->smtp_pass) }}
                    {{ Form::bsText('smtp_port', 'SMTP port', $settings->smtp_port) }}

                </div>

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
    <link rel="stylesheet" href="/css/sweetalert2.min.css">
@endsection

@section('js')
    <script src="/js/jquery.form.min.js"></script>
    <script src="/js/jquery.validate.min.js"></script>
    <script src="/js/messages_az.min.js"></script>
    <script src="/js/sweetalert2.min.js"></script>

    <script>
        $(document).ready(function(){
            $('#settings-form').validate();
            $('#settings-form').ajaxForm({
                beforeSubmit:function () {

                },
                success: function ( response ) {
                    Swal.fire(
                        response.title,
                        response.description,
                        response.status
                    )
                    if(response.status == 'success') {
                        $('#logo').attr('src', '/uploads/img/' + response.img);
                    }
                }
            });
        });
    </script>
@endsection
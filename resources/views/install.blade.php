<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/icon.png" type="image/png" sizes="16x16">
    <title>{{ $title }}</title>
    <link href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <style type="text/css">
            #msg{
                text-align: center;
            }
            .error,.failed{
                color: #ff0000;
                font-weight: normal;
            }
            .success,.passed{
                color: #418802;
            }
            .passed,.failed{
                text-align: right;
                float: right;
            }
            .container{
                font-size: 13px !important;
            }
            .info-install{
                margin: 0 5px !important;
            }
        </style>
</head>
<body>
<div class="container">
    <div class="row" style=" margin-top:10px">
        <div class="col-md-1"></div>
    <div class="col-md-5 col-sm-8">
        <div style="text-align: center;display: inline;line-height: 80px;">
            <img alt="Logo-Scart" title="Logo-Scart" src="images/scart-min.png" style="width: 150px; padding: 5px;">
        </div>

        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
            @if ($path_lang == '?lang=vi')
            <img src="https://s-cart.org/data/language/flag_vn.png" style="height: 25px;">
            @else
            <img src="https://s-cart.org/data/language/flag_uk.png" style="height: 25px;">
            @endif


        <span class="caret"></span>
      </button>
          <ul class="dropdown-menu" >
              <li><a href="install.php"><img src="https://s-cart.org/data/language/flag_uk.png" style="height: 25px;"></a></li>
              <li><a href="install.php?lang=vi"><img src="https://s-cart.org/data/language/flag_vn.png" style="height: 25px;"></a></li>
          </ul>
        </div>
        <div style="clear: both;display: block;">
            <p>
                {{ trans('install.info.about') }}<br>
                {!! trans('install.info.about_us') !!}<br>
                {!! trans('install.info.document') !!}<br>
            </p>
            <p><b>{{ trans('install.info.version') }}</b>: {{ config('s-cart.version') }}</p>
            <p>{!! trans('install.info.terms') !!}</p>
        </div>

@php
    $checkRequire = 'pass';
@endphp
<b>{{ trans('install.check_extension') }}</b>:
@if (count($requirements['ext']))
    <ul>
        @foreach ($requirements['ext'] as $label => $result)
            @php
                if($result) {
                    $status = 'passed';
                } else {
                    $status = $checkRequire = 'failed';
                }
            @endphp
                <li>{{ $label }}<span class='{{ $status }}'>{{ $result ? trans('install.check_ok') : trans('install.check_failed') }}</span></li>
        @endforeach
    </ul>
@endif
<b>{{ trans('install.check_writable') }}</b>:
@if (count($requirements['writable']))
    <ul>
        @foreach ($requirements['writable'] as $label => $result)
            @php
                if($result) {
                    $status = 'passed';
                } else {
                    $status = $checkRequire = 'failed';
                }
            @endphp
                <li>{{ $label }}<span class='{{ $status }}'>{{ $result ? trans('install.check_ok') : trans('install.check_failed') }}</span></li>
        @endforeach
    </ul>
@endif
    </div>
    <div id="signupbox"  class="mainbox col-md-5  col-sm-8">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h1>{{ $title }}</h1>
            </div>
            <div class="panel-body" >
                    <form  class="form-horizontal" id="formInstall">
                        <div id="div_database_host" class="form-group info-install required">
                            <label for="database_host"  required class="control-label col-md-4  requiredField"> {{ trans('install.database_host') }} </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textInput form-control" id="database_host"  name="database_host" placeholder="{{ trans('install.database_host') }}" style="margin-bottom: 10px" type="text" value="127.0.0.1" />
                            </div>
                        </div>
                        <div id="div_database_port" class="form-group info-install required">
                            <label for="database_port"  required class="control-label col-md-4  requiredField"> {{ trans('install.database_port') }} </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textInput form-control" id="database_port"  name="database_port" placeholder="{{ trans('install.database_port') }}" style="margin-bottom: 10px" type="number" value="3306" />
                            </div>
                        </div>
                        <div id="div_database_name" class="form-group info-install required">
                            <label for="database_name"  required class="control-label col-md-4  requiredField"> {{ trans('install.database_name') }} </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textInput form-control" id="database_name"  name="database_name" placeholder="{{ trans('install.database_name') }}" style="margin-bottom: 10px" type="text" value="s-cart" />
                            </div>
                        </div>
                        <div id="div_database_user" class="form-group info-install required">
                            <label for="database_user"  required class="control-label col-md-4  requiredField"> {{ trans('install.database_user') }} </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textInput form-control" id="database_user"  name="database_user" placeholder="{{ trans('install.database_user') }}" style="margin-bottom: 10px" type="text" value="root" />
                            </div>
                        </div>
                        <div id="div_database_password" class="form-group info-install required">
                            <label for="database_password"  required class="control-label col-md-4  requiredField"> {{ trans('install.database_password') }} </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textInput form-control" id="database_password"  name="database_password" placeholder="{{ trans('install.database_password') }}" style="margin-bottom: 10px" type="password" value="" />
                            </div>
                        </div>
                        <div id="div_database_prefix" class="form-group info-install">
                            <label for="database_prefix"  class="control-label col-md-4 "> {{ trans('install.database_prefix') }} </label>
                            <div class="controls col-md-8 ">
                                <input class="input-md  textInput form-control" id="database_prefix"  name="database_prefix" placeholder="{{ trans('install.database_prefix_help') }}" style="margin-bottom: 10px" type="text"  value="sc_" />
                            </div>
                        </div>
                        <hr>
                        <div id="div_language_default" class="form-group info-install required">
                            <label for="language_default"  required class="control-label col-md-4  requiredField"> {{ trans('install.language_default') }} </label>
                            <div class="controls col-md-8">
                                <select name="language_default" class="form-control" id="language_default">
                                    @foreach (['vi' => 'VietNam', 'en' => 'English'] as $key => $value)
                                        <option value="{{ $key }}">{{  $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div id="div_timezone_default" class="form-group info-install required">
                            <label for="timezone_default"  required class="control-label col-md-4  requiredField"> {{ trans('install.timezone_default') }} </label>
                            <div class="controls col-md-8">
                                <select name="timezone_default" class="form-control" id="timezone_default">
                                @foreach (timezone_identifiers_list() as $key => $value)
                                    <option value="{{ $value }}"  {{ $value == 'Asia/Ho_Chi_Minh'?'selected':'' }}>{{  $value }}</option>
                                @endforeach
                                </select>
                                </div>
                        </div>
                        <hr>
                        <div id="div_admin_url" class="form-group info-install required">
                            <label for="admin_url"  required class="control-label col-md-4  requiredField"> {{ trans('install.admin_url') }} </label>
                            <div class="controls col-md-8">
                                <input class="input-md  textInput form-control" id="admin_url"  name="admin_url" placeholder="{{ trans('install.admin_url') }}" style="margin-bottom: 10px" type="text" value="sc_admin" />
                            </div>
                        </div>
                        <div id="div_admin_user" class="form-group info-install required">
                            <label for="admin_user"  required class="control-label col-md-4  requiredField"> {{ trans('install.admin_user') }} </label>
                            <div class="controls col-md-8">
                                <input class="input-md  textInput form-control" id="admin_user"  name="admin_user" placeholder="{{ trans('install.admin_user') }}" style="margin-bottom: 10px" type="text" value="admin" />
                            </div>
                        </div>
                        <div id="div_admin_password" class="form-group info-install required">
                            <label for="admin_password"  required class="control-label col-md-4  requiredField"> {{ trans('install.admin_password') }} </label>
                            <div class="controls col-md-8">
                                <input class="input-md  textInput form-control" id="admin_password"  name="admin_password" placeholder="{{ trans('install.admin_password') }}" style="margin-bottom: 10px" type="password" value="admin" />
                            </div>
                        </div>
                        <div id="div_admin_email" class="form-group info-install required">
                            <label for="admin_email"  required class="control-label col-md-4  requiredField"> {{ trans('install.admin_email') }} </label>
                            <div class="controls col-md-8">
                                <input class="input-md  textInput form-control" id="admin_email"  name="admin_email" placeholder="{{ trans('install.admin_email') }}" style="margin-bottom: 10px" type="email" />
                            </div>
                        </div>
                        <div class="form-group info-install required">
                            <div class="controls col-md-offset-4 col-md-8 ">
                                <input required class="input-md checkboxinput" id="id_terms" name="terms" style="margin-bottom: 10px" type="checkbox" />
                                         {!! trans('install.terms') !!}
                            </div>
                        </div>
                        <div id="msg" class="form-group info-install"></div>
                        <div class="form-group">
                            <div class="controls col-md-4 "></div>
                            <div class="controls col-md-8 ">
                                <input  type="button" {{ ($checkRequire == 'pass')?'':'disabled'}} data-loading-text="{{ trans('install.installing_button') }}"  value="{{ trans('install.installing') }}" class="btn btn-primary btn btn-info" id="submit-install" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="progress" style="display: none;">
                                  <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>

    </div>
</div>
</div>

<script type="text/javascript">
$('#submit-install').click(function(event) {
    validateForm();
    if($("#formInstall").valid()){
        $(this).button('loading');
        $('.progress').show();
            $.ajax({
                url: 'install.php{{ $path_lang }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    database_host:$('#database_host').val(),
                    database_port:$('#database_port').val(),
                    database_name:$('#database_name').val(),
                    database_user:$('#database_user').val(),
                    timezone_default:$('#timezone_default').val(),
                    language_default:$('#language_default').val(),
                    admin_user:$('#admin_user').val(),
                    admin_password:$('#admin_password').val(),
                    database_prefix:$('#database_prefix').val(),
                    admin_email:$('#admin_email').val(),
                    admin_url:$('#admin_url').val(),
                    database_password:$('#database_password').val(),
                    step:'step1',
                },
            })
            .done(function(data) {

                error= parseInt(data.error);
                if(error != 1 && error !=0){
                    $('#msg').removeClass('success');
                    $('#msg').addClass('error');
                    $('#msg').html(data);
                    $('#submit-install').button('reset');
                }
                else if(error ===0)
                {
                    var infoInstall = data.infoInstall;
                    $('#admin_url').val(infoInstall.admin_url);
                    $('#msg').addClass('success');
                    $('#msg').html(data.msg);
                    $('.progress-bar').css("width","15%");
                    $('.progress-bar').html("15%");
                    setTimeout(installDatabaseStep1(infoInstall), 1000);
                } else {
                    $('#msg').removeClass('success');
                    $('#msg').addClass('error');
                    $('#msg').html(data.msg);
                    $('#submit-install').button('reset');
                }
            })
            .fail(function() {
                $('#msg').removeClass('success');
                $('#msg').addClass('error');
                $('#msg').html('{{ trans('install.env.error') }}');
                $('#submit-install').button('reset');

            })
    }
});

function installDatabaseStep1(infoInstall){
    $.ajax({
        url: 'install.php{{ $path_lang }}',
        type: 'POST',
        dataType: 'json',
        data: {step: 'step2-1', 'infoInstall':infoInstall},
    })
    .done(function(data) {

         error= parseInt(data.error);
        if(error != 1 && error !=0){
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data);
            $('#submit-install').button('reset');
        }
        else if(error === 0)
        {
            var infoInstall = data.infoInstall;
            $('#msg').addClass('success');
            $('#msg').html(data.msg);
            $('.progress-bar').css("width","25%");
            $('.progress-bar').html("25%");
            setTimeout(installDatabaseStep2(infoInstall), 1000);
        }else{
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data.msg);
            $('#submit-install').button('reset');
        }

    })
    .fail(function() {
        $('#msg').removeClass('success');
        $('#msg').addClass('error');
        $('#msg').html('{{ trans('install.database.error_1') }}');
        $('#submit-install').button('reset');
    })
}


function installDatabaseStep2(infoInstall){
    $.ajax({
        url: 'install.php{{ $path_lang }}',
        type: 'POST',
        dataType: 'json',
        data: {step: 'step2-2', 'infoInstall':infoInstall},
    })
    .done(function(data) {

         error= parseInt(data.error);
        if(error != 1 && error !=0){
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data);
            $('#submit-install').button('reset');
        }
        else if(error === 0)
        {
            var infoInstall = data.infoInstall;
            $('#msg').addClass('success');
            $('#msg').html(data.msg);
            $('.progress-bar').css("width","40%");
            $('.progress-bar').html("40%");
            setTimeout(installDatabaseStep3(infoInstall), 1000);
        }else{
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data.msg);
            $('#submit-install').button('reset');
        }

    })
    .fail(function() {
        $('#msg').removeClass('success');
        $('#msg').addClass('error');
        $('#msg').html('{{ trans('install.database.error_2') }}');
        $('#submit-install').button('reset');
    })
}

function installDatabaseStep3(infoInstall){
    $.ajax({
        url: 'install.php{{ $path_lang }}',
        type: 'POST',
        dataType: 'json',
        data: {step: 'step2-3', 'infoInstall':infoInstall},
    })
    .done(function(data) {

         error= parseInt(data.error);
        if(error != 1 && error !=0){
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data);
            $('#submit-install').button('reset');
        }
        else if(error === 0)
        {
            var infoInstall = data.infoInstall;
            $('#msg').addClass('success');
            $('#msg').html(data.msg);
            $('.progress-bar').css("width","60%");
            $('.progress-bar').html("60%");
            setTimeout(installDatabaseStep4(infoInstall), 1000);
        }else{
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data.msg);
            $('#submit-install').button('reset');
        }

    })
    .fail(function() {
        $('#msg').removeClass('success');
        $('#msg').addClass('error');
        $('#msg').html('{{ trans('install.database.error_3') }}');
        $('#submit-install').button('reset');
    })
}

function installDatabaseStep4(infoInstall){
    $.ajax({
        url: 'install.php{{ $path_lang }}',
        type: 'POST',
        dataType: 'json',
        data: {step: 'step2-4', 'infoInstall':infoInstall},
    })
    .done(function(data) {

         error= parseInt(data.error);
        if(error != 1 && error !=0){
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data);
            $('#submit-install').button('reset');
        }
        else if(error === 0)
        {
            var infoInstall = data.infoInstall;
            $('#msg').addClass('success');
            $('#msg').html(data.msg);
            $('.progress-bar').css("width","75%");
            $('.progress-bar').html("75%");
            setTimeout(installDatabaseStep5(infoInstall), 1000);
        }else{
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data.msg);
            $('#submit-install').button('reset');
        }

    })
    .fail(function() {
        $('#msg').removeClass('success');
        $('#msg').addClass('error');
        $('#msg').html('{{ trans('install.database.error_4') }}');
        $('#submit-install').button('reset');
    })
}

function installDatabaseStep5(infoInstall){
    $.ajax({
        url: 'install.php{{ $path_lang }}',
        type: 'POST',
        dataType: 'json',
        data: {step: 'step2-5', 'infoInstall':infoInstall},
    })
    .done(function(data) {
         error= parseInt(data.error);
        if(error != 1 && error !=0){
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data);
            $('#submit-install').button('reset');
        }
        else if(error === 0)
        {
            $('#msg').addClass('success');
            $('#msg').html(data.msg);
            $('.progress-bar').css("width","85%");
            $('.progress-bar').html("85%");
            setTimeout(completeInstall, 1000);
        }else{
            $('#msg').removeClass('success');
            $('#msg').addClass('error');
            $('#msg').html(data.msg);
            $('#submit-install').button('reset');
        }

    })
    .fail(function() {
        $('#msg').removeClass('success');
        $('#msg').addClass('error');
        $('#msg').html('{{ trans('install.database.error_5') }}');
        $('#submit-install').button('reset');
    })
}

function completeInstall() {
    $.ajax({
        url: 'install.php{{ $path_lang }}',
        type: 'POST',
        dataType: 'json',
        data: {step: 'step3'},
    })
    .done(function(data) {
         error= parseInt(data.error);
        if(error != 1 && error !=0){
            $('#msg').addClass('error');
            $('#msg').html(data);
            $('#submit-install').button('reset');
        }
        else if(error ===0)
        {
            $('#msg').addClass('success');
            $('#msg').html(data.msg);
            $('.progress-bar').css("width","100%");
            $('.progress-bar').html("100%");
            $('#msg').html('{{ trans('install.complete.process_success') }}');
            setTimeout(function(){ window.location.replace($('#admin_url').val()); }, 1000);
        }else{
            $('#msg').addClass('error');
            $('#msg').html(data.msg);
            $('#submit-install').button('reset');
        }
    })
    .fail(function() {
        $('#msg').removeClass('success');
        $('#msg').addClass('error');
        $('#msg').html('{{ trans('install.complete.error') }}');
        $('#submit-install').button('reset');
    })
}

function validateForm(){
        $("#formInstall").validate({
        rules: {
            "database_host": {
                required: true,
            },
            "database_port": {
                required: true,
                number:true,
            },
            "admin_url": {
                required: true,
            },
            "database_name": {
                required: true,
            },
            "database_user": {
                required: true,
            },
            "admin_user": {
                required: true,
            },
            "admin_password": {
                required: true,
            },
            "admin_email": {
                required: true,
            },
            "timezone_default": {
                required: true,
            },
            "language_default": {
                required: true,
            },
        },
        messages: {
            "database_host": {
                required: "{{ trans('install.validate.database_host_required') }}",
            },
            "database_port": {
                required: "{{ trans('install.validate.database_port_required') }}",
                number: "{{ trans('install.validate.database_port_number') }}",
            },
            "admin_url": {
                required: "{{ trans('install.validate.admin_url_required') }}",
            },
            "database_name": {
                required: "{{ trans('install.validate.database_name_required') }}",
            },
            "database_user": {
                required: "{{ trans('install.validate.database_user_required') }}",
            },
            "admin_user": {
                required: "{{ trans('install.validate.admin_user_required') }}",
            },
            "admin_password": {
                required: "{{ trans('install.validate.admin_password_required') }}",
            },
            "admin_email": {
                required: "{{ trans('install.validate.admin_email_required') }}",
            },
            "timezone_default": {
                required: "{{ trans('install.validate.timezone_default_required') }}",
            },
            "language_default": {
                required: "{{ trans('install.validate.language_default_required') }}",
            }
            
        }
    }).valid();
}

</script>

</body>
</html>

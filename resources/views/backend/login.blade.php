<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> Login {{ config('APP_NAME', "novoye-vremya.com") }} admin - azDesign.ws </title>

    <!-- Bootstrap -->
    <link href="/backend/login/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/backend/login/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/backend/login/css/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="/backend/login/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/backend/login/css/custom.min.css" rel="stylesheet">
</head>

<body class="login" style="background-image: url('/backend/login/login.png')">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form action="{{ Route("admin.signin") }}" method="post">
                    {{ csrf_field() }}
                    <h1>Admin</h1>
                    <div> <input type="email" class="form-control" name="email" placeholder="Email" required="" /> </div>
                    <div> <input type="password" class="form-control" name="pass" placeholder="Password" required="" /> </div>
                    <div>
                        <button type="submit" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">
                            Daxil ol
                        </button>
                        <br>
                    </div>

                    <div class="clearfix"></div>

                </form>

                <div class="separator">


                    <div class="clearfix"></div>

                    <div>
                        <p>©{{ date('Y') }} {{ config('APP_NAME', "novoye-vremya.com") }}  All Rights Reserved. </p>
                    </div>
                </div>
            </section>
        </div>

    </div>
</div>




</body>
</html>
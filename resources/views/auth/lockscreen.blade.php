<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" href="{{asset('/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ setting('site.title') }} - {{ setting('site.description') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/light-bootstrap-dashboard.css')}}" rel="stylesheet" />
    @toastr_css
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{asset('/css/demo.css')}}" rel="stylesheet" />
</head>

<body>
    <div class="wrapper wrapper-full-page">

        <div class="full-page lock-page" data-color="black" data-image="{{asset('/img/full-screen-image-3.jpg')}}">
            <!--   you can change the color of the filter page using: data-color="blue | azure | green | orange | red | purple" -->
            <div class="content">
                <div class="container">
                    <div class="col-md-4 ml-auto mr-auto">
                        <form action="{{route('unlock')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="card card-lock text-center card-plain">
                                <div class="card-header ">
                                    <div class="author">
                                        <img class="avatar" src="{{ Voyager::image(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}">
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <h4 class="card-title">{{ Auth::user()->name }}</h4>
                                    <div class="form-group">
                                        <input type="password" name="password" placeholder="Digite sua senha" class="form-control" autofocus required>
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <button class="btn btn-info btn-round">Desbloquear</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</body>
<!--   Core JS Files   -->
<script src="{{asset('/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{asset('/js/light-bootstrap-dashboard.js')}}" type="text/javascript"></script>
<!-- Light Dashboard DEMO methods, don't include it in your project! -->
<script src="{{asset('/js/demo.js')}}"></script>

@toastr_js
@toastr_render

<script>
    $(document).ready(function() {
        demo.checkFullPageBackgroundImage();

        setTimeout(function() {
            // after 1000 ms we add the class animated to the login/register card
            $('.card').removeClass('card-hidden');
        }, 700)
    });
</script>

</html>

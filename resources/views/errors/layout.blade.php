<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html, body {
            height: 100%;
        }
        .bg-image {
            /* The image used */
            background-image: url("https://images.unsplash.com/photo-1534190239940-9ba8944ea261?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format");

            /* Add the blur effect */
            filter: blur(8px);
            -webkit-filter: blur(8px);

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .bg-text {
            font-family: 'Nunito', sans-serif;
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0, 0.6); /* Black w/opacity/see-through */
            color: white;
            font-weight: bold;
            border: 3px solid #f1f1f1;
            border-radius: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 60%;
            padding: 20px;
            text-align: center;
        }

        * {
            box-sizing: border-box;
        }
    </style>
</head>
<body>
<div class="bg-image"></div>
<div class="bg-text">
    @yield('message')
</div>
</body>
</html>

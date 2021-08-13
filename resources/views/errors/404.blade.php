<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>404</title>
    <link href="{{mix('/css/app-front.css')}}" rel="stylesheet">

    <!-- Styles -->
    <style>
        .bg-404{
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: left;
        }
        .full-height {
            height: 100vh;
        }
        .flex-center {
            padding: 12vw 7vw;
        }
        .position-ref {
            position: relative;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .title {
            font-size: 40px;
            line-height: 1;
            margin-bottom: 69px;
        }
        .title p{
            font-size: 80px;
        }
    </style>
</head>
<body>

<div class="flex-center position-ref full-height">
    <img src="/img/404.jpg" alt="" class="bg-404">
    <div class="content">
        <div class="title">
            <p>404</p>
            {{__('Sorry')}}<br>
            {{__('page not found')}}
        </div>
        <a href="/" class="btn btn_green">{{__('Back to Home')}}</a>
    </div>
</div>
</body>
</html>

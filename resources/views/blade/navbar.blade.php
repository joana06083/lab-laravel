<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="{{ url('css/main.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light container-fluid" style="position: fixed;">
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/" style="color:black;">Home</a>
                </li>
            </ul>
            <div>
            @section('loginnav')

                @if(!empty($LoggedUserInfo))
                <label>Hi! {{$LoggedUserInfo->userName}}</label>
                &nbsp;
                @if(!empty($UsrBalance))
                    <a href="transferIndex" class="btn btn-primary">額度：{{$UsrBalance['Balance']}} {{$UsrBalance['Currency']}}</a>
                @endif
                &nbsp;
                <a href="/logout" class="btn btn-secondary" >登出</a>
                @else
                <a href="/register" class="btn btn-primary">註冊</a>
                &nbsp;
                <a href="/login" class="btn btn-secondary">登入</a>
                @endif
            @show
            </div>
        </div>
    </nav>
    <br>
    <br>
    <div class="container">
    <br>
    <br>
        @yield('content')
    </div>
</body>
</html>

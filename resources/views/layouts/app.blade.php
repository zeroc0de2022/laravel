<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="with=device-with, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="/css/app.css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    @include('inc.header')
    @if(Request::is("/"))
        @include('inc.hero')
    @endif
    
    
    <div class="container mt-5">   
        @include('inc.messages')
        <div class="row">        
            <div class="col-8">
                @yield('content')
            </div>
            <div class="col-4">
                @include('inc.aside')
            </div>
        </div>
    </div>
    @include('inc.footer')
</body>
</html>
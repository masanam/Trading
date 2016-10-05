<!doctype html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyDYe6YgQqs0HRnu0mkLu5qcBJZ9zwtxUDA"></script>
    <script src="bower_components/angular-pusher/angular-pusher.min.js" type="text/javascript"></script>
    
    <title>Coal Trade</title>
    
    <!-- JS -->
    @foreach (Config::get('assets.jstrade') as $js)
        <script src="{{ $js }}"></script>
    @endforeach

    <!-- CSS -->
    @foreach (Config::get('assets.css') as $css)
        <link rel="stylesheet" href="{{ $css }}">
    @endforeach

</head> 
<!-- declare our angular app and controller --> 
<body ng-app="coaltrade">
        
    <!-- LOADING ICON =============================================== -->
    <!-- show loading icon if the loading variable is set to true -->
    <div class="wrap">
        <div ng-include="'./angular/views/layout/header.view.html'"></div>

        <div class="container-fluid">
            @yield('container')
        </div>
    </div>

    <footer ng-include="'./angular/views/layout/footer.view.html'"></footer>
</body> 
</html>
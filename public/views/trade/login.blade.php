<!DOCTYPE html>
<html>
<head>
  <base href="/">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CoalTrade</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- JS -->
  @foreach (Config::get('assets.jstrade') as $js)
      <script src="{{ $js }}"></script>
  @endforeach

  <!-- CSS -->
  @foreach (Config::get('assets.css') as $css)
      <link rel="stylesheet" href="{{ $css }}">
  @endforeach

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page" ng-app="coaltrade">
<div ng-include="'./angular/views/layout/header.view.html'"></div>
  @yield('container')


<!-- /.login-box -->




</body>
</html>

<!DOCTYPE html>
<html>
<head>
  <base href="/">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Coal Trade</title>
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

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page sidebar-collapse skin-blue sidebar-mini" ng-app="coaltrade">
<div ng-include="'./angular/views/layout/header_lte.view.html'"></div>
<div ng-include="'./angular/views/layout/sidebar.view.html'"></div>
  @yield('container')

</body>
</html>

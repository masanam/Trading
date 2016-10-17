<!DOCTYPE html>
<html>
<head>
  <base href="/">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CoalTrade</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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
<body class="hold-transition skin-blue login-page fixed sidebar-mini" ng-app="coaltrade"
    ng-class="collapse ? 'sidebar-collapse' : ''" ng-controller="LayoutController" ng-init="collapse = true">
  <div class="wrapper" style="min-height: 100vh;">
    <div ng-static-include="'./angular/core/views/layout/header.view.html'" ng-controller="AuthController"></div>
    <div ng-static-include="'./angular/core/views/layout/sidebar.view.html'" ng-controller="AuthController" ng-show="Authentication.user"></div>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="overflow: auto; min-height: 100vh;">
      @yield('container')
    </div>
  </div>

  <!-- JS -->
  @foreach (Config::get('assets.jstrade') as $js)
      <script src="{{ $js }}"></script>
  @endforeach
  <script src="http://maps.google.com/maps/api/js?key=AIzaSyDYe6YgQqs0HRnu0mkLu5qcBJZ9zwtxUDA&libraries=placeses,visualization,drawing,geometry,places"></script>
  <script src="node_modules/chart.js/Chart.min.js"></script>
  <script src="node_modules/angular-chart.js/dist/angular-chart.min.js"></script>
</body>
</html>

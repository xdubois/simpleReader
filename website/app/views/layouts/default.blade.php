<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>
    @section('title')
    simepleReader
    @show
  </title>
  <meta name="viewport" content="initial-scale=1.0, width=device-width" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
  <!-- Latest compiled and minified JavaScript -->
  {{ HTML::style('assets/css/style.css') }}
</head>
<body>
 <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">SimpleReader</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <!-- <li class="active"><a href="#">Home</a></li> -->
        <li><a href="{{ route('simple') }}">feeds</a></li>
        @if (Sentry::check())
        <li><a href="{{ route('logout') }}">logout</a></li>
        @endif
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>

<div class="container">

  <div class="row">
    <div class="span12">
      @include('layouts.notifications')
    </div>
  </div>
  @yield('content')

</div><!-- /.container --> 
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
{{ HTML::script('assets/js/script.js') }}
@yield('js')
</body>
</html>
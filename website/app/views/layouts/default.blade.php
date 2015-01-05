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
  {{ HTML::style('assets/css/style.css') }}
</head>
<body>
 <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container-fluid">
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
          <li><a href="{{ route('feed.index') }}">feeds</a></li>
        @if (Sentry::check())
          <li><a href="{{ route('user.index') }}">settings</a></li>
          <li><a href="{{ route('logout') }}">logout</a></li>
        @endif
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</div>
<div class="container-fluid"> 

<div class="row-fluid">
  <div class="col-md-2"> 
  @if(Sentry::check())
    <div data-spy="affix" id="user-navbar">
      {{ $navbar }}
    </div>
  @endif
  </div>
  <div class="col-md-10">
  @include('layouts.notifications')
  @yield('content')
  </div>
</div>
</div>

</div><!--/.fluid-container-->


<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
{{ HTML::script('assets/js/waypoints.min.js') }}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
{{ HTML::script('assets/js/script.js') }}
@yield('js')
</body>
</html>
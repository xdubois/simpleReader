@extends('layouts.default')

@section('title')

@stop

@section('content')

<div class="row">
<div class="page-header">
  <h3>Sign in into your account</h3>
</div>
  {{ Form::open(array('route' => 'signup')) }}
  <!-- Email -->
  <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {{ Form::label('email', Lang::get('auth.email')) }}
    {{ Form::text('email', null, ['class' => 'form-control']) }}
    {{ $errors->has('email') ? '<p class="error">' . $errors->first('email') .'</p>' : '' }}
  </div>
  <!-- Password -->
  <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {{ Form::label('password', Lang::get('auth.password')) }}
    <input type="password" id="password" name="password" class="form-control" />
    {{ $errors->has('password') ? '<p class="error">' . $errors->first('password') .'</p>' : '' }}
  </div>

    <!-- Password -->
  <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {{ Form::label('password_confirm', Lang::get('auth.password')) }}
    <input type="password" id="password_confirm" name="password_confirm" class="form-control" />
    {{ $errors->has('password_confirm') ? '<p class="error">' . $errors->first('password_confirm') .'</p>' : '' }}
  </div>

  <button type="submit" class="btn btn-primary btn-sm">Submit</button>
  {{ Form::close() }}
</div>
@stop

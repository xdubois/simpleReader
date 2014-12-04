@extends('layouts.default')

@section('title')
Account Sign in ::
@parent
@stop

@section('content')

<div class="row">
  <div class="page-header">
    <h3>Sign in into your account</h3>
  </div>
  {{ Form::open(array('route' => 'signin')) }}

  <!-- Email -->
  <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    {{ Form::label('email', 'E-mail') }}
    <input type="text"  class="form-control" name="email" id="email" value="{{ Input::old('email') }}" />
    {{ $errors->has('email') ? '<p class="error">' . $errors->first('email') .'</p>' : '' }}
  </div>

  <!-- Password -->
  <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
    {{ Form::label('password', Lang::get('auth.password')) }}
    <input type="password" id="password" name="password" class="form-control" />
    {{ $errors->has('password') ? '<p class="error">' . $errors->first('password') .'</p>' : '' }}
  </div>

  <button type="submit" class="btn btn-primary btn-sm"> @lang('auth.signin_button') </button>
  <a href="{{ route('forgot-password') }}"> @lang('auth.lost_password')</a>
  {{ Form::close() }}

</form>
</div>
@stop

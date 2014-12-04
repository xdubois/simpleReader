@extends('layouts.default')

@section('title')
Forgot Password ::
@parent
@stop

@section('content')
  <div class="row">
    <div class="page-header">
      <h3>{{ Lang::get('auth.newPassword') }}</h3>
    </div>

    {{ Form::open() }}
    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
      {{ Form::label('password', Lang::get('auth.password')) }}
      {{ Form::password('password', array('class' => $errors->first('password', 'error') .' form-control')) }}
      {{ $errors->has('password') ? '<p class="error">' . $errors->first('password') .'</p>' : '' }}
    </div>

    <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
      {{ Form::label('password_confirm', Lang::get('auth.password_confirm')) }}
      {{ Form::password('password_confirm', array('class' => $errors->first('password_confirm', 'error') .' form-control')) }}
      {{ $errors->first('password_confirm', '<span class="help-block">:message</span>') }}
    </div>
    <button type="submit" class="btn btn-primary btn-sm"> @lang('auth.validate') </button>
    {{ Form::close() }}
  </div>
@stop

@extends('layouts.default')

@section('title')
Forgot Password ::
@parent
@stop

@section('content')
  <div class="row">
    <div class="page-header">
      <h3>{{ Lang::get('auth.lost_password') }}</h3>
    </div>

    {{ Form::open() }}
    <!-- Email -->
    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
      {{ Form::label('email', 'E-mail') }}
      {{ Form::email('email', '', array('class' => $errors->first('email', 'error') .' form-control' )) }}
      {{ $errors->has('email') ? '<p class="error">' . $errors->first('email') .'</p>' : '' }}
    </div>
    <button type="submit" class="btn btn-primary btn-sm"> @lang('auth.validate') </button>
    {{ Form::close() }}
  </div>
@stop

@extends('layouts.default')

@section('title')

@parent
@stop


@section('content')
<div class="span12">
  <h2>@lang('user.stats')</h2>
  <table class="table hover">
      <tr><td>@lang('user.synchroCode') </td><td>{{ $user->synchroCode }}</td></tr>
      <tr><td>@lang('user.articleReaded') </td><td>{{ $user->articleReaded }}</td></tr>
      <tr><td>@lang('user.articleDownload') </td><td>{{ $user->aricleDownloaded}}</td></tr>
      <tr><td>@lang('user.articleClicked') </td><td>{{ $user->articleClicked }}</td></tr>
  </table>
</div>

<div class="span12">
  <h2>{{ Lang::get('user.title') }} </h2>
  {{ Form::open(array('route' => 'user.store')) }}
  <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    {{ Form::label('cache_max', Lang::get('user.cache_max') ) }}
    {{ Form::text('cache_max', $user->articleCacheMax, ['class' => 'form-control']) }}
    {{ $errors->has('cache_max') ? '<p class="error">' . $errors->first('cache_max') .'</p>' : '' }}

  </div>
  <button type="submit" class="btn btn-primary btn-sm"> @lang('user.validate') </button>

  {{ Form::close() }}
</div>

@stop
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

<div class="span12">
  <h2>@lang('user.category')</h2>
  <table class="table hover">
    <thead>
      <th>Name</th>
      <th></th>
    </thead>
    @foreach ($categories as $category)  
    <tr>
      <td>{{ Form::text('name', $category->name, ['class' => 'form-control'])}} </td>
      <td>
       <a href="{{ route('feed.destroy', $category->id) }}">update</a>
       <a href="{{ route('category.destroy', $category->id) }}">delete</a>
      </td>
    </tr>
    @endforeach
  </table>
</div>

<div class="span12">
  <h2>@lang('user.categoryAdd')</h2>
  {{ Form::open(array('route' => 'category.store')) }}
  <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {{ Form::label('name', Lang::get('category.name') ) }}
    {{ Form::text('name', null, ['class' => 'form-control']) }}
    {{ $errors->has('name') ? '<p class="error">' . $errors->first('name') .'</p>' : '' }}
  </div>
  <button type="submit" class="btn btn-primary btn-sm"> @lang('category.validate') </button>
  {{ Form::close() }}
</div>

@stop
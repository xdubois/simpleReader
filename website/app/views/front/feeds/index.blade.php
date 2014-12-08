@extends('layouts.default')

@section('title')

@parent
@stop


@section('content')
<div class="span12">
  <h2>Add feed</h2>
  {{ Form::open(array('route' => 'feed.store')) }}
  <div class="form-group {{ $errors->has('url') ? 'has-error' : ''}}">
    {{ Form::label('url', Lang::get('feed.url') ) }}
    {{ Form::text('url', null, ['class' => 'form-control']) }}
    {{ $errors->has('url') ? '<p class="error">' . $errors->first('url') .'</p>' : '' }}
  </div>
  <div class="form-group">
    {{ Form::select('category', $categories, null, ['class' => 'form-control']) }}
  </div>
  <button type="submit" class="btn btn-primary btn-sm"> @lang('auth.signin_button') </button>

  {{ Form::close() }}

</div>


<div class="span12">
  <h2>Feeds</h2>
  <table class="table hover">
    <thead>
      <th>Name</th>
      <th>description</th>
      <th>website</th>
      <th>url</th>
      <th>category</th>
      <th>Last Update</th>
    </thead>
    @foreach ($feeds as $feed)  
    <tr>
      <td>{{ $feed->name }} </td>
      <td>{{ $feed->description }} </td>
      <td>{{ $feed->website }} </td>
      <td>{{ $feed->url }} </td>
      <td>{{ $feed->category == null ? '' : $feed->category->name }} </td>
      <td>{{ $feed->lastUpdate }} </td>
    </tr>

    @endforeach
  </table>
</div>

@stop
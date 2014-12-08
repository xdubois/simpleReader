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
  <div id="ajax"></div>
  <table class="table hover">
    <thead>
      <th>Name</th>
      <th>description</th>
      <th>website</th>
      <th>url</th>
      <th>category</th>
      <th>Last Update</th>
      <th></th>
    </thead>
    @foreach ($feeds as $feed)  
    <tr data-update-category-url="{{ route('ajax.update.category') }}" data-feed-id="{{ $feed->id }}">
      <td>{{ $feed->name }}</td>
      <td>{{ Str::limit($feed->description, 30) }}</td>
      <td>{{ $feed->website }}</td>
      <td>{{ $feed->url }}</td>
      <td>  {{ Form::select('category', $categories, $feed->category == null ? '' : $feed->category->id, ['class' => 'form-control category-update', 'data-feed-id' => $feed->id]) }} </td>
      <td>{{ $feed->lastUpdate }}</td>
      <td><a href="{{ route('feed.destroy', $feed->id) }}">delete</a></td>
    </tr>

    @endforeach
  </table>
</div>

@stop
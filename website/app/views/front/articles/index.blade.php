@extends('layouts.default')

@section('title')

@parent
@stop


@section('content')

<div id="ajax-url" data-favorite="{{ route('ajax.toggle.favorite') }}" data-read="{{ route('ajax.toggle.read') }}"  data-set-read="{{ route('ajax.article.read') }}" >
</div>
<div class="span12">
  <h2>Title</h2>
@foreach ($items as $item)  
<div class="article" id="{{ $item->id }}">    
  <div class="row-fluid">
      <div class="span9">
          <h2>
            <a href="{{ $item->link }}" class="item-click" style="" target="_blank">
              {{ $item->title }}
            </a>   
          </h2>
         <p> {{ $item->content }} </p>
      </div>

      <div class="row-fluid">
            <div class="span6">
              @if($item->favorite)
                <span class="glyphicon glyphicon-star togglefavorite"> </span>
              @else
                <span class="glyphicon glyphicon-star-empty togglefavorite"></span>
              @endif
              Favorite
              @if($item->unread)
                <input type="checkbox" checked="checked" class="toggleread" />
              @else
                <input type="checkbox" class="toggleread" />
              @endif
              Keep Unread

            <div class="span3">
            <p class="text-right"><em>{{ $item->creator .' '. Carbon\Carbon::parse($item->pubDate)->format('d-m-Y : h:s')  }} </em></p>
            </div>
          </div>
      </div>
      <hr />
  </div>
</div>
<div class="row-fluid">
  <div id="margin-item">
    <p class="muted text-center">You have no more items.</p>
  </div>
</div>
@endforeach

@stop
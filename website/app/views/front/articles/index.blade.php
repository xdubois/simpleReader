@extends('layouts.default')

@section('title')

@parent
@stop


@section('content')

@if (!$items->isEmpty())
<div id="ajax-url" data-favorite="{{ route('ajax.toggle.favorite') }}" data-read="{{ route('ajax.toggle.read') }}"  data-set-read="{{ route('ajax.article.read', $items->first()->id) }}" data-set-all-read="{{ route('ajax.set.articles.read', $id) }}" data-item-click="{{ route('ajax.item.click')}}">
</div>
@endif
<div class="span12">
@if (is_numeric($id))
<button type="button" class="btn btn-default btn-sm mark-all-read">
    <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Mark all as readed
  </button>
@endif

@foreach ($items as $item)  
<div class="article" id="{{ $item->id }}" data-toggled="0">    
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
              @lang('article.favorite')

              @if($item->unread == NULL || $item->unread == TRUE)
              <button type="button" class="btn btn-default btn-xs toggleread" value="0">
                @lang('article.read')
              </button>
              @else
              <button type="button" class="btn btn-default btn-xs toggleread" value="1">
                @lang('article.unread')
              </button>
              @endif
             



            <div class="span3">
            <p class="text-right paddingRight"><em>{{ $item->creator .' '. Carbon\Carbon::parse($item->pubDate)->format('d-m-Y : h:s')  }} </em></p>
            </div>
          </div>
      </div>
  </div>
</div>
@endforeach
<div class="row-fluid">
  <div id="margin-item">
    <p class="muted text-center">no more items.</p>
  </div>
</div>
@stop
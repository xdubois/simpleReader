@extends('layouts.default')

@section('title')

@parent
@stop


@section('content')

  
<div class="span12">
  <h2>Title</h2>
@foreach ($items as $item)  
<div class="dubois-post" id="item-id">    
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
          <span class="glyphicon glyphicon-star"> </span>
          <span class="glyphicon glyphicon-star-empty"></span> 
          Favorite

          <input type="checkbox" checked="checked" class="unread" />
          Keep Unread

        <div class="span3">
        <p class="text-right"><em>{{ $item->creator .' '. Carbon\Carbon::parse($item->pubDate)->format('d-m-Y : h:s')  }} </em></p>
        </div>
    </div>


    </div>
    <hr />
</div>
@endforeach

@stop
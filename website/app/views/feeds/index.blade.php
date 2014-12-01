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
          <a href="{{ $item->get_link() }}" class="item-click" style="" target="_blank">
            {{ $item->get_title() }}
          </a>   
        </h2>
       <p> {{ $item->get_content() }} </p>
    </div>

    <div class="row-fluid">
        <div class="span6">
          <span class="glyphicon glyphicon-star"> </span>
          <span class="glyphicon glyphicon-star-empty"></span> 
          Favorite

          <input type="checkbox" checked="checked" class="unread" />
          Keep Unread

        <div class="span3">
        <p class="text-right"><em>{{ ($item->get_author() === NULL ?: $item->get_author()->name) .' '. $item->get_date() }} </em></p>
        </div>
    </div>


    </div>
    <hr />
</div>
@endforeach

@stop
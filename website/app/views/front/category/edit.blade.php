@extends('layouts.default')

@section('title')

@parent
@stop


@section('content')
<div class="span12">
  <h2>@lang('category.edit')</h2>
  {{ Form::open(array('route' => array('category.update', $category->id))) }}
  <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    {{ Form::label('name', Lang::get('category.name') ) }}
    {{ Form::text('name', $category->name, ['class' => 'form-control']) }}
    {{ $errors->has('name') ? '<p class="error">' . $errors->first('name') .'</p>' : '' }}
  </div>
  <button type="submit" class="btn btn-primary btn-sm"> @lang('category.validate') </button>
  {{ Form::close() }}
</div>

@stop
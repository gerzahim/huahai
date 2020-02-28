@extends('modal')
@section('content')
<div class="modal-dialog">
  <div class="modal-content">
    {!! Form::open(['route' => ['products.store'], 'class' => 'ajax-submit']) !!}
    <div class="modal-body">
      @if (count($errors) > 0) {!! form_errors($errors) !!}
      @endif
      @include('products.partials._form')
    </div>
    <div class="modal-footer">
      {!! form_buttons() !!}
    </div>
    {!! Form::close() !!}
  </div>
</div>
@stop

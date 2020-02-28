@extends('modal')
@section('content')
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h5 class="modal-title">{{trans('application.select_product')}}</h5>
    </div>
    <div class="modal-body">
      <a href="{{ route('products.create') }}" class="btn btn-primary btn-xs" data-toggle="ajax-modal"> <i class="fa fa-plus"></i> {{trans('application.new_product')}}</a>
      <table class="table table-bordered table-striped table-hover datatable">
        <thead class="item-table-header">
          <tr>
            <th></th>
            <th>Image</th>
            <th>{{trans('application.name')}}</th>
            <th>{{trans('application.code_product')}}</th>
            <th>{{trans('application.category')}}</th>
            <th>{{trans('application.price')}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr>
            <td> {!! Form::checkbox('products_lookup_ids[]',$product->uuid) !!}</td>
            <td>
              @if($product->image != '')
                <a href="#" data-toggle="popover" data-trigger="hover" title="{{ $product->name }}" data-html="true" data-content="{{HTML::image(asset('assets/img/uploads/product_images/'.$product->image), 'image') }}">{!! HTML::image(asset('assets/img/uploads/product_images/'.$product->image), 'image', array('style'=>'width:50px')) !!}</a>
                @else {!! HTML::image(asset('assets/img/uploads/product_images/no-product-image.png'), 'image', array('style'=>'width:50px')) !!}
                @endif
            </td>
            <td>{{ $product->name }} </td>
            <td>{{ $product->code }} </td>
            <td>{{ $product->category->name }} </td>
            <td>{{ format_amount($product->price) }} </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      {!! Form::button('Add Product',['class'=>'btn btn-xs btn-success pull-left', 'id'=>'select-products-confirm'] ) !!} {!! Form::button('Cancel',['class'=>'btn btn-xs btn-danger','data-dismiss'=>'modal'] ) !!}
    </div>
  </div>
</div>
<style>
  td,
  th {
    word-break: break-all;
  }
</style>
@stop

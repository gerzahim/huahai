<div class="row">
  <br>
  <div class="col-md-12">
    <div class="form-group">
      {!! Form::label('name', trans('application.product_name').'*') !!} {!! Form::text('name', null, ['class' => 'form-control input-sm', 'required']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('code', trans('application.code').'*') !!} {!! Form::text('code', null, ['class' => 'form-control input-sm', 'required']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('model', 'Model, Part Number BBB') !!} {!! Form::text('model', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('brand', trans('application.brand')) !!} {!! Form::text('brand', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('dimension', 'Dimension') !!} {!! Form::text('dimension', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('weight', 'Weight (Kg)') !!} {!! Form::text('weight', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('category_id', trans('application.category')) !!}
      <div class="input-group col-sm-12">
        {!! Form::select('category_id',$categories,null, ['class' => 'form-control input-sm chosen']) !!}
        <span class="input-group-addon">
                    <a href="{{ route('product_category.create') }}" data-toggle="ajax-modal"><i class="fa fa-plus"></i></a>
                </span>
      </div>
    </div>
    {{-- <div class="form-group">
      {!! Form::label('price', trans('application.unit_price').'*') !!} {!! Form::input('number','price', null, ['class' => 'form-control input-sm', 'pattern'=>'^\d+(\.\d{2})?$', 'min'=>'0','step'=>'0.01']) !!}
    </div> --}}
    <div class="form-group">
      {!! Form::label('product_image', 'Product Image ('.trans('application.width').': 200)') !!}
      @if(isset($product) && $product->image != '') {!! HTML::image(asset('assets/img/uploads/product_images/'.$product->image), 'image', array('class' => 'thumbnail')) !!}
      @endif
      <div class=" form-group input-group input-file" style="margin-bottom: 10px;">
        <div class="form-control input-sm"></div>
        <span class="input-group-addon">
                    <a class='btn btn-sm btn-primary' href='javascript:;'>
                        {{ trans('application.browse') }}
                        <input type="file" name="product_image" id="product_image" onchange="$(this).parent().parent().parent().find('.form-control').html($(this).val());">
                    </a>
                </span>
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('description', trans('application.product_description')) !!} {!! Form::textarea('description',null, ['class' => 'form-control input-sm', 'rows'=>5]) !!}
    </div>
  </div>
</div>

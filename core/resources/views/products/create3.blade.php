@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-cogs"></i> New Product</h1>
</div>
<section class="content">
  <div class="row">
    <div class="col-md-2">
      &nbsp;
    </div>
    <div class="col-md-8">
      <div class="box box-primary">
        <div class="box-body">
          {{--
          <!--
                    {!! Form::open(['route' => ['products.store'], 'files'=>true]) !!}
                -->
          --}}

          @if (isset($errors) && count($errors) > 0) {!! form_errors($errors) !!}
          @endif
          <form action="{{ route('products.store') }}" method="post" id="create-form" enctype="multipart/form-data">
            {{--
            <!--
                <div class="form-group">
                    <div class="col-sm-12">
                          <div class="col-sm-6">
                                {!! Form::label('name', trans('application.name').'*') !!}
                                {!! Form::text('name', null, ['class' => 'form-control input-sm', 'required']) !!}
                          </div>
                          <div class="col-sm-6">
                                {!! Form::label('code', trans('application.code').'*') !!}
                                {!! Form::text('code', null, ['class' => 'form-control input-sm', 'required']) !!}
                          </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                          <div class="col-sm-6">
                                {!! Form::label('mSodel', 'Model*') !!}
                                {!! Form::text('model', null, ['class' => 'form-control input-sm', 'required']) !!}
                          </div>
                          <div class="col-sm-6">
                                {!! Form::label('category_id', 'Categories*') !!}
                                {!! Form::select('category_id',$categories,null, ['class' => 'form-control input-sm chosen']) !!}
                          </div>
                    </div>
                </div>

                -->
            --}}
            <div class="form-group">
              {!! Form::label('name', trans('application.product_name').'*') !!} {!! Form::text('name', null, ['class' => 'form-control input-sm', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('code', trans('application.code').'*') !!} {!! Form::text('code', null, ['class' => 'form-control input-sm', 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::label('model', 'Model, Part Number') !!} {!! Form::text('model', null, ['class' => 'form-control input-sm']) !!}
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
              {!! Form::label('category_id', 'Categories*') !!} {!! Form::select('category_id', $categories,null, ['class' => 'form-control input-sm chosen']) !!} {{--
              <!--
                        {!! Form::select('size', ['L' => 'Large', 'S' => 'Small'], null, ['class' => "form-control input-sm"]) !!}
                    -->
              --}}
            </div>
            <div class="form-group">
              {!! Form::label('quantity', 'Quantity') !!} {!! Form::input('number','quantity', '', ['class' => 'form-control input-sm', 'min'=>'0','step'=>'1']) !!}

            </div>
            {{-- <div class="form-group">
              {!! Form::label('price', trans('application.unit_price').'*') !!} {!! Form::input('number','price', '0.00', ['class' => 'form-control input-sm', 'pattern'=>'^\d+(\.\d{2})?$', 'min'=>'0','step'=>'0.01']) !!}

            </div> --}}
            <div class="form-group">
              <label for="card-name">Product Image (Width: 200)</label>
              <input type="file" id="imagepath" name="imagepath" accept="image/*">
            </div>

            <div class="form-group">
              {!! Form::label('description', trans('application.product_description')) !!} {!! Form::textarea('description',null, ['class' => 'form-control input-sm', 'rows'=>5]) !!}
            </div>


            {{ csrf_field() }}
            <div class="form-group">
              {!! Form::submit(trans('Save'), ['class' => "btn btn-primary btn-sm"]) !!}
            </div>
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</section>
@stop
@section('scripts')

@stop
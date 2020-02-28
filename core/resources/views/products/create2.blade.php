@extends('app')
@section('content')
<div class="col-md-12 content-header">
  <h1><i class="fa fa-cogs"></i> New Product </h1>
</div>

<section class="content">
  <div class="row">


    <div class="box box-primary">
      <div class="box-body">

        {!! Form::open(['route' => ['products.store'], 'class' => 'ajax-submit']) !!}



        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        <div class="row">&nbsp;
        </div>

        <div class="row">
          <div class="col-sm-2">
          </div>

          <div class="col-sm-8">

            <div class="col-sm-6">
              <label for="email">Email address:</label>
              <input type="email" class="form-control" id="email">
            </div>

            <div class="col-sm-6">
              <label for="pwd">Password:</label>
              <input type="password" class="form-control" id="pwd">
            </div>


          </div>
          <div class="col-sm-2">
          </div>
        </div>

        {!! Form::close() !!}
      </div>
    </div>


  </div>


</section>
@stop {{--

@if(Session::has('success'))
<div class="col-sm-6 col-md-4 col-md-offset-4 col-sm-offset-3">
  <div id="charge-message" class="alert alert-success">
    {{ Session::get('success') }}
  </div>
</div>
@endif --}}

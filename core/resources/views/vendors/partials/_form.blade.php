<div class="row">
  <div class="col-md-6">
    <div class="form-group">
      {!! Form::label('vendor_no', 'Vendor Number*') !!} {!! Form::text('vendor_no', isset($client_num) ? $client_num : null, ['class' => 'form-control input-sm', 'required']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('name', trans('application.name').'*') !!} {!! Form::text('name', null, ['class' => 'form-control input-sm', 'required']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('email', trans('application.email').'*') !!} {!! Form::text('email', null, ['class' => 'form-control input-sm', 'required']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('phone', trans('application.phone')) !!} {!! Form::text('phone', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('mobile', trans('application.mobile')) !!} {!! Form::text('mobile', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('address1', trans('application.address_1')) !!} {!! Form::text('address1', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('address2', trans('application.address_2')) !!} {!! Form::text('address2', null, ['class' => 'form-control input-sm']) !!}
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      {!! Form::label('city', trans('application.city')) !!} {!! Form::text('city', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('state', trans('application.state')) !!} {!! Form::text('state', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('postal_code', trans('application.postal_code')) !!} {!! Form::text('postal_code', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('country', trans('application.country')) !!} {!! Form::text('country', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('website', trans('application.website')) !!} {!! Form::text('website', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('contact_person', trans('application.contact_person')) !!} {!! Form::text('contact_person', null, ['class' => 'form-control input-sm']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('notes', trans('application.notes')) !!} {!! Form::textarea('notes', null, ['class' => 'form-control input-sm', 'rows' => '5']) !!}
    </div>
  </div>
</div>

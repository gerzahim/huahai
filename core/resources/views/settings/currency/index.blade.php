@extends('app')@section('content')<div class="col-md-12 content-header" >    <h1><i class="fa fa-usd"></i> {{trans('application.currency')}}</h1></div><section class="content">    <div class="row">        <div class="col-md-3">            @include('settings.partials._menu')        </div>        <div class="col-md-9">            <div class="box box-primary">                <div class="box-body">                    @if (count($errors) > 0)                    {!! form_errors($errors) !!}                    @endif                        {!! Form::button(trans('application.update_exchange_rates'), ['class'=>"btn btn-sm btn-primary",'id'=>"btn_update_exchange_rates"]) !!}                        <table class="table table-striped table-bordered datatable">                        <thead>                        <tr>                            <th></th>                            <th>{{trans('application.name')}}</th>                            <th>{{trans('application.code')}}</th>                            <th>{{trans('application.symbol')}}</th>                            <th>{{trans('application.exchange_rate')}}</th>                            <th>{{trans('application.active')}}</th>                            <th>{{trans('application.default')}}</th>                            <th>{{trans('application.action')}}</th>                        </tr>                        </thead>                        <tbody>                        @if($currencies->count() > 0)                        @foreach($currencies as $currency)                        <tr>                            <td></td>                            <td>{{ $currency->name }}</td>                            <td>{{ $currency->code }}</td>                            <td>{{ $currency->symbol }}</td>                            <td>{{ $currency->exchange_rate }}</td>                            <td>{!! $currency->active  ? '<span class="label label-success">'.trans('application.yes').'</span>' : '<span class="label label-danger">'.trans('application.no').'</span>' !!}</td>                            <td>{!! $currency->default_currency  ? '<span class="label label-success">'.trans('application.yes').'</span>' : '<span class="label label-danger">'.trans('application.no').'</span>' !!}</td>                            <td>                                {!! edit_btn('currency.edit', $currency->uuid) !!}                            </td>                        </tr>                        @endforeach                        @endif                        </tbody>                    </table>                </div>            </div>        </div>    </div></section>@stop @section('scripts')    @include('settings.partials.settings_js')@stop 
@extends('app')
@section('content')
    <div class="col-md-12 content-header" >
        <h1><i class="fa fa-th-large"></i> {{trans('application.couriers')}}</h1>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title pull-right">
                            <div class="box-tools">
                                <a href="{{ route('couriers.create') }}" class="btn btn-primary btn-xs pull-right" data-toggle="ajax-modal"> <i class="fa fa-plus"></i> {{trans('application.new_courier')}}</a>
                            </div>
                        </h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped table-bordered datatable">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{trans('application.name')}}</th>
                                <th>{{trans('application.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($couriers->count() > 0)
                                @foreach($couriers as $courier)
                                    <tr>
                                        <td></td>
                                        <td>{{ $courier->name }}</td>
                                        <td>
                                            {!! edit_btn('couriers.edit', $courier->uuid) !!}
                                            {!! delete_btn('couriers.destroy', $courier->uuid) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

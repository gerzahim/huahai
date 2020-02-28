@extends('modal')
@section('content')
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h5 class="modal-title">Add Files to Product</h5>
        </div>
        {!! Form::model($product, ['route' => ['products.save_files'], 'class' => 'ajax-submit', 'method' => 'POST']) !!}
        <div class="modal-body">
            @if (count($errors) > 0)
            {!! form_errors($errors) !!}
            @endif
            <div class="row">
              <br>
              <div class="col-md-12">
                <div class="form-group">
                    @if ($productFiles->count() >0)
                        <table class="table table-bordered table-striped table-hover ajax_datatable">
                            <thead>
                                <tr>
                                    <th>Existing Files</th>
                                    <th></th>                       
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productFiles as $productFile)
                                    <tr>
                                        <td>
                                            <a href="{{ asset('assets/img/uploads/product_files') }}/{{ $productFile->filename }}" target="_blank" title="Show">{{ $productFile->original_name }}</a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('products.delete_file', $productFile->uuid) }}" class="btn btn-danger btn-xs " data-rel="tooltip" data-placement="top" title="Delete"><i class="fa fa-minus"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            </table>
                    @endif
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                    <label for="card-name">Add File:</label>
                    <input type="file" id="file_product" name="file_product" class="dropify" data-default-file="" required data-max-file-size="2M"/>
                    <input type="hidden" name="product_id"  value="{{ $product->uuid }}" />
                </div>
                </div
            </div>
        </div>
        <div class="modal-footer">
            {!! form_buttons() !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>
<script>
    $(document).ready(function(){
        // Basic
        $('.dropify').dropify();


        // Used events
        var drEvent = $('.dropify-event').dropify();

        drEvent.on('dropify.beforeClear', function(event, element){
            return confirm("Do you really want to delete \"" + element.filename + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element){
            alert('File deleted');
        });
    });
</script>
@stop 

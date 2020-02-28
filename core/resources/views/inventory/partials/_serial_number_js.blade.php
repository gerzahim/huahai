<script type="text/javascript">
$(function(){
    //  Action button add serial nunmber
      $(document).on('click', '.add_serial_number', function(){
        var product_id = "";
        var quantity = "";

        transaction_id = $(this).data('transaction_id');
        transaction_item_id = $(this).data('transaction_item_id');
        product_id = $(this).data('product-id');
        quantity = $(this).data('quantity');

         if (product_id != ""){
             $('.invoice').addClass('spinner');
             var $modal = $('#ajax-modal');

             $.get('{{url("add_serial_number_modal")}}', function(data) {
                 $modal.modal();
                 $modal.html(data);
                 $('.invoice').removeClass('spinner');
                 $('[data-toggle="popover"]').popover();

                 $("#transaction_id").val(transaction_id);
                 $("#transaction_item_id").val(transaction_item_id);
                 $("#product_id").val(product_id);
                 $("#quantity").val(quantity);
             });
         }
      });
    /* ----------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#add-serial-number-confirm', function()
    {
        if ($("#type_serial_single").prop("checked") == true){
            $.ajax({
            url: "{{ url('save_serial_number') }}",
            type: "POST",
            data: {
                "_token":'{{ csrf_token() }}',
                "serial_number" : $("#serial_number").val(),
                "transaction_id" : $("#transaction_id").val(),
                "transaction_item_id" : $("#transaction_item_id").val(),
                "product_id" : $("#product_id").val(),
                "quantity" : $("#quantity").val(),
            },
            success: function (data){
                    $('#ajax-modal').modal('hide'); 
                    swal("Success!", "The serial number has been added.", "success");
                    window.location.reload();
            }
            }); 
        }

         if ($("#type_serial_secuencial").prop("checked") == true){
             var quantity = $("#quantity").val();
             var serial_number_initial = $("#serial_number_initial").val();
             var serial_number_final = $("#serial_number_final").val();
             
            if ((serial_number_final - serial_number_initial) - quantity > 0){
                swal("Error", "You have entered a sequence greater than the number of products.", "error");
            }

            $.ajax({
            url: "{{ url('save_secuencial_serial_number') }}",
            type: "POST",
            data: {
                "_token":'{{ csrf_token() }}',
                "serial_number_initial" : $("#serial_number_initial").val(),
                "serial_number_final" : $("#serial_number_final").val(),
                "transaction_id" : $("#transaction_id").val(),
                "transaction_item_id" : $("#transaction_item_id").val(),
                "product_id" : $("#product_id").val(),
                "quantity" : $("#quantity").val(),
            },
            success: function (data){
                    $('#ajax-modal').modal('hide'); 
                    swal("Success!", "The serial number has been added.", "success");
                    window.location.reload();
            }
            }); 
         }
    });
    /* ----------------------------------------------------------------------------------------------------*/
    $(document).on('click', '.show_serial_number', function(){
        var product_id = "";
        var quantity = "";

        transaction_item_id = $(this).data('transaction_item_id');

         if (transaction_item_id != ""){
             $('.invoice').addClass('spinner');
             var $modal = $('#ajax-modal');

            $.post("{{ url('show_serial_numbers') }}", {
                transaction_item_id : transaction_item_id,
                _token:'{{ csrf_token() }}'
            }).done(function(data){
                 $modal.modal();
                 $modal.html(data);
                 $('.invoice').removeClass('spinner');
                 $('[data-toggle="popover"]').popover();

                 $("#transaction_item_id").val(transaction_item_id);    
            }); 
         }
      });
    /* ----------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#delete-serial-number-confirm', function()
    {
        $.ajax({
           url: "{{ url('delete_serial_number') }}",
           type: "POST",
           data: {
               "_token":'{{ csrf_token() }}',
               "transaction_items_serial_numbers_id" : $("#transaction_items_serial_numbers_id").val(),
           },
           success: function (data){
                $('#ajax-modal').modal('hide'); 
                if (data.success == true){
                    swal("Success!", "The serial number has been deleted.", "success");
                }else{
                    swal("Error", "An error has ocurred. Try again", "error");
                }
                
                window.location.reload();
           }
        });
    });
    
    /* ----------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#type_serial_single', function(){
        if ($("#type_serial_single").prop("checked") == true){
            $(".secuencial").addClass('hidden');
            $(".single").removeClass('hidden');
        }
    });

    $(document).on('click', '#type_serial_secuencial', function(){
        if ($("#type_serial_secuencial").prop("checked") == true){
            $(".single").addClass('hidden');
            $(".secuencial").removeClass('hidden');
        }
    });

});
</script>

<script type="text/javascript">
$(function(){
    $('tr.item select').chosen({width:'100%'});
    $( document ).on("click change paste keyup", ".calcEvent", function() {
        calcTotals();
    });
    $('.text_editor').wysihtml5({image:false,link:false});

    //  Action button remove items
    $(document).on('click', '.delete_row', function(){
        $(this).parents('tr').remove();
        calcTotals();
    });

    $('#btn_product_list_modal').click(function() {
        $('.invoice').addClass('spinner');
        var $modal = $('#ajax-modal');
        $.get('{{url("products_modal")}}', function(data) {
            $modal.modal();
            $modal.html(data);
            $('.invoice').removeClass('spinner');
            var t = $('.datatable').DataTable({
                "columnDefs": [ {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                } ],
                "order": [[ 1, 'asc' ]],
                "bLengthChange": false,
                "bInfo" : false,
                "filter" : true,
                'paging': false,
                "oLanguage": { "sSearch": "Search: "}
            });
            $('div.dataTables_filter input').addClass('form-control input-sm');
            $('[data-toggle="popover"]').popover();
        });
    });

    /* ----------------------------------------------------------------------------------------------------
     ADDING SELECTED PRODUCTS TO THE CHECKIN
     --------------------------------------------------------------------------------------------------------*/
    $(document).on('click', '#select-products-confirm', function()
    {
        var products_lookup_ids = [];
        $("input[name='products_lookup_ids[]']:checked").each(function ()
        {
            products_lookup_ids.push($(this).val());
        });
        $.post("{{ url('process_products_selections') }}", {
            products_lookup_ids : products_lookup_ids,_token:'{{ csrf_token() }}'
        }).done(function(data){
            var products = data.products;
            for(var key in products) {
                
                //  Validate Quantity
                $.ajax({
                    url: "{{ url('checkProduct') }}",
                    type: "POST",
                    data: {
                        "_token":'{{ csrf_token() }}',
                        "productId" : products[key].uuid,
                    },
                    success: function (data){
                        var last_row = $('#item_table tr:last');
                        if (last_row.find('input:text[name="item_name[]"]').val() !== '')
                        {
                            cloneRow('item_table');
                            var last_row = $('#item_table tr:last');

                            last_row.find('input[name=image]').val(products[key].image);
                            last_row.find('input:text[name="product_id[]"]').val(products[key].uuid);
                            last_row.find('input:text[name="item_name[]"]').val(products[key].name);
                            last_row.find('textarea[name=item_description]').val(products[key].description);
                            last_row.find('input:input[name="quantity[]"]').val('1');
                        }
                        else
                        {
                            last_row.find('input[name=image]').val(products[key].image);
                            last_row.find('input:text[name="product_id[]"]').val(products[key].uuid);
                            last_row.find('input:text[name="item_name[]"]').val(products[key].name);
                            last_row.find('textarea[name=item_description]').val(products[key].description);
                            last_row.find('input:input[name="quantity[]"]').val('1');
                        }
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        if (textStatus == "error"){
                            swal({
                                title: "Error!",
                                text: "Product "+products[key].name+" do not have inventory in stock.",
                                type: "error",
                            });
                            return false;
                        }
                    }
                }); 

                $('#modal-choose-products').modal('hide');
                //calcTotals();
            }
        }).always(function(){
            $('#ajax-modal').modal('toggle');
        });
    });
});

function calcTotals(){
    var subTotal    = 0;
    var total       = 0;
    var totalTax    = 0;

    $('tr.item').each(function(){
        var quantity    = parseFloat($(this).find("[name='quantity']").val());
    });
    total    += parseFloat(subTotal+totalTax);
    $( '#subTotal' ).text(subTotal.toFixed(2));
    $( '#taxTotal' ).text(totalTax.toFixed(2));
    $( '#grandTotal' ).text(total.toFixed(2));
}
var count = "1";

function cloneRow(in_tbl_name)
{

    var tbody = document.getElementById(in_tbl_name).getElementsByTagName("tbody")[0];
    // create row
    var row = document.createElement("tr");
    // create table cell 1
    var td1 = document.createElement("td");
    var strHtml1 = "<span class='btn btn-danger btn-xs delete_row'><i class='fa fa-minus'></i></span> ";
    td1.innerHTML = strHtml1.replace(/!count!/g,count);

    // // create table cell 2
    var td2 = document.createElement("td");
    var strHtml2 = '<div class="form-group">{!! Form::text("item_name[]", null, ["class" => "form-control input-sm item_name", "id"=>"item_name" , "required", "readonly"]) !!}{!! Form::text("product_id[]", null, ["class" => "form-control input-sm item_name hidden", "id"=>"item_name" , "required"]) !!}</div>';
    td2.innerHTML = strHtml2.replace(/!count!/g,count);

    // create table cell 3
    var td3 = document.createElement("td");
    var strHtml3 = '<div class="form-group">{!! Form::input("number","quantity[]", null, ["class" => "form-control input-sm calcEvent quantity text-center", "id"=>"quantity" , "required", "step" => "any", "min" => "0"]) !!}</div> ';
    td3.innerHTML = strHtml3.replace(/!count!/g,count);

    // append data to row
    row.appendChild(td1);
    row.appendChild(td2);
    row.appendChild(td3);

    // add to count variable
    count = parseInt(count) + 1;

    // append row to table
    tbody.appendChild(row);
    row.className = 'item';
    $('tr.item:last select').chosen({width:'100%'});
}
</script>

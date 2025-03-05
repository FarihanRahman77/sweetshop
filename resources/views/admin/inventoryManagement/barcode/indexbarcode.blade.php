@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Barcode
@endsection
@section('content')
    <style type="text/css">

    </style>
   
   <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;">  Barcode Generate </h3>
                </div>
                <form id="barcodegenerateform" method="POST" action="/your-action-url">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label>Select Product <span class="text-danger"> * </span></label>
                            <select class="form-control input-sm" id="productid" name="productid" onchange="getproductpurchaseinfo()">
                                @foreach ($Products as $Product)
                                    <option value="{{ $Product->id }}">{{ $Product->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="productidError"></span>
                        </div>
                        <div class="col-md-3">
                            <label>Date <span class="text-danger"> * </span></label>
                            <input class="form-control input-sm" id="date" type="date" name="date" value="{{ date('Y-m-d') }}">
                            <span class="text-danger" id="nameError"></span>
                        </div>
                        <div class="col-md-3">
                            <label>Quantity</label>
                            <input class="form-control input-sm" id="quantity" type="number" name="quantity" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value === '') this.value = '0';" value="0">
                            <span class="text-danger" id="quantityError"></span>
                        </div>
                        <div class="col-md-2">
                            <label class="text-white">.</label><br>
                            <button type="submit" class="btn btn-primary btnSave mt-2" id="saveDamage">
                                <i class="fa fa-save"></i> Generate Barcode
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </section>
    </div>
       <div class="card-body">
                    <!--data listing table-->
                    <div class="table-responsive">
                        <table  width="100%" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td width="5%" class="text-center">SL#</td>
                                    <td width="10%"  class="text-center">Product</td>
                                    <td width="10%"  class="text-center"> Purchase Date</td>
                                    <td width="12%"  class="text-center">Quantity</td>
                                </tr>
                            </thead >

                            <tbody id="managepurchaseinfo">

                            </tbody>
                        </table>
                        <!--data listing table-->
                    </div>
                </div>
@endsection

@section('javascript')
    <script>
        $(function() {
            $("#productid").select2({
                placeholder: "Select Product",
            
                allowClear: true,
                width: '100%'
            });

           
        });

       
    



 function getproductpurchaseinfo() {
    var productID = $('#productid').val();
    
    $.ajax({
    url: "{{ route('products.productpurchaseinfoget') }}",
    method: "GET",
    data: {
        "productID": productID
    },
    datatype: "json",
    success: function(result) {
        // Clear any existing data in the tbody
        $('#managepurchaseinfo').empty();

        var totalQuantity = 0; // Variable to store the total quantity

        // Check if any data is returned
        if(result.length > 0) {
            // Loop through each item and append a row to the table
            $.each(result, function(index, product) {
                totalQuantity += parseInt(product.quantity); // Accumulate total quantity

                var newRow = `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td class="text-center">${product.name}</td>
                        <td class="text-center">${product.created_date}</td>
                        <td class="text-center">${product.quantity}</td>
                    </tr>
                `;
                $('#managepurchaseinfo').append(newRow);
            });

            // After the loop, append a row for the total quantity
            var totalRow = `
                <tr>
                    <td colspan="3" class="text-right font-weight-bold">Total Quantity:</td>
                    <td class="text-center font-weight-bold">${totalQuantity}</td>
                </tr>
            `;
            $('#managepurchaseinfo').append(totalRow);

        } else {
            // In case no data is found, you can show a message
            $('#managepurchaseinfo').append('<tr><td colspan="4" class="text-center">No purchase data found for this product.</td></tr>');
        }
    },
    error: function(response) {
        alert(JSON.stringify(response));
    },
    beforeSend: function() {
        $('#loading').show();
    },
    complete: function() {
        $('#loading').hide();
    }
});

}


          $("#barcodegenerateform").submit(function(e) {
            e.preventDefault();
         
            var ProductID = $("#productid").val();
            var Purchasedate = $("#date").val();
            var purchaseqty = $("#quantity").val();
            var _token = $('input[name="_token"]').val();
            
            var fd = new FormData();
            fd.append('ProductID', ProductID);
            fd.append('Purchasedate', Purchasedate);
            fd.append('purchaseqty', purchaseqty);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('products.productbarcodegenerate') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                  alert(JSON.stringify(result));
                 
                },
                error: function(response) {
                    alert(JSON.stringify(response));
                
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }

            })
        })

        Mousetrap.bind('ctrl+shift+n', function(e) {
            e.preventDefault();
            if ($('#modal.in, #modal.show').length) {

            } else {
                create();
            }
        });

        function reloadDt() {
            if ($('#modal.in, #modal.show').length) {

            } else if ($('#editModal.in, #editModal.show').length) {

            } else {
                table.ajax.reload(null, false);
            }
        }
        Mousetrap.bind('ctrl+shift+r', function(e) {
            e.preventDefault();
            reloadDt();
        });
        Mousetrap.bind('ctrl+shift+s', function(e) {
            e.preventDefault();
            if ($('#modal.in, #modal.show').length) {
                $("#unitForm").trigger('submit');
            } else {
                alert("Not Calling");
            }
        });
        Mousetrap.bind('ctrl+shift+u', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editUnitForm").trigger('submit');
            } else {
                alert("Not Calling");
            }
        });
        Mousetrap.bind('esc', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editModal").modal('hide');
            } else if ($('#modal.in, #modal.show').length) {
                $('#modal').modal('hide');
            }
        });

        function printPurchase(id) {
            window.open("{{ url('damage/invoice/') }}" + "/" + id);
        }
    </script>
@endsection

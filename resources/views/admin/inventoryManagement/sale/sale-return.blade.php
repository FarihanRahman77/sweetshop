@extends('admin.master')
@section('title')
{{Session::get("companySettings")[0]['name']}} Sale Return
@endsection
@section('content')
<style>
    .table td, .table th {padding: .5rem;vertical-align: top;border-top: 1px solid #dee2e6;}
</style>
    <div class="content-wrapper">
        <section class="content box-border">
        <div class="shadow-lg p-3 mb-5 bg-white rounded">
            <div class="col-md-12 text-center">
                <h4><u> Sale Return </u></h4>
            </div>
        <form>
          @csrf
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4 ">
                      <div class="form-group">
                        <label for="saleNo"> Sale Invoice No</label>
                        <input type="text" readonly class="form-control" name="saleNo" id="saleNo" aria-describedby="emailHelp" value="{{$sale->code}}">
                      </div>
                    </div>
                    <div class="col-md-4 ">
                      <div class="form-group">
                        <label for="customerId"> Customer Name</label>
                        <input type="hidden" readonly name="customerId" id="customerId" value="{{$customer->customer_id}}">
                        <input type="hidden" name="discount" id="discount" value="{{$sale->grand_discount}}">
                        <input type="text" readonly class="form-control" name="customerName" id="customerName" aria-describedby="emailHelp" value="{{$customer->name}}">
                      </div>
                    </div>
                    <div class="col-md-4 ">
                      <div class="form-group">
                        <label for="saleDate"> Sale Date</label>
                        <input type="hidden" name="saleId" id="saleId" value="{{$sale->id}}">
                        <input type="text" readonly class="form-control" name="saleDate" id="saleDate" aria-describedby="emailHelp" value="{{$sale->order_date}}">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="dateOfSaleReturn"> Return Date</label>
                        <input type="text" readonly class="form-control" name="dateOfSaleReturn" id="dateOfSaleReturn" aria-describedby="emailHelp" value="{{date('Y-m-d')}}">
                      </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="purchaseDate"> Sisterconcern</label>
                           <select id="warehouse" name="warehouse" class="form-control" style="width:100%" Required >
                               <option value='' selected='true'> Return Sisterconcern </option>
                                @foreach ($warehouses as $warehouse)
                                    <option value='{{ $warehouse->id }}'>
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                           </select>
                           <span class="text-danger" id="warehouseError"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 ">
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th scope="col">SN</th>
                              <th scope="col">Product Name</th>
                              <th scope="col">Unit Price</th>
                              <th scope="col">Quantity</th>
                              <th scope="col">Returned Quantity</th>
                              <th scope="col">Return Quantity</th>
                              <th scope="col">Remaining Quantity</th>
                              <th scope="col" class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i = 0;
                            @endphp
                            @foreach($saleProducts as $saleProduct)
                            <tr>
                                <td scope="row" id="">{{++$i}}</td>
                                <input type="hidden" id="itemCode{{$saleProduct->id}}" value="{{$saleProduct->product_id}}">
                                <td> {{$saleProduct->name.' - ' .$saleProduct->productname}}</td>
                                <td id="unitPrice{{$saleProduct->id}}">{{$saleProduct->sale_price}}</td>
                                <td id="quantity{{$saleProduct->id}}">{{$saleProduct->menu_quantity}}</td>
                                <td id="returnedQty_{{$saleProduct->id}}">{{$returnedQtyArray[$i-1]}}</td>
                                <td>
                                    <input type="number" id="saleReturn{{$saleProduct->id}}" oninput="saleRemain( {{$saleProduct->id}} )" min="0" placeholder="0" class="form-control" name="saleReturn" aria-describedby="emailHelp">
                                </td>
                                <td id="remainQty{{$saleProduct->id}}">{{($saleProduct->menu_quantity-$returnedQtyArray[$i-1])}}</td>
                                <input type="hidden" id="saleProductId{{$saleProduct->id}}" value="{{$saleProduct->id}}">
                                <input type="hidden" id="productIdOfSale{{$saleProduct->id}}" value="{{$saleProduct->product_id}}">
                                <td id="total{{$saleProduct->id}}" class="text-right">0</td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="7" class="text-right">Total: </td>
                                <td id="grandTotal" class="text-right">0</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Discount: </td>
                                <td class="text-right">{{$sale->discount}}</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Transport: </td>
                                <td class="text-right">{{$sale->carrying_cost}}</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Vat: </td>
                                <td class="text-right">{{$sale->vat}}</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Ait: </td>
                                <td class="text-right">{{$sale->ait}}</td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Adjustment Amount: </td>
                                <td class="text-right"><input type="text" class="form-control text-right" value="0" id="adjustment_amount" onkeyup="saleRemain()"></td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Grand Total: </td>
                                <td class="text-right" id="grand_total">0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
        <div class="col-md-12">
                <div class="float-right">
                    <a href="#/" class="btn btn-primary btn-md" onclick="saleReturn()" aria-pressed="true"><i class="fas fa-save"></i> Return Sale</a>
                </div>
                <div>
                    <a href="{{ url('sale') }}" class="btn btn-dark btn-md" role="button" aria-pressed="true"><i class="fas fa-undo"></i> Back </a>
                </div>
        </div>
        </div>
        </section>
    </div>
<!-- /.content-wrapper -->

@endsection
@section('javascript')
<script>
  $("#warehouse").select2({
        placeholder: " Select Warehouse ",
        allowClear: true,
        width: '100%'
    });
        
  function saleRemain(id) {
    var adjustment_amount=$('#adjustment_amount').val();
    if(adjustment_amount == ""){
      adjustment_amount =0;
      $('#adjustment_amount').val(0);
    }
    unitPrice = $('#unitPrice' + id).text();
    quantity = $('#quantity' + id).text();
    var returnedQty = $('#returnedQty_' + id).text();
    returnQty = $('#saleReturn' + id).val();
    remainingQty = quantity - returnedQty - returnQty;

    if (remainingQty >= 0) {
      $("#remainQty" + id).text(remainingQty);

      total = returnQty * unitPrice;
      $("#total" + id).text(total);
    } else if(remainingQty < 0){
      $('#saleReturn' + id).val(0);
      $('#total' + id).text("00");
      $("#remainQty" + id).text(quantity);
      Swal.fire({
        title: 'Error!',
        text: 'Can not return Qty more than sale',
        icon: 'error',
        confirmButtonText: 'Ok'
      })
    }


    let grandTotal = 0;
    let i = 0;
    let saleProductIds = [];
    $('input[id^="saleProductId"]').each(function() {
      saleProductIds[i] = $(this).val();
      console.log($("#total" + saleProductIds[i]).text());
      grandTotal = grandTotal + parseFloat($("#total" + saleProductIds[i]).text());
      i = i + 1;
    });
    $("#grandTotal").text(grandTotal);
    var grand_total=parseFloat(adjustment_amount)+parseFloat(grandTotal);
    $('#grand_total').text(grand_total);
  }

  function saleReturn() {
    var warehouse = $("#warehouse").val();
    var saleId = $("#saleId").val();
    var saleNo = $("#saleNo").val();
    var customerId = $("#customerId").val();
    var discount = $("#discount").val();
    var saleDate = $("#saleDate").val();
    var dateOfSaleReturn = $("#dateOfSaleReturn").val();

    var _token = $('input[name="_token"]').val();
    var saleProductIds = [];
    var itemCodes = []; //product_id
    var Quantities = [];
    var returnedQuantities = [];
    var returnQuantities = [];
    var remainQuantities = [];
    var productIdsOfSale = [];
    var unitPrices = [];
    var totals = [];
    var grandTotal = 0;

    var i = 0;
    $('input[id^="saleProductId"]').each(function() {
      saleProductIds[i] = $(this).val();
      i = i + 1;
    });
    i = 0;
    $('input[id^="saleReturn"]').each(function() {
      returnQuantities[i] = parseInt($(this).val());
      i = i + 1;
    });
    i = 0;
    $('input[id^="productIdOfSale"]').each(function() {
      productIdsOfSale[i] = parseInt($(this).val());
      i = i + 1;
    });

    saleProductIds.forEach(myFunction);
    function myFunction(value, index, array) {
      
      itemCodes[index] = $("#itemCode" + value).val();
      
      unitPrices[index] = parseFloat($("#unitPrice" + value).text());
      Quantities[index] = parseFloat($("#quantity" + value).text());
      remainQuantities[index] = parseFloat($("#remainQty" + value).text());
      returnedQuantities[index] = parseFloat($("#returnedQty" + value).text());
      totals[index] = parseFloat($("#total" + value).text());

      grandTotal += parseFloat(totals[index] ? totals[index] : 0);

    }

    if (isNaN(grandTotal) || grandTotal == 0) {
      /*Swal.fire({
				title: 'Error!',
				text: 'This Quantity Not available for sale',
				icon: 'error',
				confirmButtonText: 'Ok'
      		});*/
      		alert('This Quantity Not available for sale Return')
      return 0;
    }
    var grand_total=$('#grand_total').text();
    var _token = $('input[name="_token"]').val();
    var fd = new FormData();
    fd.append('saleId', saleId);
    fd.append('warehouse', warehouse);
    fd.append('saleNo', saleNo);
    fd.append('customerId', customerId);
    fd.append('discount', discount);
    fd.append('saleDate', saleDate);
    fd.append('dateOfSaleReturn', dateOfSaleReturn);
    fd.append('saleProductIds', saleProductIds);
    fd.append('itemCodes', itemCodes);
    fd.append('Quantities', Quantities);
    fd.append('returnedQuantities', returnedQuantities);
    fd.append('returnQuantities', returnQuantities);
    fd.append('remainQuantities', remainQuantities);
    fd.append('productIdsOfSale', productIdsOfSale);
    fd.append('unitPrices', unitPrices);
    fd.append('totals', totals);
    fd.append('grandTotal', grand_total);
    fd.append('_token', _token);
    $.ajax({
      url: "{{route('sale.saveSaleReturn')}}",
      method: "POST",
      data: fd,
      contentType: false,
      processData: false,
      datatype: "json",
      success: function(result) {
         Swal.fire({
            title: "Saved !",
            text: result.success,
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
        }).then((btnresult) => {
            if (btnresult.isConfirmed) {
                window.location.href = "{{url('sale/sale-returnList/')}}"+"/"+result.type;
            }
        }); //--end redirect after click OK--//
      },
      beforeSend: function() {
        $('#loading').show();
      },
      complete: function() {
        $('#loading').hide();
      },
      error: function(response) {
          if (response.responseJSON.errors.warehouse) {
                        $('#warehouseError').text("Please Select Warehouse");
                    }
        //alert(JSON.stringify(response));
      }
    })
  }
</script>
@endsection
@extends('admin.master')

@section('title')
{{ Session::get('companySettings')[0]['name'] }} Food
@endsection
@section('content')


<div class="content-wrapper" style="display: flex; justify-content: space-between;">
    <!-- Left Section: Menu Items -->
    <section class="content" style="flex: 1;">
        <div class="card">
            <div class="card-header">
                <h3>Menu Items</h3>
            </div>
            <div class="row">
                <div class="card-body col-12 col-md-12 col-lg-6 col-sm-12 col-xl-8">
                    <div class=" align-items-center w-100 overflow-hidden">
                        <div class="tab  flex-nowrap overflow-auto" id="menulist">
                            @foreach ($categories as $category)
                            <button class="tablinks btn btn-secondary mx-1 flex-shrink-0"
                                onclick="opencategorytab(event,'{{ $category->id }}')">
                                {{$category->name}}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-content" id="itemscard">
                        @foreach ($categories as $category)
                        <div id="tab-{{$category->id}}" class="tabcontent"
                            style="display: none; max-height: 600px; overflow-y: auto;">
                            @php
                            $inventoryProducts = DB::table('tbl_inventory_products')
                            ->where('category_id', '=', $category->category_id)
                            ->where('deleted', 'No')
                            ->where('status', '=', 'Active')
                            ->get();
                            @endphp

                          
                            <div class="col-md-12 mt-3">
                                <div class="row">
                                    @foreach($inventoryProducts as $menu)
                                    <div class="card col-lg-4 col-md-3 col-sm-4 col-4 col-xl-2 p-2">
                                        <div class="image-container text-center position-relative">
                                            <img src="{{asset('upload/product_images/thumbs/' . $menu->image)}}" class="card-img-top img-fluid" alt="{{$menu->image}}" />
                                            <div class="position-absolute w-100 d-flex justify-content-between" style="top: 100%; transform: translateY(-50%);">
                                                <a href="#" class="btn btn-primary mx-1" onclick="menudetailsmodal({{$menu->id}})">
                                                    <i class="fa fa-eye"> Details</i>
                                                </a>
                                                <a href="#" class="btn btn-primary mx-1" onclick="addmenuitemtocard({{$menu->id}})">
                                                    <i class="fa fa-shopping-cart"> Buy</i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-truncate">{{substr($menu->name, 0, 33)}}</h5>
                                            @if($menu->discount > 0)
                                            <p class="mb-1">
                                                <span class="text-danger font-weight-bold">{{$menu->sale_price}}</span>
                                            </p>
                                            @else
                                            <p class="mb-1">{{$menu->sale_price}}<br>{{$menu->purchase_price}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- Right Section: Menu Card -->
                <div class="col-12 col-md-12 col-lg-6 col-sm-12 col-xl-4 mx-auto p-3">
                    <p name="menu_item_id" class="d-none" id="menu_item_id"></p>
                    <h5 class="text-center mb-3 font-weight-bold" style="font-size: 1.5rem; color: #ff7043;">
                        🍽️ Menu Card
                    </h5>
                    <div class="card shadow-lg rounded">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th width="10%">Img</th>
                                            <th  width="20%">Name</th>
                                            <th  width="20%">Qty</th>
                                            <th  width="10%">Broken<br>Qty</th>
                                            <th  width="10%">Unit<br>Price </th>
                                            <th  width="20%">Sub<br>Total </th>
                                            <th  width="10%">Action </th>
                                        </tr>
                                    </thead>
                                    <tbody id="manu_item_table_card">
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">Total Tk:</td>
                                            <td  class="text-right" colspan="2"> <span id="totalAmount"> <sapn></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Discount:</td>
                                            <td colspan="2"> <input class="form-control text-right" id="discount" value="0" onkeyup="calculateGrandTotal()" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value === '') this.value = '0';" ></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Vat:</td>
                                            <td colspan="2"> <input class="form-control text-right" id="vat" value="0" onkeyup="calculateGrandTotal()" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value === '') this.value = '0';"> </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Ait:</td>
                                            <td colspan="2"> <input class="form-control text-right" id="ait" value="0" onkeyup="calculateGrandTotal()" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value === '') this.value = '0';"> </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Grand Total:</td>
                                            <td colspan="2" class="text-right"> <span id="grandTotal"></span> </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Payment Method:</td>
                                            <td colspan="2"> 
                                                <select class="form-control" id="payment_method">
                                                    @foreach($payemntMethods as $paymentMethod)
                                                    <option value="{{$paymentMethod->id}}">{{$paymentMethod->name}}</option>
                                                    @endforeach
                                                </select>
                                             </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">Payment:</td>
                                            <td colspan="2"> <input class="form-control text-right" value="0" id="payment" oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value === '') this.value = '0';"> </td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="form-group">
                                <label>Customer Name</label>
                                <input type="text" name="customerName" id="customerName" class="form-control"  value="{{$defaultParty->name}}"
                                    placeholder="Customer Name">
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="party_id" name="party_id" value="0" />
                                <label>Phone: <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="partyPhoneNumber" name="partyPhoneNumber" class="form-control" placeholder="Phone Number"
                                        onchange="getCustomerInfo(0,'Walkin_Customer')" value="{{$defaultParty->contact}}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger" type="button"
                                            onclick="getCustomerInfo(0,'Walkin_Customer')">
                                            <i class="fas fa-sync"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="text-danger" id="partyPhoneNumberError"></span>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <a class="btn btn-danger" href="#" onclick="clearCart()">
                                    <i class="fa fa-trash"></i> Clear Cart
                                </a>
                                <button type="submit" class="btn btn-primary" id="menuorder" onclick="placeOrder()">
                                    🍽️ Place Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- The item Details Modal -->
<div class="modal fade" id="menumodal" tabindex="-1" role="dialog" aria-labelledby="menumodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <!-- Modal body -->
            <div class="modal-body p-4">
                <!-- Image Section -->
                <div class="d-flex justify-content-center mb-3" id="imageDiv"></div>

                <!-- Product Info Section -->
                <div class="text-center">
                    <h4 id="menu_name" class="font-weight-bold"></h4>
                    <p id="menucategory" class="text-muted mb-2"></p>
                </div>
                
               <!-- Stock and Pricing Details -->
                <div class="row justify-content-center text-center mx-0 mb-3">
                    <div class="col-6">
                        <p class="mb-1"><b>Brand: </b><span id="menubrand"></span></p>
                        <p class="mb-1"><b>Broken Stock: </b><span id="brokenremainingstock"></span></p>
                        <p class="mb-1"><b>Price: </b><span id="max_price"></span> {{ Session::get('companySettings')[0]['currency'] }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><b>Current Stock: </b><span id="menustock"></span>  <span id="menunit"></span></p>
                        <p class="mb-1"><b>Discount Price: </b><span id="min_price"></span> {{ Session::get('companySettings')[0]['currency'] }}</p>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="text-center">
                    <p id="menu_remarks" class="font-italic text-muted"></p>
                </div>

                <!-- Specifications -->
                <div id="menu_specs" class="text-center"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <a href="#" class="btn btn-danger" id="getmenuid"   onclick="addmenuitemtocard($(this).val())">
                    <i class="fa fa-shopping-cart"></i> Buy
                </a>
                <button type="button" class="btn btn-secondary" id="modalclosebtn" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Item Cut Modal -->

<div class="modal" tabindex="-1" role="dialog" id="ProductCutModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Product Break</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th width="15%" class="text-center">Image</th>
                            <th width="45%" class="text-center">Name</th>
                            <th width="20%" class="text-center">Qty</th>
                            <th width="20%" class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody id="menu_item_breakdown_card" style="text-align:center;">

                    </tbody>

                </table>
                <div class="row d-flex  mt-2">
                    <input type="hidden" name="previous_broken_price" id="previous_broken_price"
                        placeholder="previous_broken_price" class="form-control" readonly>
                    <div class="col-md-3 col-3">
                        <label> Prev Broken Qty</label>
                        <input type="number" name="broken_quantity" id="broken_quantity" placeholder="broken_quantity"
                            class="form-control" readonly>
                    </div>
                    <div class="col-md-3 col-3">
                        <label> Prev Sold Qty</label>
                        <input type="number" name="broken_sell_quantity" id="broken_sell_quantity"
                            placeholder="broken_sell_quantity" class="form-control" readonly>
                    </div>
                    <div class="col-md-3 col-3">
                        <label>Available Qty</label>
                        <input type="number" name="available_qty" id="available_qty" placeholder="Available Qty"
                            class="form-control" readonly>
                    </div>

                    <div class="col-md-3 col-3">
                        <label>Sell Previous Item</label>
                        <input type="number" name="broken_remain_quantity" id="broken_remain_quantity"
                            placeholder="broken_remain_quantity" class="form-control" min="0"
                            oninput="LoadBreakMenuCartandUpdate()">
                        <!-- <button class="btn btn-primary" id="checkQuantityBtn" onclick="addremainQuantity()">
                            <i class="fas fa-plus"></i>
                        </button> -->
                    </div>

                </div>
                <div class="row d-flex  mt-2">
                    <div class="col-md-6">
                        <label> Broken Slice Qty</label>
                        <input type="number" name="broken_quantity_break" id="broken_quantity_break"
                            placeholder="Broken Quantity" class="form-control" value="0"
                            onkeyup="LoadBreakMenuCartandUpdate()">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Slice Unit Price: </label>
                        <input type="number" id="break_slice_price" name="break_slice_price"
                            class="form-control input-sm" placeholder=" per slice price" value="0"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..?)\../g, '$1');"
                            onkeyup="LoadBreakMenuCartandUpdate()" />
                    </div>
                </div>
                <div class="row d-flex  mt-2">
                    <div class="col-md-4 col-4">
                        <label> Sell Slice Qty</label>
                        <input type="number" name="slice_quantity_break" id="slice_quantity_break"
                            placeholder="Broken  Slice sell Quantity" class="form-control" value="0"
                            onkeyup="LoadBreakMenuCartandUpdate()">
                    </div>
                    <div class="col-md-4 col-4">
                        <label> Total Sell Slice</label>
                        <input type="number" name="slice_quantity_total" id="slice_quantity_total" value="0"
                            placeholder="Total Slice sell Quantity" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-4 col-4">
                        <label>Total Sell Price: </label>
                        <input type="number" id="break_slice_sell_price" name="break_slice_sell_price" value="0"
                            class="form-control input-sm" placeholder=" slice sell price" readonly />
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary order-btn" id="savechangesbreakquantity" onclick="savebreakitems()">Save changes</button>
            </div>
        </div>

    </div>
</div>


@endsection

@section('javascript')

<script>
   
$(document).ready(function() {
    $("#main-wrapper").toggleClass("mini-sidebar");
    $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");

    
});
function validateNumericInput(input) {
    input.value = input.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
     if(input.value === '') 
     input.value = '0';
}

function scrollTabs(direction) {
    const container = document.getElementById('menulist');
    const scrollAmount = 150;

    if (direction === 'left') {
        container.scrollLeft -= scrollAmount;
    } else {
        container.scrollLeft += scrollAmount;
    }
}

// Toggle visibility of scroll buttons
function updateScrollButtons() {
    const menulist = document.getElementById('menulist');
    const scrollLeftButton = document.getElementById('scrollLeft');
    const scrollRightButton = document.getElementById('scrollRight');

    setTimeout(() => { // Small delay to allow proper update
        if (menulist.scrollLeft > 0) {
            scrollLeftButton.style.display = 'inline-block';
        } else {
            scrollLeftButton.style.display = 'none';
        }

        if (menulist.scrollLeft + menulist.clientWidth < menulist.scrollWidth) {
            scrollRightButton.style.display = 'inline-block';
        } else {
            scrollRightButton.style.display = 'none';
        }
    }, 50);
}

// Event Listeners
document.getElementById('menulist').addEventListener('scroll', updateScrollButtons);
window.addEventListener('resize', updateScrollButtons);
document.addEventListener('DOMContentLoaded', updateScrollButtons);





function opencategorytab(evt, categoryId) {
    // Hide all tabcontent elements
    var tabcontent = document.getElementsByClassName("tabcontent");
    for (var i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Remove active class from all tablinks
    var tablinks = document.getElementsByClassName("tablinks");
    for (var i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the selected tab content
    document.getElementById("tab-" + categoryId).style.display = "block";
    evt.currentTarget.className += " active";
}




// Set default tab
document.getElementsByClassName("tablinks")[0].click();
</script>
<script>
function checkremainQuantity() {
    var breakProduct_id = $("#Productid").val();
    // alert(Product_id);

    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.getRemainmenuquantity') }}",
        method: "GET",
        data: {
            "breakProduct_id": breakProduct_id
        },
        datatype: "json",
        success: function(result) {
            // alert(JSON.stringify(result));
            $("#previous_broken_price").val(result.Currentstock.broken_perslice_price);
            $("#broken_quantity").val(result.Currentstock.broken_quantity);
            $("#broken_sell_quantity").val(result.Currentstock.broken_sold);
            //  $("#break_slice_price").val(result.Currentstock.broken_perslice_price);
            $("#available_qty").val(result.Currentstock.broken_remaining);
            $("#broken_remain_quantity").val(0);
            if (result.Currentstock.broken_remaining > 0) {
                $("#checkQuantityBtn").prop("disabled", false);
            } else {
                $("#checkQuantityBtn").prop("disabled", true);
            }
        },
        beforeSend: function() {
            $('#loading').show();
        },
        complete: function() {
            $('#loading').hide();
        },
        error: function(response) {
            //  alert(JSON.stringify(response));
        },
    });
}




// function addremainQuantity(){
//     var previous_remain_quantity = parseFloat($("#broken_remain_quantity").val());
//     var previous_available_qty= parseFloat($("#available_qty").val());
//     var sellBreakQuantity = parseFloat($("#slice_quantity_break").val());
//     if(previous_remain_quantity < 0){
//         $("#broken_remain_quantity").val(0);
//     }else if(previous_available_qty < previous_remain_quantity){
//         $("#broken_remain_quantity").val(previous_available_qty);
//     }
// }

function cutitems(id) {
    //   alert(id);
    fetch_modal_menu_Cart_item(id);
    $("#ProductCutModal").modal('show');

}


function getCustomerInfo(id, customer_type) {
    if (id == undefined) {
        id = 0;
    }
    let partyPhoneNumber = $("#partyPhoneNumber").val();
    var _token = $('input[name="_token"]').val();
    var fd = new FormData();
    fd.append('id', id);
    fd.append('partyPhoneNumber', partyPhoneNumber);
    fd.append('customer_type', customer_type);
    fd.append('_token', _token);
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.customerinfo') }}",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        datatype: "json",
        success: function(result) {
            //  alert(JSON.stringify(result));
            let isEpmty = Object.keys(result).length;
            if (isEpmty > 0) {
                $("#party_id").val(result['id']);
                $("#partyPhoneNumber").val(result['contact']);
                $("#customerName").val(result['name']);
                $("#customerName").prop('disabled', true);
                $("#partyPhoneNumber").prop('disabled', true);
            } else {
                $("#customerName").prop('disabled', false);
                $("#partyPhoneNumber").prop('disabled', false);
            }
        },
        beforeSend: function() {
            $('#loading').show();
        },
        complete: function() {
            $('#loading').hide();
        },
        error: function(response) {
            $("#barcodeError").text("No such product available in your system");
            // alert(JSON.stringify(response));
        }
    })
}



// setting value to cart modal

document.getElementById('savechangesbreakquantity').addEventListener('click', function() {

    var menu_Break_Remain_Quantity = document.getElementById('broken_remain_quantity').value;
    var menu_BreakQuantity = document.getElementById('broken_quantity_break').value;
    var TotalsellSlice = document.getElementById('slice_quantity_total').value;
    var SetBreakSellProductId = document.getElementById('Productid').value;
    var SetBreakSelluserId = document.getElementById('user_id').value;
    var SetBreakSellPrice = document.getElementById('break_slice_sell_price').value;
    var Setquantitybreak = document.getElementById('slice_quantity_break').value;
    var breakslicepRiece = document.getElementById('break_slice_price').value;

    var _token = $('input[name="_token"]').val();
    var fd = new FormData();
    fd.append('menu_Break_Remain_Quantity', menu_Break_Remain_Quantity);
    fd.append('menu_BreakQuantity', menu_BreakQuantity);
    fd.append('Setquantitybreak', Setquantitybreak);
    fd.append('TotalsellSlice', TotalsellSlice);
    fd.append('breakslicepRiece', breakslicepRiece);
    fd.append('SetBreakSellProductId', SetBreakSellProductId);
    fd.append('SetBreakSelluserId', SetBreakSelluserId);
    fd.append('_token', _token);

    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.updateCartmenubreakitem') }}",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(result) {
           // alert(JSON.stringify(result));
            fetch_menu_Cart_item();
            
            $("#broken_quantity_break").val('');
            $("#break_slice_sell_price").val('');
            $("#slice_quantity_break").val('');
            $("#break_slice_price").val('');
        },
        error: function(response) {
          //  alert(JSON.stringify(response));
        }
    });
    $("#ProductCutModal").modal('hide');
});


function LoadBreakMenuCartandUpdate() {
    var menu_BreakQuantity = parseFloat($("#broken_quantity_break").val());
    var previous_remain_quantity = parseFloat($("#broken_remain_quantity").val());
    var previous_available_qty = parseFloat($("#available_qty").val());
    var previous_sell_Price = parseFloat($("#broken_perslice_price").val());
    var Persliceprice = parseFloat($("#break_slice_price").val());
    var sellBreakQuantity = parseFloat($("#slice_quantity_break").val());
    if (sellBreakQuantity > menu_BreakQuantity) {
        sellBreakQuantity = menu_BreakQuantity;
        $("#slice_quantity_break").val(sellBreakQuantity);
        alert("Sell quantity cannot be greater than broken quantity.");
    }
    var slice_quantity_total = sellBreakQuantity + previous_remain_quantity;
    $("#slice_quantity_total").val(slice_quantity_total);
    var totalBreakSellPrice = (Persliceprice * slice_quantity_total);
    $("#break_slice_sell_price").val(totalBreakSellPrice.toFixed(2));
}



function menuorderprint(id) {
    // alert(id);
    var url = "{{ route('sweetsconfectionary.menu.menuinvoice', ':id') }}";
    url = url.replace(':id', id);
    window.open(url);
}




function clearCart() {
    Swal.fire({
        title: "Are you sure ?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, clear cart!",
        closeOnConfirm: false
    }).then((result) => {
        if (result.isConfirmed) {
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('sweetsconfectionary.menu.clearCart') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    fetch_menu_Cart_item();

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                    //  alert(JSON.stringify(response));
                }
            });
        } else {
            Swal.fire("Cancelled", "Your imaginary Expense is safe :)", "error");
        }
    })
}




function placeOrder() {
    let partyid = $("#party_id").val();
    var partyname = $("#customerName").val();
    let partyPhoneNumber = $("#partyPhoneNumber").val();
    var breakslicepRiece = document.getElementById('break_slice_price').value;
    let break_item_subtotal = $("#menubreak_item_subtotal").text();
    let break_item_subtotal_price = $("#menubreak_item_subtotal_price").text();
    var grandTotal = $("#totalAmount").text();
    var discount = $("#discount").val();
    var vat = $("#vat").val();
    var ait = $("#ait").val();
    var  totalAmount =  $('#grandTotal').text();
    var payment_method =  $('#payment_method').val();
    var payment =  $('#payment').val();
    var fd = new FormData();
    fd.append('totalAmount', totalAmount);
    fd.append('breakslicepRiece', breakslicepRiece);
    fd.append('break_item_subtotal', break_item_subtotal);
    fd.append('break_item_subtotal_price', break_item_subtotal_price);
    fd.append('partyid', partyid);
    fd.append('partyname', partyname);
    fd.append('partyPhoneNumber', partyPhoneNumber);
    fd.append('discount', discount);
    fd.append('vat', vat);
    fd.append('ait', ait);
    fd.append('grandTotal', grandTotal);
    fd.append('payment_method', payment_method);
    fd.append('payment', payment);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.menucheckout') }}",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function(result) {
            alert(JSON.stringify(result));
            let menuorderId = result.menuorder_id;
            fetch_menu_Cart_item();
            if (result.status === 'success') {
                Swal.fire({
                    title: "Saved Order!",
                    text: result
                        .message,
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
                $("#customerName").val("");
                $("#partyPhoneNumber").val("");
                $("#customerName").prop('disabled', false);
                $("#partyPhoneNumber").prop('disabled', false);
                menuorderprint(menuorderId);
            } else {
                Swal.fire("Error: ", "Please Check Required Field!", "error");
            }
        },
        error: function(response) {
             alert(JSON.stringify(response));
            alert('Checkout error: ' + JSON.stringify(response));
        }
    });
}



$(document).ready(function() {
    fetch_menu_Cart_item();
});


$('.truncate-text').dotdotdot({
    height: 60, // Maximum height of the element
    fallbackToLetter: true, // Truncate by letter when word truncation isn't possible
    watch: true, // Update on window resize
});



function menudetailsmodal(id) {
    // alert(id);
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.getmenucarddetails') }}",
        method: "GET",
        data: {
            "id": id
        },
        datatype: "json",
        success: function(result) {
            //  alert(JSON.stringify(result));
            $('#imageDiv').html(result.imageHtml);
            $('#getmenuid').val(result.menu.id);
            $('#menu_name').text(result.menu.name);
            $('#menunit').text(result.menu.unitName);
            $('#menucategory').text(result.menu.categoryName);
            $('#menubrand').text(result.menu.brandName);
            $('#menustock').text(result.menu.current_stock);
            $('#brokenstock').text(result.menu.broken_quantity);
            $('#brokenremainingstock').text(result.menu.broken_remaining);
            $('#brokendamagestock').text(result.menu.broken_damage);
            if (result.menu.discount > 0) {
               let priceafterdiscount = result.menu.sale_price - result.menu.discount;
               $('#min_price').text(priceafterdiscount).addClass('text-danger font-weight-bold');
                $('#max_price').html(result.menu.sale_price).addClass('text-danger font-weight-bold');
                $('#max_price').html('<del>' + result.menu.sale_price + '</del>');
            } else {
                $('#max_price').text(result.menu.sale_price);
              $('#min_price').text(priceafterdiscount);
            }
            $('#menu_remarks').text(result.menu.notes);
            $("#menumodal").modal('show');
        },
        beforeSend: function() {
            $('#loading').show();
        },
        complete: function() {
            $('#loading').hide();
        },
        error: function(response) {
           alert(JSON.stringify(response));
        },
    });
}


function addmenuitemtocard(id) {
  
    var menu_card_id = id;
    var menu_quantity = 1;
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.addtocard') }}",
        method: "GET",
        data: {
            "id": menu_card_id,
            "menu_quantity": menu_quantity
        },
        datatype: "json",
        success: function(result) {
            fetch_menu_Cart_item();
        },
        beforeSend: function() {
            $('#loading').show();
        },
        complete: function() {
            $('#loading').hide();
        },
        error: function(response) {
            //  alert(JSON.stringify(response));
        },
    });
}


function fetch_menu_Cart_item() {
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.fetch_menu_Cart_item') }}",
        method: "GET",
        success: function(result) {
            //alert(JSON.stringify(result));
            $("#manu_item_table_card").html(result.cart);
            $("#totalAmount").text(result.totalAmount);
            calculateGrandTotal();
        },
        error: function(response) {
           // alert(JSON.stringify(response));
        }
    });
}




function fetch_modal_menu_Cart_item(productId) {

    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.fetch_menu_modal_Cart_item') }}",
        method: "get",
        data: {
            product_id: productId // Send the product ID as part of the request
        },
        success: function(result) {
            //    alert(JSON.stringify(result));
            $("#menu_item_breakdown_card").html(result.cart);
            checkremainQuantity();
        },
        error: function(response) {
            //  alert(JSON.stringify(response));
        }
    })
}


function deleteCartItem(menu_id, userId) {
    Swal.fire({
        title: "Are you sure ?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, remove cart data!",
        closeOnConfirm: false
    }).then((result) => {
        if (result.isConfirmed) {
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('menu_id', menu_id);
            fd.append('userId', userId);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('sweetsconfectionary.menu.removeCartmenuitem') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    //  alert(JSON.stringify(result));
                    fetch_menu_Cart_item();

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                    //  alert(JSON.stringify(response));
                }
            });
        } else {
            Swal.fire("Cancelled", "Your imaginary Expense is safe :)", "error");
        }
    });
}

function updatemenuCart(menu_id, userId) {
    var menu_quantity = $('#menu_quantity_' + menu_id + '_' + userId).val();
    var min_price = $('#min_price_' + menu_id + '_' + userId).val();
    // alert(menu_quantity);
    // alert(min_price);
    // alert(menu_id);
    // alert(userId);
    var _token = $('input[name="_token"]').val();
    var fd = new FormData();
    fd.append('menu_quantity', menu_quantity);
    fd.append('min_price', min_price);
    fd.append('userId', userId);
    fd.append('_token', _token);
    fd.append('menu_id', menu_id);
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.updateCartmenuitem') }}",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(result) {
            //alert(JSON.stringify(result));
            fetch_menu_Cart_item();
        },
        error: function(response) {
            //alert(JSON.stringify(response));
        }
    });
}



 function calculateGrandTotal(){
    var totalAmount=$('#totalAmount').text();
    var discount=$('#discount').val();
    var vat = $('#vat').val();
    var ait=$('#ait').val();
    var grandTotal=parseFloat(totalAmount)-parseFloat(discount)+parseFloat(vat)+parseFloat(ait);
    $('#grandTotal').text(grandTotal);
    $('#payment').val(grandTotal);
 }



function loadmenuCartandUpdate(menu_id, userId) {
    updatemenuCart(menu_id, userId);
}


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
        $("#FloorForm").trigger('submit');
    } else {
        alert("Not Calling");
    }
});
Mousetrap.bind('ctrl+shift+u', function(e) {
    e.preventDefault();
    if ($('#editModal.in, #editModal.show').length) {
        $("#editFloorForm").trigger('submit');
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
</script>

<!--   script for food item menu  -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> -->
@endsection
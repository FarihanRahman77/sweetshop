@extends('admin.master')

@section('title')
{{ Session::get('companySettings')[0]['name'] }} Food
@endsection
@section('content')


<style type="text/css">

   /* style for order button  */
     .clear-btn{
        background: linear-gradient(45deg, #ff6b6b, #f94d4d);
        border: none;
        color: white;
        border-radius: 11px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
     }
   .order-btn {
        background: linear-gradient(45deg, #ff6b6b, #f94d4d);
        border: none;
        padding: 12px 24px;
        font-size: 1.2rem;
        color: white;
        border-radius: 11px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .order-btn:hover {
        background: linear-gradient(45deg, #f94d4d, #ff6b6b);
        transform: translateY(-3px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
    }

    .order-btn:active {
        transform: translateY(1px);
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Style the tab */
.tab {
  overflow: hidden;
  /* border: 1px solid #ccc; */
  background-color: #f1f1f1;
}

/* Style the buttons that are used to open the tab content */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  /* border: 1px solid #ccc; */
  border-top: none;
}
.tab-content {
/* width: 100%; */
overflow-x: hidden;
}
    #floorViewRow {
        padding: 0;
        margin: 0;
    }

    #floorViewRow li {
        background-color: rgb(223, 236, 236);
        padding: 1px 2px 1px 4px;
        margin-bottom: 2px;
        border-radius: 2px;
        list-style-type: none;
    }
    .modalcardimg {
        width: 100%;
    }

    #cardtitle {
        font-family: "Times New Roman", Times, serif;
    }

    #cardtitle:hover {
        color: #b9044fad;

    }


    #menulist {
        position: fixed;
        top: 120px;
        width: 53%;
        opacity: 0.9;
        background-color: #fff8e1;
    }
    #menulist::-webkit-scrollbar {
        display: none;
    }


    #menulist {
        -ms-overflow-style: none; 
        scrollbar-width: none; 
    }
 
    #itemscard {
        margin-top: 18px;
        overflow-x: scroll;
        height:900px;
    }


    #card {
        border: 1px solid #ccc;
        border-radius: 8px;
        transition: transform 0.3s;
        background:#fff8e1;
    }

    #card:hover {
        transform: scale(1.1);
        background: #fad9e761;
    }

    /*  menu card css */

    .cardimg {
        height: 100px;
        width: 100%;
        border-radius: 4px;
    }

    #menucard {
    height: 400px;
    background-color: transparent;
    overflow-y: scroll; 
    overflow-x: scroll; 
    float: center;
    margin-top: 50px;
    border-radius: 10px;
    padding: 5px;
    border: 1px solid #8080807d;
    
   
    scrollbar-width: none; 
    -ms-overflow-style: none; 
    }
#menucard::-webkit-scrollbar {
    display: none; 
}
.cardDataBody{
    margin-right:14px;
}
    #modalclosebtn {
        border: 1px solid gray;
        box-shadow: 1px 2px #96000069;
    }

    .item {
        /* padding-left:5px;
  padding-right:5px; */
    }

    .item-card {
        transition: 0.5s;
        cursor: pointer;
    }

    .item-card-title {
        font-size: 15px;
        transition: 1s;
        cursor: pointer;
    }

    .item-card-title i {
        font-size: 15px;
        transition: 1s;
        cursor: pointer;
        color: #ffa710
    }

    .card-title i:hover {
        transform: scale(1.25) rotate(100deg);
        color: #18d4ca;

    }
 
    /*  */
    .card-text {
        height: 80px;
    }

    .card::before,
    .card::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        transform: scale3d(0, 0, 1);
        transition: transform .3s ease-out 0s;
        background: rgba(255, 255, 255, 0.1);
        content: '';
        pointer-events: none;
    }

    .card::before {
        transform-origin: left top;
    }

    .card::after {
        transform-origin: right bottom;
    }

    .card:hover::before,
    .card:hover::after,
    .card:focus::before,
    .card:focus::after {
        transform: scale3d(1, 1, 1);
    }
   .menuimg{
    width: 100%;
    margin: 3px 88px;
   }
    .cardimg {
        display: block;
        width: 100%;
        height: auto;
    }

    #carditemimg {
        height: 30px;
        margin-left: 10px;
        border-radius: 10%;
    }

    #menuaddcardicon {
        position: absolute;
        top: 35px;
        right: 10px;
        font-size: 24px;
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 5px;
        border-radius: 50%;
    }

    /* On screens that are 600px or less, set the background color to olive */
    @media only screen and (max-width: 470px) {
    /* Adjust menu items layout */
    .content {
        flex: 1;
        padding: 0 10px;
    }

    .card {
        width: 100%;
        padding: 10px;
    }

    .tab button {
        font-size: 14px;
        padding: 8px;
    }

    /* Hide overflow scrollbars for menu items */
    .tab {
        overflow-x: scroll;
    }

    .tablinks {
        display: inline-block;
        width: 100%;
    }

    /* Adjust cards */
    .col-md-4 {
        width: 100%;
        padding: 5px;
    }

    #card {
        flex-direction: column;
        text-align: center;
    }

    .image-container {
        width: 100%;
        text-align: center;
    }

    .cardimg {
        width: 80px;
        height: auto;
    }

    h4#cardtitle {
        font-size: 16px;
    }

    /* Adjust text and buttons */
    .truncate-text {
        font-size: 12px;
    }

    /* Right Section: Menu Card */
    #menucard {
        width: 100%;
        position: relative;
        margin: 0 auto;
        top: 0;
    }

    .order-btn {
        width: 100%;
        font-size: 16px;
    }
}

    @media screen and (max-width: 600px) {
        #menulist {
            position: fixed;
            top: 110px;
            overflow-x: scroll;
            height: 90px;
            opacity: 0.9;
            background-color: #fff8e1;
        }

        #itemscard {
        margin-top: 40px;
        overflow-x: scroll;
        height:900px;
    }

        .cardimg {
            height: 120px;
            width: 41%;
            float: right;
            margin-top: -67px;
            border-radius: 4px;
        }

        #card {
            border: 1px solid #ccc;
            border-radius: 8px;
            
            box-shadow: 1px 2px 2px gray;
            transition: transform 0.3s;
        }

        #card:hover {
            transform: scale(0.9);
        }

        #menuaddcardicon {
            position: absolute;
            top: 8px;
            /* Adjust this to change the vertical position */
            right: 31px;
            /* Adjust this to change the horizontal position */
            font-size: 24px;
            /* Adjust icon size */
            color: white;
            /* Adjust icon color */
            background-color: rgba(0, 0, 0, 0.5);
            /* Optional background to make icon more visible */
            padding: 5px;
            border-radius: 50%;
            /* Make the icon circular */
        }
    }

    /* footer css */
</style>




<div class="content-wrapper" style="display: flex; justify-content: space-between;">
    <!-- Left Section: Menu Items -->
    <section class="content" style="flex: 1;">
        <div class="card">
            <div class="card-header">
                <h3>Menu Items</h3>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                <div class="tab" id="menulist" style="overflow-x: auto; white-space: nowrap; -ms-overflow-style: none; scrollbar-width: none;">
                        @foreach ($categories as $category)
                            <button class="tablinks" onclick="opencategorytab(event,'{{ $category->id }}')">
                                {{$category->name}}
                            </button>
                        @endforeach
                    </div>

                    <div class="tab-content" id="itemscard">
                        @foreach ($categories as $category)
                            <div id="tab-{{$category->id}}" class="tabcontent" style="display: none; max-height: 400px; overflow-y: auto;">
                                @php
                                    $inventoryProducts = DB::table('tbl_inventory_products')
                                        ->where('category_id', '=', $category->category_id)
                                        ->where('deleted', 'No')
                                        ->where('status', '=', 'Active')
                                        ->get();
                                @endphp

                                <div class="col-md-9 mt-3">
                                    <div class="row">
                                        @foreach($inventoryProducts as $menu)
                                        <div class="col-md-4 row m-1 p-2 ml-3" id="card">
                                            <div class="col-md-7" onclick="menudetailsmodal({{$menu->id}})">
                                                <h4 id="cardtitle">{{substr($menu->name, 0, 33)}}</h4>
                                                @if($menu->discount > 0)
                                                <p>
                                                    <span class="text-danger font-weight-bold">
                                                        {{$menu->sale_price}}
                                                    </span>
                                                    <!-- <br><del>{{$menu->sale_price}}</del> -->
                                                </p>
                                                @else
                                                <p class="">{{$menu->sale_price}}<br>{{$menu->purchase_price}}</p>
                                                @endif
                                                <p style="color: grey" class="truncate-text">{{$menu->notes}}</p>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="image-container">
                                                    <img src="{{asset('upload/product_images/thumbs/' . $menu->image)}}" class="cardimg" alt="{{$menu->image}}" />
                                                    <i class="fa fa-plus-circle" id="menuaddcardicon" onclick="addmenuitemtocard({{$menu->id}})"></i>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Right Section: Menu Card -->
    <div class="col-md-  d-block" id="menucard" style="position: fixed; right: 0; top: 10%; width: 25%; margin-right: 20px;background-color: #fff8e1;">
    <p name="menu_item_id" class="d-none" id="menu_item_id"></p>

    <h5 class="text-center mb-3" style="font-weight: bold;font-size: 1.5rem;color: #ff7043;">🍽️ Menu Card</h5>
    <div class="card shadow-lg rounded " style="width: 100%; background-color: #fff8e1; border: none;">
        <div class="card-body cardDataBody">
            <div class="row d-flex">
                <table style="width: 100%;">
                    <tbody id="manu_item_table_card" style="text-align:center;">
                        
                    </tbody>
                </table>
                
            </div> 
                        <div class="col-md-12 mt-2">
                            <label> Customer Name</label>
                            <input type="text" name="customerName" id="customerName" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <input type="hidden" id="party_id" name="party_id" value="0" />
                            <label>Phone: <span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <input type="text" id="partyPhoneNumber" name="partyPhoneNumber"
                                    onchange="getCustomerInfo(0,'Walkin_Customer')" class="form-control input-sm"
                                    placeholder=" Phone Number"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                <a class="btn " onclick="getCustomerInfo(0,'Walkin_Customer')" style="background-color: #fff8e1;color:#f44336a1;border:1px solid #f7dcdc;"><i
                                        class="fas fa-sync "></i></a>
                            </div>
                            <span class="text-danger" id="partyPhoneNumberError"></span>
                        </div>
            <div class="text-center mt-2">
           
                            <a class="check-out-btn clear-btn float-left" href="#" onclick="clearCart()"> <i
                                    class="fa fa-trash"></i><span class="check-out-text text-white"> Clear Cart</span> </a>
                        
                <button type="submit" class="btn btn-primary order-btn" id="menuorder" onclick="placeOrder()">🍽️ Place Order</button>
            </div>
        </div>
    </div>
     </div>
</div>
<!-- The item Details Modal -->
<div class="modal" id="menumodal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <div class="row" id="imageDiv"></div>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h3 id="menu_name"></h3>
                <div class="price">
                    <span> {{ Session::get('companySettings')[0]['currency'] }} </span> <span id="max_price"></span><br>
                    <!-- <span> {{ Session::get('companySettings')[0]['currency'] }} </span> <span id="min_price"></span> -->
                </div>
                <br>
                <div class="notes">
                    <p id="menu_remarks"></p>
                </div>
                <div id="menu_specs">

                </div>

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn" id="modalclosebtn" data-dismiss="modal">Close</button>
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
                <input type="hidden" name="previous_broken_price" id="previous_broken_price" placeholder="previous_broken_price"
                class="form-control" readonly>
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
                        <input type="number" name="available_qty" id="available_qty"
                            placeholder="Available Qty" class="form-control" readonly>
                    </div>

                    <div class="col-md-3 col-3">
                        <label>Sell Previous Item</label>
                        <input type="number" name="broken_remain_quantity" id="broken_remain_quantity"
                            placeholder="broken_remain_quantity" class="form-control"  min="0" oninput="LoadBreakMenuCartandUpdate()">
                        <!-- <button class="btn btn-primary" id="checkQuantityBtn" onclick="addremainQuantity()">
                            <i class="fas fa-plus"></i>
                        </button> -->
                    </div>
                 
                </div>
                <div class="row d-flex  mt-2">
                    <div class="col-md-6">
                        <label> Broken Slice Qty</label>
                        <input type="number" name="broken_quantity_break" id="broken_quantity_break"
                            placeholder="Broken Quantity" class="form-control" value="0" onkeyup="LoadBreakMenuCartandUpdate()">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Slice Unit Price: </label>
                        <input type="number" id="break_slice_price" name="break_slice_price"
                            class="form-control input-sm" placeholder=" per slice price" value="0"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" onkeyup="LoadBreakMenuCartandUpdate()"/>
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
                            class="form-control input-sm" placeholder=" slice sell price" readonly/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="submit" class="btn btn-primary order-btn" id="savechangesbreakquantity"
                    onclick="savebreakitems()">Save changes</button>
            </div>
        </div>

    </div>
</div>


@endsection

@section('javascript')

<script>
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
            alert(JSON.stringify(response));
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

function cutitems(id){
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
                 alert(JSON.stringify(response));
        }
    })
}



// setting value to cart modal

document.getElementById('savechangesbreakquantity').addEventListener('click', function() {
  
        var menu_Break_Remain_Quantity = document.getElementById('broken_remain_quantity').value;
        var menu_BreakQuantity = document.getElementById('broken_quantity_break').value;
        var SetBreakSellProductId = document.getElementById('Productid').value;
        var SetBreakSelluserId = document.getElementById('user_id').value;
        var SetBreakSellPrice = document.getElementById('break_slice_sell_price').value;
        var Setquantitybreak = document.getElementById('slice_quantity_break').value;
        var breakslicepRiece = document.getElementById('break_slice_price').value;
        alert(breakslicepRiece);
        var _token = $('input[name="_token"]').val();
        var fd = new FormData();
        fd.append('menu_Break_Remain_Quantity', menu_Break_Remain_Quantity);
        fd.append('menu_BreakQuantity', menu_BreakQuantity);
        fd.append('Setquantitybreak', Setquantitybreak);
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
            success: function(result){
             alert(JSON.stringify(result));
                fetch_menu_Cart_item();
                $("#broken_quantity_break" ).val('');
                $("#break_slice_sell_price" ).val('');
                $("#slice_quantity_break" ).val('');
                $("#break_slice_price" ).val('');
            },
            error: function(response){
                alert(JSON.stringify(response));
            }
        });
        $("#ProductCutModal").modal('hide');
    });



function LoadBreakMenuCartandUpdate() {
    
    $("#break_slice_sell_price").val(0);

    var menu_BreakQuantity = parseFloat($("#broken_quantity_break").val());
    var previous_remain_quantity = parseFloat($("#broken_remain_quantity").val());
    var previous_available_qty= parseFloat($("#available_qty").val());
    var previous_sell_Price= parseFloat($("#broken_perslice_price").val());
    

    if(previous_remain_quantity < 0){
        $("#broken_remain_quantity").val(0);
    }else if(previous_available_qty < previous_remain_quantity){
        $("#broken_remain_quantity").val(previous_available_qty);
    }
    var breaksubtotalprice = parseFloat($("#menusubtotal_break").val());
    var sliceprice = (breaksubtotalprice / menu_BreakQuantity);
    $("#break_slice_price").val(sliceprice.toFixed(2));
    var Persliceprice = parseFloat($("#break_slice_price").val());
    var sellBreakQuantity = parseFloat($("#slice_quantity_break").val());

    

    if (sellBreakQuantity > menu_BreakQuantity) {
        sellBreakQuantity = menu_BreakQuantity; 
        $("#slice_quantity_break").val(sellBreakQuantity); 
        alert("Sell quantity cannot be greater than broken quantity."); 
    }
    var slice_quantity_total= sellBreakQuantity + previous_remain_quantity;

    $("#slice_quantity_total").val(slice_quantity_total);


    var totalBreakSellPrice = (Persliceprice * slice_quantity_total);
    $("#break_slice_sell_price").val(totalBreakSellPrice.toFixed(2));
    
}



function menuorderprint(id){
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
                            alert(JSON.stringify(response));
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your imaginary Expense is safe :)", "error");
                }
            })
        }




function placeOrder(){
    let partyid= $("#party_id").val();
    var partyname = $("#customerName").val();
    let partyPhoneNumber = $("#partyPhoneNumber").val();
    var breakslicepRiece = document.getElementById('break_slice_price').value;
    let break_item_subtotal = $("#menubreak_item_subtotal").text();
    let break_item_subtotal_price = $("#menubreak_item_subtotal_price").text();
    var grandTotal = $("#totalAmount").text();
    var fd = new FormData();
    fd.append('grandTotal', grandTotal);
    fd.append('breakslicepRiece', breakslicepRiece);
    fd.append('break_item_subtotal', break_item_subtotal);
    fd.append('break_item_subtotal_price', break_item_subtotal_price);
    fd.append('partyid', partyid);
    fd.append('partyname', partyname);
    fd.append('partyPhoneNumber', partyPhoneNumber);
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
        fetch_menu_Cart_item()
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
            // alert(JSON.stringify(result));
                $('#imageDiv').html(result.imageHtml);
                $('#menu_name').text(result.menu.name);
                if (result.menu.discount > 0) {
                    // let priceafterdiscount = result.menu.sale_price - result.menu.discount;
                    // $('#min_price').text(priceafterdiscount).addClass('text-danger font-weight-bold');
                    $('#max_price').html(result.menu.sale_price ).addClass('text-danger font-weight-bold');
                    // $('#max_price').html('<del>' + result.menu.sale_price + '</del>');
                } else {
                    $('#max_price').text(result.menu.sale_price);
                    // $('#min_price').text(priceafterdiscount);
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
            alert(JSON.stringify(response));
        },
    });
}


function fetch_menu_Cart_item() {
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.fetch_menu_Cart_item') }}",
        method: "GET",
        success: function(result) {
            $("#manu_item_table_card").html(result.cart);
        },
        error: function(response) {
            alert(JSON.stringify(response));
        }
    });
}




    function fetch_modal_menu_Cart_item(productId){
       
    $.ajax({
        url: "{{ route('sweetsconfectionary.menu.fetch_menu_modal_Cart_item') }}",
        method: "get",
        data: {
            product_id: productId  // Send the product ID as part of the request
        },
        success: function(result) {
        //    alert(JSON.stringify(result));
            $("#menu_item_breakdown_card").html(result.cart);
            checkremainQuantity();
        },
        error: function(response) {
            alert(JSON.stringify(response));
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
                        alert(JSON.stringify(response));
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
                // alert(JSON.stringify(result));
                fetch_menu_Cart_item();
            },
            error: function(response) {
                alert(JSON.stringify(response));
            }
        });
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
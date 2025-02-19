@extends('admin.master')
@section('title')
{{ Session::get('companySettings')[0]['name'] }} Orders
@endsection
@section('content')
<style type="text/css">
    h3 {
        color: #66a3ff;
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

    #tablePlanner .card_rounded {
        margin: 10px;
    }

    #tablePlanner .card-notify-badge {
        position: absolute;
        /* left: -10px;
                    top: -20px; */
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: #000;
        padding: 5px 10px;
        font-size: 14px;

    }

    #tablePlanner .card-notify-year {
        position: absolute;
        /* right: -10px;
                    top: -20px; */
        background: #ff4444;
        border-radius: 50%;
        text-align: center;
        color: #fff;
        font-size: 14px;
        width: 50px;
        height: 50px;
        padding: 15px 0 0 0;
    }


    #tablePlanner .card-detail-badge {
        background: #f2d900;
        text-align: center;
        border-radius: 30px 30px 30px 30px;
        color: #000;
        padding: 5px 10px;
        font-size: 12px;
    }



    #tablePlanner .card:hover {
        background: #fff;
        box-shadow: 12px 15px 20px 0px rgba(46, 61, 73, 0.15);
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    #tablePlanner .card-image-overlay {
        font-size: 20px;

    }


    #tablePlanner .card-image-overlay span {
        display: inline-block;
    }


    #tablePlanner .ad-btn {
        text-transform: uppercase;
        width: 150px;
        height: 40px;
        border-radius: 80px;
        font-size: 16px;
        line-height: 35px;
        text-align: center;
        border: 3px solid #e6de08;
        display: block;
        text-decoration: none;
        margin: 20px auto 1px auto;
        color: #000;
        overflow: hidden;
        position: relative;
        background-color: #e6de08;
    }

    #tablePlanner .ad-btn:hover {
        background-color: #e6de08;
        color: #1e1717;
        border: 2px solid #e6de08;
        background: transparent;
        transition: all 0.3s ease;
        box-shadow: 12px 15px 20px 0px rgba(46, 61, 73, 0.15);
    }

    #tablePlanner .ad-title h5 {
        text-transform: uppercase;
        font-size: 18px;
    }



    /*  order side bar css*/

    .sidebarorder {
        max-width: 250px;
        max-height: 350px;
        /* Set the maximum height */
        padding-block: 0px;
        display: flex;
        flex-direction: column;
        position: relative;
        top: 0;
        border-radius: 0 5px 5px 0;
        background: rgb(44 44 44 / 10%);
        backdrop-filter: blur(5px);
        opacity: 1;
        transition: all ease 0.2s;
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .sidebarorder:hover {
        backdrop-filter: blur(10px);
    }

    .sidebarorder .item {
        padding: 5px 5px;
        width: 100%;
        cursor: pointer;
        transition: all ease 0.2s;
        font-size: 15px;
        border-radius: 3px;
        margin-left: -25px;
    }

    .sidebarorder i {
        padding-right: 5px;
    }

    .sidebarorder .item:hover {
        color: #fff;
        background-color: #bfbfbf;
    }


    #orderdetailsorder {
        display: none;
        /* Hide the div initially */
    }


    @media (max-width: 400px) {
        .sidebarorder {
            min-width: 60%;
            top: 0;
        }
    }
</style>



<div class="content-wrapper">
    <section class="content box-border">
        <div class="card">
            <div class="card-header">
                <h3 style="float:left;"> Orders </h3>

                <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                    Refresh
                </a>

            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="col-md-12 row">
                    <div class="col-md-3">
                        <label for="building"> Room </label>
                        <select class="form-control input-sm" id="room_id" name="room_id" onchange="getTablePlanner()">
                            <option value="" selected> Select Room </option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="room_idError"></span>
                    </div>
                </div>
                <div class="row col-md-12 m-3" id="tablePlanner"></div>
            </div>
        </div><!-- /.container-fluid -->




        <!-- Show order table  -->
        <div class="col-md-12 row">
            <div class="col-md-3">
                <ul class="sidebarorder">
                    @php
                    $i = 1;
                    @endphp
                    @foreach($orders as $order)
                    <li class="item d-flex" onclick="showordertable(this.value)" value="{{ $order->id }}">
                        {{ $i++ }} .
                        Code: {{ $order->code }} <br />
                        Date: {{ $order->order_date }}
                    </li>
                    @endforeach
                </ul>
            </div>



            <!-- Order Details Section -->
            <div id="orderdetailsorder" class="col-md-9">
                <div class="dialog" style="max-width: 100%;">
                    <div class="content">
                        <div class="header ">
                            <h4 class="title text-center"> Order No: <span id="ordernumdetails"></span></h4>
                        </div>
                        <div class="body">
                            <form id="OrderFormdetails" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="order_codedetails" id="order_codedetails">
                                <input type="hidden" id="edit_order_token">
                                <div class="form-group row">
                                    <hr>
                                    <div class="form-group col-md-6">
                                        <b>Table Name : </b><span id="tableNamedetails"></span> <br>
                                        <b>Capacity : </b><span id="capacitydetails"></span> persons <br>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" id="party_iddetails" name="party_iddetails" value="0" />
                                        <b>Customr Name : </b><span id="customerNamedetails"></span> <br>
                                        <b>Customer Number : </b><span id="partyPhoneNumberdetails"></span> <br>
                                    </div>

                                    <div class="col-md-6">
                                        <label> Menu</label>
                                        <select id="menu_iddetails" name="menu_iddetails" class="form-control input-sm">
                                            <option value="">Select Menu</option>
                                            @foreach ($menus as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->categoryName }} -
                                                {{ $menu->name }} - ({{ $menu->code }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="manudetails_tabledetails">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sl</th>
                                                <th class="text-left">Menu Info</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-right">Price</th>
                                                <th class="text-right">Discount Price(%)</th>
                                                <th class="text-right">Price after discount</th>
                                                <th class="text-right">Total</th>
                                                <th class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="menutable_bodydetails"></tbody>
                                        <tr>
                                            <td colspan="6" class="text-right"> previous Discount
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right font-weight-bold">
                                                <input type="" id="previousdiscountdetails" name="discount"
                                                    class="form-control input-sm text-right" value="0" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right"> Previous Vat
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right font-weight-bold">
                                                <input type="text" id="previousvatdetails" name="vat"
                                                    class="form-control input-sm text-right" value="0" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right"> Previous Grand Total
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right">
                                                <span class="btn btn-light text-right viewPurchase"
                                                    id="previousgrandSumdetails"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right"> Current Total
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right">
                                                <span class="btn btn-light text-right viewPurchase"
                                                    id="current_total"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">Paid Amount
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>

                                            <td>
                                                <input type="number" id="paymentdetails" name="paymentdetails"
                                                    class="form-control input-sm text-right" value="0" readonly />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right"> Current Due
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right">
                                                <span class="btn btn-light text-right viewPurchase"
                                                    id="current_Due"></span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="6" class="text-right"> Discount
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right font-weight-bold">
                                                <input type="text" id="discountdetails" name="discount"
                                                    class="form-control input-sm text-right" value="0" />
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="6" class="text-right">Vat
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right font-weight-bold">
                                                <input type="text" id="vatdetails" name="vat"
                                                    class="form-control input-sm text-right" value="0" />
                                            </td>
                                        </tr>


                                        <tr>
                                            <td colspan="6" class="text-right">Grand Total
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                            <td class="text-right">
                                                <span class="btn btn-light text-right viewPurchase"
                                                    id="grandSumdetails"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">Current Paid Amount
                                                {{ Session::get('companySettings')[0]['currency'] }} : </td>

                                            <td>
                                                <input type="number" id="currentpaymentdetails"
                                                    name="currentpaymentdetails"
                                                    class="form-control input-sm text-right" value="0" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="text-right">Payment Method : </td>
                                            <td>
                                                <select id="paymentMethoddetails" name="paymentMethoddetails"
                                                    class="form-control input-sm">
                                                    <option value="Cash" selected> Cash </option>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="6" class="text-right">Order Status : </td>
                                            <td>
                                                <select id="OrderStatusdetails" name="OrderStatusdetails"
                                                    class="form-control input-sm">
                                                    <option value="Open" selected> Open </option>
                                                    <option value="Closed"> Closed </option>
                                                    <option value="Cancel"> Cancel </option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="footer">

                                    <button type="submit" class="btn btn-primary btnSave float-right"
                                        id="saveorderdetails">
                                        <i class="fa fa-save"></i> Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- ADD ORDER modal -->
<div class="modal fade" id="orderAddModal">
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header float-left">
                <h4 class="modal-title float-left"> Add Order</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="OrderForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="table_id" id="table_id">
                    <input type="hidden" id="order_token">
                    <div class="form-group row">
                        <hr>
                        <div class="form-group col-md-12">
                            <b>Table Name :</b> <span id="tableName"></span> <br>
                            <b>Capacity : </b><span id="capacity"></span> persons <br>
                            <!-- <b>Assigned To :</b> <span id="assigned_to">Rubel Hossain</span>  -->
                        </div>
                        <div class="col-md-6">
                            <label> Menu</label>
                            <select id="menu_id" name="menu_id" class="form-control input-sm">
                                <option value="">Select Menu</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label> Customer Name</label>
                            <input type="text" name="customerName" id="customerName" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="hidden" id="party_id" name="party_id" value="0" />
                            <label>Phone: <span class="text-danger">*</span></label>
                            <div class="d-flex">
                                <input type="text" id="partyPhoneNumber" name="partyPhoneNumber"
                                    onchange="getCustomerInfo(0,'Walkin_Customer')" class="form-control input-sm"
                                    placeholder=" Phone Number"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                <a class="btn btn-outline-success" onclick="getCustomerInfo(0,'Walkin_Customer')"><i
                                        class="fas fa-sync"></i></a>
                            </div>
                            <span class="text-danger" id="partyPhoneNumberError"></span>
                        </div>


                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped 
                    table-bordered table-hover" id="manudetails_table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Menu Info</th>
                                    <th>Available Qty</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Discount Price(%)</th>
                                    <th>Price after discount</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="menutable_body"></tbody>
                            <tr>
                                <td colspan="7" class="text-right"> Discount
                                    {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                <td class="text-right font-weight-bold"> <input type="text" id="discount"
                                        name="discount" onkeyup="calculateTotal()"
                                        class="form-control input-sm text-right" value="0" /> </td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Vat
                                    {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                <td class="text-right font-weight-bold"><input type="text" id="vat" name="vat"
                                        onkeyup="calculateTotal()" class="form-control input-sm text-right" value="0" />
                                </td>
                                <!-- <td></td> -->
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Grand Total
                                    {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                <td class="text-right"><span class="btn btn-light text-right viewPurchase"
                                        id="grandSum">0</span></td>

                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Payment Method : </td>
                                <td>
                                    <select id="paymentMethod" name="paymentMethod" class="form-control input-sm">
                                        <option value="Cash" selected> Cash </option>
                                    </select>
                                </td>

                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Paid Amount
                                    {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                <td><input type="number" id="payment" name="payment"
                                        class="form-control input-sm text-right" value="0"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7" class="text-right">Order Status : </td>
                                <td>
                                    <select id="OrderStatus" name="OrderStatus" class="form-control input-sm">
                                        <option value="Open" selected> Open </option>
                                        <option value="Closed"> Closed </option>
                                        <option value="Cancle"> Cancle </option>
                                    </select>
                                </td>

                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X Close</button>
                        <button type="submit" class="btn btn-primary btnSave float-right" id="saveorder">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@endsection

@section('javascript')
<script>
$("#room_id").select2({
    placeholder: "Select Room",
    allowClear: true,
    width: '100%'
});


$("#menu_id").select2({
    placeholder: "Select Menu",
    allowClear: true,
    width: '100%'
});


$("#menu_iddetails").select2({
    placeholder: "Select Menu",
    allowClear: true,
    width: '100%'
});


function showordertable(id) {
    $.ajax({
        url: "{{ route('restaurentManagement.order.tablewiseorderdetails') }}",
        method: "GET",
        data: {
            "id": id,
        },
        datatype: "json",
        success: function(result) {
            document.getElementById('orderdetailsorder').style.display = 'block';
            alert(JSON.stringify(result));
            $('#order_codedetails').val(result.orderdatas[0].order_id);
            $('#ordernumdetails').text(result.orderdatas[0].order_id);
            $('#tableNamedetails').text(result.orderdatas[0].table_name);
            $('#capacitydetails').text(result.orderdatas[0].Capecity_table);
            $('#customerNamedetails').text(result.orderdatas[0].party_name);
            $('#partyPhoneNumberdetails').text(result.orderdatas[0].party_contact);
            $('#previousdiscountdetails').val(result.orderdatas[0].grand_discount);
            $('#previousvatdetails').val(result.orderdatas[0].vat);
            $('#previousgrandSumdetails').text(result.orderdatas[0].order_total);
            $('#paymentdetails').val(result.orderdatas[0].paid_amount);
            $('#party_iddetails').val(result.orderdatas[0].party_id);
            Edit_fetch_menu_Cart();

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


$("#menu_iddetails").change(function() {
    var menu_id = $("#menu_iddetails").val();
    var order_id = $("#order_codedetails").val();
    var menu_quantity = 1;
    var order_token = $("#edit_order_token").val();
    $.ajax({
        url: "{{ route('restaurentManagement.order.addEdititemToCart') }}",
        method: "GET",
        data: {
            "menu_id": menu_id,
            "order_id": order_id,
            "menu_quantity": menu_quantity,
            "order_token": order_token
        },
        datatype: "json",
        success: function(result) {
            alert(JSON.stringify(result));
            Edit_fetch_menu_Cart();
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
});


function Edit_fetch_menu_Cart() {
    var order_id = $("#order_codedetails").val();

    $.ajax({
        url: "{{ route('restaurentManagement.order.edit_fetch_menu_Cart') }}",
        method: "get",
        data: {
            "order_id": order_id
        },
        success: function(result) {
            alert(JSON.stringify(result));

            $("#menutable_bodydetails").html(result.cart);
            //$("#grandSumdetails").text(result.totalAmountdetails);
            calculateTotaldetails();

        },
        error: function(response) {
            alert(JSON.stringify(response));
        }
    });
}


function loadCartandUpdatedetails(menu_id, order_id) {
    update_menu_Cartdetails(menu_id, order_id);

}


function update_menu_Cartdetails(menu_id, order_id) {
    var editmenu_quantity = $('#menu_quantity_details' + menu_id + '_' + order_id).val();
    var editmenu_discount = $('#menu_discount_details' + menu_id + '_' + order_id).val();
    var editmenu_price_after_discount = $('#menu_price_after_discount_details' + menu_id + '_' + order_id).val();
    var _token = $('input[name="_token"]').val();
    var data = {
        menu_quantity: editmenu_quantity,
        menu_discount: editmenu_discount,
        menu_price_after_discount: editmenu_price_after_discount,
        menu_id: menu_id,
        order_id: order_id,
        _token: _token
    };

    $.ajax({
        url: "{{ url('sweetsconfectionary/order/details_update_menu_Cart') }}",
        method: "POST",
        data: data,
        success: function(result) {
            alert(JSON.stringify(result));
            if (result.status == "success") {
                Edit_fetch_menu_Cart();
            } else {
                alert("Error updating cart");
            }
        },
        error: function(response) {
            alert(JSON.stringify(response));
        }
    });
}


function itemremoveCartdetails(menu_id, order_id) {


    Swal.fire({
        title: "Are you sure ?",
        text: "You will not be able to recover this imaginary file!",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, remove cart data!",
    }).then((result) => {
        if (result.isConfirmed) {
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('menu_id', menu_id);
            fd.append('order_id', order_id);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ url('sweetsconfectionary/order/removeEditCartitem') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    alert(JSON.stringify(result));
                    Edit_fetch_menu_Cart();

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


function getTablePlanner() {
    var room_id = $('#room_id').val();
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.getTablePlanning') }}",
        method: "GET",
        data: {
            "room_id": room_id
        },
        datatype: "json",
        success: function(result) {
            // alert(JSON.stringify(result));
            $('#tablePlanner').html(result);
        },
        beforeSend: function() {
            $('#loading').show();
        },
        complete: function() {
            $('#loading').hide();
        },
        error: function(response) {
            // alert(JSON.stringify(response));
        },
    });
}


function viewOrders(id) {
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.getRunningOrders') }}",
        method: "GET",
        data: {
            "id": id
        },
        datatype: "json",
        success: function(result) {
            // alert(JSON.stringify(result));

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

function getCustomerById(id, customer_type) {
    getCustomerInfo(id, customer_type);
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
                $("#customerAddress").prop('disabled', false);
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


function addOrder(id) {
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.addOrder') }}",
        method: "GET",
        data: {
            "id": id
        },
        datatype: "json",
        success: function(result) {
            //  alert(JSON.stringify(result));
            $('#table_id').val(result.table_id);
            $('#tableName').text(result.table.name);
            $('#capacity').text(result.table.capacity);
            $('#menu_id').html(result.menuHtml);

            var orderToken = Math.random().toString(36).substr(2) + Math.random().toString(36).substr(2);

            // alert(orderToken);

            $("#order_token").val(orderToken);
            fetch_menu_Cart();
            $("#orderAddModal").modal('show');

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


$("#menu_id").change(function() {
    var menu_id = $("#menu_id").val();
    var table_id = $("#table_id").val();
    var menu_quantity = 1;
    var order_token = $("#order_token").val();
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.addToCart') }}",
        method: "GET",
        data: {
            "menu_id": menu_id,
            "table_id": table_id,
            "menu_quantity": menu_quantity,
            "order_token": order_token
        },
        datatype: "json",
        success: function(result) {
            // alert(JSON.stringify(result));
            fetch_menu_Cart();
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
})


function fetch_menu_Cart() {
    var table_id = $("#table_id").val();
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.fetch_menu_Cart') }}",
        method: "get",
        data: {
            "table_id": table_id
        },
        success: function(result) {
            // alert(JSON.stringify(result));
            $("#menutable_body").html(result.cart);
            $("#totalAmount").text(result.totalAmount);
            calculateTotal();
        },
        error: function(response) {
            //   alert(JSON.stringify(response));
            $("#barcodeError").text("No such product available in your system 1 " + JSON.stringify(
                response));
        }
    })
}


function update_menu_Cart(menu_id, table_id) {
    var menu_quantity = $('#menu_quantity' + menu_id + '_' + table_id).val();
    var menu_discount = $('#menu_discount' + menu_id + '_' + table_id).val();
    var menu_price_after_discount = $('#menu_price_after_discount' + menu_id + '_' + table_id).val();
    var _token = $('input[name="_token"]').val();


    $.ajax({
        url: "{{ url('sweetsconfectionary/order/update_menu_Cart') }}",
        method: "POST",
        data: {
            menu_quantity: menu_quantity,
            menu_discount: menu_discount,
            menu_price_after_discount: menu_price_after_discount,
            menu_id: menu_id,
            table_id: table_id,
            _token: _token
        },
        success: function(result) {
            alert(JSON.stringify(result));
            if (result.status == "success") {
                fetch_menu_Cart(); // Reload cart
            } else {
                alert("Error updating cart");
            }
        },
        error: function(response) {
            // alert(JSON.stringify(response));
        }
    });

}


function loadCartandUpdate(menu_id, table_id) {

    update_menu_Cart(menu_id, table_id);
}


function itemremoveCart(menu_id, table_id) {
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
            fd.append('table_id', table_id);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ url('sweetsconfectionary/order/removeCartitem') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    // alert(JSON.stringify(result));
                    fetch_menu_Cart();

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


function clearSalesForm() {

    $("#customerName").val("");
    $("#partyPhoneNumber").val("");
    $("#total_amount").text("0");
    $("#discount").val("0");
    $("#grandSum").text("0");
    $("#vat").val("0");
    $("#payment").val("0");
}


$("#OrderForm").submit(function(e) {
    e.preventDefault();
    var table_id = $("#table_id").val();
    var partyId = $("#party_id").val();
    var partyname = $("#customerName").val();
    var partycontact = $("#partyPhoneNumber").val();
    var TotalAmount = $("#totalAmount").text();
    var Vat = $("#vat").val();
    var GrandDiscount = $("#discount").val();
    var Grandsum = $("#grandSum").text();
    var current_payment = $("#payment").val();
    var payment_method = $("#paymentMethod").val();
    var OrderStatus = $("#OrderStatus").val();
    var current_balance = parseFloat(Grandsum) - parseFloat(current_payment);
    var _token = $('input[name="_token"]').val();
    var fd = new FormData();
    fd.append('table_id', table_id);
    fd.append('party_id', partyId);
    fd.append('name', partyname);
    fd.append('contact', partycontact);
    fd.append('Vat', Vat);
    fd.append('GrandDiscount', GrandDiscount);
    fd.append('totalAmount', TotalAmount);
    fd.append('Grandsum', Grandsum);
    fd.append('current_payment', current_payment);
    fd.append('payment_method', payment_method);
    fd.append('OrderStatus', OrderStatus);
    fd.append('current_balance', current_balance);
    fd.append('_token', _token);
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.checkout') }}",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function(result) {
            // alert(JSON.stringify(result));
            $("#orderAddModal").modal('hide');
            clearSalesForm();
            fetch_menu_Cart();
            $("#customerName").prop('disabled', false);
            $("#partyPhoneNumber").prop('disabled', false);
            if (result.status === 'success') { // Check if status is 'success'
                Swal.fire({
                    title: "Saved Order!",
                    text: result
                        .message, // Corrected this to use the 'message' from the result
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire("Error: ", "Please Check Required Field!", "error");
            }
        },
        error: function(response) {
            alert(JSON.stringify(response));
            alert('Checkout error: ' + JSON.stringify(response));
        }
    });
});


function clearorderdetailsForm() {

    $("#customerNamedetails").val("");
    $("#partyPhoneNumberdetails").val("");
    $("#discountdetails").val("0");
    $("#grandSumdetails").text("0");
    $("#vatdetails").val("0");
    $("#currentpaymentdetails").val("0");
}


$("#OrderFormdetails").submit(function(e) {
    e.preventDefault();
    var order_id = $("#order_codedetails").val();
    var partyId = $("#party_iddetails").val();
    var partyname = $("#customerNamedetails").text();
    var partycontact = $("#partyPhoneNumberdetails").text();
    var TotalAmount = $("#totalAmountdetails").text();
    var Vat = $("#vatdetails").val();
    var Previous_Vat = $("#previousvatdetails").val();
    var GrandDiscount = $("#discountdetails").val();
    var Previous_Discount = $("#previousdiscountdetails").val();
    var Grandsum = $("#grandSumdetails").text();
    var Previous_Grandsum = $("#previousgrandSumdetails").text();
    var previous_paidamount = $("#paymentdetails").val();
    var current_payment = $("#currentpaymentdetails").val();
    var payment_method = $("#paymentMethoddetails").val();
    var OrderStatus = $("#OrderStatusdetails").val();
    var TotalDiscountAmount = Number(GrandDiscount) + Number(Previous_Discount);
    var TotalVatAmount = Number(Vat) + Number(Previous_Vat);
    var Total_Paid_amount = Number(previous_paidamount) + Number(current_payment);
    var Partycurrent_due = Number(Grandsum) - Number(current_payment);

    // var current_balance = parseFloat(Grandsum) - parseFloat(current_payment);
    var _token = $('input[name="_token"]').val();
    var fd = new FormData();
    fd.append('order_id', order_id);
    fd.append('party_id', partyId);
    fd.append('name', partyname);
    fd.append('contact', partycontact);
    fd.append('Vat', Vat);
    fd.append('GrandDiscount', GrandDiscount);
    fd.append('TotalDiscountAmount', TotalDiscountAmount);
    fd.append('TotalVatAmount', TotalVatAmount);
    fd.append('Total_Paid_amount', Total_Paid_amount);
    fd.append('totalAmount', TotalAmount);
    fd.append('Grandsum', Grandsum);
    fd.append('Partycurrent_due', Partycurrent_due);
    fd.append('Previous_Grandsum', Previous_Grandsum);
    fd.append('current_payment', current_payment);
    fd.append('payment_method', payment_method);
    fd.append('OrderStatus', OrderStatus);
    // fd.append('current_balance', current_balance);
    fd.append('_token', _token);
    $.ajax({
        url: "{{ route('sweetsconfectionary.order.editcheckout') }}",
        method: "POST",
        data: fd,
        contentType: false,
        processData: false,
        success: function(result) {
            alert(JSON.stringify(result));
            clearorderdetailsForm();
            $("#customerName").prop('disabled', false);
            $("#partyPhoneNumber").prop('disabled', false);
            if (result.status === 'success') { // Check if status is 'success'
                Swal.fire({
                    title: "Update Order!",
                    text: result
                        .message, // Corrected this to use the 'message' from the result
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire("Error: ", "Please Check Required Field!", "error");
            }
        },
        error: function(response) {
            alert(JSON.stringify(response));
            alert('Checkout error: ' + JSON.stringify(response));
        }
    });
});


function calculateTotal() {
    const totalAmount = parseFloat(document.getElementById('totalAmount').textContent) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const vat = parseFloat(document.getElementById('vat').value) || 0;
    const grandSum = totalAmount - discount + vat;

    document.getElementById('grandSum').textContent = grandSum.toFixed(2);
}


function calculateTotaldetails() {
    document.getElementById('vatdetails').addEventListener('input', calculateTotaldetails);
    document.getElementById('discountdetails').addEventListener('input', calculateTotaldetails);
    var totalAmountString = document.getElementById('totalAmountdetails').textContent;
    var cleanedTotalAmount = totalAmountString.replace(/[^0-9.]/g, '');
    var totalAmount = parseFloat(cleanedTotalAmount) || 0;
    var previousDiscount = $('#previousdiscountdetails').val();
    var previousVat = $('#previousvatdetails').val();
    var previousPaidAmount = $('#paymentdetails').val();
    var currentTotal = parseFloat(totalAmount) - parseFloat(previousDiscount) + parseFloat(previousVat);
    $('#current_total').text(currentTotal);
    var currentDue = parseFloat(currentTotal) - parseFloat(previousPaidAmount);
    $('#current_Due').text(currentDue);
    var currentDiscount = $('#discountdetails').val();
    var currentVat = $('#vatdetails').val();
    var grandTotal = parseFloat(currentDue) - parseFloat(currentDiscount) + parseFloat(currentVat);
    $('#grandSumdetails').text(grandTotal);
};


Mousetrap.bind('ctrl+shift+n', function(e) {
    e.preventDefault();
    if ($('#modal.in, #modal.show').length) {

    } else {
        create();
    }
});


function reloadDt() {
    getTablePlanner();
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
@endsection
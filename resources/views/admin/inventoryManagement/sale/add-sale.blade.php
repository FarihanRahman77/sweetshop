@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Sale
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
                <form id="saleProducts" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-md-12">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <input type="hidden" name="saleType" id="saleType" value="{{ $type }}">
                                <div class="card-header">
                                    <h3>
                                        @if ($type == 'walkin_sale')
                                            Walkin Sale
                                        @elseif ($type == 'party_sale')
                                            Party Sale
                                        @elseif ($type == 'ts')
                                            Temporary Sale
                                        @endif
                                        <a class="btn btn-outline-success float-right"
                                            href="{{ route('sales', ['type' => $type]) }}"> 
                                                @if ($type == 'walkin_sale')
                                                    Back To Walkin Sale List 
                                                @elseif ($type == 'party_sale')
                                                     Back To Party Sale List 
                                                 @elseif ($type == 'ts')
                                                    Back To Temporary Sale List 
                                                @endif
                                                <i class="fa fa-reply"></i></a> 
                                    </h3>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        @if (Session::get('companySettings')[0]['barcode_exists'] == 'Yes')
                                            <div class="form-group col-md-12">
                                                <label>Barcode: </label>
                                                <input class="form-control input-sm" id="barcode" type="text" name="barcode"
                                                    onkeyup="findProduct()">
                                                <span class="text-danger" id="barcodeError"></span>
                                            </div>
                                        @endif
                                            <div class="form-group col-md-2">
                                                <label>Date: <span class="text-danger">*</span></label>
                                                <input type="date" id="saleDate" name="saleDate" class="form-control input-sm" value="{{ todayDate() }}" />
                                            </div>
                                        @if ($type != 'walkin_sale')
                                            <div class="form-group col-md-7">
                                                <label>Party Name : </label>
                                                <select id="customer" name="customer" class="abcd customer"
                                                    style="width:100%" required onchange="getCustomerById(this.value, 'Customer');">
                                                    <option value='' selected='true'> Select Party </option>
                                                    @foreach ($customers as $customer)
                                                        <option value='{{ $customer->id }}'>
                                                            {{ $customer->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="customerNameError"></span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="hidden" id="customer" name="customer" value="0" />
                                                <label>Phone: </label>
                                                <div class="d-flex">
                                                    <input type="text" id="partyPhoneNumber" name="partyPhoneNumber" class="form-control input-sm" placeholder=" Phone Number" readonly/>
                                                </div>
                                                <span class="text-danger" id="partyPhoneNumberError"></span>
                                            </div>
                                            
                                        @endif
                                        
                                        @if ($type == 'walkin_sale')
                                            <div class="form-group col-md-4">
                                                <input type="hidden" id="customer" name="customer" value="0" />
                                                <label>Phone: <span class="text-danger">*</span></label>
                                                <div class="d-flex">
                                                    <input type="text" id="partyPhoneNumber" name="partyPhoneNumber" onchange="getCustomerInfo(0,'Walkin_Customer')" class="form-control input-sm" placeholder=" Phone Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                    <a class="btn btn-outline-success" onclick="getCustomerInfo(0,'Walkin_Customer')"><i class="fas fa-sync"></i></a>
                                                </div>
                                                <span class="text-danger" id="partyPhoneNumberError"></span>
                                            </div>
                                        @endif
                                            <div class="form-group col-md-5">
                                                <label>Name: <span class="text-danger">*</span></label>
                                                <input type="text" id="customerName" name="customerName" class="form-control input-sm" placeholder=" Contact Person Name" />
                                                <span class="text-danger" id="customerNameError"></span>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label>Warehouse: <span class="text-danger">*</span></label>
                                                <select id="warehouse" name="warehouse" class="abcd" style="width:100%" required>
                                                    <option value='' selected='true'> Select Warehouse </option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value='{{ $warehouse->id }}'>
                                                            {{ $warehouse->wareHouseName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger" id="warehouseError"></span>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>P.O. NO : </label>
                                                <input type="text" id="poNumber" name="poNumber" class="form-control input-sm" placeholder=" P.O Number " />
                                                <span class="text-danger" id="poNumberError"></span>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>P.O Date: </label>
                                                <input type="date" id="poDate" name="poDate" class="form-control input-sm" value="{{ todayDate() }}" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Address: </label>
                                                <input type="text" id="customerAddress" name="customerAddress" class="form-control input-sm" placeholder=" Customer Address " />
                                                <span class="text-danger" id="customerAddressError"></span>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Credit Limit
                                                    ({{ Session::get('companySettings')[0]['currency'] }}):</label><br>
                                                <span class="btn btn-success float-right viewPurchase" style="height: 53%;" id="creditLimit">0</span>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label>Left credit ({{ Session::get('companySettings')[0]['currency'] }}):</label><br>
                                                <span class="btn btn-warning float-right viewPurchase" style="height: 53%;" id="leftCredit">0</span>
                                            </div>
                                            <div class="form-group col-md-2">
                                            <label>Due ({{ Session::get('companySettings')[0]['currency'] }}):
                                            </label><br>
                                            <span class="btn btn-warning float-right viewPurchase" style="height: 53%;" id="currentDue">0</span>
                                            </div>
                                            <div class="form-group col-md-6 d-none">
                                            <label>Total With Due
                                                ({{ Session::get('companySettings')[0]['currency'] }}):</label><br>
                                            <span class="btn btn-danger float-right viewPurchase" id="totalWithDue">0</span>
                                        </div>
                                        
                                        <div class="form-group col-md-6 d-none">
                                            <label>Category: </label>
                                            <select id="category" name="category" class="form-control input-sm">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 d-none">
                                            <label>Brand : </label>
                                            <select id="brand" name="brand" class="form-control input-sm">
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                                -->
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="d-flex">
                                                <select id="product" name="product" class="form-control input-sm" style="width:96%">
                                                <option value=""> Product Search </option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"> {{ $product->name .' - '.$product->model_no.' - ' . $product->brandName . ' - ' . $product->product_code}} </option>
                                                    @endforeach
                                                </select>
                                                 <button type="button" class="btn btn-primary input-group-addon" onclick="showAdvanceSearch();"> <i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Cart Details: </label>
                                            <table border="1" style="font-size: 13px; width:100%;" class="table-bordered" >
                                                <thead>
                                                    <tr>
                                                        <th style="width: 3%;text-align:center;">SL</th>
                                                        <th style="width: 25%;text-align:center;">Product Info</th>
                                                        <th style="width: 7%;text-align:center;">Available</th>
                                                        <th style="width: 7%;text-align:center;">Qty</th>
                                                        <th style="width: 7%;text-align:center;">Length (Inch)</th>
                                                        <th style="width: 12%;text-align:center;">Price/Inch</th>
                                                        <th style="width: 12%;text-align:center;">Unit Price</th>
                                                        <th style="width: 12%;text-align:center;">Unit Dis.</th>
                                                        <th style="width: 12%;text-align:center;">Total</th>
                                                        <th style="width: 3%;text-align:center;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="manageCartTable"></tbody>
                                                    <tr>
                                                        <td colspan="8" class="text-right" > Discount {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                                        <td class="text-right font-weight-bold"> <input type="text" id="discount" name="discount" onkeyup="calculateTotal()" class="form-control input-sm text-right" /> </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-right" >Transport {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                                        <td class="text-right font-weight-bold"><input type="text" id="transport" name="transport" onkeyup="calculateTotal()" class=" form-control input-sm text-right" /></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-right" >Vat {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                                        <td class="text-right font-weight-bold"><input type="text" id="vat" name="vat" onkeyup="calculateTotal()" class="form-control input-sm text-right" /></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-right" >Ait {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                                        <td class="text-right font-weight-bold"><input type="text" id="ait" name="ait" onkeyup="calculateTotal()" class="form-control input-sm text-right" /></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr> 
                                                        <td colspan="8" class="text-right" >Grand Total {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                                        <td class="text-right"><span class="btn btn-light text-right viewPurchase" id="grandSum">0</span></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-right" >Payment Method : </td>
                                                        <td>
                                                            <select id="paymentMethod" name="paymentMethod" class="form-control input-sm">
                                                                <option value="Cash" selected> Cash </option>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="text-right" >Paid Amount {{ Session::get('companySettings')[0]['currency'] }} : </td>
                                                        <td>
                                                            <input type="number" id="payment" name="payment" class="form-control input-sm text-right" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                            </table>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <a class="btn btn-secondary float-left" href="#" onclick="clearCart()"> <i class="fa fa-trash"></i> Clear Cart </a>
                                        </div>
                                        <div class="col-md-10">
                                            <button type="button" id="checkOutCart" class="btn btn-success my_button float-right btn-block"><i class="fas fa-save"> Place Order </i> </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->

                                <!-- /.card -->
                            </div>
                        </section>
                    </div><!-- /.container-fluid -->
                </section>
            </div>
        </form>

        <!-- /.content -->
        <!-- Product Advance Search modal -->
        <div class="modal fade" id="showAdvanceSearchModal">
            <div class="modal-dialog" style="max-width: 90%;" role="document">
                <!-- style, added by Md Hamid -->
                <div class="modal-content">
                    <div class="modal-header float-left">
                        <h4 class="modal-title float-left"> Product Advance Search</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> x </button>
                    </div>
                    <div class="modal-body">
                        <form id="productForm" method="POST" enctype="multipart/form-data" action="#">
                            @csrf
                            <div class="row">
                                <!--data listing table-->
                                <div class="table-responsive">
                                    <table id="advanceSearchProductTable" width="100%"
                                        class="table table-bordered table-hover ">
                                        <thead>
                                            <tr>
                                                <td width="5%">SL</td>
                                                <td width="18%">Product Info</td>
                                                <td width="18%">Product Info</td>
                                                <td width="21%">Speccification</td>
                                                <td width="10%">Price</td>
                                                <td width="20%">Stock</td>
                                                <td width="6%">Actions</td>
                                            </tr>
                                        </thead>
                                    </table>
                                    <!--data listing table-->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> x
                                </button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
        <!-- End Product Advance Search modal -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('javascript')
    <script>
        // Start Advance Search Product
        var advanceSearchTable;
        var loadSearch = 1
        function showAdvanceSearch() {
            getManageProductTable();
            $("#showAdvanceSearchModal").modal('show');
        }
        
        function getManageProductTable() {
            if(loadSearch == 1){
                advanceSearchTable = $('#advanceSearchProductTable').DataTable({
                    'ajax': "{{ route('viewAdvanceSearchProducts', ['page' => 'walkin_sale']) }}",
                    processing: true,
                    destroy: true,
                });
                loadSearch = 0;
            }
        }

        function warehouseWiseStock(id) {
            $.ajax({
                url: "{{ route('warehouseWiseStock') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    if (result) {
                        //$("#warehouseWise").remove();
                        $("#" + id).html(result);
                    } else {
                        $("#" + id).html('Stock : 0');
                    }
                },
                error: function(response) {
                   // alert(JSON.stringify(response));
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }
        $("#warehouse").change(function (){
            $("#product").val("").trigger('change');
        })
        function selectProducts(productId, warehouseId) {
            var id = productId;
            var warehouseId = warehouseId;
            if (warehouseId != '') {
                var warehouseName = $("#wrhs_name" + warehouseId).text();
                var saleType = $("#saleType").val();
                var _token = $('input[name="_token"]').val();
                var fd = new FormData();
                fd.append('id', id);
                fd.append('warehouseId', warehouseId);
                fd.append('warehouseName', warehouseName);
                fd.append('quantity', 1);
                fd.append('saleType', saleType);
                fd.append('_token', _token);
                addToCart(fd);
            }else{
                alert('Warehouse must be selected');

            }
        }
        // End Advance Search Product

        fetchCart();

        $("#warehouse").select2({
            placeholder: "Select warehouse",
            /*dropdownParent: $("#modal"),*/
            allowClear: true,
            width: '100%'
        });
        $("#category").select2({
            placeholder: "Select Category",
            /*dropdownParent: $("#modal"),*/
            allowClear: true,
            width: '100%'
        });
        $("#brand").select2({
            placeholder: "Select Brand",
            /*dropdownParent: $("#modal"),*/
            allowClear: true,
            width: '100%'
        });
        $("#product").select2({
            placeholder: " Product Search ",
            /*dropdownParent: $("#modal"),*/
            allowClear: true,
            width: '100%'
        });
        $(document).ready(function() {
            $(".customer").select2({
                placeholder: "Select Party",
                /*dropdownParent: $("#modal"),*/
                allowClear: true,
                width: '100%'
            });
        });

        function fetchCart() {
            $.ajax({
                url: "{{ url('sale/fetchCart') }}",
                method: "get",
                success: function(result) {
                  //  alert(JSON.stringify(result));
                    $("#manageCartTable").html(result.cart);
                    $("#totalAmount").text(result.totalAmount);
                    calculateTotal();
                },
               
               
                error: function(response) {
                  //  alert(JSON.stringify(response));
                    $("#barcodeError").text("No such product available in your system 1 " + JSON.stringify(
                        response));
                }
            })
        }


        $('#save').attr('disabled', true);
        $('#emi').attr('disabled', true);

        var totalPrice = 0;
        var downPayment = 0;
        var duesAmount = 0;
        var noOfTenure = 0;
        var startDate = 0;
        var perTenurAmount = 0;
        var dayMonthYear = 0;
        var emiPaymentDateArray = [];
        var isSave = "";
        $('.myButton').click(function() {
            isSave = $(this).val();
            localStorage.setItem('isSave', isSave);
        });

        function addEMI() {
            totalPrice = parseFloat($('#grandTotal').text());
            if (totalPrice <= 0) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please, add product to get EMI!',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                })
                return 0;
            } else {
                $('#totalAmoutForEMI').text(totalPrice);
                $('#duesAmount').text(totalPrice);
                var payment = parseFloat($("#payment").val());
                $("#downPayment").val(payment);
                duesAmount = totalPrice - downPayment;
                $('#duesAmount').text(duesAmount);
                calculateEMI();
            }
        }

        // calculate EMI 
        function calculateEMI() {
            $("#addEMIModal").modal('show');
            downPayment = $('#downPayment').val();
            duesAmount = totalPrice - downPayment;
            $('#duesAmount').text(duesAmount);

            noOfTenure = $("#noOfTenure").val();
            startDate = $('#startDate').val();
            dayMonthYear = startDate.split('-');

            var year = parseInt(dayMonthYear[0]);
            var month = parseInt(dayMonthYear[1]);
            var day = parseInt(dayMonthYear[2]);

            mumber = parseInt(localStorage.getItem('numberOfTenure'));
            if (mumber > 0) {
                $(".tenurDate").remove();
            }
            localStorage.setItem('numberOfTenure', noOfTenure);
            perTenurAmount = (parseFloat(duesAmount ? duesAmount : totalPrice) / parseInt(noOfTenure)).toFixed(2)
            $('#perTenurAmount').text(perTenurAmount);
            // to show tenure and date//
            for (i = 0; i < noOfTenure; i++) {
                if (month > 12) {
                    year++;
                    month = 1;
                }
                var setDay = 0;
                var setMonth = 0;
                if (day < 10) {
                    setDay = '0' + day;
                } else {
                    setDay = day;
                }
                setMonth = month >= 10 ? month : '0' + month;
                month++;
                ymdFormat = year + '-' + setMonth + '-' + setDay;
                emiPaymentDateArray[i] = ymdFormat;
                // $( ".dynamic" ).append("<div class='form-group border border-primary tenurDate' id='tenurDate'><label class='col-form-label p-2'>"+(i+1)+". Amount: <span id='perTenurAmount'>"+perTenurAmount+"</span>, Tenure date: <span id='dayMonthYear'>"+ (year) +"-"+ (setMonth) +"-"+(setDay)+"</span></label></div>" );
                $(".dynamic").append("<tr class='tenurDate' id='tenurDate'><th scope='row'>" + (i + 1) +
                    ". </th><td> Amount: <span id='perTenurAmount'>" + perTenurAmount +
                    " </span></td><td> Tenure date: <span id='dayMonthYear'> " + (year) + "-" + (setMonth) + "-" + (
                        setDay) + "</span></td></tr>");

            }
            // to enable EMI save button//
            if (noOfTenure && startDate) {
                $('#save').attr('disabled', false);
            }
        }
        $("#category").change(function() {
            var categoryId = $("#category").val();
            loadBrands(categoryId);
            //loadProducts(categoryId,'');
        })
        $("#brand").change(function() {
            var categoryId = $("#category").val();
            var brandId = $("#brand").val();
            var warehouseId = $("#warehouse").val();
            loadProducts(categoryId, brandId, warehouseId);
        })

        function loadBrands(categoryId) {
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('id', categoryId);
            fd.append('type', "sale");
            fd.append('_token', _token);
            $.ajax({
                url: "{{ url('brands/categoryWiseView') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    var brandData = "<option value=''>Select Brand</option>";
                    for (var i = 0; i < result.length; i++) {
                        brandData += "<option value='" + result[i]["id"] + "'>" + result[i]["name"] +
                            "</option>";
                    }
                    if (brandData == "<option value=''>Select Brand</option>") {
                        brandData = "<option value=''>No Available Brand</option>";
                    }
                    $("#brand").html(brandData);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                    $("#barcodeError").text("No such product available in your system 1 " + JSON.stringify(
                        response));
                    //alert(JSON.stringify(response));
                }
            })
        }

        function loadProducts(categoryId, brandId, warehouseId) {
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('categoryId', categoryId);
            fd.append('brandId', brandId);
            fd.append('warehouseId', warehouseId);
            fd.append('type', "sale");
            fd.append('_token', _token);
            $.ajax({
                url: "{{ url('products/brandAndCategoryWise') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    var productData = "<option value=''>Select Product</option>";
                    let current_stock = '';
                    for (var i = 0; i < result.length; i++) {
                        if (warehouseId) {
                            current_stock = result[i]["currentStock"];
                        }else{
                            current_stock = result[i]["current_stock"];
                        }
                        productData += "<option value='" + result[i]["id"] + "'>" + result[i]["name"] +
                            " ( available-" + current_stock + " )</option>";
                    }
                    if (productData == "<option value=''>Select Product</option>") {
                        productData = "<option value=''>No Available Product</option>";
                    }
                    $("#product").html(productData);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                    $("#barcodeError").text("No such product available in your system 1 " + JSON.stringify(
                        response));
                    //alert(JSON.stringify(response));
                }
            })
        }

        function calculateTotal() {
            var totalAmount = 0;
            var i = 0;
            $('span[id^="totalPrice_"]').each(function() {
                totalAmount += parseFloat($(this).text());
                i = i + 1;
            });
            $("#totalAmount").text(totalAmount);
            var discount = 0;
            var payChar = $("#discount").val().substr(-1);
            if (payChar == "%") {
                discount = (totalAmount / 100) * parseFloat($("#discount").val());
            } else {
                if (parseFloat($("#discount").val()) >= 0) {
                    discount = parseFloat($("#discount").val());
                } else {
                    $("#discount").val("0");
                    discount = 0;
                }
            }
            var transport = 0;
            if (parseFloat($("#transport").val()) >= 0) {
                transport = parseFloat($("#transport").val());
            } else {
                $("#transport").val("0");
                transport = 0;
            }
            var vat = 0;
            if (parseFloat($("#vat").val()) >= 0) {
                vat = parseFloat($("#vat").val());
            } else {
                $("#vat").val("0");
                vat = 0;
            }
            var ait = 0;
            if (parseFloat($("#ait").val()) >= 0) {
                ait = parseFloat($("#ait").val());
            } else {
                $("#ait").val("0");
                ait = 0;
            }
            var grandTotal = parseFloat(totalAmount) + parseFloat(transport) + parseFloat(vat) + parseFloat(ait) - parseFloat(discount);
            //alert(grandTotal);
          //  $("#grandTotal").text(grandTotal);
            $("#grandSum").text(grandTotal);
            
            var currentDue = parseFloat($("#currentDue").text());
            var totalWithDue = parseFloat(grandTotal) + parseFloat(currentDue);
            $("#totalWithDue").text(totalWithDue);
        }

        function findProduct() {
            $("#barcodeError").text("");
            var barcode = $("#barcode").val();
            var warehouseId = $("#warehouse").val();
            var warehouseName = $("#warehouse option:selected").text();
            var _token = $('input[name="_token"]').val();
            if (warehouseId != '') {
                if (barcode.length >= 6) {
                    var result = confirm("Want to add?");
                    if (result) {
                        var fd = new FormData();
                        fd.append('barcode', barcode);
                        fd.append('warehouseId', warehouseId);
                        fd.append('warehouseName', warehouseName);
                        fd.append('quantity', 1);
                        fd.append('_token', _token);
                        addToCart(fd);
                    }
                }
            } else {
                alert('Warehouse must be selected');
                //$("#warehouse").val('').trigger('change');
            }
        }
        $("#product").change(function() {
            $("#barcodeError").text("");
            var id = $("#product").val();
            var warehouseId = $("#warehouse").val();
            if (warehouseId != '') {
                var warehouseName = $("#warehouse option:selected").text();
                var _token = $('input[name="_token"]').val();
                var fd = new FormData();
                fd.append('id', id);
                fd.append('warehouseId', warehouseId);
                fd.append('warehouseName', warehouseName);
                fd.append('quantity', 1);
                fd.append('_token', _token);
                addToCart(fd);
            }else{
                alert('Warehouse must be selected');
                //$("#warehouse").val('').trigger('change');

            }
        })

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
                url: "{{ url('sale/supplierDue') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                   // alert(JSON.stringify(result));
                    let isEpmty = Object.keys(result).length;
                    if (isEpmty > 0) {
                        $("#currentDue").text(result['current_due']);
                        $("#customerName").val(result['name']);
                        $("#customerAddress").val(result['address']);
                        $("#customer").val(result['id']);
                        $("#partyPhoneNumber").val(result['contact']);
                        $("#creditLimit").text(result['credit_limit']);
                        $("#leftCredit").text(result['credit_limit'] - result['current_due']);
                        $("#customerName").prop('disabled', true);
                        $("#customerAddress").prop('disabled', true);
                    } else {
                        $("#customerName").prop('disabled', false);
                        $("#customerAddress").prop('disabled', false);
                        $("#currentDue").text(0);
                        $("#customerName").val("");
                        $("#customerAddress").val("");
                        $("#currentDue").text(0);
                        $("#customer").val(0);
                        $("#creditLimit").text(0);
                        $("#leftCredit").text(0);
                    }
                    calculateTotal();
                    $("#payment").focus();

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                    $("#barcodeError").text("No such product available in your system");
                   //alert(JSON.stringify(response));
                }
            })
        }

        function addToCart(fd) {
            $.ajax({
                url: "{{ url('sale/addProduct') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    if (result == "Success") {
                        fetchCart();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: result,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                    $("#barcode").focus();
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

        function updateCart(id, warehouse_id) {
            var product_quantity = $('#quantity_' + id+'_'+warehouse_id).val();
            var unitPrice = $('#unitPrice_' + id+'_'+warehouse_id).val();
            var discount = $('#discountPrice_' + id+'_'+warehouse_id).val();
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('quantity', product_quantity);
            fd.append('unitPrice', unitPrice);
            fd.append('discount', discount);
            fd.append('_token', _token);
            fd.append('id', id);
            fd.append('warehouse_id', warehouse_id);
            $.ajax({
                url: "{{ url('sale/updateCart') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                   // alert(JSON.stringify(result));
                    if (result == "Success") {
                        fetchCart();
                        // calculateTotal();
                        // fetchCart();
                        // $('#quantity_'+id).focus();
                    } else {
                        alert("Error To update cart");
                    }
                },
               
                error: function(response) {
                    //alert(JSON.stringify(response));
                    if(response.responseJSON.errors.quantity){
                        Swal.fire("Cancelled", "Quantity is always a number.", "error");
                    }
                    if(response.responseJSON.errors.unitPrice){
                        Swal.fire("Cancelled", "Unit Price is always a number.", "error");
                    }
                    if(response.responseJSON.errors.discount){
                        Swal.fire("Cancelled", "Unit Discount is always a number.", "error");
                    }
                }
            })
        }

        function loadCartandUpdate(id,warehouse_id) {
            // Check Available Quantity
            let available_qty = parseFloat($('#available_qty_' + id+'_'+warehouse_id).text());
            let quantity = parseFloat($('#quantity_' + id+'_'+warehouse_id).val());
            if (available_qty < quantity) {
                Swal.fire({
                    title: 'Error!',
                    text: 'This Quantity Not available for sale',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
                $('#quantity_' + id+'_'+warehouse_id).val(0);
                return 0;
            }
            // End Available Quantity

            updateCart(id, warehouse_id);
            
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
                    $("#barcode").val("");
                    var _token = $('input[name="_token"]').val();
                    var fd = new FormData();
                    fd.append('_token', _token);
                    $.ajax({
                        url: "{{ url('sale/clearCart') }}",
                        method: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        datatype: "json",
                        success: function(result) {
                            $("#barcode").focus();
                            if (result == "Success") {
                                calculateTotal();
                                fetchCart();
                                clearSalesForm();
                                window.localStorage.removeItem('isSave');
                            } else {
                               // alert(JSON.stringify(response));
                            }
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                        error: function(response) {
                            //$("#barcodeError").text("No such product available in your system");
                           // alert(JSON.stringify(response));
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "Your imaginary Expense is safe :)", "error");
                }
            })
        }

        function removeCartProduct(id, warehouse_id) {
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
                    fd.append('id', id);
                    fd.append('warehouse_id', warehouse_id);
                    fd.append('_token', _token);
                    $.ajax({
                        url: "{{ url('sale/removeProduct') }}",
                        method: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        datatype: "json",
                        success: function(result) {
                            $("#barcode").focus();
                            if (result == "Success") {
                                fetchCart();
                                calculateTotal();
                            } else {
                                alert(JSON.stringify(response));
                            }
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                        error: function(response) {
                           // alert(JSON.stringify(response));
                        }
                    })
                } else {
                    Swal.fire("Cancelled", "Your imaginary Expense is safe :)", "error");
                }
            })
        }
        //Save Sale Products
        $("#checkOutCart").click(function(e) {
            Swal.fire({
                title: "Are you sure ?",
                text:  "You want to save this data?",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK!'
            }).then((result) => {
                if (result.isConfirmed) {
            var saleType = $("#saleType").val();
            var date = $("#saleDate").val();
            var customer_id = parseInt($("#customer").val());
            var totalAmount = $("#grandTotal").text();
            var discount = $("#discount").val();
            var carrying_cost = $("#transport").val();
            var vat = $("#vat").val();
            var ait = $("#ait").val();
            var poNumber = $("#poNumber").val();
            var poDate = $("#poDate").val();
            var grand_total = $("#grandSum").text();
            var previous_due = $("#currentDue").text();
            var total_with_due = parseFloat($("#totalWithDue").text());
            var current_payment = $("#payment").val();
            var payment_method = $("#paymentMethod").val();
            var current_balance = parseFloat(total_with_due) - parseFloat(current_payment);
            var totalDue = parseFloat(grand_total)-parseFloat(current_payment);
           // alert(totalDue);
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();

            // Check EMI Yes/No
            var isSave = localStorage.getItem('isSave');
            if (isSave == "save") {
                dayMonthYears = $('span[id^="dayMonthYear"]').text().length;
                fd.append('totalPrice', totalPrice);
                //fd.append('totalPrice', totalPrice);
                //fd.append('totalPrice', totalPrice);
                fd.append('downPayment', downPayment);
                fd.append('duesAmount', duesAmount);
                fd.append('noOfTenure', parseInt(noOfTenure));
                fd.append('startDate', startDate);
                fd.append('perTenurAmount', perTenurAmount);
                fd.append('dayMonthYear', dayMonthYear);
                fd.append('dayMonthYears', dayMonthYears);
                fd.append('emiPaymentDateArray', emiPaymentDateArray);

                emiPaymentDateArray = Object.values(emiPaymentDateArray);

            } else {
                fd.append('noOfTenure', 0);
                //--Check Credit Limit
                var creditLimit = $("#creditLimit").text();
                var leftCredit = $("#leftCredit").text();
                if ((totalDue > leftCredit) && ($("#saleType").val() != 'walkin_sale')) {
                    Swal.fire({
                        title: 'Credit-limit Crossed!',
                        text: 'Sorry, can not cross Credit-limit !',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    return 0;
                }
            }
            //--Check Product & Customer Select or Not
            let product_id = '';
            let product_ids = $('input[name="ids[]"]').val();
            if (product_ids != undefined) {
                product_id = -1;
            }
            //--End Check Product & Supplier Select or Not

            //Just For Validation
            fd.append('product', product_id); // product_id as product_name
            //End Just For Validation

            fd.append('saleType', saleType);
            fd.append('date', date);
            fd.append('customer_id', customer_id);
            fd.append('total_amount', totalAmount);
            fd.append('discount', discount);
            fd.append('carrying_cost', carrying_cost);
            fd.append('vat', vat);
            fd.append('ait', ait);
            fd.append('poNumber', poNumber);
            fd.append('poDate', poDate);
            fd.append('grand_total', grand_total);
            fd.append('previous_due', previous_due);
            fd.append('payment_method', payment_method);
            fd.append('total_with_due', total_with_due);
            fd.append('current_payment', current_payment);
            fd.append('current_balance', current_balance);
            fd.append('totalDue', totalDue);
            // If Customer Not Exist
            var customerName = $("#customerName").val();
            var customerAddress = $("#customerAddress").val();
            var partyPhoneNumber = $("#partyPhoneNumber").val();
            fd.append('customerName', customerName);
            fd.append('customerAddress', customerAddress);
            fd.append('partyPhoneNumber', partyPhoneNumber);

            fd.append('_token', _token);
            clearErrorMessage();

            $.ajax({
                url: "{{ url('sale/checkOutCart') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                   //alert(JSON.stringify(result));
                    clearSalesForm();
                    fetchCart();
                    window.localStorage.removeItem('isSave');
                    calculateTotal();
                    // Redirect After Click OK--//
                    let saleId = result['saleId'];
                    Swal.fire({
                        title: "Saved !",
                        text: result.success,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if(saleType=='ts'){
                                printTsSales(saleId);
                            }else{
                                printSale(saleId);
                            }
                        }
                    });
                    //--End Redirect After Click OK--//
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                  //  alert(JSON.stringify(response));
                    Swal.fire({
                        title: 'Required!',
                        text: 'Please, Fill up Required Field!',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                    $('#partyPhoneNumberError').text(response.responseJSON.errors.partyPhoneNumber);
                    $('#customerNameError').text(response.responseJSON.errors.customerName);
                    if(response.responseJSON.errors.discount){
                        Swal.fire("Cancelled", "Discount should be a number.", "error");
                    }
                    if(response.responseJSON.errors.grand_total){
                        Swal.fire("Cancelled", "Grand Total should be a number.", "error");
                    }
                    if(response.responseJSON.errors.carrying_cost){
                        Swal.fire("Cancelled", "Transport cost should  be a number.", "error");
                    }
                    if(response.responseJSON.errors.vat){
                        Swal.fire("Cancelled", "Vat should  be a number.", "error");
                    }
                    if(response.responseJSON.errors.ait){
                        Swal.fire("Cancelled", "Ait should  be a number.", "error");
                    }
                    if(response.responseJSON.errors.payment_method){
                        Swal.fire("Cancelled", "Payment method should be required.", "error");
                    }
                    if(response.responseJSON.errors.current_payment){
                        Swal.fire("Cancelled", "Paid amount should be a number.", "error");
                    }
                    if(response.responseJSON.errors.date){
                        Swal.fire("Cancelled", "Date is required.", "error");
                    }
                    //$('#warehouseError').text(response.responseJSON.errors.warehouse);
                }
            })
        } else {
                    Swal.fire("Cancelled", "Your imaginary Sales is safe :)", "error");
                }
        });
    });

        function clearSalesForm() {
            $("#supplier").val("");
            $("#poNumber").val("");
            $("#poDate").val("");
            $("#total_amount").text("0");
            $("#discount").val("0");
            $("#transport").val("0");
            $("#vat").val("0");
            $("#ait").val("0");
            $("#grandTotal").text("0");
            $("#currentDue").text("0");
            $("#totalWithDue").text("0");
            $("#payment").val("0");
            //EMI clear
            $('#downPayment').val(0);
            $("#noOfTenure").val(0);
            $('#perTenurAmount').text('');
            $('#startDate').val('');
            $('#category').val('').trigger('change');
            $(".tenurDate").remove();
            // Customer Info
            $('#customer').val(null).trigger('change');
            $("#customerName").val('');
            $("#customerAddress").val('');
            $("#partyPhoneNumber").val('');

        }

        function clearErrorMessage() {
            $('#productError').text('');
            $('#partyPhoneNumberError').text('');
            $('#customerNameError').text('');
            //$('#warehouseError').text('');
        }

        function printSale(id) {
            window.open("{{ url('sale/invoice/') }}" + "/" + id);
        }
        function printTsSales(id) {
            window.open("{{ url('sale/tsInvoice/') }}" + "/" + id);
        }
    </script>
@endsection

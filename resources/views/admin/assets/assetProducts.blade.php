@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Asset Products
@endsection
@section('content')
    <style type="text/css">


    </style>
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;">Asset Product List </h3>
                    <a class="btn btn-cyan float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add
                    Asset Product
                    </a>
                    {{-- <a class="btn btn-cyan float-right" onclick="createService()" style="margin-right:10px;">
                        <i class="fa fa-plus circle"></i> 
                        Add  Service
                    </a> --}}
                    <!-- <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()">
                        <i class="fas fa-sync"></i> Refresh 
                    </a> -->
                </div><!-- /.card-header -->
                <div class="card-body">
                    <!--data listing table-->
                    <div class="table-responsive">
                        <table id="manageProductTable" width="100%" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td width="5%">SL#</td>
                                    <td width="30%">Product Info</td>
                                    <td width="21%">Product Info</td>
                                    <td width="10%">Image</td>
                                    <td width="5%">Status</td>
                                    <td width="7%">Actions</td>
                                </tr>
                            </thead>
                        </table>
                        <!--data listing table-->
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- modal -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog" style="max-width: 70%;" role="document">
            <!-- style, added by Md Hamid -->
            <div class="modal-content">
                <div class="modal-header float-left">
                    <h4 class="modal-title float-left"> Add Asset Product</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="productForm" method="POST" enctype="multipart/form-data" action="#">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label> Category <span class="text-danger"> * </span></label><br>
                                <select name="category_id" id="category_id" class="form-control input-sm">
                                    <option value="" selected="selected">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="categoryError"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label> Brand <span class="text-danger"> * </span></label><br>
                                <select name="brand_id" id="brand_id" class="form-control input-sm">
                                    <option value="" selected>Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="brandError"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label> Product Name <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="name" type="text" name="name"
                                    placeholder=" Product name">
                                <span class="text-danger" id="nameError"></span>
                            </div>
                          
                            <div class="form-group col-md-3">
                                <label>Code <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="code" type="text" name="code"
                                    placeholder="Product Code">
                                <span class="text-danger" id="code_noError"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Model No </label>
                                <input class="form-control input-sm" id="model_no" type="text" name="model_no"
                                    placeholder=" Model Number ">
                                <span class="text-danger" id="model_noError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label> Unit <span class="text-danger"> * </span></label><br>
                                <select name="unit_add" id="unit_add" class="form-control input-sm">
                                    <option value="" selected>Select Unit</option>
                                   @foreach ($units as $unit)
                                        <option value="{{ $unit->name }}">{{ $unit->name }}</option>
                                    @endforeach
                                      
                                 
                                </select>
                                <span class="text-danger" id="brandError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Notes</label>
                                <input class="form-control input-sm" id="notes" type="text" name="notes"
                                    placeholder=" notes about product ">
                                <span class="text-danger" id="notesError"></span>
                            </div>
                          
          
                            <div class="form-group col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="">Image</label>
                                        <input type="file" name="image" id="image"
                                            class="form-control form-control-sm">
                                        <span class="text-danger" id="imageError"></span>

                                        <div class="row">
                                            <div class="form-group col-12">
                                                <img id="showImage" src=" {{ asset('upload/no_image.png') }} "
                                                    alt="Image Not Found"
                                                    style="width: 60%;height: 90px; border:1px solid #000000;margin: 2% 0% 0% 0%;">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Start spec -->
                                    <div class=" col-md-8" id="specSection">
                                        <div class="row">
                                            <div class=" col-5">
                                                <label> Product Specification</label>
                                                <input class="form-control input-sm" id="specName" type="text"
                                                    name="spec" placeholder=" Name">
                                                <span class="text-danger" id="specError"></span>
                                            </div>
                                            <div class=" col-5">
                                                <label>Value </label>
                                                <input class="form-control input-sm" id="specValue" type="text"
                                                    name="spec" placeholder=" Value">
                                                <span class="text-danger" id="specError"></span>
                                            </div>
                                            <div class=" col-2">
                                                <button type="button" class="btn btn-cyan btn-md add mt-4 "
                                                    onclick="addNewSpecRow();"><span class="glyphicon glyphicon-plus"
                                                        style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>
                                            </div>
                                            <!--new spec append here...-->
                                        </div>
                                    </div>
                                    <!-- End spec -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x
                                Close</button>
                            <button type="submit" class="btn btn-cyan " id="saveProduct"><i class="fa fa-save"></i>
                                Save Product</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->




    <!-- edit modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog" style="max-width: 80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Asset Product</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">

                    <form id="editProductForm" method="POST" enctype="multipart/form-data" action="#">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="editId" id="editId">
                            <div class="form-group col-md-3" id="CategoryDiv">
                                <label> Category <span class="text-danger"> * </span></label><br>
                                <select name="editCategory" id="editCategory" class="form-control input-sm">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editCategoryError"></span>
                            </div>
                            <div class="form-group col-md-3" id="BrandDiv">
                                <label> Brand <span class="text-danger"> * </span></label><br>
                                <select name="editBrand" id="editBrand" class="form-control input-sm">
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editBrandError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label> Product Name <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="editName" type="text" name="editName">
                                <span class="text-danger" id="editNameError"></span>
                            </div>
                           
                            <div class="form-group col-md-3" id="ModelDiv">
                                <label>Model No <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="editModelNo" type="text" name="editModelNo">
                                <span class="text-danger" id="editModelNoError"></span>
                            </div>
                        
                            <div class="form-group col-md-3">
                                <label> Status <span class="text-danger"> * </span></label>
                                <select id="editStatus" name="editStatus" class="form-control input-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger" id="editStatusError"></span>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Notes</label>
                                <input class="form-control input-sm" id="editNotes" type="text" name="editNotes"
                                    placeholder="notes about product">
                                <span class="text-danger" id="editNotesError"></span>
                            </div>
                        
                            <div class="form-group col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-3 " id="ImageDiv">
                                        <label for="">Edit Image</label>
                                        <input type="file" name="editImage" id="editImage"
                                            class="form-control form-control-sm">
                                        <span class="text-danger" id="editImageError"></span>
                                        <div class="row">
                                            <div class="form-group col-12">
                                                <img id="showImage" src="{{ asset('upload/no_image.png') }}"
                                                    style="width: 60%;height: 90px; border:1px solid #000000;margin: 2% 0% 0% 0%;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2" id="ShowImageDiv">
                                        <img id="editShowImage" src="{{ url('upload/no_image.png') }}"
                                            style="width: 100%; border:1px solid #ececec;">
                                    </div>
                                    <!-- Start edit spec -->
                                    <div class="col-md-7" id="editSpecSection">
                                        <div class="row">
                                            <div class="col-12"></div>

                                            <div class="col-10">
                                                <label> Product Specification</label>
                                            </div>
                                            <div class=" col-2">
                                                <button type="button" class="btn btn-cyan btn-md add"
                                                    onclick="addSpecRowForEdit();"><span class="glyphicon glyphicon-plus"
                                                        style="font-size: 18px; font-weight:800;"><strong>+</strong></span></button>
                                            </div>

                                            <!--edit spec append here...-->
                                        </div>
                                    </div>
                                    <!-- End spec -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x
                                Close</button>
                            <button type="submit" class="btn btn-cyan" id="updateProduct"><i
                                    class="fa fa-save"></i>
                                Update Product</button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal --> 

@endsection

@section('javascript')
<script>


   //=========== Start Serialize Product ===========//
   var serialNumbers = [];
        var stockQuantities = [];
        var tempOpeningStock = 0;
        var tempitemsInBox = 0;

        function checkType() {
            let itemsInBox = $("#itemsInBox").val();
            let openingStock = $("#opening_stock").val();
            var type = $("#type").val();
            if (type == "serialize") {
                $("#itemsInBox").prop("disabled", false);
                if (openingStock > 0 && itemsInBox > 0) {
                    if (tempOpeningStock != openingStock || tempitemsInBox != itemsInBox) {
                        tempOpeningStock = openingStock;
                        tempitemsInBox = itemsInBox;
                        serialNumbers = [];
                        stockQuantities = [];
                    } else {
                        storeSerialNumbers();
                        storeStockQuantity();
                    }
                    addProductSerial(type, openingStock, itemsInBox);
                }
            } else {
                $("#showBtn").addClass("d-none");
                $("#itemsInBox").val('');
                $("#itemsInBox").prop("disabled", true);
                serialNumbers = [];
                stockQuantities = [];
            }
        }

        function storeSerialNumbers() {
            serialNumbers = $('input[id^=serialNo]').map(function(index, serialNo) {
                return $(serialNo).val();
            }).get();
        }

        function storeStockQuantity() {
            stockQuantities = $('input[name^=stockQuantity]').map(function(index, quantity) {
                return $(quantity).val();
            }).get();
        }

        function addProductSerial(type, openingStock, itemsInBox) {
            var carton = openingStock / itemsInBox;
            if (stockQuantities.length > 0) {
                carton = stockQuantities.length;
            }
            let rows = '';
            var remainingStock = openingStock;
            if (type == "serialize" && carton > 0) {
                for (let i = 0; i < carton; i++) {
                    let serialNo = i + 1;
                    remainingStock = remainingStock - itemsInBox;
                    if (remainingStock < 0) {
                        itemsInBox = parseFloat(itemsInBox) + parseFloat(remainingStock);
                    }
                    if (stockQuantities.length > 0) {
                        itemsInBox = stockQuantities[i];
                        serialNo = serialNumbers[i];
                    }
                    rows += '<tr id="row' + i + '">' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td><input class="form-control input-sm stockQuantity' + i +
                        '" id="stockQuantity" value="' +
                        itemsInBox +
                        '" type="number" name="stockQuantity" placeholder=" Quantity... " required oninput="calculateTotalQuantity()"></td>';
                    if (i == 0) {
                        rows +=
                            '<td><input class="form-control input-sm serialNo0" id="serialNo" type="text" name="serialNo" placeholder=" Serial... " required oninput="generateSerialNo(this.value);" value="' +
                            serialNo + '"><td><a href="#" onclick="removeRow(' +
                            i + ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td>';
                    } else {
                        rows +=
                            '<td><input class="form-control input-sm serialNo' + i +
                            '" id="serialNo" type="text" name="serialNo" placeholder=" Serial... " value="' + serialNo +
                            '" required><td><a href="#" onclick="removeRow(' +
                            i + ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td>';
                    }
                    rows += '</tr>';
                }
                $("#serializeProductTable").html('');
                $("#serializeProductTable").html(rows);
                $("#totalStockQuantity").text(openingStock);
                $("#showBtn").removeClass("d-none");
                $("#serializeProductModal").modal("show");
            }
        }

        function generateSerialNo(num) {
            let len = $('input[name^=serialNo]').length;
            serialNo = parseInt(num);
            if (num > 0) {
                for (let i = 1; i <= len; i++) {
                    $(".serialNo" + i).val((serialNo + i));
                }
            }
            storeSerialNumbers();
        }

        function addRow() {
            var trId = $('#serializeProductTable tr:last').attr('id');
            trId = parseInt(trId.substring(3)) + 1;
            let serialNum = parseInt($(".serialNo" + (trId - 1)).val()) + 1;
            let rows = '';
            rows += '<tr id="row' + trId + '">' +
                '<td>' + (trId + 1) + '</td>' +
                '<td><input class="form-control input-sm stockQuantity' + trId +
                '" id="stockQuantity" type="number" name="stockQuantity" placeholder=" Quantity... " required oninput="calculateTotalQuantity()"></td>';
            rows += '<td><input class="form-control input-sm serialNo' + trId +
                '" id="serialNo" type="text" name="serialNo" placeholder=" Serial... " required value="' + serialNum +
                '" ><td><a href="#" onclick="removeRow(' +
                trId + ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td></tr>';
            $("#serializeProductTable").append(rows);
        }

        function removeRow(rowNumber) {
            $('#row' + rowNumber).remove();
            $("#serializeProductTable").find('tr').each(function(i, el) {
                $(el).find("td").eq(0).text(i + 1);
            });
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Confirmed',
                showConfirmButton: false,
                timer: 200,
            });
            calculateTotalQuantity();
        }

        function calculateTotalQuantity() {
            var totalStockQuantity = 0;
            $('[name="stockQuantity"]').each(function() {
                var currentTxtQuantity = $(this).val();
                if (currentTxtQuantity == '') {
                    currentTxtQuantity = 0;
                }
                totalStockQuantity += parseFloat(currentTxtQuantity);
            });
            $("#totalStockQuantity").text(totalStockQuantity);
            $("#opening_stock").val(totalStockQuantity);
            tempOpeningStock = totalStockQuantity;
            storeStockQuantity();
            storeSerialNumbers();
        }
        //=========== End Serialize Product ===========//

        //===========  Spec  ===========//
        // Start add new spec row
        var rowNumber = 0;

        function addNewSpecRow(type = 'regular') {
            
            
                if(type == 'service'){
                    var newSpecRow = '<div class="row" id="' + rowNumber + '">' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="servicespecName" type="text" name="servicespecName" placeholder=" Name">' +
                '<span class="text-danger" id="specError" ></span>' +
                '</div>' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="servicespecValue" type="text" name="servicespecValue" placeholder=" Value">' +
                '<span class="text-danger" id="specError"></span>' +
                '</div>' +
                '<div class=" col-2 mt-2">' +
                '<button type="button" class="btn btn-danger btn-md add" onclick="deleteSpecRow(' +
                rowNumber +
                ');"><span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>' +
                '</div></div>';

                    $("#specSectionService").append(newSpecRow);

                }else{

                    var newSpecRow = '<div class="row" id="' + rowNumber + '">' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="specName" type="text" name="specName" placeholder=" Name">' +
                '<span class="text-danger" id="specError" ></span>' +
                '</div>' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="specValue" type="text" name="specValue" placeholder=" Value">' +
                '<span class="text-danger" id="specError"></span>' +
                '</div>' +
                '<div class=" col-2 mt-2">' +
                '<button type="button" class="btn btn-danger btn-md add" onclick="deleteSpecRow(' +
                rowNumber +
                ');"><span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>' +
                '</div></div>';

                    $("#specSection").append(newSpecRow);

                }
            rowNumber++;

        } // End add new spec row

        // Start edit spec row 
        var editRowNumber = 0;

        function addSpecRowForEdit() {
            var editSpecRow = '<div class="row editSpecRow" id="' + editRowNumber + '">' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="editNewSpecName" type="text" name="editNewSpecName">' +
                '<span class="text-danger" id="specError" ></span>' +
                '</div>' +
                '<div class=" col-5 mt-2">' +
                '<input class="form-control input-sm"  id="editNewSpecValue" type="text" name="editNewSpecValue" >' +
                '<span class="text-danger" id="specError"></span>' +
                '</div>' +
                '<div class=" col-2 mt-2">' +
                '<button type="button" class="btn btn-danger btn-md add" onclick="deleteSpecRow(' +
                editRowNumber +
                ');"><span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>' +
                '</div></div>';

            $("#editSpecSection").append(editSpecRow);
            editRowNumber++;
        } // End edit SpecRow

        // Start delete added spec row
        function deleteSpecRow(rowNum) {
            $('#' + rowNum).remove();
        }
        // End delete added SpecRow

        // Start delete editSpecRow (Edit-Form)
        function deleteSpecConfirm(rowNum) {
            deleteSpec(rowNum);
        }

        function deleteSpec(id) {
            Swal.fire({
                title: "Are you sure ?",
                text: "You will not be able to recover this Spec!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete Product Spec!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var productId = $("#editId").val();
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    var fd = new FormData();
                    fd.append('id', id);
                    fd.append('productId', productId);
                    fd.append('_token', _token);
                    $.ajax({
                        url: "{{ route('deleteSpec') }}",
                        method: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(result) {
                            $('#' + id).remove();
                            Swal.fire("Done!", result.success, "success");
                        },
                        error: function(response) {
                            //alert(JSON.stringify(response));
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your imaginary Product is safe :)", "error");
                }
            })

        } // End delete editSpecRow

        //=========== End Spec  ===========//

        $(function() {
            $(document).ready(function() {
                $("#category_id").select2({
                    placeholder: "Select Category",
                    dropdownParent: $("#modal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#stock_warehouse").select2({
                    placeholder: "Select Warehouse",
                    dropdownParent: $("#modal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#editStock_warehouse").select2({
                    placeholder: "Select Warehouse",
                    dropdownParent: $("#modal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#unitAdd").select2({
                    placeholder: "Select Unit",
                    dropdownParent: $("#modal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#editUnit").select2({
                    placeholder: "Select Unit",
                    dropdownParent: $("#modal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#brand_id").select2({
                    placeholder: "Select Brand",
                    dropdownParent: $("#modal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#editCategory").select2({
                    placeholder: "Select Category",
                    dropdownParent: $("#editModal"),
                    allowClear: true,
                    width: '100%'
                });
                $("#editBrand").select2({
                    placeholder: "Select Brand",
                    dropdownParent: $("#editModal"),
                    allowClear: true,
                    width: '100%'
                });
            });
        });

        function create() {
            reset();
            $("#modal").modal('show');
        }

        function createService() {
            reset();
            $("#servicemodal").modal('show');
        }

        $('#modal').on('shown.bs.modal', function() {
            $('#name').focus();
        })
        $('#editModal').on('shown.bs.modal', function() {
            $('#editName').focus();
        })
        var table;
        $(document).ready(function() {
        
            table = $('#manageProductTable').DataTable({
                'ajax': "{{ route('assets.products.getproducts') }}",
                processing: true,
            });
        });

        $("#productForm").submit(function(e) {
            e.preventDefault();
            clearMessages();
            var specNames = $('input[id^=specName]').map(function(index, name) {
                return $(name).val();
            }).get();
            var specValues = $('input[id^=specValue]').map(function(index, value) {
                return $(value).val();
            }).get();
            var name = $("#name").val();
            var code = $("#code").val();
            var category_id = $("#category_id").val();
            var brand_id = $("#brand_id").val();
            var units = $("#unit_add").val();
            var notes = $("#notes").val();
            var model_no = $("#model_no").val();
            var productImage = $('#image')[0].files[0];
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();
            fd.append('name', name);
            fd.append('code', code);
            fd.append('category_id', category_id);
            fd.append('units', units);
            fd.append('notes', notes);
            fd.append('model_no', model_no);
            fd.append('brand_id', brand_id);
            fd.append('image', productImage);
            let chechspecNames = $.trim(specNames[0]);
            let checkspecValues = $.trim(specValues[0]);
            // Serialize Product
            // if (type == "serialize") {
            //     storeSerialNumbers();
            //     storeStockQuantity();
            //     let totalStockQuantity = parseFloat($("#totalStockQuantity").text());
            //     fd.append('itemsInBox', itemsInBox);
            //     fd.append('serialNumbers', serialNumbers);
            //     fd.append('stockQuantities', stockQuantities);
            //     fd.append('totalStockQuantity', totalStockQuantity);
            //     if (opening_stock != totalStockQuantity) {
            //         Swal.fire("Warning: ", "Openning Stock Must Be Equal To Total Quantity! ", "warning");
            //         return 0;
            //     }
            // } else {
            //     fd.append('itemsInBox', 0);
            // }
            // End Serialize Product
            if (chechspecNames.length <= 0 && checkspecValues.length <= 0) {
                fd.append('specNames', -1);
                fd.append('specValues', -1);
            } else {
                fd.append('specNames', specNames);
                fd.append('specValues', specValues);
            }
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('assets.products.store') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    if (result['success']) {
                        $("#modal").modal('hide');
                        Swal.fire("Product saved!", result.success, "success");
                        reset();
                        $("#productForm").trigger("reset");
                        table.ajax.reload(null, false);
                        for (i = 0; i < rowNumber; i++) {
                            $('#' + i).remove();
                        }
                    } else {
                        Swal.fire("Error!", result['error'], "error");
                    }
                },
                error: function(response) {
                    //alert(JSON.stringify(response));
                    $('#nameError').text(response.responseJSON.errors.name);
                    $("#categoryError").text(response.responseJSON.errors.category_id);
                    $("#brandError").text(response.responseJSON.errors.brand_id);
                    $("#unitError").text(response.responseJSON.errors.unit_id);
                    $("#notesError").text(response.responseJSON.errors.notes);
                    $("#model_noError").text(response.responseJSON.errors.model_no);
                    $("#code_noError").text(response.responseJSON.errors.code);
                    $('#imageError').text(response.responseJSON.errors.image);
                    // if (type == "serialize") {
                    //     $('#itemsInBoxError').text('This field is required.');
                    //     Swal.fire("Error: ", "Please Check Required Field ! ", "error");
                    // }
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }

            })
        })


        function clearMessages() {
            $('#nameError').text("");
            $("#codeError").text("");
            $("#categoryError").text("");
            $("#brandError").text("");
            $("#unitError").text("");
            $('#imageError').text("");
        }

        function editClearMessages() {
            $('#editNameError').text("");
            $('#editCodeError').text("");
           
            $('#editCategoryError').text("");
            $('#editBrandError').text("");
            $('#editUnitError').text("");
          
            $('#editImageError').text("");
        

        }

        function reset() {
            $("#name").val("");
            $("#code").val("");
          
            $("#category_id").val("").trigger("change");
            $("#brand_id").val("").trigger("change");
            $("#units").val("").trigger("change");
       
            $("#image").val("")
            //$('#showImage').attr('src', "");
            $("#serializeProductTable").html('');
        }

        function editReset() {
            $("#editName").val("");
            $("#editCode").val("");
            $("#editBarcode").val("");
            $("#editCategory").val("").trigger("change");
            $("#editBrand").val("").trigger("change");
            $("#editUnit").val("");
            $("#editOpenStock").val("");
            $("#editRemainder").val("");
            $("#editPurchase").val("");
            $("#sale_price").val("");
            $("#discount").val("");
            $("#image").val("")
            $('#showImage').attr('src', "");
        }

        function editProduct(id) {
            editReset();
            editClearMessages();
            $.ajax({
                url: "{{ route('assets.products.editProduct') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    $('.editSpecRow').remove();
                    $("#editModal").modal('show');
                 
                    $("#editName").val(result[0].productName);
                    $("#editCode").val(result[0].productCode);
                    $("#editCategory").val(result[0].tbl_assetCategoryId).trigger("change");
                    $("#editBrand").val(result[0].tbl_assetBrandId).trigger("change");
                    $("#editUnit").val(result[0].units);
                    $("#editModelNo").val(result[0].modelNo);
                    $("#editNotes").val(result[0].notes);
                    var imageString = '{{ asset('upload/asset_product_images/resizes') }}' + "/" + result[0].productImage;
                    if(result[0].productImage == 'no_image.png'){
                        var imageString = '{{ asset('upload/') }}' + "/" + result[0].productImage;
                    }
                    $('#editShowImage').attr('src', imageString);
                    $("#editId").val(result[0].id);
                    if (result[0].status != "") {
                        $("#editStatus").val(result[0].status);
                    } else {
                        $("#editStatus").val("Inactive");
                    }
                    // Start Edit Spec
                    for (i = 0; i < result[1].length; i++) {
                        var setSpecRow = '<div class="row editSpecRow" id="' + result[1][i].id + '">' +
                            '<div class=" col-5 mt-2">' +
                            '<input id="specids" type="hidden"  value="' + result[1][i].id + '">' +
                            '<input class="form-control input-sm"  id="editSpecName" type="text" name="editSpecName" value="' +
                            result[1][i].specificationName + '">' +
                            '<span class="text-danger" id="specError" ></span>' +
                            '</div>' +
                            '<div class=" col-5 mt-2">' +
                            '<input class="form-control input-sm"  id="editSpecValue" type="text" name="editSpecValue" value="' +
                            result[1][i].specificationValue + '">' +
                            '<span class="text-danger" id="specError"></span>' +
                            '</div>' +
                            '<div class=" col-2 mt-2">' +
                            '<button type="button" class="btn btn-danger btn-md add" onclick="deleteSpecConfirm(' +
                            result[1][i].id +
                            ');"><span class="glyphicon glyphicon-plus" style="font-size: 18px; font-weight:800;"><strong>x</strong></span></button>' +
                            '</div></div>';
                        $("#editSpecSection").append(setSpecRow);
                        editRowNumber++;
                    }
                    // End Edit Spec
                },
                error: function(response) {
                    //alert(JSON.stringify(response));

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        var productType = null;
        var temp_items_InBox = null;

        function editOpenStock(id) {
            editClearMessages();
            $.ajax({
                url: "{{ route('editOpenStock') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    $("#editOpenStockModal").modal('show');
                    $("#editOpenStockId").val(result.product.id);
                    $("#editOpenStockName").val(result.product.name);
                    $("#editOpenStockInsert").val(result.product.opening_stock);
                    $("#initialStockData").html(result.initialStockData);
                    // Edit Serialize Product
                    productType = result.product.type;
                    temp_items_InBox = result.product.items_in_box;
                    if (result.product.type == "serialize") {
                        $("#editSerializeProductTable").removeClass("d-none");
                        $(".editSerializeProductTable").removeClass("d-none");
                        $("#editSerializeProductStockData").html('');
                        $("#editSerializeProductStockData").html(result.serializeProductRows);
                    } else {
                        $("#editSerializeProductTable").addClass("d-none");
                        $(".editSerializeProductTable").addClass("d-none");
                    }
                    // End Edit Serialize Product
                },
                error: function(response) {
                    //alert(JSON.stringify(response));

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        // Start Edit Serialize Product For Opening Stock
        function updateCalculateTotalQuantity(saleQty, product_id, warehouse_id, tblSerializeId) {
            var totalStockQuantity = 0;
            $('[name="stockQuantity"]').each(function() {
                var currentTxtQuantity = $(this).val();
                if (currentTxtQuantity == '') {
                    currentTxtQuantity = 0;
                }
                totalStockQuantity += parseFloat(currentTxtQuantity);
            });
            $("#totalStockQuantity").text(totalStockQuantity);
            $("#editOpenStockInsert").val(totalStockQuantity);

            ediStoreSerialNumbers();
            editStoreStockQuantity();
        }

        var editSerialNumbers = [];
        var editStockQuantities = [];
        // Create Serialize Table
        function checkTypeForOpenStockEdit() {
            if (productType == "serialize") {
                let openingStock = $("#editOpenStockInsert").val();
                let itemsInBox = temp_items_InBox;
                let carton = openingStock / itemsInBox;
                let rows = '';
                var remainingStock = openingStock;
                for (let i = 0; i < carton; i++) {
                    let serialNo = i + 1;
                    remainingStock = remainingStock - itemsInBox;
                    if (remainingStock < 0) {
                        itemsInBox = parseFloat(itemsInBox) + parseFloat(remainingStock);
                    }
                    editSerialNumbers[i];
                    editStockQuantities[i];
                    rows += '<tr id="row' + i + '">' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td><input class="form-control input-sm serialNo' + i +
                        '" id="editSerialNo" type="text" name="serialNo" placeholder=" Serial... " value="' + serialNo +
                        '" required></td>';
                    if (i == 0) {
                        rows +=
                            '<td><input class="form-control input-sm stockQuantity' + i +
                            '" id="stockQuantity" value="' +
                            itemsInBox +
                            '" type="number" name="stockQuantity" placeholder=" Quantity... " required oninput="updateCalculateTotalQuantity()"><td><a href="#" onclick="removeRow(' +
                            i + ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td>';
                    } else {
                        rows +=
                            '<td><input class="form-control input-sm stockQuantity' + i +
                            '" id="stockQuantity" value="' +
                            itemsInBox +
                            '" type="number" name="stockQuantity" placeholder=" Quantity... " required oninput="updateCalculateTotalQuantity()"><td><a href="#" onclick="removeRow(' +
                            i + ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td>';
                    }
                    rows += '</tr>';
                }
                $("#editSerializeProductStockData").html('');
                $("#editSerializeProductStockData").html(rows);
                $("#totalStockQuantity").text(openingStock);
                ediStoreSerialNumbers();
                editStoreStockQuantity();
            }
        }

        function ediStoreSerialNumbers() {
            editSerialNumbers = $('input[id^=editSerialNo]').map(function(index, serialNo) {
                return $(serialNo).val();
            }).get();
        }

        function editStoreStockQuantity() {
            editStockQuantities = $('input[name^=stockQuantity]').map(function(index, quantity) {
                return $(quantity).val();
            }).get();
        }
        // End Edit Serialize Product For Opening Stock

        $("#editProductForm").submit(function(e) {
            e.preventDefault();
            editClearMessages();
            var name = $("#editName").val();
           
       
            var category_id = $("#editCategory").val();
            var brand_id = $("#editBrand").val();
            var unit = $("#editUnit").val();
            var model_no = $("#editModelNo").val();
            var notes = $("#editNotes").val();
            var status = $("#editStatus").val();

            var specNames = [];
            var specValues = [];
            var specIds = [];
            var newSpecNames = [];
            var newSpecValues = [];
            var i = 0;

            $('[id^="specids"]').each(function() {
                specIds[i] = $(this).val();
                i++;
            });
            i = 0;
            $('input[id^="editSpecName"]').each(function() {
                specNames[i] = $(this).val();
                i++;
            });
            i = 0;
            $('input[id^="editSpecValue"]').each(function() {
                specValues[i] = $(this).val();
                i++;
            });
            i = 0;
            $('[id^="editNewSpecName"]').each(function() {
                newSpecNames[i] = $(this).val();
                i++;
            });
            i = 0;
            $('[id^="editNewSpecValue"]').each(function() {
                newSpecValues[i] = $(this).val();
                i++;
            });
            var productImage = $('#editImage')[0].files[0];
            var _token = $('input[name="_token"]').val();
            if( ($("#editType").val()) == null){
                var type= 'service';
            }else{
                var type = $("#editType").val();
            }
            
            if( ($("#editStockCheck").val()) == null){
                var stockCheck= 'No';
            }else{
                var stockCheck = $("#editStockCheck").val();
            }
            
           

            var id = $("#editId").val();
            var fd = new FormData();
            fd.append('name', name);
            fd.append('code', code);
        
            fd.append('category_id', category_id);
            fd.append('brand_id', brand_id);
            fd.append('model_no', model_no);
            fd.append('notes', notes);
            fd.append('unit', unit);
            fd.append('image', productImage);
            fd.append('status', status);
            fd.append('id', id);

            // End Serialize
            //Specs
            if (specIds.length <= 0) {
                fd.append('specIds', -1);
            } else {
                fd.append('specIds', specIds);
            }
            fd.append('specNames', specNames);
            fd.append('specValues', specValues);
            //New Specs
            if (newSpecNames.length == 0 || newSpecValues.length == 0) {
                fd.append('newSpecNames', -1);
                fd.append('newSpecValues', -1);
            } else {
                fd.append('newSpecNames', newSpecNames);
                fd.append('newSpecValues', newSpecValues);
            }
            // End New Specs

            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('assets.products.update') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                //alert(JSON.stringify(result));
                    $("#editModal").modal('hide');
                    Swal.fire("Updated Product!", result.success, "success");
                    $('.editSpecRow').remove();
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    //alert(JSON.stringify(response));
                    $('#editNameError').text(response.responseJSON.errors.productName);
                    $('#editCodeError').text(response.responseJSON.errors.productCode);
                    $('#editCategoryError').text(response.responseJSON.errors.tbl_assetCategoryId);
                    $('#editBrandError').text(response.responseJSON.errors.tbl_assetBrandId);
                    $('#editUnitError').text(response.responseJSON.errors.units);
                    $('#editStatusError').text(response.responseJSON.errors.status);
                    $('#editImageError').text(response.responseJSON.errors.productImage);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            })
        });

        $("#editOpenStockProductForm").submit(function(e) {
            e.preventDefault();
            var productId = $("#editOpenStockId").val();
            var openingStock = $("#editOpenStockInsert").val();
            var warehouseId = $("#edit_open_stock_warehouse").val();
            var _token = $('input[name="_token"]').val();

            var id = $("#editId").val();
            var fd = new FormData();
            fd.append('productId', productId);
            fd.append('openingStock', openingStock);
            fd.append('warehouseId', warehouseId);
            // Serialize
            if (productType == "serialize") {
                fd.append('editSerialNumbers', editSerialNumbers);
                fd.append('editStockQuantities', editStockQuantities);
            }
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('updateProductOpenStock') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    
                    $("#editOpenStockModal").modal('hide');
                    Swal.fire("Updated Stock!", result.success, "success");
                    table.ajax.reload(null, false);
                    $("#edit_open_stock_warehouse").val("").trigger("change");
                },
                error: function(response) {
                   
                    if (response.responseJSON.errors && jQuery.inArray("warehouseId", response
                            .responseJSON.errors)) {
                        $('#edit_open_stock_warehouseError').text("Please Select Warehouse.");
                    } else {
                        Swal.fire("Updated Stock Error!", "try again", "error");
                    }

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            })
        })

        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure ?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete Product!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('assets.products.delete') }}",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": _token
                        },
                        success: function(result) {
                            Swal.fire("Done!", result.success, "success");
                            table.ajax.reload(null, false);
                        },
                        error: function(response) {
                            //alert(JSON.stringify(response));
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your imaginary Product is safe :)", "error");
                }
            })

        }

        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

            $('#editImage').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#editShowImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });

        });



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
                $("#productForm").trigger('submit');
            } else {
                //alert("Not Calling");
            }
        });
        Mousetrap.bind('ctrl+shift+u', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editProductForm").trigger('submit');
            } else {
                //alert("Not Calling");
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
@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Floor
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
    </style>
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;"> Table List </h3>
                    <a class="btn btn-primary float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add Table</a>
                    <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                        Refresh</a>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-12">

                        <!--data listing table-->
                        <table id="manageTable" width="100%" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td width="5%">SL#</td>
                                    <td>Image</td>
                                    <td>General Info</td>
                                    <td>Code</td>
                                    <td>Asset Info</td>
                                    <td>Capacity</td>
                                    <td width="5%">Status</td>
                                    <td width="5%">Action</td>
                                </tr>
                            </thead>
                        </table>
                        <!--data listing table-->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- modal -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog" style="width: 30%">
            <div class="modal-content">
                <div class="modal-header float-left">
                    <h4 class="modal-title float-left"> Add Table</h4>
                    <button type="button" class="close"data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="tableForm" method="POST" enctype="multipart/form-data" action="#">
                        @csrf

                        <input type="hidden" name="id">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="building"> Select building <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="building" name="building"
                                    onchange="getRooms()">
                                    <option value="" selected> Select building </option>
                                    @foreach ($buildings as $building)
                                        <option value="{{ $building->id }}">
                                            {{ $building->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="buildingError"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="building"> Room <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="room" name="room">
                                    <option value="" selected> Select Room </option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="roomError"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="building"> Asset Product <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="asset_product_id" name="asset_product_id"
                                    onchange="getAssetProduct()">
                                    <option value="" selected> Select asset product </option>
                                    @foreach ($assetProducts as $assetProduct)
                                        <option value="{{ $assetProduct->id }}">
                                            {{ $assetProduct->productName }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="asset_product_idError"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="building"> Asset Serialize Product  <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="asset_serialize_product_id" name="asset_serialize_product_id">
                                    <option value="" selected> Select Asset Serialize Product </option>
                                    @foreach ($assetSerializeProducts as $assetSerializeProduct)
                                        <option value="{{ $assetSerializeProduct->id }}">
                                            {{ $assetSerializeProduct->serial_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="asset_serialize_product_idError"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <hr>
                            <div class="form-group col-md-6">
                                <label>Table  Name<span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="name" type="text" name="name"
                                    placeholder="Enter Table Name">
                                <span class="text-danger" id="nameError"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="floor_no"> Capacity <span class="text-danger">*</span></label>
                                <input class="form-control input-sm" id="capacity" type="number" name="capacity"
                                    placeholder="Enter capacity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                <span class="text-danger" id="capacityError"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label for="">Image</label>
                                <input type="file" name="image" id="image"
                                    class="form-control form-control-sm">
                                <span class="text-danger" id="imageError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <img id="showImage" src=" {{ asset('upload/table_images/no_image.png') }} "
                                    alt="Image Not Found"
                                    style="width: 60%;height: 90px; border:1px solid #000000;margin: 2% 0% 0% 0%;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X Close</button>
                            <button type="submit" class="btn btn-primary btnSave float-right" id="saveCategory"><i
                                    class="fa fa-save"></i> Save</button>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- edit modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Table</h4>
                    <button type="button" class="close"data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="editTableForm" method="POST" enctype="multipart/form-data" action="#">
                        @csrf

                        <input type="hidden" name="editId" id="editId">
                        <div class="form-group row">

                            <div class="col-md-6">
                                <label for="editBuilding"> Select building <span class="text-danger"></span></label>
                                <select class="form-control input-sm" id="editBuilding" name="editBuilding"
                                    onchange="getEditRooms()">
                                    <option value="" selected> Select building </option>
                                    @foreach ($buildings as $building)
                                        <option value="{{ $building->id }}">
                                            {{ $building->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editBuildingError"></span>
                            </div>

                            <div class="col-md-6">
                                <label for="building"> Room <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="editRoom" name="editRoom">
                                    <option value="" selected> Select Room </option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editRoomError"></span>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="building"> Asset Product <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="editAsset_product_id" name="editAsset_product_id"
                                    onchange="getEditAssetProduct()">
                                    <option value="" selected> Select asset product </option>
                                    @foreach ($assetProducts as $assetProduct)
                                        <option value="{{ $assetProduct->id }}">
                                            {{ $assetProduct->productName }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editAsset_product_idError"></span>
                            </div>

                            <div class="col-md-6">
                                <label for="building"> Asset Serialize Product  <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="editAsset_serialize_product_id" name="editAsset_serialize_product_id">
                                    <option value="" selected> Select Asset Serialize Product </option>
                                    @foreach ($assetSerializeProducts as $assetSerializeProduct)
                                        <option value="{{ $assetSerializeProduct->id }}">
                                            {{ $assetSerializeProduct->serial_no }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editAsset_serialize_product_idError"></span>
                            </div>

                            <div class="col-md-6">
                                <label>Table Name <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="editName" type="text" name="editName"
                                    placeholder="Enter Table Name" required="">
                                <span class="text-danger" id="editNameError"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_capacity">Capacity <span class="text-danger"> </span></label>
                                <input class="form-control input-sm" id="editCapacity" type="number"
                                    name="editCapacity" onblur="floor_no_get_seletion()" placeholder="Enter Capacity">
                                <span class="text-danger" id="editCapacityError"></span>
                            </div>
                            
                            <div class="col-md-6">
                                <label> Status</label>
                                <select id="editStatus" name="editStatus" class="form-control input-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6 " id="ImageDiv">
                                <label for="">Edit Image</label>
                                <input type="file" name="editImage" id="editImage"
                                    class="form-control form-control-sm">
                                <span class="text-danger" id="editImageError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <img id="editShowImage" src="{{ asset('upload/table_images/no_image.png') }}"
                                    style="width: 60%;height: 90px; border:1px solid #000000;margin: 2% 0% 0% 0%;">
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X
                                Close</button>
                            <button type="submit" class="btn btn-primary btnUpate" id="editCategory"><i
                                    class="fa fa-save"></i> Update
                            </button>
                    </form>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('javascript')
    <script>
        function floor_no_get_seletion() {
            $("#editTable_no").val(result['floor'].floor_no)
        }

        function create() {
            reset();
            $("#modal").modal('show');
            //$(".btnSave").show();
        }
        $('#modal').on('shown.bs.modal', function() {
            $('#name').focus();
        })
        $('#editModal').on('shown.bs.modal', function() {
            $('#editName').focus();
        })
        var table;
        $(document).ready(function() {
            table = $('#manageTable').DataTable({
                'ajax': "{{ route('Sweets_and_confectionery.table.getTable') }}",
                processing: true,
            });
        });
        $("#building").select2({
            placeholder: "Select Building",
            allowClear: true,
            width: '100%'
        });


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



        function getRooms() {
            var id = $('#building').val();
            $.ajax({
                url: "{{ route('hotelManagement.building.getRoomsFromBuilding') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    // alert(JSON.stringify(result));
                    $('#room').html(result);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },error: function(response) {
                    // alert(JSON.stringify(response));
                },
            });
        }
        function getEditRooms() {
            var id = $('#editBuilding').val();
            $.ajax({
                url: "{{ route('hotelManagement.building.getRoomsFromBuilding') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    $('#editRoom').html(result);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },error: function(response) {
                   // alert(JSON.stringify(response));
                },
            });
        }



        function getAssetProduct(){
            var asset_product_id=$('#asset_product_id').val();
            //alert(asset_product_id);
            $.ajax({
                url: "{{ route('Sweets_and_confectionery.table.assetSerializeProduct') }}",
                method: "GET",
                data: {
                    "asset_product_id": asset_product_id
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    $('#asset_serialize_product_id').html(result);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },error: function(response) {
                    //alert(JSON.stringify(response));
                },
            });
        }
        function getEditAssetProduct(){
            var asset_product_id=$('#editAsset_product_id').val();
            //alert(asset_product_id);
            $.ajax({
                url: "{{ route('Sweets_and_confectionery.table.assetSerializeProduct') }}",
                method: "GET",
                data: {
                    "asset_product_id": asset_product_id
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    $('#editAsset_serialize_product_id').html(result);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },error: function(response) {
                    //alert(JSON.stringify(response));
                },
            });
        }


        function editFloorNo() {
            var building = $('#editBuilding').val();
            $.ajax({
                url: "{{ route('hotelManagement.floor.getFloorView') }}",
                method: "GET",
                data: {
                    "buildingInfo": building
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result))
                    var j = 1;
                    $('#editFloor_no').html('');

                    var floorsId = [];
                    for (var i = 0; i < result['floor'].length; i++) {
                        floorsId.push(result['floor'][i].floor_no);
                    }
                    floorsId = floorsId.sort();
                    var k = 0;
                    for (var i = 1; i <= result['no_of_floor']; i++) {
                        var floorOption = '';
                        if (j == 1) {
                            floorOption = '1st';
                        } else if (j == 2) {
                            floorOption = '2nd';
                        } else if (j == 3) {
                            floorOption = '3rd';
                        } else {
                            floorOption = j + 'th';
                        }

                        // if (floorsId[k] == j) {
                        //     $('#editFloor_no').append('<option value="' + j + '" disabled >' + floorOption +
                        //         '</option>');
                        //     k = k + 1;
                        // } else {
                        //     $('#editFloor_no').append('<option value="' + j + '">' + floorOption + '</option>');
                        // }
                        j = j + 1;
                    }

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            });
        }

        $("#tableForm").submit(function(e) {
             //alert("calling");
            e.preventDefault();
            clearMessages();
            var name = $("#name").val();
            var capacity = $("#capacity").val();
            var building = $('#building').val();
            var room = $('#room').val();
            var asset_product_id = $('#asset_product_id').val();
            var asset_serialize_product_id = $('#asset_serialize_product_id').val();
            var image = $('#image')[0].files[0];
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('name', name);
            fd.append('capacity', capacity);
            fd.append('building', building);
            fd.append('room', room);
            fd.append('asset_product_id', asset_product_id);
            fd.append('asset_serialize_product_id', asset_serialize_product_id);
            fd.append('image', image);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('Sweets_and_confectionery.table.store') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    // alert(JSON.stringify(result));
                    if (result['success']) {
                        $("#modal").modal('hide');
                        Swal.fire("Table Saved!", result.success, "success");
                    } else if (result['exist']) {
                        Swal.fire("Cancelled!", result.exist);
                    } else {
                        // alert(JSON.stringify(result));
                    }
                    reset();
                    table.ajax.reload(null, false);

                },
                error: function(response) {
                    alert(JSON.stringify(response));
                    $('#nameError').text(response.responseJSON.errors.name);
                    $('#capacityError').text(response.responseJSON.errors.capacity);
                    $('#roomError').text(response.responseJSON.errors.room);
                    $('#asset_product_idError').text(response.responseJSON.errors.asset_product_id);
                    $('#asset_serialize_product_idError').text(response.responseJSON.errors.asset_serialize_product_id);
                    $('#buildingError').text(response.responseJSON.errors.building);
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
            $('#buildingError').text("");
            $('#capacityError').text("");
            $('#roomError').text("");
        }

        function reset() {
            $("#name").val("");
            $("#capacity").val("");
            $("#building").val("").trigger('change');
            $("#room").val("").trigger('change');
            $("#asset_product_id").val("").trigger('change');
            $("#asset_serialize_product_id").val("").trigger('change');
        }


        function editClearMessages() {
            $("#editNameError").text("");
            $("#editCapacityError").text("");
            $("#editBuildingError").text("");
            $("#editRoomError").text("");
            $("#editAsset_product_idError").text("");
            $("#editAsset_serialize_product_idError").text("");
        }


        function editReset() {
            $("#editName").val("");
            $("#editCapacity").val("");
        }

        function editFloor(id) {
            editReset();
            editClearMessages();
            $.ajax({
                url: "{{ route('Sweets_and_confectionery.table.edit') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    $("#editBuilding").val(result.building_id);
                    $("#editAsset_product_id").val(result.asset_product_category_id);
                    $("#editRoom").val(result.warehouse_id);
                    $("#editAsset_serialize_product_id").val(result.asset_product_id);
                    $("#editId").val(result.id);
                    $("#editName").val(result.name);
                    $("#editCapacity").val(result.capacity);
                    var imageString = '{{ asset('upload/table_images') }}' + "/" + result.image;
                    $('#editShowImage').attr('src', imageString);
                    
                    if (result.status != "") {
                        $("#editStatus").val(result.status);
                    } else {
                        $("#editStatus").val("Inactive");
                    }
                    $("#editModal").modal('show');
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },error: function(response) {
                    //alert(JSON.stringify(response));
                    
                }
            });
        }

        $("#editTableForm").submit(function(e) {
            e.preventDefault();
            editClearMessages();
            var building = $("#editBuilding").val();
            var asset_product_id = $("#editAsset_product_id").val();
            var room = $("#editRoom").val();
            var asset_serialize_product_id = $("#editAsset_serialize_product_id").val();
            var id = $("#editId").val();
            var name = $("#editName").val();
            var capacity = $("#editCapacity").val();
            var status = $("#editStatus").val();
            var image = $('#editImage')[0].files[0];
            var _token = $('input[name="_token"]').val();
            var id = $("#editId").val();
            
            var fd = new FormData();
            fd.append('name', name);
            fd.append('room', room);
            fd.append('building', building);
            fd.append('asset_product_id', asset_product_id);
            fd.append('asset_serialize_product_id', asset_serialize_product_id);
            fd.append('capacity', capacity);
            fd.append('status', status);
            fd.append('image', image);
            fd.append('id', id);
            fd.append('_token', _token);
           
            $.ajax({
                url: "{{ route('Sweets_and_confectionery.table.update') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    alert(JSON.stringify(result));
                    if (result['success']) {
                        $("#editModal").modal('hide');
                        Swal.fire("Updated Room Info!", result.success, "success");
                    } else {
                        Swal.fire("Something Went Erong!");
                    }
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    alert(JSON.stringify(response));
                    $('#editNameError').text(response.responseJSON.errors.name);
                    $('#editCapacityError').text(response.responseJSON.errors.capacity);
                    
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }
            })
        });

        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure ?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete Table!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('restaurentManagement.table.delete') }}",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": _token
                        },
                        success: function(result) {
                            Swal.fire("Done!", "Table was succesfully deleted!", "success");
                            table.ajax.reload(null, false);
                        },
                        error: function(response) {
                            Swal.fire("Cancelled", result, "error");
                            $('#editNameError').text(response.responseJSON.errors.name);
                            $('#editBuildingError').text(response.responseJSON.errors.warehouse);
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your imaginary Room is safe :)", "error");
                }
            })

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
@endsection

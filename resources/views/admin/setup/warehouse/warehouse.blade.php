@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Warehouse
@endsection
@section('content')
    <style type="text/css">


    </style>
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;"> Warehouse List </h3>
                    <a class="btn btn-primary float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add
                        Warehouse</a>
                    <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i
                            class="fas fa-sync"></i> Refresh </a>
                </div><!-- /.card-header -->

                <div class="card-body">
                    <div class="col-md-12">


                        <!--data listing table-->
                        <div class="table-responsive">
                            <table id="manageWarehouseTable" width="100%" class="table table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <td width="5%">SL</td>
                                        <td width="30%">Warehouse Name</td>
                                        <td width="31%">Sister Concerns</td>
                                        <td width="11%">Status</td>
                                        <td width="7%">Actions</td>
                                    </tr>
                                </thead>
                            </table>
                            <!--data listing table-->
                        </div>

                    </div>


                </div>
                <!-- /.card -->
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- modal -->
    <div class="modal fade" id="warehouseModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header float-left">
                    <h4 class="modal-title float-left"> Add Warehouse</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="warehouseForm" method="POST" enctype="multipart/form-data" action="#">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label>Warehouse Name <span class="text-danger"> * </span></label>
                                <input class="form-control  input-sm" id="warehouseName" type="text" name="warehouseName"
                                    placeholder=" Warehouse name">
                                <span class="text-danger" id="warehouseNameError"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="floor">Sister Concern <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="sisterConcern_id" name="sisterConcern" multiple>
                                    @foreach ($sisterConcerns as $sisterConcern)
                                        <option value="{{ $sisterConcern->id }}">{{ $sisterConcern->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="sisterConcernError"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label> Address </label>
                                <input class="form-control input-sm" id="description" type="text" name="description"
                                    placeholder=" description">
                                <span class="text-danger" id="descriptionError"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x Close</button>
                            <button type="submit" class="btn btn-primary " id="saveWarehouse"><i class="fa fa-save"></i>
                                Save Warehouse
                            </button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- edit modal -->
    <div class="modal fade" id="editWarehouseModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header float-left">
                    <h4 class="modal-title float-left"> Edit Warehouse</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <div class="modal-body">
                    <form id="editWarehouseForm" method="POST" action="#">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="warehouseEditId" name="warehouseEditId">
                            <div class="form-group col-md-12">
                                <label>Warehouse Name <span class="text-danger"> * </span></label>
                                <input class="form-control  input-sm" id="editWarehouseName" type="text"
                                    name="editWarehouseName" value="">
                                <span class="text-danger" id="editWarehouseNameError"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="floor">Sister Concern <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="editSisterConcern_id" name="editSisterConcern_id" multiple>
                                    @foreach ($sisterConcerns as $sisterConcern)
                                        <option value="{{ $sisterConcern->id }}">{{ $sisterConcern->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editSisterConcern_idError"></span>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Address <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="editdDscription" type="text" name="editdDscription"
                                    value="">
                                <span class="text-danger" id="editDescriptionError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label> Status </label>
                                <select id="editStatus" name="editStatus " class="form-control input-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select> <br>
                                <span class="text-danger" id="editStatusError"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x Close</button>
                            <button type="submit" class="btn btn-primary " id="saveWarehouse"><i class="fa fa-save"></i>
                                Save Warehouse</button>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('javascript')
    <script>

        $("#sisterConcern_id").select2({
            placeholder: "Select Sister Concern",
            allowClear: true,
            width: '100%'
        });
        $("#editSisterConcern_id").select2({
            placeholder: "Select Sister Concern",
            allowClear: true,
            width: '100%'
        });


        function create() {
            $("#warehouseModal").modal('show');
        }

        $('#warehouseModal').on('shown.bs.modal', function() {
            $('#warehouseName').focus();
        })
        $('#editWarehouseModal').on('shown.bs.modal', function() {
            $('#editwarehouseName').focus();
        })
        var table;
        $(document).ready(function() {
            table = $('#manageWarehouseTable').DataTable({
                'ajax': "{{ route('warehouse.getWarehouses') }}",
                processing: true,
            });
            // $.ajax({
            //     url: "",
            //     method: "GET",
             
            //     contentType: false,
            //     processData: false,
            //     success: function(result) {
            //         alert(JSON.stringify(result));
                   
            //     },
            //     error: function(response) {
            //         alert(JSON.stringify(response));
                   
            //     },
            //     beforeSend: function() {
            //         $('#loading').show();
            //     },
            //     complete: function() {
            //         $('#loading').hide();
            //     }

            // })
        });

        $("#warehouseForm").submit(function(e) {
            e.preventDefault();
            var warehouseName = $("#warehouseName").val();
            var sisterConcern_id = $("#sisterConcern_id").val();
            var description = $("#description").val();
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('warehouseName', warehouseName);
            fd.append('sisterConcern_id', sisterConcern_id);
            fd.append('description', description);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('warehouse.store') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                    alert(JSON.stringify(result));
                    $("#warehouseModal").modal('hide');
                    Swal.fire("Warehouse saved!", result.success, "success");
                    $("#warehouseForm").trigger("reset");
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    alert(JSON.stringify(response));
                    $('#warehouseNameError').text(response.responseJSON.errors.warehouseName);
                    $("#descriptionError").text(response.responseJSON.errors.description);
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }

            })
        });

        function editWarehouse(id) {
            $.ajax({
                url: "{{ route('warehouse.edit') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    alert(JSON.stringify(result));
                    $("#editWarehouseModal").modal('show');
                    $("#warehouseEditId").val(result.warehouse.id);
                    $("#editWarehouseName").val(result.warehouse.name);
                    $("#editdDscription").val(result.warehouse.ware_house_address);
                    $("#editSisterConcern_id").html(result.sisterConcernsName);
                    $("#editStatus").val(result.warehouse.status).trigger("change");
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

        $("#editWarehouseForm").submit(function(e) {
            e.preventDefault();
            const id = $("#warehouseEditId").val();
            const warehouseName = $("#editWarehouseName").val();
            const editSisterConcern_id = $("#editSisterConcern_id").val();
            const description = $("#editdDscription").val();
            const status = $("#editStatus").val();
            const _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('id', id);
            fd.append('warehouseName', warehouseName);
            fd.append('editSisterConcern_id', editSisterConcern_id);
            fd.append('description', description);
            fd.append('status', status);
            fd.append('_token', _token);
            $.ajax({
                url: "{{ route('warehouse.update') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                success: function(result) {
                   alert(JSON.stringify(result));
                    $("#editWarehouseModal").modal('hide');
                    Swal.fire("Updated Warehouse!", result.success, "success");
                    $("#editWarehouseForm").trigger("reset");
                    table.ajax.reload(null, false);
                },
                error: function(response) {
                    alert(JSON.stringify(response));
                    $('#editWarehouseNameError').text(response.responseJSON.errors.warehouseName);
                    $("#editDescriptionError").text(response.responseJSON.errors.description);
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
                text: "You will not be able to recover this record!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete Warehouse!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('warehouse.delete') }}",
                        method: "GET",
                        data: {
                            "id": id,
                            "_token": _token
                        },
                        success: function(result) {
                            Swal.fire("Done!", result.success, "success");
                            table.ajax.reload(null, false);
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
                } else {
                    Swal.fire("Cancelled", "Your imaginary record is safe :)", "error");
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
                $("#productForm").trigger('submit');
            } else {
                alert("Not Calling");
            }
        });
        Mousetrap.bind('ctrl+shift+u', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editProductForm").trigger('submit');
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

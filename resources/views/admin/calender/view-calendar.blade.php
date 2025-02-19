@extends('admin.master')

@section('title')
    {{ Session::get('companySettings')[0]['name'] }}
@endsection

@section('content')
    <style type="text/css">
        h3 {

            color: #66a3ff;

        }

        ul {
            list-style-type: none;
        }
        .head {
            background-color: #d8dbdb;
            color: #4b5b61
        }
    </style>

    <div class="content-wrapper">

        <section class="content box-border">

            <div class="card">

                <div class="card-header">

                    <h3 style="float:left;"> Calendar </h3>

                    <button class="btn btn-primary float-right" onclick="create()" data-toggle="modal"
                    data-target="#myModal"><i class="fa fa-plus circle"></i> Create Calendar</button>
                </div><!-- /.card-header -->

                <div class="card-body">

                    <!--data listing table-->
                    <div class="table-responsive">
                        <table id="manageCalendarTable" width="100%" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td width="5%">SL</td>
                                    <td width="25%">Date</td>
                                    <td width="25%">Day Name</td>
                                    <td width="20%">Day Type</td>
                                    <td width="5%">Action</td>
                                </tr>
                            </thead>
                            <tbody id="tableViewVahicle">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>

    <!-- /.content-wrapper -->

    <div class="modal fade" id="modal">
        <div class="modal-dialog" style="max-width: 60%;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create calendar </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"
                            aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                <div class="form-group  row">
                    <label for="employee" class="col-sm-3 control-label text-right">Yearly Calender
                        Added</label>
                    <div class="col-sm-6">
                        <?php $years = range(2050, date('%Y', time())); ?>
                        <select class="form-control" id="addyear" name="addyear" >
                            <option>Select Year</option>
                            <?php foreach($years as $year) : ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="" class="btn btn-primary btn-flat col-sm-2" name="add" id="add_btn" onclick="createAndUpdate('add');"><i
                            class="fa fa-save"></i> Submit</button>
                </div>
                <div class="form-group row">
                    <label for="off_year" class="col-sm-3 control-label text-right">Yearly Offdays
                        Added</label>
                    <div class="col-sm-3">
                        <?php $years = range(2050, date('%Y', time())); ?>
                        <select class="form-control" id="off_year" name="off_year" >
                            <option>Select Year</option>
                            <?php foreach($years as $year) : ?>
                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="off_day" name="off_day" >
                            <option value="" selected>- Select One -</option>
                            <option value="Fri">Friday</option>
                            <option value="Sat">Saturday</option>
                            <option value="Sun">Sunday</option>
                            <option value="Mon">Monday</option>
                            <option value="Tue">Tuesday</option>
                            <option value="Wed">Wednesday</option>
                            <option value="Thu">Thursday</option>
                        </select>
                    </div>
                    <button type="" class="btn btn-primary btn-flat col-sm-2" name="offday"  id="offday_btn" onclick="createAndUpdate('offday');"><i
                            class="fa fa-save"></i> Submit</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x Close</button>
            </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!-- edit modal -->

    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editHoliday" method="POST" enctype="multipart/form-data" action="#">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"
                                aria-hidden="true"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class=" col-md-6">
                                @csrf
                                <input type="hidden" name="editId" id="editId" value="">
                                <input type="hidden" name="callDate" id="callDate" value="">

                                <div class="form-group col-md-12">
                                    <label for="edit_onday_type" class="control-label">Day Type</label>
                                    <select class="form-control" id="edit_type" name="edit_type" required>
                                        <option value="" selected>- Select One -</option>
                                        @foreach ($dayTypes as $dayType)
                                            <option value="{{ $dayType->day_type }}">{{ $dayType->day_type }}</option>
                                        @endforeach
                                    </select>

                                </div>
                              
                                <div class="form-group  col-md-12">
                                    <label for="edit_cause" class="control-label">Cause</label>
                                    <input type="text" class="form-control" id="edit_cause" name="edit_cause"
                                        placeholder="Offday/Holiday Cause">

                                </div>
                            </div>
                         
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x Close</button>
                        <button type="submit" class="btn btn-primary btnUpate" id="editCategory">Update</button>
                    </div>

                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection



@section('javascript')
    <script>

        function create() {
            reset();
            $("#modal").modal('show');
        }

        $('#modal').on('shown.bs.modal', function() {
            $('#name').focus();
        })

        $('#editModal').on('shown.bs.modal', function() {
            $('#edit_type').focus();
        })
        var serviceCalls = [];
        var table;

        $(document).ready(function() {
            table = $('#manageCalendarTable').DataTable({
                'ajax': "{{ route('calendar.getcalendar') }}",
                processing: true,
            });
        });
        function createAndUpdate(type){
            if(type == "add"){
                var addyear = $('#addyear').val();
            }else if(type == "offday"){
                var off_year = $('#off_year').val();
                var off_day = $('#off_day').val();
            }else if(type == "holiday"){
                var holidayDate = $('#holidayDate').val();
                var holidayCause = $('#holiday_Cause').val();
            }
            var _token = $('meta[name="csrf-token"]').attr('content');
           
            $.ajax({
                url: "{{ route('calendar.createCalendarStore') }}",
                method: "post",
                data: {
                    "type": type,
                    "addyear": addyear,
                    "off_year": off_year,
                    "off_day": off_day,
                    "holidayDate": holidayDate,
                    "holidayCause": holidayCause,
                    '_token': _token
                },
                datatype: "json",
                success: function(result) {
                    if ({{ config('settings.mode') }} == '0') {
                               // alert(JSON.stringify(result));
                     }
                    if(result['message']){
                        Swal.fire("Year Already Exist!!", result.success, "Year Already Exist!!");
                    }else{
                        Swal.fire("Done!", result.success, "success");
                    }
                    table.ajax.reload(null, false);
                   
                    $('#addyear').val('Select Year');
                    $('#off_year').val('Select Year');
                    $('#off_day').val('- Select One -');
                    $('#holidayDate').val('mm/dd/yyyy');
                    $('#holiday_Cause').val('');
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



        $("#editHoliday").submit(function(e) {
            e.preventDefault();
            var id = $("#editId").val();
            var edit_type = $("#edit_type").val();
            var shifting_date = $("#shifting_date").val();
            var edit_cause = $("#edit_cause").val();
            var _token = $('input[name="_token"]').val();

           // alert(JSON.stringify(serviceCalls));
            //console.log(serviceCalls);
            
            var fd = new FormData();
            fd.append('id', id);
            fd.append('edit_type', edit_type);
            fd.append('shifting_date', shifting_date);
            fd.append('edit_cause', edit_cause);
            fd.append('serviceCalls', JSON.stringify(serviceCalls));
            fd.append('_token', _token);

            $.ajax({
                url: "{{ url('calendar/update') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    // alert(JSON.stringify(result));
                    $("#editModal").modal('hide');
                    Swal.fire("Saved!", result.success, "success");
                    table.ajax.reload(null, false);
                    $('#edit_type').val('Select Type');
                    $('#edit_cause').val('');
                    services = null;
                },
                error: function(response) {
                    // alert(JSON.stringify(response));
                    $('#edit_type').val('~ Select Type ~');
                    $('#edit_cause').val('');
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
            $('#customersError').text("");
            $('#menufacturerError').text("");
        }

        function editClearMessages() {
            $('#edit_customersError').text("");
            $('#edit_menufacturerError').text("");
        }

        function reset() {
            $("#menufacturer").val("");
            $("#vehicleReg").val("");
        }

        function editReset() {
            $("#edit_menufacturer").val("");
            $("#edit_vehicleReg").val("");
        }

        function editHolyday(id, date) {
            $("#editModal").modal('show');
            $("#editId").val(id);
            $("#callDate").val(date);

        }





        function confirmDelete(id) {

            Swal.fire({
                title: "Are you sure ?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete Party!",
                closeOnConfirm: false

            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ url('carservices/vehicles/delete') }}",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": _token
                        },
                        success: function(result) {
                            Swal.fire("Done!", result.success, "success");
                            table.ajax.reload(null, false);
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your imaginary Party is safe :)", "error");
                }
            })
        }



        Mousetrap.bind('ctrl+shift+n', function(e) {
            e.preventDefault();
            if ($('#modal.in, #modal.show').length) {} else {
                create();
            }
        });


        function reloadDt() {
            if ($('#modal.in, #modal.show').length) {} else if ($('#editModal.in, #editModal.show').length) {} else {
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
                $("#partyForm").trigger('submit');
            } else {
                alert("Not Calling");
            }
        });

        Mousetrap.bind('ctrl+shift+u', function(e) {
            e.preventDefault();
            if ($('#editModal.in, #editModal.show').length) {
                $("#editPartyForm").trigger('submit');
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

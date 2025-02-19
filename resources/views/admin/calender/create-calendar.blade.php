@extends('admin.master')

@section('title')
    {{ Session::get('companySettings')[0]['name'] }}
@endsection

@section('content')
    <style type="text/css">
        h3 {

            color: #66a3ff;

        }

        .response {
            padding: 6px;
            display: none;
        }

        .not-exists {
            color: red;
        }

        .exists {
            color: green;
        }
    </style>

    <div class="content-wrapper">

        <section class="content box-border">

            <div class="card">

                <div class="card-header">

                    <h3 style="float:left;"> Manage Yearly Date & Holiday </h3>

                </div><!-- /.card-header -->

                <div class="card-body">


                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <br>

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
                                    <button type="" class="btn btn-primary btn-flat col-sm-1" name="add" id="add_btn" onclick="createAndUpdate('add');"><i
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
                                    <button type="" class="btn btn-primary btn-flat col-sm-1" name="offday"  id="offday_btn" onclick="createAndUpdate('offday');"><i
                                            class="fa fa-save"></i> Submit</button>
                                </div>

                                <div class="form-group row d-none">
                                    <label for="holidayDate" class="col-sm-3 control-label text-right">Holiday Added</label>
                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="holidayDate" name="holidayDate"
                                            placeholder='Holiday Select' >
                                    </div>
                                    <div class="col-sm-3">
                                        <textarea class="form-control" id="holiday_Cause" name="holidayCause" placeholder="Holiday Cause"></textarea>
                                    </div>
                                    <button type="" class="btn btn-primary btn-flat col-sm-1" name="holiday"  id="holiday_btn" onclick="createAndUpdate('holiday');"><i
                                            class="fa fa-save"></i> Submit</button>
                                </div>

                                <br><br><br><br>
                            </div>
                        </div>

                    </div>

                </div>

            </div><!-- /.container-fluid -->

        </section>

        <!-- /.content -->

    </div>

    <!-- /.content-wrapper -->
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

            $('#editName').focus();

        })

        var table;

        $(document).ready(function() {

        });

        $('#datepicker_add').datepicker();

        var nativePicker = document.querySelector('.nativeDatePicker');
        var fallbackPicker = document.querySelector('.fallbackDatePicker');
        var fallbackLabel = document.querySelector('.fallbackLabel');

        var yearSelect = document.querySelector('#year');
        var monthSelect = document.querySelector('#month');

        // hide fallback initially
        fallbackPicker.style.display = 'none';
        fallbackLabel.style.display = 'none';

        // test whether a new date input falls back to a text input or not
        var test = document.createElement('input');
        test.type = 'month';
        // if it does, run the code inside the if() {} block
        if (test.type === 'text') {
            // hide the native picker and show the fallback
            nativePicker.style.display = 'none';
            fallbackPicker.style.display = 'block';
            fallbackLabel.style.display = 'block';

            // populate the years dynamically
            // (the months are always the same, therefore hardcoded)
            populateYears();
        }

        function populateYears() {
            // get the current year as a number
            var date = new Date();
            var year = date.getFullYear();

            // Make this year, and the 100 years before it available in the year <select>
            for (var i = 0; i <= 100; i++) {
                var option = document.createElement('option');
                option.textContent = year - i;
                yearSelect.appendChild(option);
            }
        }

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
                   
                    $('#addyear').val('Select Year');
                    $('#off_year').val('Select Year');
                    $('#off_day').val('- Select One -');
                    $('#holidayDate').val('mm/dd/yyyy');
                    $('#holiday_Cause').val('');
                },
                error: function(response) {
                    if ({{ config('settings.mode') }} == '0') {
                        // alert(JSON.stringify(response));
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



        function clearMessages() {
            $('#remarksError').text("");

        }


        function editClearMessages() {

            $('#edit_fitnessError').text("");
            $('#edit_insuranceError').text("");
            $('#edit_remarksError').text("");

        }

        function reset() {

  
            $("#tax_token").val("");
            $("#color").val("");

        }



        function editReset() {
          
         
            $("#edit_remarks").val("");
            $("#edit_fitness").val("");

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

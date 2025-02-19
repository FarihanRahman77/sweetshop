@extends('admin.master')
@section('title')
{{ Session::get('companySettings')[0]['name'] }} User
@endsection
@section('User Management')
@endsection
@section('content')
<style type="text/css">
    h3 {
        color: #66a3ff;
    }
</style>
<div class="container-fluid">
    <section class="content box-border">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Update Password</h3>
               
                @if (Auth::check())
                <h5 class="text-center"> User : {{ Auth::user()->name }} </h5>
                @endif
               

            </div><!-- /.card-header -->
            <div class="card-body row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <!-- <div class="form-group">
                        <label for="user">User</label><span class="text-danger"> * </span>

                        <select name="user" id="user" class="form-control input-sm">
                            <option value="" selected>Select user</option>
                            @php
                                $users = DB::table('users')->get(); 
                             @endphp
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="userError"></span>
                    </div> -->

                    <div class="form-group">
                        <label for="">Old Password</label>
                        <input type="password" class="form-control" id="old_password">
                        <span class="text-danger" id="old_passwordError"></span>
                    </div>

                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="password" class="form-control" id="new_password">
                        <span class="text-danger" id="new_passwordError"></span>
                    </div>

                    <div class="form-group">
                        <label for="">Re-type Password</label>
                        <input type="password" class="form-control" id="re_type_password">
                    </div>

                    <div class="form-group">
                        <input type="checkbox" onclick="myFunction()"> Show Password
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary m-3 float-right" onclick="submit()">Save</button>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->


@endsection

@section('javascript')
<script>
    function myFunction() {
        // var w = document.getElementById("old_password");
        var x = document.getElementById("old_password");
        var y = document.getElementById("new_password");
        var z = document.getElementById("re_type_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
        if (y.type === "password") {
            y.type = "text";
        } else {
            y.type = "password";
        }
        if (z.type === "password") {
            z.type = "text";
        } else {
            z.type = "password";
        }
    }

    function reset() {
        $('#re_type_password').val('');
        $('#new_password').val('');
        $('#old_password').val('');
    }

    function resetError() {
        $('#new_passwordError').text('');
        $('#old_passwordError').text('');
    }


    function submit() {
        // var user = $("#user").val();
        var old_password = $("#old_password").val();
        var new_password = $("#new_password").val();
        var re_type_password = $("#re_type_password").val();
        var _token = $('input[name="_token"]').val();
        var fd = new FormData();
    
        fd.append('old_password', old_password);
        fd.append('new_password', new_password);
        fd.append('re_type_password', re_type_password);
        fd.append('_token', _token);
        if (old_password === new_password) {
            Swal.fire("Error", "Old password and New Password can not be same.)", "error");
            reset();
            resetError();
        } else {
            if (old_password == '') {
                Swal.fire("Error: ", "Somethig wrong!", "error");
                $('#old_passwordError').text('Old password is required');
            } else {
                if (re_type_password === new_password) {
                    $.ajax({
                        url: "{{ route('users.password_update') }}",
                        method: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        datatype: "json",
                        success: function(result) {
                            //alert(JSON.stringify(result));
                            if (result.success) {
                                Swal.fire({
                                    title: "Saved !",
                                    text: result.success,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    cancelButtonColor: '#d33',
                                    confirmButtonText: 'OK'
                                });
                            } else if (result.error) {
                                Swal.fire("Error: ", "Old password not matched.", "error");
                                $('#old_passwordError').text('Old password not matched');
                            }

                            reset();
                            resetError();
                        },
                        beforeSend: function() {
                            $('#loading').show();
                        },
                        complete: function() {
                            $('#loading').hide();
                        },
                        error: function(response) {
                            // alert(JSON.stringify(response));
                            Swal.fire("Error: ", "Somethig wrong!", "error");
                            $('#new_passwordError').text(response.responseJSON.errors.new_password);
                            $('#old_passwordError').text(response.responseJSON.errors.old_password);
                            reset();
                        }
                    })
                } else {
                    Swal.fire("Please", "Re-type the new password correctly.)", "error");
                    reset();
                    resetError();
                }
            }
        }
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
            $("#userForm").trigger('submit');
        } else {
            alert("Not Calling");
        }
    });
    Mousetrap.bind('ctrl+shift+u', function(e) {
        e.preventDefault();
        if ($('#editModal.in, #editModal.show').length) {
            $("#editUserForm").trigger('submit');
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
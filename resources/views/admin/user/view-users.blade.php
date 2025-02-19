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
                    <h3> Users List
                        <a class="btn btn-primary float-right" onclick="create()"><i class="fa fa-plus circle"></i>
                            Add User</a>
                        <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i
                                class="fas fa-sync"></i> Refresh</a>
                    </h3>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="manageUserTable" width="100%" class="table table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <td>ID</td>
                                        <td>Image</td>
                                        <td>Full Name</td>
                                        <td>Contact</td>
                                        <td>Dep./Des.</td>
                                        <td>Status</td>
                                        <td width="8%">ACTION</td>
                                    </tr>
                                </thead>
                                <!--<tbody id="tableViewUsers"></tbody>-->
                            </table>
                        </div>
                        <!--data listing table-->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- /.content-wrapper -->

    <!-- modal -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header float-left">
                    <h4 class="modal-title float-left"> Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <form id="userForm" method="POST" action="#">
                    <div class="modal-body">
                        <div class="row">
                            @csrf
                            <input type="hidden" name="id">
                            <div class="form-group col-md-4">
                                <label> Full Name</label><span class="text-danger"> * </span>
                                <input class="form-control input-sm" id="name" type="text" name="name"
                                    placeholder="Full name">
                                <span class="text-danger" id="nameError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>User Name</label><span class="text-danger"> * </span>
                                <input class="form-control input-sm" id="username" type="text" name="username"
                                    placeholder="User name">
                                <span class="text-danger" id="usernameError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email </label><span class="text-danger"> * </span>
                                <input class="form-control input-sm" type="email" id="email" name="email"
                                    placeholder="Email">
                                <span class="text-danger" id="emailError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mobile No</label><span class="text-danger"> * </span>
                                <input class="form-control input-sm" type="text" id="mobile_no" name="mobile_no"
                                    placeholder="Mobile number 11 digit only" onkeyup="mobileDigitCount()" maxlength="11">
                                <span class="text-danger" id="mobileError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Password</label><span class="text-danger"> * </span>
                                <input class="form-control input-sm" type="password" id="password" name="password"
                                    placeholder="password" onkeyup="passwordCount()">
                                <span class="text-danger" id="passwordError"></span>
                            </div>


                            <div class="form-group col-md-4">
                                <label>Designation</label>
                                <input class="form-control input-sm" id="designation" type="text" name="designation"
                                    placeholder="designation">
                                <span class="text-danger" id="designationError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Department</label>
                                <input class="form-control input-sm" id="department" type="text" name="department"
                                    placeholder="department">
                                <span class="text-danger" id="departmentError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Address</label>
                                <input class="form-control input-sm" id="address" type="text" name="address"
                                    placeholder="address">
                                <span class="text-danger" id="addressError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Roles</label><span class="text-danger"> * </span>
                                <select name="role" id="role" class="form-control input-sm">
									<option value="" selected>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="rolesError"></span>
                            </div>
                          
                                <div class="form-group col-md-6">
                                <label for="sisterconcern"> Select Sister Concern <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm"  id="sisterConcern" name="sisterConcern"  multiple>
                             
                                    @foreach ($sisterConcerns as $sisterConcern)
                                        <option value="{{ $sisterConcern->id }}">{{ $sisterConcern->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="sisterConcernError"></span>
                                </div>
                            <div class="form-group col-md-6">
                                <label for="">Image</label>
                                <input type="file" name="image" id="image" class="form-control form-control-sm">
                                <span class="text-danger">image size should must be lower then 2048 X 1848</span>
                                <span class="text-danger" id="imageError"></span>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="">Signature:</label>
                                <input type="file" id="signature" name="signature" class="form-control form-control-sm">
                                <span class="text-danger" id="signatureError"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <img id="showImage" src="{{ asset('upload/user_images/no_image.png') }}"
                                    style="width: 70px;height: 80px; border:1px solid #000000">
                            </div>

                            <div class="form-group col-md-6">
                                <img id="showSignature" src="{{ asset('upload/user_signatures/no_image.png') }}"
                                    style="width: 70px;height: 80px; border:1px solid #000000">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x Close</button>
                        <button type="submit" class="btn btn-primary btnSave" id="saveCategory"><i
                                class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- edit modal -->
    <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="fas fa-window-close"></i></button>
                </div>
                <form id="editUserForm" method="POST" enctype="multipart/form-data" action="#">
                    <div class="modal-body">

                        <div class="row">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <input type="hidden" name="editId" id="editId">
                            <div class="form-group col-md-4">
                                <label> Full Name <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="editName" type="text" name="name" required="" />
                                <span class="text-danger" id="editNameError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>User Name <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" type="text" id="editusername" name="username" required="" />
                                <span class="text-danger" id="editusernameError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" type="text" id="editEmail" name="email" required="" />
                                <span class="text-danger" id="editEmailError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mobile No <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" type="text" id="editMobile" name="mobile_no" placeholder="Mobile number 11 digit only"
                                    required="" onkeyup="mobileDigitCount()" maxlength="11"/>
                                <span class="text-danger" id="editMobileError"></span>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Designation</label>
                                <input class="form-control input-sm" id="editDesignation" type="text" name="designation" />
                                <span class="text-danger" id="editDesignationError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Department</label>
                                <input class="form-control input-sm" type="text" id="editDepartment" name="department" />
                                <span class="text-danger" id="editDepartmentError"></span>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Address</label>
                                <input class="form-control input-sm" id="editAddress" type="text" name="address" />
                                <span class="text-danger" id="editAddressError"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label> Status</label>
                                <select id="editStatus" name="editStatus" class="form-control input-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger" id="editStatusError"></span>
                            </div>
                            <div class="form-group col-md-6"><span class="text-danger"> * </span>
                                <label>Roles <span class="text-danger"> * </span></label>
                                <select name="role_name" id="role_name" class="form-control input-sm">
									<option value="" selected="selected">Select Role</option>                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="role_nameError"></span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sisterconcern"> Select Sister Concern <span class="text-danger"> * </span></label>
                                <select class="form-control input-sm" id="editSisterConcern" name="editSisterConcern"
                                    multiple>

                                    @foreach ($sisterConcerns as $sisterConcern)
                                        <option value="{{ $sisterConcern->id }}">{{ $sisterConcern->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editSisterConcernError"></span>
                                </div>
                            <div class="form-group col-md-6">
                                <label for="">Edit Image</label>
                                <input type="file" name="editImage" id="editImage" class="form-control form-control-sm" />
                                <span class="text-danger">image size should must be lower then 2048 X 1848</span>
                                <span class="text-danger" id="editImageError"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="">Edit Signature:</label>
                                <input type="file" id="editSignature" name="editSignature"
                                    class="form-control form-control-sm">
                                <span class="text-danger" id="editSignatureError"></span>
                            </div>

                            <div class="form-group col-md-6">
                                <img id="editShowImage" src="{{ url('upload/no_image.png') }}"
                                    style="width: 70px;height: 80px; border:1px solid #000000">
                            </div>

                            <div class="form-group col-md-6">
                                <img id="editShowSignature" src="{{ asset('upload/no_image.png') }}"
                                    style="width: 70px;height: 80px; border:1px solid #000000">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">x Close</button>
                        <button type="submit" class="btn btn-primary btnUpate" id="editCategory"><i
                                class="fa fa-save"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $(function() {
            $("#role").select2({
                placeholder: "Select Role",
                dropdownParent: $("#modal"),
                allowClear: true,
                width: '100%'
            });
            $("#role_name").select2({
                placeholder: "Select Role",
                dropdownParent: $("#editModal"),
                allowClear: true,
                width: '100%'
            });
        });
 
        $("#sisterConcern").select2({
            placeholder: "Select Sister Concern",
            allowClear: true,
            width: '100%'
        });
        $("#editSisterConcern").select2({
            placeholder: "Select Sister Concern",
            allowClear: true,
            width: '100%'
        });
        function mobileDigitCount(){
            var num=$('#mobile_no').val();
            var length = num.toString().length;
            if(length > 11){
                $('#mobileError').text('Mobile number can not more then 11 digit');
            }else if(length <= 11){
                $('#mobileError').text('');
            }
            
            var num2=$('#editMobile').val();
            var length2 = num2.toString().length;
            if(length2 > 11){
                $('#editMobileError').text('Mobile number can not more then 11 digit');
            }else if(length2 <= 11){
                $('#editMobileError').text('');
            }
        }


        function passwordCount(){
            
        }

        function create() {
            reset();
            resetMessages();
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
            table = $('#manageUserTable').DataTable({
                'ajax': "{{ route('users.view') }}",
                processing: true,
            });
        })








        function reset() {
            $("#name").val("");
            $("#username").val("");
            $("#email").val("");
            $("#designation").val("");
            $("#department").val("");
            $("#usertype_id").val("");
            $("#mobile_no").val("");
            $("#address").val("");
            $("#password").val("");
            $("#image").val("")
            $('#showImage').attr('src', "{{ asset('upload/no_image.png') }}");
            $('#showSignature').attr('src', "{{ asset('upload/no_image.png') }}");
        }


        $("#userForm").submit(function(e) {
            resetMessages();
            e.preventDefault();
            var name = $("#name").val();
            var username = $("#username").val();
            var email = $("#email").val();
            var mobile_no = $("#mobile_no").val();
            var address = $("#address").val();
            var designation = $("#designation").val();
            var department = $("#department").val();
            var password = $("#password").val();
            var usertype_id = -999;
            var role = $("#role").val();
            var sister_concernid = $("#sisterConcern").val();
            var image = $('#image')[0].files[0];
            var signature = $('#signature')[0].files[0];
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
            fd.append('name', name);
            fd.append('username', username);
            fd.append('email', email);
            fd.append('mobile_no', mobile_no);
            fd.append('address', address);
            fd.append('designation', designation);
            fd.append('department', department);
            fd.append('password', password);
            fd.append('role', role);
            fd.append('usertype_id', usertype_id);
            fd.append('sister_concern_id', sister_concernid);
            fd.append('image', image);
            fd.append('signature', signature);
            fd.append('_token', _token);
            $.ajax({
                url: "{{route('users.store')}}",
                method: "POST",
                data:fd,
                contentType:false,
                processData:false,
                beforeSend:function() {
                    $("#loading").show();
                },
                success:function(result){
                    //  alert(JSON.stringify(result));
                    $("#modal").modal('hide');
                    table.ajax.reload(null, false);
                    Swal.fire("Saved!", result, "success");
                },
                error: function(response) {
                    // alert(JSON.stringify(response));
                   
                    $('#nameError').text(response.responseJSON.errors.name);
                    $('#usernameError').text(response.responseJSON.errors.username);
                    $('#emailError').text(response.responseJSON.errors.email);
                    $("#designationError").text(response.responseJSON.errors.designation);
                    $("#departmentError").text(response.responseJSON.errors.department);
                    $("#userTypeError").text(response.responseJSON.errors.usertype_id);
                    $("#mobileError").text(response.responseJSON.errors.mobile_no);
                    $("#addressError").text(response.responseJSON.errors.address);
                    $("#passwordError").text(response.responseJSON.errors.password);
                    $("#imageError").text(response.responseJSON.errors.image);
                    $("#signatureError").text(response.responseJSON.errors.signature);
                    $("#rolesError").text(response.responseJSON.errors.role);
                },
                complete: function() {
                    $("#loading").hide();
                }

            })
        })

        function resetMessages() {
            $("#nameError").text("");
            $("#usernameError").text("");
            $("#emailError").text("");
            $("#designationError").text("");
            $("#departmentError").text("");
            $("#rolesError").text("");
            $("#mobileError").text("");
            $("#addressError").text("");
            $("#passwordError").text("");
            $("#imageError").text("");
            $("#signatureError").text("");
        }
        function userEdit(id) {
    resetEditMessages();
    $.ajax({
        url: "{{ route('users.edit') }}",
        method: "GET",
        data: {
            "id": id
        },
        datatype: "json",
        success: function(result) {
            //  alert(JSON.stringify(result));
            // Set form values
            $("#editId").val(result.user.id);
            $("#editModal").modal('show');
            $("#editName").val(result.user.name);
            $("#editusername").val(result.user.username);
            $("#editEmail").val(result.user.email);
            $("#editDesignation").val(result.user.designation);
            $("#editDepartment").val(result.user.department);
            $("#editUsertype").val(result.user.usertype_id);
            $("#editMobile").val(result.user.mobile_no);
            $("#editAddress").val(result.user.address);
            
            var sisterConcernID = result.sisterConcern.map(function(concern) {
                return concern.id; 
            });

            var options = '';
            $.each(result.allSisterConcerns, function(index, concern) {
                options += '<option value="' + concern.id + '"';
                if ($.inArray(concern.id, sisterConcernID) !== -1) {
                    options += ' selected';  
                }
                options += '>' + concern.name + '</option>';
            });
            $("#editSisterConcern").html(options); 
            $("#editSisterConcern").val(sisterConcernID).trigger('change');
            $("#role_name").val(result.user.role).trigger('change');
            
            // Set image or default no-image.png if blank
            var imageString = result.user.image ? '{{ asset('upload/user_images') }}' + "/" + result.user.image : '{{ asset('upload/no_image.png') }}';
            $('#editShowImage').attr('src', imageString);
            $('#editImage').val('');

            // Set signature or default no-image.png if blank
            var signatureString = result.user.signature ? '{{ asset('upload/user_signatures') }}' + "/" + result.user.signature : '{{ asset('upload/no_image.png') }}';
            $('#editShowSignature').attr('src', signatureString);
            $('#editSignature').val('');

            if (result.status != "") {
                $("#editStatus").val(result.user.status);
            } else {
                $("#editStatus").val("Inactive");
            }
        },
        error: function(response) {
            // Handle error
        }
    });
}

       

        $("#editUserForm").submit(function(e) {
            e.preventDefault();
            var id = $("#editId").val();
            var name = $("#editName").val();
            var username = $("#editusername").val();
            var email = $("#editEmail").val();
            var designation = $("#editDesignation").val();
            var department = $("#editDepartment").val();
            var role = $("#role_name").val();
            var mobile_no = $("#editMobile").val();
            var address = $("#editAddress").val();
            var status = $("#editStatus").val();
            var editsister_concernid = $("#editSisterConcern").val();
            var userImage = $('#editImage')[0].files[0];
            var signature = $('#editSignature')[0].files[0];
            var _token = $('input[name="_token"]').val();
            
            var fd = new FormData();
            fd.append('name', name);
            fd.append('username', username);
            fd.append('email', email);
            fd.append('designation', designation);
            fd.append('department', department);
            fd.append('mobile_no', mobile_no);
            fd.append('address', address);
            fd.append('role', role);
            fd.append('sister_concern_id', editsister_concernid);
            fd.append('image', userImage);
            fd.append('signature', signature);
            fd.append('status', status);
            fd.append('id', id);
            fd.append('_token', _token);
            //alert(role);
            $.ajax({
                url: "{{ route('users.update') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $("#loading").show();
                },
                success: function(result) {
					// alert(JSON.stringify(result));
                    $("#editModal").modal('hide');
                    table.ajax.reload(null, false);
                    Swal.fire("Updated!", result.success, "success");
                },
                error: function(response) {
					// alert(JSON.stringify(response));
                    $('#editNameError').text(response.responseJSON.errors.name);
                    $('#editusernameError').text(response.responseJSON.errors.username);
                    $('#editEmailError').text(response.responseJSON.errors.email);
                    $("#editDesignationError").text(response.responseJSON.errors.designation);
                    $("#editDepartmentError").text(response.responseJSON.errors.department);
                    $("#editUserTypeError").text(response.responseJSON.errors.usertype_id);
                    $("#editMobileError").text(response.responseJSON.errors.mobile_no);
                    $("#editAddressError").text(response.responseJSON.errors.address);
                    $("#editImageError").text(response.responseJSON.errors.image);
                    $("#editSignatureError").text(response.responseJSON.errors.signature);
                    $("#role_nameError").text(response.responseJSON.errors.role);
                },
                complete: function() {
                    $("#loading").hide();
                }
            })
        });

        function resetEditMessages() {
            $("#editNameError").text("");
            $("#editusernameError").text("");
            $("#editEmailError").text("");
            $("#editDesignationError").text("");
            $("#editDepartmentError").text("");
            $("#editUserTypeError").text("");
            $("#editMobileError").text("");
            $("#editAddressError").text("");
            $("#editImageError").text("");
        }

        
        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure ?",
                text: "You will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete User!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "{{ route('users.delete') }}",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": _token
                        },
                        success: function(result) {
                            Swal.fire(" Deleted! ", result.success, "success");
                            table.ajax.reload(null, false);
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your imaginary User is safe :)", "error");
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



        $(document).ready(function() {
            $('#signature').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showSignature').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
            $('#editSignature').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#editShowSignature').attr('src', e.target.result);
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

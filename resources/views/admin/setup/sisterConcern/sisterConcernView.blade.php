@extends('admin.master')
@section('title')
{{Session::get("companySettings")[0]['name']}} Sister Concerns
@endsection
@section('content')

<style type="text/css">
  
  h3{
    color: #66a3ff;
  }
</style>
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
            <div class="card-header">
              <h3 style="float:left;"> Sister Concern List </h3>
                <a class="btn btn-primary float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add Sister Concerns</a>
				
            </div><!-- /.card-header -->
            <div class="card-body">
               <div class="col-md-12">
                    <table id="manageSisterConcernTable" width="100%" class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <td width="5%">SL.</td>
                                <td width="15%">Logo</td>
                                <td width="50%">Name</td>
                                <td width="10%">Is Admin</td>
                                <td width="10%">Status</td>
                                <td width="10%">ACTION</td>
                            </tr>
                        </thead>
                    </table>
                    <!--data listing table-->
                </div>
            </div>
          <!-- /.card -->
            </div>
          <!-- /.card -->
        </section>
    </div>


    <!-- modal -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header float-left">
                    <h4 class="modal-title float-left"> Add Sister Concern</h4>
                    <button type="button" class="close"data-dismiss="modal" aria-hidden="true"><i class="fas fa-window-close" ></i></button>
                </div> 
                <div class="modal-body">
                <form id="sisterConcernForm" method="POST" enctype="multipart/form-data" action="#">
                  @csrf
                 
                        <input type="hidden" name="id">
                        <div class="form-group col-md-12">
                            <label>Name <span class="text-danger"> * </span></label>
                            <input class="form-control input-sm" id="name" type="text" name="name" >
                            <span class="text-danger" id="nameError"></span>
                        </div>
                        <div class="form-group row"> 
                            <div class="col-md-8">
                                <label for="">Logo</label>
                                <input type="file" name="image" id="image" class="form-control form-control-sm">
                                <span class="text-danger" id="imageError"></span>
                            </div>
                        
                            <div class="col-md-3">
                                <img id="showImage" src="{{asset('upload/images/no_image.png')}}" style="width: 70px;height: 80px; border:1px solid #000000">
                            </div>
                        </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X Close</button>
                      <button type="submit" class="btn btn-primary btnSave" id="saveCategory"><i class="fa fa-save"></i> Save</button>
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
                    <h4 class="modal-title">Edit sister Concern</h4>
					<button type="button" class="close"data-dismiss="modal" aria-hidden="true"><i class="fas fa-window-close" ></i></button>
                </div> 
                <div class="modal-body">
                <form id="editsiSterConcernForm" method="POST" enctype="multipart/form-data" action="#">
                  @csrf
                 
                      <input type="hidden" name="editId" id="editId">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label> Name <span class="text-danger"> * </span></label>
                                <input class="form-control input-sm" id="editName" type="text" name="editName" required="">
                                <span class="text-danger" id="editNameError"></span>
                            </div>
                            <div class="col-md-6">
                                <label> Status</label>
                                <select id="editStatus" name="editStatus" class="form-control input-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8">
                                <label for="">Edit Logo</label>
                                <input type="file" name="editImage" id="editImage" class="form-control form-control-sm">
                                <span class="text-danger" id="editImageError"></span>
                            </div>
                            <div class="col-md-4">
                                <img id="editShowImage" src="{{url('upload/images/no_image.png')}}" style="width: 100px;height: 80px; border:1px solid #000000"><br><a href="#" onclick="removeImage()" style="margin-left:20px;"> <i class="fas fa-trash-alt"></i> Remove Image</a><input type="hidden" id="removeImage" name="removeImage" value="" />
                            </div>
                        </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X Close</button>
                      <button type="submit" class="btn btn-primary btnUpate" id="editCategory"><i class="fa fa-save"></i> Update</button>
                 </form> </div>
              </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('javascript')

  <script>

	function create() {
		reset();
		clearMessages();
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
		table = $('#manageSisterConcernTable').DataTable({
			'ajax': "{{route('getSisterConcern')}}",
			processing:true,
		});
	})

	
	$("#sisterConcernForm").submit(function (e){
		e.preventDefault();
		clearMessages();
		var sisterConcernName = $("#name").val();
		var sisterConcernImage = $('#image')[0].files[0];
		var _token = $('input[name="_token"]').val();
		var fd = new FormData();
		fd.append('name',sisterConcernName);
		fd.append('image',sisterConcernImage);
		fd.append('_token',_token);
		$.ajax({
			url:"{{route('sisterConcern.store')}}",
			method:"POST",
			data:fd,
			contentType: false,
			processData: false,
			success:function(result){
				//alert(JSON.stringify(result));
			  	$("#modal").modal('hide');
			  	Swal.fire("Save Sister Concern!",result.success,"success");
			  	table.ajax.reload(null, false);
		  }, error: function(response) {
				//alert(JSON.stringify(resourse));
				$('#nameError').text(response.responseJSON.errors.name);
				$('#imageError').text(response.responseJSON.errors.image);
		  }, beforeSend: function () {
			  $('#loading').show();
		  },complete: function () {
			  $('#loading').hide();
		  }

		})
	})
	function clearMessages(){
	  $('#nameError').text("");
	  $('#imageError').text("");
	}
	function editClearMessages(){
	  $('#editNameError').text("");
	  $('#editImageError').text("");
	}
	function reset(){
	  $("#name").val("");
	  $("#image").val("")
	  $('#showImage').attr('src',"");
	}
	function editReset(){
		$("#editName").val("");
	  $("#editImage").val("")
	  $('#editShowImage').attr('src',"");
		$("#removeImage").val("");
	}
	function editSisterConcern(id){
		editReset();
		editClearMessages();
	    $.ajax({
			url:"{{route('sisterConcern.edit')}}",
		    method:"GET",
		    data:{"id":id},
		    datatype:"json",
		    success:function(result){
				//alert(JSON.stringify(result));
				$("#editModal").modal('show');
				$("#editName").val(result.name);
				var imageString = '{{asset("upload/images")}}'+"/"+result.logo;
				$('#editShowImage').attr('src',imageString);
				$("#editId").val(result.id);
				if(result.status != ""){
					$("#editStatus").val(result.status);
				}else{
					$("#editStatus").val("Inactive");
				}
		    }, beforeSend: function () {
				$('#loading').show();
			},complete: function () {
				$('#loading').hide();
			}, error: function(response) {
				//alert(JSON.stringify(resourse));
		  }
	    });
	}

	$("#editsiSterConcernForm").submit(function (e){
		e.preventDefault();
		editClearMessages();
		var sisterConcernName = $("#editName").val();
		var status  =$("#editStatus").val();
		var removeImage = $("#removeImage").val();
		var sisterConcernImage = $('#editImage')[0].files[0];
		var _token = $('input[name="_token"]').val();
		var id = $("#editId").val();
		var fd = new FormData();
		fd.append('name',sisterConcernName);
		fd.append('removeImage',removeImage);
		fd.append('image',sisterConcernImage);
		fd.append('status',status);
		fd.append('id',id);
		fd.append('_token',_token);
		$.ajax({
			url:"{{route('sisterConcern.update')}}",
			method:"POST",
			data:fd,
			contentType: false,
			processData: false,
			success:function(result){
				//alert(JSON.stringify(result));
				$("#editModal").modal('hide');
				Swal.fire("Updated Sister Concern!",result.success,"success");
				table.ajax.reload(null, false);
			}, 
			error: function(response) {
				//alert(JSON.stringify(response));
				$('#editNameError').text(response.responseJSON.errors.name);
				$('#editImageError').text(response.responseJSON.errors.image);
			}, beforeSend: function () {
				$('#loading').show();
			},complete: function () {
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
            confirmButtonText: "Yes, delete Sister Concern!",
            closeOnConfirm: false
        }).then((result) => {
			if (result.isConfirmed) {
				var _token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url:"{{route('sisterConcern.delete')}}",
					method: "POST",
					data: {"id":id, "_token":_token},
					success: function (result) {
						//alert(JSON.stringify(result));
						 if(result.message == "success"){
							Swal.fire("Deleted!",result.success,"success");
							table.ajax.reload(null, false);
						}else{
							Swal.fire("Cancelled", result, "error");
						}
					  
					}, error: function(response) {
						//alert(JSON.stringify(response));
					  $('#editNameError').text(response.responseJSON.errors.name);
					  $('#editImageError').text(response.responseJSON.errors.image);
					}, beforeSend: function () {
						$('#loading').show();
					},complete: function () {
						$('#loading').hide();
					}
				});
			}else{
			  Swal.fire("Cancelled", "Your imaginary Category is safe :)", "error");
			}
        })
    }
	function removeImage(){
		Swal.fire({
            title: "Are you sure ?",
            text: "You will not be able to recover this image file after save!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, remove image!",
            closeOnConfirm: false
        }).then((result) => {
			if (result.isConfirmed) {
				$("#removeImage").val("1");
				$("#editShowImage").attr('src',"");
			}else{
			  Swal.fire("Cancelled", "Your image is safe :)", "error");
			}
        })
	}
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader =new FileReader();
            reader.onload =function(e){  
              $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });

        $('#editImage').change(function(e){
            var reader =new FileReader();
            reader.onload =function(e){  
              $('#editShowImage').attr('src',e.target.result);
			  $("#removeImage").val("");
            }
            reader.readAsDataURL(e.target.files['0']);
        });

	});
	
	Mousetrap.bind('ctrl+shift+n', function(e) {
		e.preventDefault();
		if($('#modal.in, #modal.show').length){
			
		}else{
			create();
		}
	});
	function reloadDt(){
		if($('#modal.in, #modal.show').length){
			
		}else if($('#editModal.in, #editModal.show').length){
			
		}
		else{
			table.ajax.reload(null, false);
		}
	}
	Mousetrap.bind('ctrl+shift+r', function(e) {
		e.preventDefault();
		reloadDt();
	});
	Mousetrap.bind('ctrl+shift+s', function(e) {
		e.preventDefault();
		if($('#modal.in, #modal.show').length){
			$("#categoryForm").trigger('submit');
		}else{
			alert("Not Calling");
		}
	});
	Mousetrap.bind('ctrl+shift+u', function(e) {
		e.preventDefault();
		if($('#editModal.in, #editModal.show').length){
			$("#editCategoryForm").trigger('submit');
		}else{
			alert("Not Calling");
		}
	});
	Mousetrap.bind('esc', function(e) {
		e.preventDefault();
		if($('#editModal.in, #editModal.show').length){
			$("#editModal").modal('hide');
		}else if($('#modal.in, #modal.show').length){
			$('#modal').modal('hide');
		}
	});

    </script>


 
@endsection
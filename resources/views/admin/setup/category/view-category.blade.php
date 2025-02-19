@extends('admin.master')
@section('title')
{{Session::get("companySettings")[0]['name']}} Categories
@endsection
@section('content')

<style type="text/css">
	h3 {
		color: #66a3ff;
	}
</style>
<div class="content-wrapper">
	<section class="content box-border">
		<div class="card">
			<div class="card-header">
				<h3 style="float:left;"> Category List </h3>
				<a class="btn btn-primary float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add Category</a>

			</div><!-- /.card-header -->
			<div class="card-body">
				<div class="col-md-12">
					<table id="manageCategoryTable" width="100%" class="table table-bordered table-hover ">
						<thead>
							<tr>
								<td width="6%">SL.</td>
								<td>Category Name</td>
								<td>Type</td>
								<td>Sister Concern</td>
								<td>Image</td>
								<td>Priority code</td>
								<td width="8%">Status</td>
								<td width="8%">ACTION</td>
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
				<h4 class="modal-title float-left"> Add Category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fas fa-window-close"></i></button>
			</div>
			<div class="modal-body">
				<form id="categoryForm" method="POST" enctype="multipart/form-data" action="#">
					@csrf

					<input type="hidden" name="id">
					<div class="form-group col-md-12">
						<label for="floor">Category Type <span class="text-danger"> * </span></label>
						<select class="form-control input-sm" id="category_type" name="category_type" required>
							<option value="">Select Type</option>
							<option value="Food menu">Food Menu</option>
							<option value="Product">Product</option>
							<option value="Sweets_and_confectionery">Sweets and Confectionery</option>
							<option value="Room">Room</option>
							<option value="Room Facility">Room Facility</option>
						</select>
						<span class="text-danger" id="category_typeError"></span>
					</div>
					<div class="form-group col-md-12">
						<label>Name <span class="text-danger"> * </span></label>
						<input class="form-control input-sm" id="name" type="text" name="name">
						<span class="text-danger" id="nameError"></span>
					</div>
					<div class="form-group col-md-12">
						<label>Priority code <span class="text-danger"> * </span></label>
						<input class="form-control input-sm" id="sort_code" type="number" name="sort_code">
						<span class="text-danger" id="sort_codenameError"></span>
					</div>

					<div class="form-group col-md-12">
						<label for="floor">Sister Concern <span class="text-danger"> * </span></label>
						<select class="form-control input-sm" id="sisterConcern_id" name="sisterConcern_id" multiple>
							@foreach ($sisterConcerns as $sisterConcern)
							<option value="{{ $sisterConcern->id }}">{{ $sisterConcern->name }}
							</option>
							@endforeach
						</select>
						<span class="text-danger" id="sisterConcernError"></span>
					</div>
					<div class="form-group row">
						<div class="col-md-8">
							<label for="">Image</label>
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
				<h4 class="modal-title">Edit Category</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fas fa-window-close"></i></button>
			</div>
			<div class="modal-body">
				<form id="editCategoryForm" method="POST" enctype="multipart/form-data" action="#">
					@csrf
					<input type="hidden" name="editId" id="editId">
					<div class="form-group row">
						<div class="col-md-6">
							<label> Name <span class="text-danger"> * </span></label>
							<input class="form-control input-sm" id="editName" type="text" name="editName" required="">
							<span class="text-danger" id="editNameError"></span>
						</div>
						<div class="col-md-6">
							<label> Sort code <span class="text-danger"> * </span></label>
							<input class="form-control input-sm" id="edit_sort_code" type="text" name="edit_sort_code" required="">
							<span class="text-danger" id="editNameError"></span>
						</div>
						<div class="form-group col-md-6">
							<label for="floor">Category Type <span class="text-danger"> * </span></label>
							<select class="form-control input-sm" id="editCategory_type" name="editCategory_type" required>
							
								<option value="Food menu">Select Type</option>
								<option value="Food menu">Food Menu</option>
								<option value="Product">Product</option>
								<option value="Room">Room</option>
								<option value="Sweets_and_confectionery">Sweets and Confectionery</option>
								<option value="Room Facility">Room Facility</option>
							</select>
							<span class="text-danger" id="editCategory_typeError"></span>
						</div>
						<div class="form-group col-md-12">
							<label for="floor">Sister Concern <span class="text-danger"> * </span></label>
							<select class="form-control input-sm" id="editSisterConcern_id" name="editSisterConcern_id" multiple>
								@foreach ($sisterConcerns as $sisterConcern)
								<option value="{{ $sisterConcern->id }}">{{ $sisterConcern->name }}
								</option>
								@endforeach
							</select>
							<span class="text-danger" id="editSisterConcern_idError"></span>
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
							<label for="">Edit Image</label>
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
				</form>
			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('javascript')

<script>
	function sortcodeValidation() {
		var sort_code = $('#sort_code').val();
		if (sort_code == "") {
			$('#sort_code').val();
		}
	}

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

	$("#category_type").select2({
		placeholder: "Select Type",
		allowClear: true,
		width: '100%'
	});
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


	var table;
	$(document).ready(function() {
		table = $('#manageCategoryTable').DataTable({
			'ajax': "{{route(name: 'categories.getCategories')}}",
			processing: true,
		});

	})


	$("#categoryForm").submit(function(e) {
		e.preventDefault();
		clearMessages();
		var categoryName = $("#name").val();
		var sort_code = $("#sort_code").val();
		var category_type = $("#category_type").val();
		var sisterConcern_id = $("#sisterConcern_id").val();
		var categoryImage = $('#image')[0].files[0];
		var _token = $('input[name="_token"]').val();
		var fd = new FormData();
		fd.append('name', categoryName);
		fd.append('sort_code', sort_code);
		fd.append('sisterConcern_id', sisterConcern_id);
		fd.append('category_type', category_type);
		fd.append('image', categoryImage);
		fd.append('_token', _token);
		$.ajax({
			url: "{{route('categories.store')}}",
			method: "POST",
			data: fd,
			contentType: false,
			processData: false,
			success: function(result) {
				//   alert(JSON.stringify(result));
				$("#modal").modal('hide');
				Swal.fire("Save Category!", result.success, "success");
				table.ajax.reload(null, false);
			},
			error: function(response) {
				// alert(JSON.stringify(response));
				$('#nameError').text(response.responseJSON.errors.name);
				$('#imageError').text(response.responseJSON.errors.image);
				$('#sisterConcern_idError').text(response.responseJSON.errors.sisterConcern_id);
				$('#category_typeError').text(response.responseJSON.errors.category_type);
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
		$('#imageError').text("");
	}

	function editClearMessages() {
		$('#editNameError').text("");
		$('#editImageError').text("");
	}

	function reset() {
		$("#name").val("");
		$("#image").val("")
		$('#showImage').attr('src', "{{ asset('upload/no_image.png') }}")
	}

	function editReset() {
		$("#editName").val("");
		$("#editImage").val("")
		$('#editShowImage').attr('src', "{{ asset('upload/no_image.png') }}")
		$("#removeImage").val("");
	}

	function editCategory(id) {
		editReset();
		editClearMessages();
		$.ajax({
			url: "{{route('categories.edit')}}",
			method: "GET",
			data: {
				"id": id
			},
			datatype: "json",
			success: function(result) {
				// alert(JSON.stringify(result));
				$("#editModal").modal('show');
				$("#editId").val(result.category.id);
				$("#editName").val(result.category.name);
				$("#edit_sort_code").val(result.sisterConcern.sort_code);
			   $('#editCategory_type').val(result.category.category_type);
				var imageString = '{{asset("upload/category_images")}}' + "/" + result.category.image;
				$('#editShowImage').attr('src', imageString);

				if (result.status != "") {
					$("#editStatus").val(result.category.status);
				} else {
					$("#editStatus").val("Inactive");
				}
				$('#editSisterConcern_id').html(result.sisterConcernsName);
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
		});
	}

	$("#editCategoryForm").submit(function(e) {
		e.preventDefault();
		editClearMessages();
		var id = $("#editId").val();
		var categoryName = $("#editName").val()
		var sort_code = $("#edit_sort_code").val();
		var sisterConcern_id = $("#editSisterConcern_id").val();
		var category_type = $("#editCategory_type").val();
		var Status = $("#editStatus").val();
		var removeImage = $("#removeImage").val();
		var categoryImage = $('#editImage')[0].files[0];
		var _token = $('input[name="_token"]').val();

		var fd = new FormData();
		fd.append('name', categoryName);
		fd.append('sort_code', sort_code);
		fd.append('sisterConcern_id', sisterConcern_id);
		fd.append('category_type', category_type);
		fd.append('removeImage', removeImage);
		fd.append('image', categoryImage);
		fd.append('Status', Status);
		fd.append('id', id);
		fd.append('_token', _token);
		$.ajax({
			url: "{{route('categories.update')}}",
			method: "POST",
			data: fd,
			contentType: false,
			processData: false,
			success: function(result) {
				// alert(JSON.stringify(result));
				$("#editModal").modal('hide');
				Swal.fire("Updated Category!", result.success, "success");
				table.ajax.reload(null, false);
			},
			error: function(response) {
				// alert(JSON.stringify(response));
				$('#editNameError').text(response.responseJSON.errors.name);
				$('#editImageError').text(response.responseJSON.errors.image);
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
			confirmButtonText: "Yes, delete category!",
			closeOnConfirm: false
		}).then((result) => {
			if (result.isConfirmed) {
				var _token = $('meta[name="csrf-token"]').attr('content');
				$.ajax({
					url: "{{route('categories.delete')}}",
					method: "POST",
					data: {
						"id": id,
						"_token": _token
					},
					success: function(result) {
						// if(result == "success"){
						Swal.fire("Deleted!", result.success, "success");
						table.ajax.reload(null, false);
						// }else{
						// 	Swal.fire("Cancelled", result, "error");
						// }

					},
					error: function(response) {
						$('#editNameError').text(response.responseJSON.errors.name);
						$('#editImageError').text(response.responseJSON.errors.image);
					},
					beforeSend: function() {
						$('#loading').show();
					},
					complete: function() {
						$('#loading').hide();
					}
				});
			} else {
				Swal.fire("Cancelled", "Your imaginary Category is safe :)", "error");
			}
		})
	}

	function removeImage() {
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
				$("#editShowImage").attr('src', "");
			} else {
				Swal.fire("Cancelled", "Your image is safe :)", "error");
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
				$("#removeImage").val("");
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
			$("#categoryForm").trigger('submit');
		} else {
			alert("Not Calling");
		}
	});
	Mousetrap.bind('ctrl+shift+u', function(e) {
		e.preventDefault();
		if ($('#editModal.in, #editModal.show').length) {
			$("#editCategoryForm").trigger('submit');
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
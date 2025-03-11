@extends('admin.master')
@section('title') 
{{Session::get("companySettings")[0]['name']}} Expense Type
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
                            <h3 style="float:left;"> Expense Type List </h3>
                            <a class="btn btn-outline-success float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add Expense Type</a>
                            <a class="btn btn-outline-success" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i> Refresh</a>
                        </div><!-- /.card-header -->
                <div class="card-body">
                            <!--data listing table-->
                            <table id="manageExpenseTypeTable" width="100%" class="table table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <td width="7%">SL</td>
                                        <td>ExpenseType Name</td>
                                        <td width="10%">Status</td>
                                        <td width="7%">Action</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
<!-- /.content-wrapper -->

<!-- modal -->
<div class="modal fade" id="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header float-left">
                <h4 class="modal-title float-left"> Add ExpenseType</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
            </div> 
            <div class="modal-body">
                <form id="expenseTypeForm" method="POST" enctype="multipart/form-data" action="#">
                    @csrf

                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label> ExpenseType Name <span class="text-danger"> * </span></label>
                        <input class="form-control input-sm" id="name" type="text" name="name" placeholder=" Write Expense Type" >
                        <span class="text-danger" id="nameError"></span>
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
                <h4 class="modal-title">Edit ExpenseType</h4>
                <button type="button" class="close"data-dismiss="modal" aria-hidden="true">X</button>
            </div> 
            <div class="modal-body">
                <form id="editexpenseTypeForm" method="POST" enctype="multipart/form-data" action="#">
                    @csrf

                    <input type="hidden" name="editId" id="editId">
                    <div class="form-group">
                        <label> ExpenseType Name <span class="text-danger"> * </span></label>
                        <input class="form-control input-sm" id="editName" type="text" name="editName" required="" placeholder=" Write Expense Type">
                        <span class="text-danger" id="editNameError"></span>
                    </div>
                    <div class="form-group">
                        <label> Status <span class="text-danger"> * </span> </label>
                        <select id="editStatus" name="editStatus" class="form-control input-sm">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
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
			table = $('#manageExpenseTypeTable').DataTable({
				'ajax': "{{route('viewExpenseTypes')}}",
				processing:true,
			});
		});
		
        $("#expenseTypeForm").submit(function (e){
          e.preventDefault();
          clearMessages();
          var expenseTypeName = $("#name").val();
          var _token = $('input[name="_token"]').val();
          var fd = new FormData();
          fd.append('name',expenseTypeName);
          fd.append('_token',_token);
          $.ajax({
                url:"{{url('expensetype/store')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                success:function(result){
                  //alert(JSON.stringify(result));
                  $("#modal").modal('hide');
                  Swal.fire("Saved!",result.success,"success");
                  table.ajax.reload(null, false);
              }, error: function(response) {
                  //alert(JSON.stringify(response));
                $('#nameError').text(response.responseJSON.errors.name);
              }, beforeSend: function () {
                  $('#loading').show();
              },complete: function () {
                  $('#loading').hide();
              }

          })
        })
        function clearMessages(){
          $('#nameError').text("");
        }
        function editClearMessages(){
          $('#editNameError').text("");
        }
        function reset(){
          $("#name").val("");
        }
        function editExpenseType(id){
          $.ajax({
              url:"{{route('editExpenseType')}}",
              method:"GET",
              data:{"id":id},
              datatype:"json",
              success:function(result){
                $("#editModal").modal('show');
                $("#editName").val(result.name);
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
              }
          });
        }

        $("#editexpenseTypeForm").submit(function (e){
          e.preventDefault();
          editClearMessages();
          var expenseTypeName = $("#editName").val();
          var Status  =$("#editStatus").val();
          var _token = $('input[name="_token"]').val();
          var id = $("#editId").val();
          var fd = new FormData();
          fd.append('name',expenseTypeName);
          fd.append('Status',Status);
          fd.append('id',id);
          fd.append('_token',_token);
          $.ajax({
              url:"{{route('updateExpenseType')}}",
              method:"POST",
              data:fd,
              contentType: false,
              processData: false,
              success:function(result){
                //alert(JSON.stringify(result));
                $("#editModal").modal('hide');
                  Swal.fire("Updated!",result.success,"success");
                  table.ajax.reload(null, false);
              }, error: function(response) {
                //alert(JSON.stringify(response));
                $('#editNameError').text(response.responseJSON.errors.name);
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
            confirmButtonText: "Yes, delete ExpenseType!",
            closeOnConfirm: false
        }).then((result) => {
        if (result.isConfirmed) {
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"{{route('expenseTypeDelete')}}",
                method: "POST",
                data: {"id":id, "_token":_token},
                success: function (result) {
                    Swal.fire("Done!",result.success,"success");
                    table.ajax.reload(null, false);
                }, error: function(response) {
                  $('#editNameError').text(response.responseJSON.errors.name);
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }
            });
        }else{
          Swal.fire("Cancelled", "Your imaginary ExpenseType is safe :)", "error");
        }
      })
        
    }
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
			$("#expenseTypeForm").trigger('submit');
		}else{
			alert("Not Calling");
		}
	});
	Mousetrap.bind('ctrl+shift+u', function(e) {
		e.preventDefault();
		if($('#editModal.in, #editModal.show').length){
			$("#editexpenseTypeForm").trigger('submit');
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
@extends('admin.master')
@section('title')
{{Session::get("companySettings")[0]['name']}} Expense
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
                    <h3 style="float:left;"> Expense List </h3>
                    <a class="btn btn-outline-success float-right" onclick="create()"><i class="fa fa-plus circle"></i> Add Expense </a>
                    <a class="btn btn-outline-success" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i> Refresh </a>
                </div><!-- /.card-header -->
                <div class="card-body">
                                <!--data listing table-->
                    <div class="table-responsive">
                        <table id="manageExpenseTable" width="100%" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td width="6%" class="text-center">SL#</td>
                                    <td class="text-center">Invoice</td>
                                    <td class="text-center">Expense Date</td>
                                    <td class="text-center">Expenses By</td>
                                    <td class="text-center">Expense Cause</td>
                                    <td class="text-center">Expense Type</td>
                                    <td class="text-center">Amount</td>
                                    <td width="6%" class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody ></tbody>
                        </table>
                    </div>

                </div>
            </div>
        </section>
    </div>
<!-- /.content-wrapper -->

<!-- modal -->
<div class="modal fade" id="addmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header float-left">
                <h4 class="modal-title float-left"> Add Expenses </h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> x </button>
            </div> 
                <div class="modal-body">
                    <form id="expenseForm" method="POST" enctype="multipart/form-data" action="#">
                        @csrf
    
                            <input type="hidden" name="id">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label> Expense Date <span class="text-danger"> * </span></label>
                                    <input class="form-control input-sm" id="expense_date" type="date" name="expense_date" value="{{ todayDate() }}">
                                    <span class="text-danger" id="expense_dateError"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Expenses By <span class="text-danger"> * </span></label>
                                    <select class="form-control input-sm" id="user_id" name="user_id">
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="user_id_error"></span>
                                </div>
                            </div>
                            <div class="form-group row"> 
                                <div class="col-md-6">
                                    <label> Expense Type <span class="text-danger"> * </span></label>
                                    <select  name="expense_type_id" id="expense_type_id" class="form-control input-sm" selected>
                                        @foreach($expenseTypes as $expensetype)
                                        <option value="{{$expensetype->id}}">{{$expensetype->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="expense_type_id_error"></span>
                                </div>
                                <div class="col-md-6">
                                    <label>Amount : <span class="text-danger"> * </span></label>
                                    <input class="form-control input-sm" id="amount" type="number" name="amount" placeholder=" Write amount in Tk">
                                    <span class="text-danger" id="amountError"></span>
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label> Remarks : </label>
                                    <input class="form-control input-sm" id="expense_cause" type="text" name="expense_cause" placeholder=" Write Expense Cause">
                                    <span class="text-danger" id="expense_causeError"></span>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X Close</button>
                            <button type="submit" class="btn btn-primary btnSave" id="saveCategory12"><i class="fa fa-save"></i> Add Expense</button>
                        
                        </div>
                    </form>    
                </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<!-- edit modal -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Expenses</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            </div> 
            <div class="modal-body">
                <form id="editExpenseForm" method="POST" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="editId" id="editId">
                        <div class="form-group row">
                            <div class="col-md-6">
                            <label> Expense Date</label>
                            <input class="form-control input-sm" id="editExpenseDate" type="date" name="editExpenseDate" >
                            <span class="text-danger" id="editExpenseDateError"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Expenses By</label><br>
                                <select class="form-control input-sm" id="editUser" name="editUser">
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editUserError"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row"> 
                            <div class="col-md-6">
                                <label> Expense Type</label>
                                <select  name="editExpenseType" id="editExpenseType" class="form-control input-sm">
                                    @foreach($expenseTypes as $expensetype)
                                    <option value="{{$expensetype->id}}">{{$expensetype->name}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="editExpenseTypeError"></span>
                            </div>
                            <div class="col-md-6" id="editDivMonthYear" style="display:none;">
                                <label> Month Year </label>
                                <select  name="month_year" id="month_year" class="form-control input-sm">
                                    @foreach($monthYears as $monthYear)
                                    <option value="{{$monthYear}}" {{($monthYear==date('M-Y')) ? 'Selected' : ''}}>{{$monthYear}}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="expense_type_id_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Amount</label>
                                <input class="form-control input-sm" id="editAmount" type="number" name="editAmount">
                                <span class="text-danger" id="editAmountError"></span>
                            </div>
                            <div class="col-md-6">
                                <label> Status</label>
                                <select id="editStatus" name="editStatus" class="form-control input-sm">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                                <span class="text-danger" id="editStatusError"></span>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label> Expense Cause</label>
                            <input class="form-control input-sm" id="editExpense" type="text" name="editExpense" required="">
                            <span class="text-danger" id="editExpenseError"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-auto" data-dismiss="modal">X Close</button>
                        <button type="submit" class="btn btn-primary btnUpate" id="editExpenses"><i class="fa fa-save"></i>Update</button>
                </form> 
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
@endsection

@section('javascript')

<script>

    $("#user_id").select2({
        placeholder: "Select user name",
        dropdownParent: $("#addmodal"),
        allowClear: true,
        width:'100%'
    });
    $("#expense_type_id").select2({
        placeholder: "Select Type",
        dropdownParent: $("#addmodal"),
        allowClear: true,
        width:'100%'
    });
    $("#editUser").select2({
        placeholder: "Select User",
        dropdownParent: $("#editModal"),
        allowClear: true,
        width:'100%'
    });
    $("#editExpenseType").select2({
        placeholder: "Select Type",
        dropdownParent: $("#editModal"),
        allowClear: true,
        width:'100%'
    });

      function create() {
           reset();
			$("#addmodal").modal('show');
      }
	  $('#addmodal').on('shown.bs.modal', function() {
			$('#expense_cause').focus();
		})
		$('#editModal').on('shown.bs.modal', function() {
			$('#edit_expense_cause').focus();
		})
		var table;
		$(document).ready(function() {
			table = $('#manageExpenseTable').DataTable({
				'ajax': "{{route('viewExpenses')}}",
				processing:true,
			});
		});
		$("#expense_type_id").change(function (){
			if($("#expense_type_id").val() == 3){
				$("#divMonthYear").show();
			}else{
				$("#divMonthYear").hide();
			}
		})
		
        $("#expenseForm").submit(function (e){
            
          e.preventDefault();
		  clearMessage();
		  var expense_type_id = $("#expense_type_id").val();
          var user_id = $("#user_id").val();
		  if(expense_type_id != null){
			  if(user_id != null){
				  var expense_date = $("#expense_date").val();
				  var expense_cause = $("#expense_cause").val();
				  var amount = $("#amount").val();
				  var _token = $('input[name="_token"]').val();
				  var fd = new FormData();
				  fd.append('expense_date',expense_date);
				  fd.append('expense_cause',expense_cause);
				  fd.append('expense_type_id',expense_type_id);
				  fd.append('tbl_user_id',user_id);
				  fd.append('amount',amount);
				  fd.append('_token',_token);
				  $.ajax({
						url:"{{url('expenses/store')}}",
						method:"POST",
						data:fd,
						contentType: false,
						processData: false,
						datatype:"json",
						success:function(result){
                        alert(JSON.stringify(result));
						  $("#addmodal").modal('hide');
						  table.ajax.reload(null, false);
						  Swal.fire("Saved!",result.success,"success");
					  }, error: function(response) {
                        alert(JSON.stringify(response));
							$('#expense_dateError').text(response.responseJSON.errors.expense_date);
							$('#expense_causeError').text(response.responseJSON.errors.expense_cause);
							$('#amountError').text(response.responseJSON.errors.amount);
							$('#user_id_error').text(response.responseJSON.errors.tbl_user_id);
							$('#expense_type_id_error').text(response.responseJSON.errors.expense_type_id);
					  }, beforeSend: function () {
						  $('#loading').show();
					  },complete: function () {
						  $('#loading').hide();
					  }
				  })
			  }else{
				  $("#user_id_error").text("User can not be null");
			  }
		  }else{
			  $("#expense_type_id_error").text("Expense type can not be null");
		  }
        })
		function clearMessage(){
			$("#expense_cause_error").text("");
			$("#expense_type_id_error").text("");
			$("#user_id_error").text("");
			$("#amount_error").text("");
		}
		function clearEditMessage(){
			$("#editExpenseError").text("");
			$("#editExpenseTypeError").text("");
			$("#editUserError").text("");
			$("#editAmountError").text("");
			$("#editStatusError").text("");
		}
        function reset(){
          $("#expense_cause").val("");
          $("#expense_type_id").val("").trigger('change');
          $("#user_id").val("").trigger('change');
          $("#amount").val("");
        }
		$("#editExpenseType").change(function (){
			if($("#editExpenseType").val() == 3){
				$("#editDivMonthYear").show();
			}else{
				$("#editDivMonthYear").hide();
			}
		})
        function editExpenses(id){
			clearEditMessage();
          $.ajax({
              url:"{{route('editExpenses')}}",
              method:"GET",
              data:{"id":id},
              datatype:"json",
              success:function(result){
                $("#editModal").modal('show');
                $("#editExpense").val(result.expense_cause);
                $("#editExpenseType").val(result.expense_type_id);
				if(result.expense_type_id == 3){
					$("#editDivMonthYear").show();
				}else{
					$("#editDivMonthYear").hide();
				}
                $("#editUser").val(result.tbl_user_id);
                $("#editAmount").val(result.amount);
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
					alert(response);
					//$('#nameError').text(response.responseJSON.errors.name);
              }
          });
        }

        $("#editExpenseForm").submit(function (e){
          e.preventDefault();
		  clearEditMessage();
		  var expense_type_id =$("#editExpenseType").val();
          var user_id = $("#editUser").val();
		  if(expense_type_id != null){
			  if(user_id != null){
				  var  expense_date= $("#editExpenseDate").val();
				  var  expense_cause= $("#editExpense").val();
				  var amount =$("#editAmount").val();
				  var status  =$("#editStatus").val();
				  var _token = $('input[name="_token"]').val();
				  var id = $("#editId").val();
				  var fd = new FormData();
				  fd.append('expense_type_id',expense_type_id);
				  fd.append('tbl_user_id',user_id);
				  fd.append('expense_date',expense_date);
				  fd.append('expense_cause',expense_cause);
				  fd.append('amount',amount);
				  fd.append('status',status);
				  fd.append('id',id);
				  fd.append('_token',_token);
				  $.ajax({
					  url:"{{route('updateExpenses')}}",
					  method:"POST",
					  data:fd,
					  contentType: false,
					  processData: false,
					  datatype:"json",
					  success:function(result){
						$("#editModal").modal('hide');
						  Swal.fire("Updated!",result.success,"success");
						  table.ajax.reload(null, false);
					  }, beforeSend: function () {
						  $('#loading').show();
					  },complete: function () {
						  $('#loading').hide();
					  }, error: function(response) {
							alert(JSON.stringify(response));
							$('#editExpenseDateError').text(response.responseJSON.errors.expense_date);
							$('#editExpenseError').text(response.responseJSON.errors.expense_cause);
							$('#editAmountError').text(response.responseJSON.errors.amount);
							//$('#editStatusError').text(response.responseJSON.errors.status);
					  }
				  })
				}else{
					  $("#editUserError").text("User can not be null");
				  }
			  }else{
				  $("#editExpenseTypeError").text("Expense type can not be null");
			  }
        });

        function confirmDelete(id) {
        Swal.fire({
            title: "Are you sure ?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete Expense!",
            closeOnConfirm: false
        }).then((result) => {
        if (result.isConfirmed) {
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"{{route('expenseDelete')}}",
                method: "POST",
                data: {"id":id, "_token":_token},
                success: function (result) {
                    alert(JSON.stringify(result));
                    Swal.fire("Done!",result.success,"success");
                    table.ajax.reload(null, false);
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                },error: function (response) {
                    alert(JSON.stringify(result));
                }
            });
        }else{
          Swal.fire("Cancelled", "Your imaginary Expense is safe :)", "error");
        }
      })
        
    }
	Mousetrap.bind('ctrl+shift+n', function(e) {
		e.preventDefault();
		if($('#addmodal.in, #addmodal.show').length){
			
		}else{
			create();
		}
	});
	function reloadDt(){
		if($('#addmodal.in, #addmodal.show').length){
			
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
		if($('#addmodal.in, #addmodal.show').length){
			$("#expenseForm").trigger('submit');
		}else{
			alert("Not Calling");
		}
	});
	Mousetrap.bind('ctrl+shift+u', function(e) {
		e.preventDefault();
		if($('#editModal.in, #editModal.show').length){
			$("#editExpenseForm").trigger('submit');
		}else{
			alert("Not Calling");
		}
	});
	Mousetrap.bind('esc', function(e) {
		e.preventDefault();
		if($('#editModal.in, #editModal.show').length){
			$("#editModal").modal('hide');
		}else if($('#addmodal.in, #addmodal.show').length){
			$('#addmodal').modal('hide');
		}
	});
    </script>


@endsection
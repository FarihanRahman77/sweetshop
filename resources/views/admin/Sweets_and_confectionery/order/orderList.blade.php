@extends('admin.master')
@section('title')
{{Session::get("companySettings")[0]['name']}} Order List
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
                    <h4 style="float:left;"> Sale List </h4>
                    <a href="{{url('sweetsconfectionary/menu/getMenu_itms_list')}}"  class="btn btn-outline-success float-right" ><i class="fa fa-plus circle"></i> Add sale</a>
                    <a class="btn btn-outline-success" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i> Refresh </a>
                   
                    <!-- <div class="form-group float-right col-3">
                        <select name="table_id" id="table_id" class="form-control" onchange="loadFilterDatatable('table')">
                            <option value='' selected> ~~Filter By Table~~ </option>
                            <option value='FilterByDays'> Filter By Days </option>
                            @foreach ($Tables as $Table)
                            <option value="{{ $Table->id }}">{{ $Table->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger" id="table_idError"></span>
                    </div> -->

                    <div class="form-group float-right col-2">
                        <select id="daysFilters" name="daysFilters" style="width:100%" onchange="loadFilterDatatable('days')">
                            <option value=''> ~~Filter By Days~~ </option>
                            <option value='FilterBytable'> Filter By Table </option>
                            <option value='Today'> Today </option>
                            <option value='2'> 2 Days </option>
                            <option value='7' selected> 7 Days </option>
                            <option value='15'> 15 Days </option>
                            <option value='30'> 1 Month </option>
                        </select>
                    </div>

                </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                    <table id="manageorderTable" width="100%" class="table table-bordered table-hover ">
                                        <thead>
                                            <tr>
                                                <td width="6%">SL</td>
                                                <td width="6%">Sale No</td>
                                                <td>Sale Date</td>
                                                <td>Party Info</td>
                                                <td>Amount</td>
                                                <td>Payment Method:</td>
                                                <td>Status</td>
                                                <td width="8%">Actions</td>
                                            </tr>
                                        </thead>
                                        <tbody id="tableViewParty">

                                        </tbody>
                                    </table>
                                </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>

@endsection

@section('javascript')


<script>
            $("#daysFilters").select2({
                placeholder: " ~~Filter By Days~~ ",
                width: '100%'
            });
            $("#table_id").select2({
                placeholder: " ~~Filter By Table~~ ",
                width: '100%'
            });

            $('#table_id').prop('disabled', true);
            var table;
            $(document).ready(function() {
                const days = $("#daysFilters").val();
                var filterByTypeDateParty = days ;
               
            //     $.ajax({
            //  url: ,
            //     method: "GET",
            //     contentType: false,
            //     processData: true,
               
            //     success: function(result) {
            //         alert(JSON.stringify(result));

            //     },
            //     beforeSend: function() {
            //         $('#loading').show();
            //     },
            //     complete: function() {
            //         $('#loading').hide();
            //     },
            //     error: function(response) {
            //        alert(JSON.stringify(response));
            //     }
            // });
              loadFilterDatatable();
            });

            function loadFilterDatatable(filterBy = '') {

                        const days = $("#daysFilters").val();
                        // const table = $("#table_id").val();   
                       
                        var filterByTypeDateParty = days ;
                        // if (filterBy === "table") {
                        //     if (table === 'FilterByDays') {
                        //         $('#table_id').prop('disabled', true); 
                        //         $('#daysFilters').prop('disabled', false); 
                        //     } else {
                        //         $('#table_id').prop('disabled', false); 
                        //         $('#daysFilters').prop('disabled', true); 
                        //         filterByTypeDateParty = 'Today@' + table; 
                               
                        //     }
                        // }
                        // else if (filterBy === "days") {
                        //     if (days === 'FilterBytable') {
                        //         $('#daysFilters').prop('disabled', true); 
                        //         $('#table_id').prop('disabled', false); 
                        //     } else {
                        //         $('#daysFilters').prop('disabled', false); 
                        //         $('#table_id').prop('disabled', true); 
                        //         filterByTypeDateParty = days + "@"; 
                        //     }
                        // }

                          


                        






                        
                        table = $('#manageorderTable').DataTable({
                                'ajax': "{{ url('sweetsconfectionary/order/getlist') }}/" + filterByTypeDateParty,
                                        processing: true,
                                        destroy: true,
                                    });
            }

            $('#modal').on('shown.bs.modal', function() {
                $('#name').focus();
            })
            $('#editModal').on('shown.bs.modal', function() {
                $('#editName').focus();
            })

            function reset(){
                console.log("reset");
                $("#currentDue").val("");
                $("#amount").val("");
                $("#currentDue").text('0');
                $("#remarks").val("");
                $("#contact").val("");
                $("#alternate_contact").val("");
                $("#credit_limt").val("");
            }


        function edit(id){
            // alert(id);
            $.ajax({
                url: "{{ route('sweetsconfectionary.order.editList') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                    alert(JSON.stringify(result));

                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },
                error: function(response) {
                   alert(JSON.stringify(response));
                }
            });
        }

        function saleReturn(id) {
            window.location.href = "{{ url('sale/sale-return') }}" + "/" + id;

        }


        function printorderBill(id) {
            var url = '{{ route('sweetsconfectionary.order.orderInvoice', ':id') }}';
            url = url.replace(':id', id);
            window.open(url);
        }



    function confirmDelete(id) {
        // alert(id);
        Swal.fire({
            title: "Are you sure ?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete Order!",
            closeOnConfirm: false
        }).then((result) => {
        if (result.isConfirmed) {
            var _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url:"{{ route('sweetsconfectionary.order.deleteorder') }}",
                method: "POST",
                data: {"id":id, "_token":_token},
                success: function (result) {
                    // alert(JSON.stringify(result));
                    Swal.fire({
                    title: "Deleted  Order!",
                    text: result
                    .message, 
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
                table.ajax.reload(null, false);
                reset(); 
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                },
                error: function(response) {
                   alert(JSON.stringify(response));
                }
            });
        }else{
          Swal.fire("Cancelled", "Your imaginary Voucher is safe :)", "error");
        }
      })
      table.ajax.reload(null, false);
    }
	


   


	Mousetrap.bind('ctrl+shift+n', function(e) {
		e.preventDefault();
		if($('#modal.in, #modal.show').length){
			
		}else{
			create();
		}
	});
	function reloadDt(){
			table.ajax.reload(null, false);

	}
	Mousetrap.bind('ctrl+shift+r', function(e) {
		e.preventDefault();
		reloadDt();
	});
	Mousetrap.bind('ctrl+shift+s', function(e) {
		e.preventDefault();
		if($('#modal.in, #modal.show').length){
			$("#partyForm").trigger('submit');
		}else{
			alert("Not Calling");
		}
	});
	Mousetrap.bind('ctrl+shift+u', function(e) {
		e.preventDefault();
		if($('#editModal.in, #editModal.show').length){
			$("#editPartyForm").trigger('submit');
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
    
    function printPaymentReceivedVoucher(id){
		//alert(id);
		window.open("{{url('voucher/invoice/')}}"+"/"+id);
	}
    
    </script>
    

@endsection
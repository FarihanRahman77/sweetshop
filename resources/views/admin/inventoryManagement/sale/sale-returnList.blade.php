@extends('admin.master')
@section('title')
{{Session::get("companySettings")[0]['name']}} Sale View
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                @php 
                $type='';
                if($saleType == 'party_sale'){
                    $type='Party';
                }elseif($saleType == 'walkin_sale'){
                    $type='Walkin';
                }elseif($saleType == 'ts'){
                    $type='TS';
                }elseif($saleType == 'FS'){
                    $type='FS';
                }
                @endphp
              <h3 style="float:left;">{{ $type }} Sale Return list</h3>
                <a class="btn btn-outline-success" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i> Refresh </a>
              
              <input type="hidden" id="salesType" name="salesType" value="{{ $saleType }}">
                    <div class="form-group float-right col-4">
                        <select id="partyFilters2" name="partyFilters" style="width:100%;"
                            onchange="loadFilterDatatable('party')">
                            <option value='' selected> ~~Filter By Customers~~ </option>
                            <option value='FilterByDays'> Filter By Days </option>
                            @foreach ($customers as $customer)
                                <option value='{{ $customer->id }}'> {{ $customer->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group float-right col-3">
                        <select id="daysFilters2" name="daysFilters" style="width:100%"
                            onchange="loadFilterDatatable('days')">
                            <option value=''> ~~Filter By Days~~ </option>
                            <option value='FilterByCustomers'> Filter By Customers </option>
                            <option value='Today'> Today </option>
                            <option value='2'> 2 Days </option>
                            <option value='7' selected> 7 Days </option>
                            <option value='15'> 15 Days </option>
                            <option value='30'> 1 Month </option>
                            <option value='60'> 2 Month </option>
                        </select>
                    </div>

                </div><!-- /.card-header -->
                <div class="card-body">
            
			        <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="managePurchaseTable" width='100%' class="table table-bordered table-hover">
                            <thead>
                              <tr>
                                <td width="6%">SL.</td>
                                <td>Sale return info</td>
                                <td>Customer info</td>
                                <td>Amount</td>
                                <td width="8%">Actions</td>
                              </tr>
                            </thead>
                            </table>
                        </div>
        			</div>
                </div>
            </div>
        </section>
    </div>
<!-- /.content-wrapper -->

@endsection
@section('javascript')
	<script>
		var table;

        $(document).ready(function() {


            $("#daysFilters2").select2({
                placeholder: " ~~Filter By Days~~ ",
                width: '100%'
            });
            $("#partyFilters2").select2({
                placeholder: " ~~Filter By Customers~~ ",
                width: '100%'
            });

            $('#partyFilters2').prop('disabled', true);

            loadFilterDatatable();

        });

        function loadFilterDatatable(filterBy = '') {

            const type = $("#salesType").val();
            const days = $("#daysFilters2").val();
            const party = $("#partyFilters2").val();
            var filterByTypeDateParty = type + "@" + days;

            if (filterBy === "party" && party === 'FilterByDays') {
                $('#partyFilters2').prop('disabled', true);
                $('#daysFilters2').prop('disabled', false);
                return;
            } else if (filterBy === "days" && days === 'FilterByCustomers') {
                $('#daysFilters2').prop('disabled', true);
                $('#partyFilters2').prop('disabled', false);
                return;
            }

            if (filterBy === "party" && party != '') {
                filterByTypeDateParty = type + "@" + days + "@" + party;
            }
            


            
            table = $('#managePurchaseTable').DataTable({
                'ajax': `{{ url('sale/saleReturnView/${filterByTypeDateParty}') }}`,
                processing: true,
                destroy: true,
            });

        }
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
					 url:"{{route('sale.deleteSaleReturn')}}",
					method: "POST",
					data: {"id":id, "_token":_token},
					success: function (result) {
                        alert(JSON.stringify(result));
							Swal.fire("Deleted!",result.success,"success");
							table.ajax.reload(null, false);
					}, error: function(response) {
            alert(JSON.stringify(response));
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

    function printPurchase(id){
		window.open("{{url('sale/return/invoice/')}}"+"/"+id);
	}




	</script>
@endsection
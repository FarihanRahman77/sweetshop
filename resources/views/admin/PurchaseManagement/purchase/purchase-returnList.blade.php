@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Purchase View
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;">Purchase Return list</h3>
                        <a class="btn btn-outline-success float-right" href="{{ route('purchase.add') }}"> <i class="fa fa-plus-circle"></i> Add Purchase</a>
                       <!--  <a class="btn btn-outline-success" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i> Refresh </a> -->
                    <div class="form-group float-right col-4">
                        <select id="partyFilters" name="partyFilters" style="width:100%;"
                            onchange="loadFilterDatatable('party')">
                            <option value='' selected> ~~Filter By Customers~~ </option>
                            <option value='FilterByDays'> Filter By Days </option>
                            @foreach ($customers as $customer)
                                <option value='{{ $customer->id }}'> {{ $customer->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group float-right col-3">
                        <select id="daysFilters" name="daysFilters" style="width:100%"
                            onchange="loadFilterDatatable('days')">
                            <option value=''> ~~Filter By Days~~ </option>
                            <option value='FilterByCustomers'> Filter By Customers </option>
                            <option value='Today'> Today </option>
                            <option value='2'> 2 Days </option>
                            <option value='7' selected> 7 Days </option>
                            <option value='15'> 15 Days </option>
                            <option value='30'> 1 Month </option>
                        </select>
                    </div>
                </div><!-- /.card-header -->
                    <div class="card-body">
                            <div class="table-responsive">
                                <table id="managePurchaseTable" width="100%"
                                    class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <td width="6%" class="text-center">SL.</td>
                                            <td class="text-center">Purchase Info</td>
                                            <td class="text-center">Supplier Info</td>
                                            <td class="text-center">Amount</td>
                                            <td width="8%" class="text-center">Actions</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                    </div>
                    <!-- /.card -->
                </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('javascript')
    <script>
        $("#daysFilters").select2({
            placeholder: " ~~Filter By Days~~ ",
            width: '100%'
        });
        $("#partyFilters").select2({
            placeholder: " ~~Filter By Customers~~ ",
            width: '100%'
        });

        $('#partyFilters').prop('disabled', true);
        var table;

        $(document).ready(function() {

            loadFilterDatatable();

        });

        function loadFilterDatatable(filterBy = '') {
            const type = "PurchaseReturn";
            const days = $("#daysFilters").val();
            const party = $("#partyFilters").val();
            var filterByTypeDateParty = type + "@" + days;

            if (filterBy === "party" && party === 'FilterByDays') {
                $('#partyFilters').prop('disabled', true);
                $('#daysFilters').prop('disabled', false);
                return;
            } else if (filterBy === "days" && days === 'FilterByCustomers') {
                $('#daysFilters').prop('disabled', true);
                $('#partyFilters').prop('disabled', false);
                return;
            }

            if (filterBy === "party" && party != '') {
                filterByTypeDateParty = type + "@" + days + "@" + party;
            }
            //alert(filterByTypeDateParty)

            table = $('#managePurchaseTable').DataTable({
                'ajax': `{{ url('purchase/purchaseReturnView/${filterByTypeDateParty}') }}`,
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
                        url: "{{ route('deletePurchaseReturn') }}",
                        method: "POST",
                        data: {
                            "id": id,
                            "_token": _token
                        },
                        success: function(result) {
                            // alert(JSON.stringify(result));
                            Swal.fire("Deleted!", result.success, "success");
                            table.ajax.reload(null, false);
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
                } else {
                    Swal.fire("Cancelled", "Your imaginary Category is safe :)", "error");
                }
            })
        }



        function printPurchase(id) {
            window.open("{{ url('purchase/return/invoice/') }}" + "/" + id);
        }

        function purchaseReturn(id) {
            window.location.href = "{{ url('purchase/purchase-return') }}" + "/" + id;

        }
    </script>
@endsection

@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Purchase View
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;">Asset Purchase List </h3>
                    <a class="btn btn-primary float-right" href="{{ route('assets.purchase.add') }}"> <i
                            class="fa fa-plus-circle"></i> Add Purchase</a>
                    <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                        Refresh </a>

                    <div class="form-group float-right col-3">
                        <select id="partyFilters" name="partyFilters" style="width:100%;"
                            onchange="loadFilterDatatable('party')">
                            <option value='' selected> ~~Filter By Customers~~ </option>
                            <option value='FilterByDays'> Filter By Days </option>
                            @foreach ($suppliers as $supplier)
                                <option value='{{ $supplier->id }}'> {{ $supplier->name }} </option>
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
                        <table id="managePurchaseTable" width="100%" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">SL.</td>
                                    <td width="10%">Purchase No</td>
                                    <td width="12%">Purchase Date</td>
                                    <td width="15%">COA Name</td>
                                    <td width="20%">Supplier Info</td>
                                    <td width="10%">Amount</td>
                                    <td width="10%">Purchased By</td>
                                    <td width="10%">Status</td>
                                    <td width="5%">Actions</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>
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

        function loadFilterDatatable(filterBy = 'days') {

            const days = $("#daysFilters").val();
            const party = $("#partyFilters").val();
            var filterByTypeDateParty = filterBy + "@" + days;

            if (filterBy === "party" && party === 'FilterByDays') {
                $('#partyFilters').prop('disabled', true);
                $('#daysFilters').prop('disabled', false);
                return;
            } else if (filterBy === "days" && days === 'FilterByCustomers') {
                $('#daysFilters').prop('disabled', true);
                $('#partyFilters').prop('disabled', false);
                return;
            }

            if (filterBy === "party") {
                filterByTypeDateParty = filterBy + "@" + party;
            }

            table = $('#managePurchaseTable').DataTable({
                'ajax': `{{ url('assets/purchase/purchaseView/${filterByTypeDateParty}') }}`,
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
                confirmButtonText: "Yes, delete purchase!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');

                    var fd = new FormData();
                    fd.append('_token', _token);
                    fd.append('id', id);
                    $.ajax({
                        url: "{{ route('assets.purchase.delete') }}",
                        method: "POST",
                        data: fd,
                        contentType: false,
                        processData: false,
                        datatype: "json",
                        success: function(result) {
                            //alert(JSON.stringify(result))
                            Swal.fire("Deleted!", result.Success, "success");
                            table.ajax.reload(null, false);
                        },
                        error: function(response) {
                            //alert(JSON.stringify(response));
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
                    Swal.fire("Cancelled", "Your imaginary purchase is safe :)", "error");
                }
            })
        }

        function reloadDt() {
            table.ajax.reload(null, false);
        }

        function details(id) {
            var url = '{{ route('assets.purchase.invoice', ':id') }}';
            url = url.replace(':id', id);
            window.open(url);
        }

     
    </script>
@endsection

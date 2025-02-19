@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Asset Sale View
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;"> Asset Sale List </h3>
                    <a class="btn btn-primary float-right" href="{{ route('assets.sales.add') }}"> <i
                            class="fa fa-plus-circle"></i> Add Asset Sale
                    </a>
                    <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                        Refresh 
                    </a>

                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="manageSalesTable" width="100%" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td width="5%">SL.</td>
                                    <td width="10%">Date</td>
                                    <td width="10%">Sale No</td>
                                    <td width="10%">Customer </td>
                                    <td width="12%">Sold By</td>
                                    <td width="12%">Total Price</td>
                                    <td width="12%">Discount</td>
                                    <td width="12%">Grand Total</td>
                                    <td width="12%">Paid Amount</td>
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
        
        /* $("#partyFilters").select2({
            placeholder: " ~~Filter By Customers~~ ",
            width: '100%'
        }); */

       /*  $('#partyFilters').prop('disabled', true); */
        var table;

        $(document).ready(function() {
            $(document).ready(function() {
            
            table = $('#manageSalesTable').DataTable({
                'ajax': "{{ url('assets/sales/getAssetSales') }}",
                processing: true,
                destroy: true,
            });
            //loadFilterDatatable();

        });
           // loadFilterDatatable();

        });

        /* function loadFilterDatatable(filterBy = 'days') {

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

            table = $('#manageSalesTable').DataTable({
                'ajax': `{{ url('assets/View/${filterByTypeDateParty}') }}`,
                processing: true,
                destroy: true,
            });

        } */

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
            var url = '{{ route('assets.sales.invoice', ':id') }}';
            url = url.replace(':id', id);
            window.open(url);
        }

     
    </script>
@endsection

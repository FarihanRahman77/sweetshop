@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Asset Sale View
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;"> Asset Register </h3>
                    <!-- <a class="btn btn-primary float-right" href="{{ route('assets.sales.add') }}"> <i
                            class="fa fa-plus-circle"></i> Sale Asset
                    </a> -->
                    <a class="btn btn-primary" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i>
                        Refresh 
                    </a>
                    <a class="btn btn-primary" style="margin-left:20px;" href="{{route('assets.generateAssetPdf')}}">
                        <i class="fa fa-file-pdf"></i> PDF 
                    </a>

                    <!-- <div class="form-group float-right col-4">
                        <select id="partyFilters" name="partyFilters" style="width:100%;"
                            onchange="loadFilterDatatable('party')">
                            <option value='' selected> ~~Filter By Customers~~ </option>
                            <option value='FilterByDays'> Filter By Days </option>
                           
                        </select>
                    </div> -->
                   <!--  <div class="form-group float-right col-3">
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
                    </div> -->


                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="manageSalesTable" width="100%" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <td width="5%" class="text-center">SL.</td>
                                    <td width="8%" class="text-center">Purchase Date</td>
                                    <td width="10%" class="text-center">Product Name</td>
                                    <td width="10%" class="text-center">Serial</td>
                                    
                                    <td width="26%"class="text-center">Supplier Info</td>
                                    <td width="8%" class="text-center">Purchased By</td>
                                   <!--  <td width="17%" class="text-center">Assigning Info</td> -->
                                    <td width="8%" class="text-right">Purchase Price</td>
                                    <td width="15%" class="text-right">Present Value</td>
                                    <td width="5%" class="text-center">Status</td>
                                    <td width="5%" class="text-center">Actions</td>
                                </tr>
                            </thead>
                        </table>
                        @php 
                        $totalPurchasePrice=0;
                        @endphp
                        @foreach($assetSerializeProducts as $product)
                        @php $totalPurchasePrice +=$product->price; @endphp
                        @endforeach
                        <div class="total">
                            <h4>Total Asset Value: {{$totalPurchasePrice}}.00 {{Session::get('companySettings')[0]['currency']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <!-- Modal -->
            <div class="modal fade" id="assignModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Assign Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Employee: </label>
                                    <select id="employee_id" name="employee_id" class="form-control input-sm" style="width:100%">
                                        <option value="">Select Employee</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
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
        
        /* $("#partyFilters").select2({
            placeholder: " ~~Filter By Customers~~ ",
            width: '100%'
        }); */

       /*  $('#partyFilters').prop('disabled', true); */
        var table;

        $(document).ready(function() {
            
            table = $('#manageSalesTable').DataTable({
                'ajax': "{{ url('assets/getAssets') }}",
                processing: true,
                destroy: true,
            });
            //loadFilterDatatable();

        });

        function loadFilterDatatable(filterBy = 'days') {

           /*  const days = $("#daysFilters").val();
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
                'ajax': `{{ url('assets/getAssets') }}`,
                processing: true,
                destroy: true,
            });*/

        }



        function assignTo(id){
            $('#assignModel').modal('show');
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
                           // alert(JSON.stringify(result))
                            Swal.fire("Deleted!", result.Success, "success");
                            table.ajax.reload(null, false);
                        },
                        error: function(response) {
                            alert(JSON.stringify(response));
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

       

     
    </script>
@endsection

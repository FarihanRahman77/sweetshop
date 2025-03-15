@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} Sale View
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3 style="float:left;" >
                        @if ($saleType == 'walkin_sale')
                            Walkin Sale 
                        @elseif ($saleType == 'party_sale')
                             Party Sale
                        @elseif ($saleType == 'ts')
                            Temporary Sale
                        @elseif ($saleType == 'FS')
                            Final Sale
                        @endif
                         list
                    </h3>
                    
                @if($saleType != 'FS')
                    <a class="btn btn-outline-success float-right" href=" {{ route('sale.add', ['type' => $saleType]) }}"> <i class="fa fa-plus-circle"></i> Add Sale</a>
                @endif
                @if($saleType == 'ts')
                    <a class="mr-2 btn btn-outline-success float-right" href="{{ route('temporarySaleAdjustment', ['type' => $saleType]) }}"> <i class="fa fa-plus-circle"></i> Sale Adjustment</a>
                @endif
                    <a class="btn btn-outline-success" style="margin-left:20px;" onclick="reloadDt()"><i class="fas fa-sync"></i> Refresh </a>
                    
                @php 
                $size='';
                if($saleType == 'ts'){
                    $size="col-md-2";
                }else{
                    $size="col-md-3";
                }
                @endphp
                    <div class="form-group float-right {{$size}}">
                        <select id="partyFilters" name="partyFilters" style="width:100%;"
                            onchange="loadFilterDatatable('party')">
                            <option value='' selected> ~~Filter By Customers~~ </option>
                            <option value='FilterByDays'> Filter By Days </option>
                            @foreach ($customers as $customer)
                                <option value='{{ $customer->id }}'> {{ $customer->name }} - {{ $customer->contact }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group float-right {{$size}}">
                        <select id="daysFilters" name="daysFilters" style="width:100%"
                            onchange="loadFilterDatatable('days')">
                            <option value=''> ~~Filter By Days~~ </option>
                            <option value='FilterByCustomers'> Filter By Customers </option>
                            <option value='Today' selected> Today </option>
                            <option value='2'> 2 Days </option>
                            <option value='7'> 7 Days </option>
                            <option value='15'> 15 Days </option>
                            <option value='30'> 1 Month </option>
                            <option value='60'> 2 Month </option>
                            <option value='90'> 3 Month </option>
                            <option value='180'> 6 Month </option>
                        </select>
                    </div>
                </div><!-- /.card-header -->
                
                    
                
                <div class="card-body">
                        <input type="hidden" id="salesType" name="salesType" value="{{ $saleType }}">
                        <div class="table-responsive">
                            <table id="manageSaleTable" width="100%" class="table table-bordered  table-hover">
                                <thead>
                                    <tr>
                                        <td width="6%">SL.</td>
                                        <td>Sale Info</td>
                                        <td>Customer Info</td>
                                        <td>Sales Products</td>
                                        <td>Amount</td>
                                        <td width="8%">Actions</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                </div>
                <!-- /.card -->
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

        function loadFilterDatatable(filterBy = '') {

            const type = $("#salesType").val();
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

            table = $('#manageSaleTable').DataTable({
                'ajax': `{{ url('sale/view/${filterByTypeDateParty}') }}`,
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
                confirmButtonText: "Yes, delete Sales!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    var type = $("#salesType").val();
                    $.ajax({
                        url: "{{ route('saleDelete') }}",
                        method: "POST",
                        data: {
                            "id": id,"type": type,
                            "_token": _token
                        },
                        success: function(result) {
                           // alert(JSON.stringify(result));
                             if(result.success != "" && result.success != undefined ){
                                Swal.fire("Deleted!", result.success, "success");
                                table.ajax.reload(null, false);
                            }else{
                             	Swal.fire("Cancelled", result.error, "error");
                            } 

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
                    });
                } else {
                    Swal.fire("Cancelled", "Your Imaginary Sales :)", "error");
                }
            })
        }

        function saleReturn(id) {
            window.location.href = "{{ url('sale/sale-return') }}" + "/" + id;

        }

        function printPurchase(id) {
            window.open("{{ url('sale/invoice/') }}" + "/" + id);
        }
        function printPurchaseChallan(id) {
            window.open("{{ url('sale/invoiceChallan/') }}" + "/" + id);
        }
        function printTsSales(id) {
            window.open("{{ url('sale/tsInvoice/') }}" + "/" + id);
        }
        
    </script>
@endsection

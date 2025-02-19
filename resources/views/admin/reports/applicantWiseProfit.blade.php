@extends('admin.master')
@section('title')
    {{$type}} Order Wise Profit
@endsection



@section('content')
<style>
    .table-responsive {
        overflow-x: auto; /* Allows horizontal scrolling if the table is wider than the container */
        padding-bottom: 15px; /* Space for the scrollbar */
    }

    table {
        table-layout: fixed;
        width: 100%; /* Ensures the table spans the container */
    }

    table th {
        position: sticky;
        top: 0; /* Sticks the header at the top of the container */
        z-index: 2; /* Ensures headers stay above table body content */
        
    }

    thead, tbody {
    display: block;
        }

        tbody {
            overflow-y: auto; /* Allows vertical scrolling for table body */
            max-height: 600px; /* Set a height for the scrollable body */
        }

        th, td {
            width: 10%; /* Explicit width for alignment */
        }
</style>
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Profit and Loss Report</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    
                    
                    <div class="row">
                        <input type="hidden" id="type" value="{{$type}}">
                        <div class="col-md-3">
                            <label class="form-label">Choose Applicant: </label>
                            <select type="date" class="form-control" name="applicant_id" id="applicant_id">
                                <option value="0"selected>Choose Party</option>
                                <option value="all"selected>All</option>
                                @foreach($applicants as $applicant)
                                    <option value="{{$applicant->id}}">{{$applicant->name}} - <b>ID: </b>{{$applicant->code}} - <b>Mobile: </b>{{$applicant->contact}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="applicant_idError">{{ $errors->has('applicant_id') ? $errors->first('applicant_id') : '' }}</span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" name="date_from" id="date_from" value="{{ todayDate() }}">
                            <span class="text-danger" id="date_fromError">{{ $errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" name="date_to" id="date_to" value="{{ todayDate() }}">
                            <span class="text-danger" id="date_toError">{{ $errors->has('date_to') ? $errors->first('date_to') : '' }}</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-white">.</label><br>
                            <div class=" d-flex">
                                <button class="btn btn-primary m-1" onclick="generateVoucher()"> <i class="fa fa-random" aria-hidden="true"></i> Generate</button>
                                <button class="btn btn-primary m-1" onclick="generateVoucherPdf()"> <i class="fa fa-file-pdf" aria-hidden="true"></i> PDF</button>
                            </div>
                        </div>
                       
                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                            <thead >
                                <tr class="bg-light">
                                    <th class="text-center" width="3%">SL#</th>
                                    <th class="text-center" width="10%">Order Info</th>
                                    <th class="text-center" width="15%">Party Name</th>
                                    <th class="text-center" width="12%">Service Info</th>
                                    <th class="text-center" width="10%">Receiveable<br>(From Applicant)</th>
                                    <th class="text-center" width="10%">Return<br>(To Applicant)</th>
                                    <th class="text-center" width="10%">Approximate Payable<br>(To Vendor)</th>
                                    <th class="text-center" width="10%">Payable<br>(To Vendor)</th>
                                    <th class="text-center" width="10%">Return<br>(From Vendor)</th>
                                    
                                    <th class="text-center" width="10%">Profit/Loss</th>
                                </tr>
                            </thead>
                            <tbody id="manageVoucherTable"></tbody>
                        </table>
                        
                    </div>
                    <div class="row">
                         <div class="col-md-12 " id="getVoucherButton"></div>
                    </div>
                    
                </div><!-- Card Content end -->
               
               
        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>
         $("#applicant_id").each(function() {
            select2Class($(this));
        });
        
        function select2Class(applicant_id){
			$('#applicant_id').select2({
                placeholder: "Select Applicant",
                allowClear: true,
                width:'100%'
		    });
        }
        
        function generateVoucher(){
            var applicant_id=$('#applicant_id').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            var type=$('#type').val();
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();
                fd.append('applicant_id',applicant_id);
                fd.append('date_from',date_from);
                fd.append('date_to',date_to);
                fd.append('type',type);
                fd.append('_token',_token);

            $.ajax({
                url:"{{route('generateOrderWiseProfit')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                datatype:"json",
                success:function(result){
                   // alert(JSON.stringify(result));
                   $('#manageVoucherTable').html(result.html);
                },error:function(response) {
                   // alert(JSON.stringify(response));
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }

            })
        }
           
        





        function generateVoucherPdf(){
            var applicant_id=$('#applicant_id').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            var type=$('#type').val();
            window.open("{{url('generateOrderWiseProfit/pdf/')}}"+"/"+applicant_id+"/"+date_from+"/"+date_to+"/"+type);
        }


       function ledgerDetails(id){
        $.ajax({
                url: "{{ route('getVoucherTypeAndId') }}",
                method: "GET",
                data: {
                    "id": id
                },
                datatype: "json",
                success: function(result) {
                   // alert(JSON.stringify(result));
                    if(result.type == 'Order'){
                        completeInvoice(result.type_no)
                    }else if(result.type == 'Bill created'){
                        seeBills(result.type_no);
                    }else if(result.type == 'Voucher'){
                        seeVoucher(result.type_no);
                    }
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                },error: function(response) {
                   // alert(JSON.stringify(response));
                }
            });
       }



       function completeInvoice(id) {
            var url = '{{ route('sale.service.completeInvoice', ':id') }}';
            url = url.replace(':id', id);
            window.open(url);
        }

        function seeBills(id){
            window.open("{{url('account/bill/details')}}"+"/"+id);
        }

        function seeVoucher(id){
            window.open("{{url('voucher/invoice/')}}"+"/"+id);
        }




    
    </script>
@endsection

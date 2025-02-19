@extends('admin.master')
@section('title')
    Admin party ledger
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Party Ledger</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    
                    
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Choose Party: </label>
                            <select type="date" class="form-control" name="vendor_id" id="vendor_id">
                                <option value="0"selected>Choose Party</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->name}} - <b>ID: </b>{{$supplier->code}} - <b>Mobile: </b>{{$supplier->contact}}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="vendor_idError">{{ $errors->has('vendor_id') ? $errors->first('vendor_id') : '' }}</span>
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
                        <div class="col-md-3">
                            <label class="form-label text-white">.</label><br>
                            <button class="btn btn-primary" onclick="generateVoucher()"> <i class="fa fa-random" aria-hidden="true"></i> Generate Party Ledger</button>
                        </div>
                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                            <thead>
                                <tr class="bg-light">
                                    <td width="5%" class="text-center">Sl</td>
                                    <td width="10%" class="text-center">Transaction Date</td>
                                    <td width="20%" class="text-center">Voucher Title</td>
                                    <td width="5%" class="text-center">Transaction No</td>
                                    <td width="25%" class="text-center">Particulars</td>
                                    <td width="10%" class="text-center">Debit</td>
                                    <td width="10%" class="text-center">Credit</td>
                                    <td width="15%" class="text-center">Balance</td>
                                </tr>
                            </thead>
                            <tbody id="manageVoucherTable"></tbody>
                            <tbody id="manageVoucherTotal"></tbody>
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
        $("#vendor_id").each(function() {
            select2Class($(this));
        });
        
        function select2Class(vendor_id){
			$('#vendor_id').select2({
                placeholder: "Select vendor",
                allowClear: true,
                width:'100%'
		    });
        }

     
            
               
        function generateVoucher(){
            var vendor_id=$('#vendor_id').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();
                fd.append('vendor_id',vendor_id);
                fd.append('date_from',date_from);
                fd.append('date_to',date_to);
                fd.append('_token',_token);

            $.ajax({
                url:"{{route('generateVoucher')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                datatype:"json",
                success:function(result){
                 alert(JSON.stringify(result));
                   $('#manageVoucherTable').html(result.table)
                   $('#manageVoucherTotal').html(result.total)
                   $('#getVoucherButton').html(result.button)
                },error:function(response) {
              alert(JSON.stringify(response));
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }

            })
        }
           
        





        function generateVoucherPdf(){
            var vendor_id=$('#vendor_id').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            window.open("{{url('account/vouchers/pdf/')}}"+"/"+vendor_id+"/"+date_from+"/"+date_to);
          
            
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

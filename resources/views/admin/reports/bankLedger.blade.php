@extends('admin.master')
@section('title')
    Admin Bank Ledger
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">          
                <div class="card-header">
                    <h3>Bank Ledger</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-2">
                            <label >Payment Method </label>
                            <select id="payment_method" name="payment_method" class="form-control input-sm" onchange="getsources()">
                                <option value="0">Select Payment Method</option>
                                @foreach($methods as $method)
                                <option value="{{$method->id}}" >{{$method->name}}</option>
                                @endforeach
                            </select>
                            <span id="payment_methodError" class="text-danger"></span>
                        </div>
                        <div class="form-group col-md-2" id="sourceTr" style="display:none;">
                            <label >Source </label>
                            <select id="source" name="source" class="form-control" onchange="getAccountStatus()">
                                <option value="0" selected>Select Sources</option>
                            </select>
                            <span id="sourceError" class="text-danger"></span>
                        </div>
                        <div class="form-group col-md-2" id="accountsTr" style="display:none;">
                            <label >Account </label>
                            <select id="accounts" name="accounts" class="form-control" onchange="getAmount()">
                                <option value="0" selected>Select Accounts</option>
                            </select>
                            <span id="accountsError" class="text-danger"></span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" name="date_from" id="date_from" value="{{ todayDate() }}">
                            <span class="text-danger" id="date_fromError">{{ $errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" name="date_to" id="date_to" value="{{ todayDate() }}">
                            <span class="text-danger" id="date_toError">{{ $errors->has('date_to') ? $errors->first('date_to') : '' }}</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label text-white">.</label><br>
                            <button class="btn btn-primary" onclick="generateVoucher()"> <i class="fa fa-random" aria-hidden="true"></i> Generate</button>
                        </div>
                    </div>

                    <div class="p-3" id="sourceInfo">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable no-footer"  width="100%">
                            <thead>
                                <tr class="bg-light">
                                    <td width="5%" class="text-center">Sl</td>
                                    <td width="10%" class="text-center">Transaction Date</td>
                                    <td width="40%" class="text-center">Voucher Title</td>
                                    <td width="10%" class="text-center">Transaction No</td>
                                    <td width="12%" class="text-center">Debit</td>
                                    <td width="12%" class="text-center">Credit</td>
                                    <td width="11%" class="text-center">Balance</td>
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
        $("#payment_method").select2({
            placeholder: "Select Payment Method",
            allowClear: true,
            width: '100%'
        });
        
        function getsources(){
			$('#credit_amount').text('');
            var payment_method=$('#payment_method').val();
                $.ajax({
                    url:"{{route('getBillsources')}}",
                    method:"GET",
                    data:{"payment_method":payment_method},
                    datatype:"json",
                    success:function(result){
                        //alert(JSON.stringify(result));
                        if(result.method_slug =='cash'){
                            $('#sourceTr').hide();
                            $('#accountsTr').hide();
                            $('#creditTr').show();
                            $('#credit_amount').text(result.cash_amount);
                        }else{
                            $('#sourceTr').show();
                            $('#accountsTr').show();
                            $('#source').html(result.data);
                            $('#creditTr').hide();
                        }
                    }, beforeSend: function () {
                        $('#loading').show();
                    },complete: function () {
                        $('#loading').hide();
                    }, error: function(response) {
                        //alert(JSON.stringify(response));
                    }
                });
        }


        function getAccountStatus(){
            var payment_method=$('#source').val();
            $.ajax({
                url:"{{route('getAccountStatus')}}",
                method:"GET",
                data:{"payment_method":payment_method},
                datatype:"json",
                success:function(result){
                    //alert(JSON.stringify(result));
                    $('#accountsTr').show();
                    $('#creditTr').show();
                    $('#accounts').html(result.status);
                    $('#credit_amount').text(result.credit_amount); 
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }, error: function(response) {
                    //alert(JSON.stringify(response));
                }
            });
        }



        function getAmount(){
            var account_status=$('#accounts').val();
            $.ajax({
                url:"{{route('getAmount')}}",
                method:"GET",
                data:{"account_status":account_status},
                datatype:"json",
                success:function(result){
                    //alert(JSON.stringify(result));
                    $('#credit_amount').text(result); 
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }, error: function(response) {
                    //alert(JSON.stringify(response));
                }
            });
        }
            
               
        function generateVoucher(){
            var payment_method=$('#payment_method').val();
            var source=$('#source').val();
            var accounts=$('#accounts').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
                fd.append('payment_method',payment_method);
                fd.append('source',source);
                fd.append('accounts',accounts);
                fd.append('date_from',date_from);
                fd.append('date_to',date_to);
                fd.append('_token',_token);
            $.ajax({
                url:"{{route('generateBankLedger')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                datatype:"json",
                success:function(result){
                // alert(JSON.stringify(result));
                    $('#manageVoucherTable').html(result.table)
                    $('#manageVoucherTotal').html(result.total)
                    $('#getVoucherButton').html(result.button) 
                },error:function(response) {
                    // alert(JSON.stringify(response));
                    $('#payment_methodError').text(response.responseJSON.errors.payment_method);
                    $('#sourceError').text(response.responseJSON.errors.source);
                    $('#accountsError').text(response.responseJSON.errors.accounts);
                    $('#date_fromError').text(response.responseJSON.errors.date_from);
                    $('#date_toError').text(response.responseJSON.errors.date_to);
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }

            })
        }
           
        





        function generateBankLedgerPdf(){
            var payment_method=$('#payment_method').val();
            var source=$('#source').val();
            var accounts=$('#accounts').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            window.open("{{url('account/Bank/Ledger/pdf/')}}"+"/"+payment_method+ "/" +source+ "/" +accounts+"/"+date_from+"/"+date_to);
          
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

    </script>
@endsection

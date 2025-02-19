@extends('admin.master')
@section('title')
    Admin party ledger
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Party Dues</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    
                    
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Party Type: </label>
                            <select type="date" class="form-control" name="party_type" id="party_type">
                                <option value=""selected>Choose Party Type</option>
                                <option value="Applicant">Applicant</option>
                                <option value="Vendor">Vendor</option>
                                <option value="Supplier">Supplier</option>
                            </select>
                            <span class="text-danger" id="party_typeError"></span>
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
                            <button class="btn btn-primary" onclick="generate()"> <i class="fa fa-random" aria-hidden="true"></i> Generate</button>
                            <button class="btn btn-primary" onclick="pdf()"> <i class="fa fa-file-pdf" aria-hidden="true"></i> PDF</button>
                        </div>
                    </div> 
                    <div class="table-responsive" id="dueTable">
                        
                    </div>
                </div><!-- Card Content end -->
               
               
        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>
        	   
        function generate(){
            var party_type=$('#party_type').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
                fd.append('party_type',party_type);
                fd.append('date_from',date_from);
                fd.append('date_to',date_to);
                fd.append('_token',_token);
            $.ajax({
                url:"{{route('generatePartyDueReport')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                datatype:"json",
                success:function(result){
                   // alert(JSON.stringify(result));
                    $('#dueTable').html(result);
                },error:function(response) {
                    //alert(JSON.stringify(response));
                },beforeSend: function (){
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }
            })
        }
           
        





        function pdf(){
            var party_type=$('#party_type').val();
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            window.open("{{url('account/party/due/pdf/')}}"+"/"+party_type+"/"+date_from+"/"+date_to);
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

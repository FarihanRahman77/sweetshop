@extends('admin.master')
@section('title')
    Admin party ledger
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Service Sale Summary</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    
                    
                    <div class="row">
                        
                        <div class="col-md-4">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" name="date_from" id="date_from" value="{{ todayDate() }}">
                            <span class="text-danger" id="date_fromError">{{ $errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" name="date_to" id="date_to" value="{{ todayDate() }}">
                            <span class="text-danger" id="date_toError">{{ $errors->has('date_to') ? $errors->first('date_to') : '' }}</span>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><span style="color:white;">.</span></label><br>
                            <button class="btn btn-primary" onclick="generateReport()" style="width: 100%;"> <i class="fa fa-random" aria-hidden="true"></i> Search Data </button>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><span style="color:white;">.</span></label><br>
                            <button class="btn btn-primary" onclick="generatePDF()" style="width: 100%;"> <i class="fa fa-file-pdf" aria-hidden="true"></i>  Generate PDF</button>
                        </div>
                    </div>


                    <div class="table-responsive" id="tableDiv"></div>
                    <div class="row">
                         <div class="col-md-12 " id="getVoucherButton"></div>
                    </div>
                    
                </div><!-- Card Content end -->
               
               
        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>
        

     
            
               
        function generateReport(){
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();
                fd.append('date_from',date_from);
                fd.append('date_to',date_to);
                fd.append('_token',_token);

            $.ajax({
                url:"{{route('generateSaleSummaryReport')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                datatype:"json",
                success:function(result){
                   alert(JSON.stringify(result));
                   $('#tableDiv').html(result)
                  /*  $('#manageVoucherTotal').html(result.total)
                   $('#getVoucherButton').html(result.button) */
                },error:function(response) {
                   alert(JSON.stringify(response));
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }

            })
        }
           
        function generatePDF(){
            var date_from=$('#date_from').val();
            var date_to=$('#date_to').val();
            window.open("{{url('service/salesummary/pdf/')}}"+"/"+date_from+"/"+date_to);
        }


        function generateExpenseAccountsDetailsPdf(expenseId) {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            
            window.open("{{ url('account/expenseDetails/pdf/') }}" + "/" + date_from + "/" + date_to + "/" + expenseId);
        }


    </script>
@endsection

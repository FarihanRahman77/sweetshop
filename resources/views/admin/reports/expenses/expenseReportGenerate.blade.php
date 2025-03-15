@extends('admin.master')
@section('title')
    Expense Report
@endsection
@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <!-- Main row -->
            <div id="msg_error"></div>
            <form id="saleProducts" method="POST" enctype="multipart/form-data">
               <div class="card">
                    <div class="card-header">
                        <h3> Generate Daily Report</h3>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            @csrf
                            
                            <div class="form-group col-md-4">
                                <label>Date : </label>
                                <input type="date" class="form-control" id="dateFrom" aria-describedby="emailHelp" value="{{ todayDate() }}">
                                <span class="text-danger" id="dateFromError"></span>
                            </div>
                            <div class="form-group col-md-4 d-none">
                                <label>Date To: </label>
                                <input type="date" class="form-control" id="dateTo" aria-describedby="emailHelp" value="{{ todayDate() }}">
                                <span class="text-danger" id="dateToError"></span>
                            </div>
                         
                            <div class="form-group col-md-4">
                                <label class="text-white">.</label>
                                <span type="button" class="btn btn-outline-primary btn-lg btn-block" onclick="generateExpenseReport()"> <i class="fa fa-eye-slash"></i> Generate  Report</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label  class="text-white">.</label>
                                <span class="btn btn-outline-primary btn-lg btn-block" id="reportBtn" onclick="expenseReport()" style="display:none;"> <i class="fa fa-file-pdf"></i> Generate PDF  </span>
                            </div>

                            <div class="form-group col-md-12">
                                <table border="1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td colspan="7" class="text-center"><b>Cash Report</b></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">SL</td>         
                                            <td width="25%">Particulars</td>
                                            <!-- <td width="25%">Remarks</td> -->
                                            <td width="5%">Voucher</td>
                                            <td width="15%">Cash In</td>
                                            <td width="15%">Cash Out</td>
                                            <td width="12%">Balance</td>
                                        </tr>
                                    </thead>
                                    <tbody id="manageCashExpenseReportTable"></tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-12">
                                <table border="1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td colspan="7" class="text-center"><b>Bank Report</b></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">SL</td>
                                            <td width="25%">Particulars</td>
                                            <td width="25%">Remarks</td>
                                            <td width="5%">Voucher</td>
                                            <td width="15%">Cash In</td>
                                            <td width="15%">Cash Out</td>
                                            <td width="12%">Balance</td>
                                        </tr>
                                    </thead>
                                    <tbody id="manageBankExpenseReportTable"></tbody>
                                </table>
                            </div>

                            <div class="form-group col-md-12">
                                <table border="1" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <td colspan="7" class="text-center"><b>Mobile Banking Report</b></td>
                                        </tr>
                                        <tr>
                                            <td width="3%">SL</td>
                                            <td width="25%">Particulars</td>
                                            <td width="25%">Remarks</td>
                                            <td width="5%">Voucher</td>
                                            <td width="15%">Cash In</td>
                                            <td width="15%">Cash Out</td>
                                            <td width="12%">Balance</td>
                                        </tr>
                                    </thead>
                                    <tbody id="manageMobileBankingExpenseReportTable"></tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                               <span id="customer_btn"></span>
                              
                               
                              <!--   <a type="button" id="checkOutCart" class="btn btn-success my_button float-right"
                                   style="color:#fff;" onclick="generateReport()" target="_blank"> Generate Report </a> -->
                            </div>
                        </div>
                    </div>
                </div> 
            </form>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection




@section('javascript')
    <script>
        $(function() {
            $("select").select2({
                width:'100%'
            });
          
        });

        

     
    
                    
    function generateExpenseReport(){
            var dateFrom=$('#dateFrom').val();
            var dateTo=$('#dateTo').val();
            $.ajax({
                url: "{{route('expenseReportGenerate')}}",
                method:"GET",
                data:{"dateFrom":dateFrom,"dateTo":dateTo},
                success:function(result){
                   // alert(JSON.stringify(result));
                    $("#manageCashExpenseReportTable").html(result.info);
                    $("#manageBankExpenseReportTable").html(result.infoBank);
                    $("#manageMobileBankingExpenseReportTable").html(result.infoMobileBanking);
                    $("#reportBtn").show();
                }, error: function(response) {
                    //alert(JSON.stringify(response));
                    $("#dateFromError").text("Enter a date");
                   // $("#dateToError").text(response.dateTo);
                }, beforeSend: function () {
                    $('#loading').show(); 

                },complete: function () {
                    $('#loading').hide();                           
				}
            })
        
    }





    const expenseReport = () => {
            dateFrom = $("#dateFrom").val();
            dateTo = $("#dateTo").val();
            const data =[ dateFrom, dateTo]
            //alert(data);
            window.open("{{ url('expense/report/Pdf') }}" + "/" + data);
        }


   function expenseDetails(id){
        window.open("{{url('expense/details')}}"+"/"+id);
   }
   function billDetails(id){
        window.open("{{url('account/bill/details')}}"+"/"+id);
   }
   function orderDetails(id){
        var url = '{{ route('sale.service.completeInvoice', ':id') }}';
        url = url.replace(':id', id);
        window.open(url);
   }





    </script>
@endsection

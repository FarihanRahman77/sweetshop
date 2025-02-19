@extends('admin.master')
@section('title')
    Admin account report
@endsection
@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Income & Expenditure Statement</h3>
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">


                    <div class="row">

                        <div class="col-md-4">
                            <label class="form-label">Date From</label>
                            <input type="date" class="form-control" name="date_from" id="date_from"
                                value="{{ date('Y-m-01') }}">
                            <span class="text-danger"
                                id="date_fromError">{{ $errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date To</label>
                            <input type="date" class="form-control" name="date_to" id="date_to"
                                value="{{ date('Y-m-d') }}">
                            <span class="text-danger"
                                id="date_toError">{{ $errors->has('date_to') ? $errors->first('date_to') : '' }}</span>
                        </div>
                        <div class="col-md-4 p-2">
                            <button class="btn btn-primary btn-lg btn-block" onclick="generateReport()"><i class="fa fa-random" aria-hidden="true"></i> Generate Report</button>
                        </div>
                        <div class="col-md-2">
                            <div class="mt-4" id="generatePdf"></div>
                        </div>
                    </div>

                    {{-- New Table --}}
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <table class="table table-bordered table-hover dataTable no-foote" border="1" id="incomeAndExpenditureData">
                             <thead class="text-center text-white bg-info">
                                <th colspan="3"> Income </th>
                                <th colspan="3"> Expenditure </th>
                            </thead> 
                        </table>
                    </div>
                </div>
                    {{-- End New Table --}}



                    <div id="monthYearHeader"></div>
                    <div class="table-responsive" id="tableData"></div>
                    <div class="row">
                        <div class="col-md-12 " id="getVoucherButton"></div>
                    </div>

                    <div id="closingBtn"></div>
                </div><!-- Card Content end -->
        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>
        function generateReport() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            var _token = $('input[name="_token"]').val();

            var fd = new FormData();
            fd.append('date_from', date_from);
            fd.append('date_to', date_to);
            fd.append('_token', _token);

            $.ajax({
                url: "{{ route('generateSummaryReport') }}",
                method: "POST",
                data: fd,
                contentType: false,
                processData: false,
                datatype: "json",
                success: function(result) {
                    //alert(JSON.stringify(result));
                    var incomeAndExpenditureData = '';
                    var expenseData = '';
                    var txtColor = 'text-success';

                    if (result.dataSet.netProfit < 0) {
                        txtColor = 'text-danger';
                    }

                    var thead = `
                            <thead class="text-center text-white bg-info">
                                <th colspan="2"> Income </th>
                                <th colspan="2"> Expenditure </th>
                            </thead>
                    `;


                    var expenseIdsArray = result.expenseDataSet.expenseIdsArray;
                    var expenseObject = result.expenseDataSet.expenseArray;
                    var i = 0;

                    Object.keys(expenseObject).forEach(keyName => {

                        expenseData += `
                                <tr>
                                    <td></td>
                                    <td></td>

                                    <td> <a href="#" onclick="generateExpenseAccountsDetailsPdf(${expenseIdsArray[i]})"> ${keyName}  </a></td>
                                    <td><span class="float-right"> ${ numberFormat(expenseObject[keyName]) } </span></td>
                                </tr>
                        `;
                        i++;
                    });

                     incomeAndExpenditureData = `
                        <tbody>
                                <tr>
                                    <td> <a href="#" onclick="generateSalesAccountsDetailsPdf(42)"> Applicant Order </a> </td>
                                    <td><span class="float-right"> ${ numberFormat(result.dataSet.totalSales) } </span></td>
                                    
                                    <td> <a href="#" onclick="generateVendorOrderPdf(30)"> Vendor Order </a> </td>
                                    <td><span class="float-right"> ${ numberFormat(result.dataSet.totalPurchases) } </span></td>
                                </tr>
                                <tr>
                                    <td> <a href="#" onclick="generateSaleReturnAccountsDetailsPdf(42)"> Applicant Order Return </a> </td>
                                    <td><span class="float-right"> (${ numberFormat(result.dataSet.totalSaleReturnAmount) }) </span></td>
                                    
                                    <td> <a href="#" onclick="generateVendorOrderReturnPdf(30)"> Vendor Order Return  </a> </td>
                                    <td><span class="float-right"> (${ numberFormat(result.dataSet.totalPurchaseReturnAmount) }) </span></td>
                                </tr>
                                
                                <tr>
                                    <tr style="background-color: #b1adad;">
                                        <td class="font-weight-bold">Total Revenue</td>
                                        <td><strong class="float-right font-weight-bold ">${ numberFormat(result.dataSet.totalRevenue)}</strong></td>

                                        <td class="font-weight-bold">Cost Of Services Sold</td>
                                        <td> <strong class="float-right font-weight-bold">${ numberFormat(result.dataSet.cost_Of_Goods_Sold) }</strong> </td>
                                    </tr>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Gross Profit</td>
                                    <td> <strong class="float-right font-weight-bold ${txtColor} ">${ numberFormat(result.dataSet.grossProfit) }</strong> </td>

                                    <td><a href="#" onclick="generateTotalBillAmountDetailsPdf()"> Bill Paid </a></td>
                                    <td><strong class="float-right font-weight-bold">${ numberFormat(result.dataSet.totalBillAmount) }</strong> </td>
                                </tr>
                                ${expenseData}
                                <tr style="background-color: #ddd;">
                                    <td class="font-weight-bold">Total Income</td>
                                    <td><strong class="float-right font-weight-bold ${txtColor} ">${ numberFormat(result.dataSet.grossProfit) }</strong></td>
                                    <td class="font-weight-bold">Total Expense</td>
                                    <td><strong class="float-right font-weight-bold ${txtColor} ">${ numberFormat(result.dataSet.expenseFinalGrandTotal) }</strong></td>
                                </tr>
                                <tr style="background-color: #ddd;">
                                    <td class="font-weight-bold">Net Profit</td>
                                    <td><strong class="float-right font-weight-bold ${txtColor} ">${ numberFormat(result.dataSet.netProfit) }</strong></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                            
                    `;


                    var incomeAndExpenditureFullTable = thead+incomeAndExpenditureData;

                    $('#incomeAndExpenditureData').html('');
                    $('#incomeAndExpenditureData').html(incomeAndExpenditureFullTable);
                    //$('#incomeAndExpenditureData').append(incomeAndExpenditureData);
                    //$('#closingBtn').html(result.closingBtn)
                    $('#generatePdf').html(result.pdf)

                },
                error: function(error) {
                  //  alert(JSON.stringify(error));
                },
                beforeSend: function() {
                    $('#loading').show();
                },
                complete: function() {
                    $('#loading').hide();
                }

            })
        }


        function numberFormat(number) {

            let tempNum = Math.round(number)
            return tempNum.toLocaleString('en-US');
        }




        function generateAccountsSummaryPdf() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/summary/pdf/') }}" + "/" + date_from + "/" + date_to);
        }

        function generateTotalBillAmountDetailsPdf(){
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/Bill/Amount/pdf/') }}" + "/" + date_from + "/" + date_to);
        }

        function generateSalesAccountsDetailsPdf() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/salesDetails/pdf/') }}" + "/" + date_from + "/" + date_to);
        }
        function generateSaleReturnAccountsDetailsPdf() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/sale/Return/Details/pdf/') }}" + "/" + date_from + "/" + date_to);
        }

        function generateVendorOrderPdf() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/purchaseDetails/pdf/') }}" + "/" + date_from + "/" + date_to);
        }
        
        
        function generateVendorOrderReturnPdf() {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/purchase/return/Details/pdf/') }}" + "/" + date_from + "/" + date_to);
        }

        function generateExpenseAccountsDetailsPdf(expenseId) {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/expenseDetails/pdf/') }}" + "/" + date_from + "/" + date_to + "/" + expenseId);
        }
        function generateOpeningClosingStockAccountsDetailsPdf(stockType) {
            var date_from = $('#date_from').val();
            var date_to = $('#date_to').val();
            window.open("{{ url('account/openingClosingStockDetails/pdf/') }}" + "/" + date_from + "/" + date_to+ "/" + stockType);
        }

    </script>
@endsection

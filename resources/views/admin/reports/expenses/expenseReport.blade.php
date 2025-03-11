<html>
<head>
    
    <!-- <link href="{{asset('backend/dist/css/report.style.css')}}" rel="stylesheet"> -->
    <style>
        #footer {
            position: fixed;
            right: 0px;
            bottom: 10px;
            text-align: center;
            border-top: 1px solid black;
        }

        #footer .page:after {
            content: counter(1, decimal);
        }

        @page {
            margin: 0.2cm 0.2cm 0.2cm 0.2cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 2.1cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            margin-left:0.5cm;
            margin-top:-0.5cm;
        }
        .header2 {
            position: fixed;
            top: 15cm;
            left: 0cm;
            right: 0cm;
            margin-left:0.5cm;
            margin-top:-0.5cm;
        }
        .main2{
            position: fixed;
            top: 17cm;
            left: 0cm;
            right: 0cm;
            margin-left:0.5cm;
            margin-top:-0.5cm;
        }
        .customer-info{
            margin-top:0.5cm;
        }

        img {}

        /** Define the footer rules **/
        footer{
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1.8cm;
            text-align: center;
        }

        .column-middle {
            float: left;
            width: 50.33%;
            padding: 1% 0% 0% 2%;
            height: 300px;
        }
        .column-left {
            float: left;
            width: 15%;
            padding: 1% 0% 0% 2%;
            height: 300px;
        }
        .column-right {
            float: right;
            width: 20%;
            padding: 0% 0% 0% 2%;
            height: 300px; 
        }
        .column11 {
            text-align: left;
            width: 100%;
            height: 33px;
        }
        .column22 {
            float: right;
            width: 15%;
            height: 33px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .column {
            float: left;
            width: 33.33%;
           
        }

        .signatures {
            padding-bottom: -500px;
        }

        .citiestd13 {
            border: 1px solid gray;
            color: black;
            text-align: center;
            font-size: 11px;
            padding: 3px;
        }

        .supAddressFont {
            font-size: 11px;
        }

        .supAddressFont h2 {
            margin: 0% 0% 0% 0%;
        }

        .supAddressFontEmi {
            font-size: 13px;
        }

        .underAlignment {
            text-align: right;
            font-size: 10px;
        }

        .underAlignmentLeft {
            text-align: left;
            font-size: 10px;
        }

        .textLeft {
            text-align: left;
            font-size: 11px;
        }

        .textRight {
            text-align: right;
        }

        .textCenter {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.8em;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        }

        /* .td-text{
                text-align:right;
                padding-right:35px ;
            } */
        thead tr {
            background-color: #ffff;
            color: black;
            text-align: left;
        }

        /* th, td {
                padding: 12px 15px;
            } */
        .overline {
            text-decoration: overline;
        }

        .emi-table {
            width: 80%;
            padding-left: 10%;
        }

        .emi-table-title {
            padding-left: 10px;
            margin-bottom: -5px;
            padding-left: 11%;
        }

        .text-center {
            text-align: center;
        }

        .spaces {
            color: white;
        }
        .column1{
            text-align: center;
            width: 35%;
            padding: 1% 0% 0% 2%;
            height: 300px; /* Should be removed. Only for demonstration */
        }
        .column2{
            float: left;
            width: 33.33%;
            padding: 1% 0% 0% 2%;
            height: 300px; /* Should be removed. Only for demonstration */
        }
        .column3 {
            float: right;
            width: 30%;
            padding: 0% 0% 0% 2%;
            height: 300px; /* Should be removed. Only for demonstration */
            }
            /* Clear floats after the columns */
            .row2:after {
            content: "";
            display: table;
            clear: both;
            }
        .pagenum:before {
                content: counter(page);
                margin-left:90%;
        }

        /*img {
              margin-top: 25px
            }*/
    </style>
    <title>Expense Report</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;font-size: 13px;">
<!-- Content Wrapper. Contains page content -->
    <header>
        <div class="row2">
        <div class="text-center">
                <img src="{{'upload/images/'.Session::get('companySettings')[0]['logo']}}" width='180' height='60'>
                <div class="supAddressFont">
                    {!!Session::get("companySettings")[0]["report_header"]!!}
                </div>
            </div>
        </div>
    </header>
    <footer>
        <div class="signatures">
            <div class="row " style="font-size:10px;">
                <div class="column-left">
                    <br>--------------------------<br>
                    Customer Signature
                </div>
                <div class="column-middle">
                    {{ auth()->user()->name }}
                    <br>----------------------------<br>
                    Created By
                </div>
                <div class="column-right">
                    <br>-----------------------------<br>
                    Authorized Signature
                </div>
            </div>
        </div>
        <hr>
    </footer>
<main>
        
<!-- Content Wrapper. Contains page content -->
    <div style="text-align: center;">
        <div class="citiestd13"> Expense Report Date : {{ \Carbon\Carbon::createFromTimestamp(strtotime($startAndEndDate[0]))->format('d-m-Y')}}</div>
            <table  cellspacing="0" cellpadding="3">
                <tr>
                    <td width="70%" class="supAddress"><div><strong>Printed Date: </strong> {{ \Carbon\Carbon::createFromTimestamp(strtotime(todayDate()))->format('d-m-Y')}}</div></td>    
                </tr>
                <tr>    
                    <td width="30%" class="supAddress"><div><strong>Printed By: </strong> {{ auth()->user()->name }}</div></td>
                </tr>

            </table>  
            @if($table) 
            <table border="1" class="invoice-info" cellspacing="0" cellpadding="3" width="100%">
                <thead>
                    <tr>
                        <th colspan="7" class="text-center">Cash Report</th>
                    </tr>
                    <tr>
                        <th width="3%">SL</th>
                        <th width="25%">Particulars</th>
                        <th width="25%">Remarks</th>
                        <th width="5%">Voucher</th>
                        <th width="15%">Cash In</th>
                        <th width="15%">Cash Out</th>
                        <th width="12%">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    {!! $table !!}
                    
                </tbody>
            </table><br>
            <!--For Cash-->
            <div class="row" style="font-size:11px;">
                <div class="column">
                    <span><b>Today Cash In : </b> {{numberFormat($cashIn)}}</span><br>
                    <span><b>Today Cash out : </b> {{numberFormat($cashOut)}}</span><br>
                    <span><b>Today Closing Balance: </b> {{numberFormat($balance)}}</span><br>
                    <span><b>Net Cash Closing Balance: </b> {{numberFormat($openingBalance+$cashIn-$cashOut)}}</span>
                </div>
                <div class="column"></div>
                <div class="column">
                    <span><b>Cash Opening Balance : </b> {{numberFormat($openingBalance)}}</span><br>
                    <span><b>Today Cash Closing Balance: </b> {{numberFormat($balance)}}</span><br>
                    <span><b>Net Cash Closing Balance: </b> {{numberFormat($openingBalance+$cashIn-$cashOut)}}</span>
                </div>
            </div>
            <br>
            @endif
            @if($tableBank)
            <table border="1" class="invoice-info" cellspacing="0" cellpadding="3" width="100%">
                <thead>
                    <tr>
                        <th colspan="7" class="text-center">Bank Report</th>
                    </tr>
                    <tr>
                        <th width="3%">SL</th>
                        <th width="25%">Particulars</th>
                        <th width="25%">Remarks</th>
                        <th width="5%">Voucher</th>
                        <th width="15%">Cash In</th>
                        <th width="15%">Cash Out</th>
                        <th width="12%">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    {!! $tableBank !!}
                    
                </tbody>
            </table>
            <br>
            <div class="row" style="font-size:11px;">
                <div class="column">
                    <span><b>Today Bank In : </b> {{numberFormat($BankIn)}}</span><br>
                    <span><b>Today Bank out : </b> {{numberFormat($BankOut)}}</span><br>
                    <span><b>Today Bank Closing Balance: </b> {{numberFormat($balanceBank)}}</span><br>
                    <span><b>Net Bank Closing Balance: </b> {{numberFormat($allBankOpeningBalance+$BankIn-$BankOut)}}</span>
                </div>
                <div class="column"></div>
                <div class="column">
                    <span><b>Bank Opening Balance : </b> {{numberFormat($allBankOpeningBalance)}}</span><br>
                    <span><b>Today Bank Closing Balance: </b> {{numberFormat($balanceBank)}}</span><br>
                    <span><b>Net Bank Closing Balance: </b> {{numberFormat($allBankOpeningBalance+$BankIn-$BankOut)}}</span>
                </div>
            </div>
            
            @endif
            @if($tableMobileBanking)
            <table border="1" class="invoice-info" cellspacing="0" cellpadding="3" width="100%">
                <thead>
                    <tr>
                        <th colspan="7" class="text-center">Mobile Banking Report</th>
                    </tr>
                    <tr>
                        <th width="3%">SL</th>
                        <th width="25%">Particulars</th>
                        <th width="25%">Remarks</th>
                        <th width="5%">Voucher</th>
                        <th width="15%">Cash In</th>
                        <th width="15%">Cash Out</th>
                        <th width="12%">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    {!! $tableMobileBanking !!}
                    
                </tbody>
            </table><br>
            <div class="row" style="font-size:11px;">
                <div class="column">
                    <span><b>Today Mobile Banking In : </b> {{numberFormat($MobileBankingIn)}}</span><br>
                    <span><b>Today Mobile Banking out : </b> {{numberFormat($MobileBankingOut)}}</span><br>
                    <span><b>Today Mobile Banking Closing Balance: </b> {{numberFormat($balanceMobileBanking)}}</span><br>
                    <span><b>Net Mobile Banking Closing Balance: </b> {{numberFormat($allMobileBankOpeningBalance+$MobileBankingIn-$MobileBankingOut)}}</span>
                </div>
                <div class="column"></div>
                <div class="column">
                    <span><b>Mobile Banking Opening Balance : </b> {{numberFormat($allMobileBankOpeningBalance)}}</span><br>
                    <span><b>Today Mobile Banking Closing Balance: </b> {{numberFormat($balanceMobileBanking)}}</span><br>
                    <span><b>Net Mobile Banking Closing Balance: </b> {{numberFormat($allMobileBankOpeningBalance+$MobileBankingIn-$MobileBankingOut)}}</span>
                </div>
            </div>
            @endif
            
        </div>
        <br><br><br><br><br><br><br><br>
       
    </div>
</main>   
        
</body>
</html>
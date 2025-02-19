<html>

<head>
    
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/assets/assets/libs/bootstrap/dist/css/bootstrap.min.css' }}">

    <style>
        #footer {
            position: fixed;
            right: 0px;
            bottom: 20px;
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
            margin-top: 3.2cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 4cm;
            font-family: "Roboto, 'Segoe UI', Tahoma, sans-serif";
            /* font-family: "Arial Narrow"; */
            font-size: 12pt;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            text-align: center;
            font-family: "Arial Narrow";
            font-size: 12pt;
        }


        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 1cm;
            /*  left: 0cm;
            right: 0cm; */
            height: 1.8cm;
            text-align: center;
            font-family: "Arial Narrow";
            font-size: 10pt;
        }

        td {
            font-size: 12px;
        }

        /*  .column {
            float: left;
            width: 33.33%;
            height: 30px;
        } */

        /* Clear floats after the columns */
        /* .row:after {
            content: "";
            display: table;
            clear: both;
        } */

        .signatures {
            padding-bottom: -500px;
            font-family: "Arial Narrow";
            font-size: 10pt;
        }

        .citiestd13 {
            background-color: rgb(242, 242, 242);
            border: 1px solid gray;
            color: black;
            text-align: center;
            font-size: 13px;
            padding: 5px;
        }

        .supAddressFont {
            font-size: 11px;
        }

        .underAlignment {
            text-align: right;
            font-size: 13px;
        }

        .underAlignmentLeft {
            text-align: left;
            font-size: 13px;
        }

        /* table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 0.8em;
            min-width: 400px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        } */

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

        .column2 {
            float: left;
            width: 50%;
            padding: 10px;
            height: 300px;
            /* Should be removed. Only for demonstration */
        }

        /* Clear floats after the columns */

        .row2:after {
            content: "";
            display: table;
            clear: both;
        }

        .textLeft {
            text-align: left;
            font-size: 14px;
        }

        .text-right {
            text-align: right;
            padding-right: 65px;
        }

        tr {
            margin: 0px;
            padding: 0px;
        }

        td {
            font-size: 12px;
        }

        .txt-right {
            text-align: right;
        }
    </style>
    <title>Bill Details ({{ $date_from }} - {{ $date_to }})</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <div class="">
            <div class="">
                <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='250'
                    height='110'>
                <div class="supAddressFont">
                    {!! Session::get('companySettings')[0]['report_header'] !!}
                </div>
            </div>

        </div>

    </header>


    <main>

        <div>
            <div style="text-align: center; border: 1px solid gray;font-size:13px;" class="">
                <div>
                    Bill Details
                    &nbsp; ({{ $date_from }} - {{ $date_to }})
                </div>
            </div>
        </div>


       <div class="container-fluid  p-0 mt-2">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <h5>Bill Details </h5>
                    <table border="1" width="100%" class="invoice-info" cellspacing="0" cellpadding="3">
                        <thead>
                            <tr class="text-center">
                                <td scope="col" width="5%">SL</td>
                                <td scope="col" width="15%">Date</td>
                                <td scope="col" width="15%">Bill No</td>
                                <td scope="col" width="25%">Reason</td>
                                <td scope="col" width="25%">Supplier Name </td>
                                <td scope="col" width="15%">Amount</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $billAmountTotal=0;
                            @endphp
                            @foreach ($bills as $key => $bill)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $bill->transaction_date }}</td>
                                    <td class="text-center">{{ $bill->code }}</td>
                                    <td>{{ $bill->particulars }}  </td>
                                    <td>{{ $bill->name }}</td>
                                    <td class="txt-right">{{ $bill->amount }}</td>
                                </tr>
                                @php 
                                    $billAmountTotal+=$bill->amount;
                                @endphp
                            @endforeach

                            @if (count($bills) > 0)
                                <tr class="txt-right">
                                    <td colspan="2"></td>
                                    <td colspan="3"><strong> Total Expense Amount </strong></td>
                                    <td ><strong> {{ number_format($billAmountTotal) }} </strong></td>
                                </tr>
                            @else
                                <tr class="text-center">
                                    <td colspan="6"> No Records Available </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </main>



</body>

</html>

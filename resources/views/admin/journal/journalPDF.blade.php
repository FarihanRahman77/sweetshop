<html>

<head>
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
            margin-top: 4.1cm;
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 4cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: .5cm;
            left: 0cm;
            right: 0cm;
            text-align: center;
        }


        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 2cm;
            left: 0cm;
            right: 0cm;
            height: 1.8cm;
            text-align: center;
        }

        .column {
            float: left;
            width: 33.33%;
            height: 30px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .signatures {
            padding-bottom: -500px;
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
    </style>
    <title>Journal Invoice</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='100' height='55'>
        <div class="supAddressFont">
            {!! Session::get('companySettings')[0]['report_header'] !!}
        </div>
    </header>


    <footer>


        <div class="signatures">

            <div class="row " style="font-size:14px;">
                <div class="column">
                    Ali Tech
                    <br>-----------------------<br>
                    Customer Signature
                </div>
                <div class="column">
                    {{ Session::get('userName') }}
                    <br>-----------------------<br>
                    Created By
                </div>
                <div class="column">
                    Manager
                    <br>-----------------------<br>
                    Authorized Signature
                </div>
            </div><br><br>
            <hr />
            <div style="font-size:10px;">{!! Session::get('companySettings')[0]['report_footer'] !!}</div>


        </div>

    </footer>
    <main>

        <!-- Content Wrapper. Contains page content -->
        <div>
            <div style="text-align: center;">
                <div class="citiestd13">Journal Invoice </div>
                <table cellspacing="0" cellpadding="3">
                    <tr>
                        <td width="60%" class="supAddress">

                        </td>
                        <td width="40%" class="supAddress">

                        </td>
                    </tr>
                </table>
                <table border="1" class="invoice-info" cellspacing="0" cellpadding="3">
                    <thead>
                        <tr>
                            <th width="5%">SL</th>
                            <th width="20%">Account</th>
                            <th width="20%">Transaction Date</th>
                            <th width="35%">Particulars</th>
                            <th width="10%">Debit</th>
                            <th width="10%">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($details as $detail)
                            <tr>
                                <td class="text-center">{{ $i++ }}</td>
                                <td>{{ $detail->name }}</td>
                                <td class="text-center">{{ $detail->transaction_date }}</td>
                                <td> {{ $detail->particulars }}</td>
                                <td class="text-center" style="text-align:right;">{{ $detail->debit }}
                                    {!! Session::get('companySettings')[0]['currency'] !!}</td>
                                <td class="text-center" style="text-align:right;"> {{ $detail->credit }}
                                    {!! Session::get('companySettings')[0]['currency'] !!}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="4" style="text-align:right;"> Total = </td>
                            <td style="text-align:right;"> {{ $journals->voucher_amount }} {!! Session::get('companySettings')[0]['currency'] !!}</td>
                            <td style="text-align:right;" style="text-align:right;"> {{ $journals->voucher_amount }}
                                {!! Session::get('companySettings')[0]['currency'] !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>



        </div>
        </div>
        </div>
        </section>
        </div>
    </main>
</body>

</html>

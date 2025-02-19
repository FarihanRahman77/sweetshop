<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/assets/assets/libs/bootstrap/dist/css/bootstrap.min.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/dist/css/report.style.css' }}">

    
    <title>Income & Expenditure Statement ({{ $date_from }} - {{ $date_to }})</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <div class="">
            <div class="">
                <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='210'height='100'>
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
                    Income & Expenditure Statement ( Vendor Order Return Details ) &nbsp; ({{ $date_from }} - {{ $date_to }})
                </div>
            </div>
        </div>


        <div class="container-fluid  p-0 mt-2">
            

            <div class="row no-gutters">
                <div class="col-md-12">
                    <h6>Vendor Order Return Details </h6>
                    <table border="1" width="100%" class="invoice-info" cellspacing="0" cellpadding="3">
                        <thead>
                            <tr>
                                <td scope="col" style="width:5%;">SL#</td>
                                <td scope="col" style="width:10%;">Invoice No</td>
                                <td scope="col" style="width:35%;">Details</td>
                                <td scope="col" style="width:25%;">Party Name</td>
                                <td scope="col" style="width:15%;">Return Date</td>
                                <td class="text-right" scope="col" style="width:15%;">Amount </td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalSaleReturnAmount = 0;
                            @endphp
                            @forelse ($vendorOrderReturns as $key => $saleReturn)
                                @php
                                    $totalSaleReturnAmount += $saleReturn->grand_total;
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $saleReturn->sale_order_return_no }}</td>
                                    <td>{{ $saleReturn->voucher_title }}</td>
                                    <td>{{ $saleReturn->name }}</td>
                                    <td>{{ $saleReturn->sale_order_return_date }}</td>
                                    <td class="text-right">{{ $saleReturn->grand_total }}</td>
                                </tr>
                                @if ($loop->last)
                                    <tr class="text-right">
                                        <td></td>
                                        <td></td>
                                        <td colspan="3" ><strong> Total Sale Return Amount  </strong></td>
                                        <td><strong> {{ number_format($totalSaleReturnAmount) }} </strong></td>
                                    </tr>
                                @endif
                            @empty
                            <tr class="text-center text-danger">
                                <td colspan="5"><strong> <h6 class="text-info">No Vendor Return</h6> </strong></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>



</body>

</html>

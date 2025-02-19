<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/assets/assets/libs/bootstrap/dist/css/bootstrap.min.css' }}">
    <link rel="stylesheet" type="text/css" href="{{ base_path() . '/public/backend/dist/css/report.style.css' }}">

    
    <title>{{$type}} Order Wise Profit ({{ $date_from }} - {{ $date_to }})</title>
</head>

<body>
    <!-- Content Wrapper. Contains page content -->
    <header>
        <div class="">
            <div class="">
                <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" width='210'height='100'>
                <div class="supAddressFont">
                    {!! Session::get('companySettings')[0]['report_header'] !!}
                    <span style="font-size:14px;">{{$warehouse->wareHouseName}}</span>
                </div>
            </div>

        </div>

    </header>


    <main>

        <div>
            <div style="text-align: center; border: 1px solid gray;font-size:13px;" class="">
                <div>
                    Profit and Loss Report &nbsp; ({{ $date_from }} - {{ $date_to }})
                </div>
            </div>
        </div>


        <div class="container-fluid  p-0 mt-2">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <table border="1" width="100%" class="invoice-info" cellspacing="0" cellpadding="3">
                        <thead>
                            <tr>
                                <td scope="col" style="width:3%;">SL#</td>
                                <td scope="col" style="width:15%;">Order Info</td>
                                <td scope="col" style="width:17%;">Applicant Info</td>
                                <td scope="col" style="width:17%;">Service Info</td>
                                <td scope="col" style="width:8%;">Receiveable<br>(From Applicant)</td>
                                <td scope="col" style="width:8%;">Return<br>(To Applicant)</td>
                                
                                <td scope="col" style="width:8%;">Approximate Payable<br>(To Vendor)</td>
                                <td scope="col" style="width:8%;">Payable<br>(To Vendor)</td>
                                <td scope="col" style="width:8%;">Return<br>(From Vendor)</td>
                                
                                <td scope="col" style="width:8%;">Profit/Loss</td>
                            </tr>
                        </thead>
                        <tbody>
                           {!! $html !!}
                        </tbody>
                    </table>
                </div>
            </div>

            
            
        </div>

    </main>



</body>

</html>

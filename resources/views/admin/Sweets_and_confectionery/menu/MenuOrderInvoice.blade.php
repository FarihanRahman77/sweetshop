<html>
<head>
    <style>
        /* Base Styles */
       
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px; 
            color: #333;
        }
     
        main {
            flex-grow: 1;
            overflow-y: auto; 
        }

        /* Header Section */
        .header {
            padding: 5px;
            border-bottom: 1px solid #333;
            text-align: center;
        }

        /* .header img {
            height: 50px; 
        } */

        .company-info {
            font-size: 0.65rem;
            line-height: 1.2;
        }

        /* Invoice Title */
        .invoice-title {
            font-size: 1rem; 
            text-align: center;
            margin: 10px 0;
            text-transform: uppercase;
        }

        /* Order Details */
        .order-info {
            width: 100%;
            margin-bottom: 10px;
        }

        .order-info td {
            /* text-align: center; */
            padding: 3px; 
        }

   
       .items-table {
            width: 100%; 
            border-collapse: collapse;
            margin: 5px 0;
        }

        .items-table th {
            background-color: #f5f5f5;
            padding: 6px 5px; 
            border-bottom: 2px solid #ddd;
            text-align: left;
            font-size: 9px;
        }

        .items-table td {
            padding: 6px 5px; 
            border-bottom: 1px solid #eee;
            font-size: 6px;
        }

        .items-table td:last-child {
            text-align: right;
        }

        /* Totals Section */
        .totals-table {
            width: 100%;
            margin-top: 10px;
        }

        .totals-table td {
            /* padding: 6px 5px; */
            text-align: right;
            font-size: 8px;
        }
        .totalstable {
    width: 100%;
    margin-top: 10px;
    border-collapse: collapse;
        }

        .totalstable td {
            font-size: 12px;
            padding: 6px 5px;
        }

        .totalstable .left-col {
            text-align: right;
            width: 80%;  
        }

        .totalstable .right-col {
            text-align: right;
            width: 20%;  
        }

        .total-row {
            font-weight: bold;
            border-top: 2px solid #333;
        }
        /* Footer Section */
        .footer {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 5px; 
            background-color: #fff;
            border-top: 1px solid #444;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            gap: 5px;
        }

        .signature-box {
            flex: 1;
            text-align: center;
            font-size: 0.7rem;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            padding-top: 10px;
        }

        .thank-you {
            text-align: center;
            font-style: italic;
            color: #666;
            font-size: 0.75rem; 
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            body {
                font-size: 9px;
            }

            .header img {
                height: 20px;
            }

            .invoice-title {
                font-size: 0.9rem;
            }

            .items-table td {
                font-size: 0.75rem;
            }

            .totals-table td {
                font-size: 0.8rem;
            }

            .signature-box {
                font-size: 0.65rem;
            }
        }

        .text-right{
            text-align: right;
        }
    </style>
    <title>Restaurant Invoice</title>
</head>

<body>

<header class="header">
    <img src="{{ 'upload/images/' . Session::get('companySettings')[0]['logo'] }}" alt="Logo" style="width:90px;">
    <div class="company-info">
        <div>Address: {{ Session::get('companySettings')[0]['address'] }}</div>
        <div>Contact: {{ Session::get('companySettings')[0]['phone'] }}</div>
    </div>
</header>

<main>
    <p class="invoice-title">Order Invoice: {{ $orderinvoicedata[0]->restaurant_order_code }}</p>

    <table class="order-info">
        <tr>
            <td><strong> Date:</strong> {{ $orderinvoicedata[0]->order_date }}</td>
            <td><strong> Customer Name:</strong> {{ $orderinvoicedata[0]->party_name }}</td>
          
        </tr>
        <tr>
        <td ><strong>Invoice Num:</strong> {{ $orderinvoicedata[0]->restaurant_order_code }}</td>
            <td ><strong>Customer Contact:</strong> {{ $orderinvoicedata[0]->party_contact }}</td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
        @php
            $i = 1;
            $totalAmount = 0;
            $totalQty = 0;
            $paidAmount = 0;
        @endphp
        @foreach ($orderinvoicedata as $info)
        @php
            $totalAmount = $info->order_total;
            $paidAmount = $info->paid_amount;
            $DiscountAmount = $info->grand_discount;
            $UnittotalAmount = $info->unit_total_price;
            $Vat = $info->vat;
            $DUE = $info->due;
            $UNITPrice = $info->unit_price;
            $grandTotal=0;
        @endphp
        @endforeach
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th> Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach ($orderinvoicedata as $index => $item)
        @php
            if ($item->product_broken_type == 'Yes'){
                $qty=$item->sub_quantity;
                $unitPrice=$item->sub_unit_price;
            }else{
                $qty=$item->menu_quantity;
                $unitPrice=$item->unit_price;
            }
        @endphp
            
    <tr>
        <td>{{ $index + 1 }}</td>
        <td style="text-align: left;">{{ $item->menu_name }}</td>
        <td>{{ $qty }}</td>
        <td>{{ number_format($unitPrice, 2) }}</td>
        <td>{{ number_format($unitPrice * $qty, 2) }}</td>
    </tr>

    @php
        $grandTotal = $item->total_amount;
        $Paidamount = $item->paid_amount;
    @endphp
@endforeach

        </tbody>
    </table>
    <table class="totalstable">
    <tr>
        <td class="left-col">Total Amount :</td>
        <td class="right-col">{{ $item->grand_total }}</td>
    </tr>
    <tr>
        <td class="left-col">Discount :</td>
        <td class="right-col">{{ $item->grand_discount }}</td>
    </tr>
    <tr>
        <td class="left-col">Vat :</td>
        <td class="right-col">{{ $item->vat }}</td>
    </tr>
    <tr>
        <td class="left-col">Ait :</td>
        <td class="right-col">{{ $item->ait }}</td>
    </tr>
    <tr>
        <td class="left-col">Payment Method :</td>
        <td class="right-col">{{ $item->paymentmethodName }}</td>
    </tr>
    <tr >
            <td class="left-col"><b>Grand Total:</b></td>
            <td class="right-col">{{ number_format($grandTotal, 2) }}</td>
        </tr>
    <tr>
            <td class="left-col">Paid Amount:</td>
            <td class="right-col">{{ number_format($Paidamount, 2) }}</td>
        </tr>
    <tr>
            <td class="left-col">Current Due</td>
            <td class="right-col">{{ number_format($grandTotal-$Paidamount, 2) }}</td>
        </tr>
      
</table>
    
    <div class="amount-in-words" style="margin-bottom:10px;">
        <strong>Amount in Words:</strong> {{ ucfirst(numberToWord($grandTotal)) }} taka only
    </div>
</main>

<footer class="footer">
   
    <div class="thank-you" style="text-align: center; padding: 20px; font-size: 10px;">
    <p style="margin: 0; font-weight: bold; "> Have a nice day </p>
    <p style="margin: 5px 0; color: #666;">Thank  You</p>
    <p style="margin: 0; font-style: italic; color: #888;">{{ Session::get('companySettings')[0]['report_footer'] }}</p>
</div>

</footer>

</body>
</html>

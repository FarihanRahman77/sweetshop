@extends('admin.master')
@section('title')
    {{ Session::get('companySettings')[0]['name'] }} {{$type}} Order Report
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- Main content -->
        <section class="content box-border">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <!-- Main row -->
                <div id="msg_error"></div>
                <form id="saleProducts" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-md-12">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <h3> {{$type}} Order Report</h3>
                                    <input type="hidden" id="type" value="{{$type}}">
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="row">
                                        @csrf
                                        <div class="form-group col-md-3">
                                            <label>{{$type}}s: </label>
                                            <select id="party_id" name="party_id" class="form-control input-sm">
                                                <option value="">Select {{$type}}</option>
                                                <option value="All">All</option>
                                                @foreach($parties as $party)
                                                <option value="{{$party->id}}">{{ $party->name }} - <b>ID: </b>{{ $party->code}} - <br><b>Mobile: </b>{{ $party->contact}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <div class="form-group col-md-3">
                                            <label>Date From: </label>
                                            <input type="date" class="form-control" id="dateFrom"
                                                aria-describedby="emailHelp" value="{{ todayDate() }}">

                                        </div>
                                        <div class="form-group col-md-3">
                                            <label>Date To: </label>
                                            <input type="date" class="form-control" id="dateTo"
                                                aria-describedby="emailHelp" value="{{ todayDate() }}">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label> </label>
                                            <span id="customerGenerateBtn"></span>
                                            <button type="button" class="btn btn-primary btn btn-block p-2" onclick="getPartyOrder()"><i class="fa fa-eye"></i> View {{$type}} Order Report</button>
                                        </div>

                                    <div class="form-group col-md-8"></div>
                                        <div class="form-group col-md-12 ">
                                            <label>{{$type}} Order Details: </label>
                                            
                                            <div class="row" id="filterDiv" style="display:none;">
                                                <div class="form-group col-md-3">
                                                    <label>Search By Status: </label>
                                                    <select type="status" class="form-control" id="status">
                                                        <option value="all">All</option>
                                                        @if($type =='Applicant')
                                                        <option value="Ordered from Applicant">Ordered from Applicant</option>
                                                        @endif
                                                        <option value="Ordered to Vendor">Ordered to Vendor</option>
                                                        <option value="Received from Vendor">Received from Vendor</option>
                                                        <option value="Delivered to Applicant">Delivered to Applicant</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6"></div>
                                                <div class="form-group col-md-3" >
                                                    <label>Search : </label>
                                                    <input type="text" class="form-control" id="searchInput" placeholder="Search ..">
                                                </div>
                                            </div>
                                            
                                            <table border="1" class="table table-bordered table-hover dataTable no-footer" style="width:100%;text-align:center;" id="manageOrderReportTable">
                                                <thead>
                                                    <tr>
                                                        <th style="width:2%;text-align:center;">SL#</th>
                                                        <th style="width:15%; text-align:left;">Order Info</th>
                                                        <th style="width:83%;text-align:center;">Order Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="manageOrderReportTbody"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card -->
                                <!-- /.card -->
                            </div>
                        </section>
                        <!-- /.Left col -->
                    </div><!-- /.container-fluid -->
                </form> 
            </div>
        </section>
       
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
@section('javascript')
<script>

       
    $("#party_id").select2({
        placeholder: "Select party",
        allowClear: true,
        width: '100%'
    });
    
    function getPartyOrder(){

        var type=$('#type').val();
        var party_id=$('#party_id').val();
        var dateFrom = $("#dateFrom").val();
        var dateTo = $("#dateTo").val();
        var _token = $('input[name="_token"]').val();

        var fd = new FormData();
        fd.append('type', type);
        fd.append('party_id', party_id);
        fd.append('dateFrom', dateFrom);
        fd.append('dateTo', dateTo);
        fd.append('_token',_token);

        $.ajax({
            url: "{{route('getReportsPartyOrder') }}",
            method: "POST",
            data: fd,
            contentType: false,
            processData: false,
            datatype: "json",
            success: function(result) {
                //alert(JSON.stringify(result));
               
                $("#manageOrderReportTbody").html(result);
                $("#filterDiv").show();
            },
            beforeSend: function() {
                $('#loading').show();
            },
            complete: function() {
                $('#loading').hide();
            },
            error: function(response) {
                //alert(JSON.stringify(response));
            }
        }); 
    }

        function completeInvoice(id) {
            var url = '{{ route('sale.service.completeInvoice', ':id') }}';
            url = url.replace(':id', id);
            window.open(url);
        }



        document.getElementById("searchInput").addEventListener("keyup", function() {
          const filter = this.value.toLowerCase();
          const table = document.getElementById("manageOrderReportTable");
          const rows = table.getElementsByTagName("tr");
        
          for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let rowVisible = false;
        
            for (const cell of cells) {
              if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                rowVisible = true;
                break;
              }
            }
        
            rows[i].style.display = rowVisible ? "" : "none";
          }
        });
        
        
        
        document.getElementById("status").addEventListener("change", function() {
            const filter = this.value.toLowerCase();
            const table = document.getElementById("manageOrderReportTable");
            const rows = table.getElementsByTagName("tr");
        
            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                
                if (filter === "all") {
                    rows[i].style.display = ""; // Show all rows
                } else {
                    let rowVisible = false;
        
                    for (const cell of cells) {
                        if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                            rowVisible = true;
                            break;
                        }
                    }
        
                    rows[i].style.display = rowVisible ? "" : "none";
                }
            }
        });







</script>
@endsection

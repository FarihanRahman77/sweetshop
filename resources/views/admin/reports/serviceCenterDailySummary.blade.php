@extends('admin.master')
@section('title')
Service Center Daily Report
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Service Center Daily Report</h3> 
                    <h3 class="text-center text-danger">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    
                    
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="date_from" id="date_from" value="{{ date('Y-m-d') }}">
                            <span class="text-danger" id="date_fromError">{{ $errors->has('date_from') ? $errors->first('date_from') : '' }}</span>
                        </div>
                        
                        <div class="col-md-3">
                            <button class="btn btn-primary" style="padding: 0.5rem !important;" onclick="generateServiceReport()"> <i class="fa fa-random" aria-hidden="true"></i> Generate Report</button>
                        </div>
                    </div>

                   
                    <div id="tableData"></div>
                    <div id="generatePdf"> </div>
                    
                </div><!-- Card Content end -->
               
               
        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>
       

     
            
               
        function generateServiceReport(){
            var date_from=$('#date_from').val();
            var _token = $('input[name="_token"]').val();
            var fd = new FormData();
                fd.append('date_from',date_from);
                fd.append('_token',_token);
            $.ajax({
                url:"{{route('generateDailyServiceReport')}}",
                method:"POST",
                data:fd,
                contentType: false,
                processData: false,
                datatype:"json",
                success:function(result){
                    //alert(JSON.stringify(result));
                   $('#tableData').html(result.table);
                   $('#generatePdf').html(result.pdf);
                  
                },error:function(response) {
                    alert(JSON.stringify(response));
                }, beforeSend: function () {
                    $('#loading').show();
                },complete: function () {
                    $('#loading').hide();
                }

            })
        }
        
        function generatePdf(){
            var date_from=$('#date_from').val();
            window.open("{{url('service/daily/report/pdf/')}}"+"/"+date_from);
        }


    </script>
@endsection

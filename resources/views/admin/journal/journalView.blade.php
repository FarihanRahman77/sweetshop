@extends('admin.master')
@section('title')
    Admin Journal List
@endsection


@section('content')
    <div class="container-fluid">
        <section class="content box-border">
            <div class="card">
                <div class="card-header">
                    <h3>Journal List
                            <button type="button" class="btn  btn-primary float-right" onclick="create()"><i class="fa fa-plus-circle"></i>
                                Add Journal</button>
                    </h3>
                    <h3 class="text-center text-success">{{ Session::get('message') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable no-footer" id="manageJournalTable" width="100%">
                            <thead>
                                <tr class="bg-light">
                                    <td width="5%" class="text-center">Sl</td>
                                    <td width="30%" class="text-center">Transaction Date</td>
                                    <td width="30%" class="text-center">Reference</td>
                                    <td width="20%" class="text-center">Particulars</td>
                                    <td width="10%" class="text-center">Status</td>
                                    <td width="5%" class="text-center">Action</td>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div><!-- Card Content end -->

               

        </section>
    </div><!-- pc-container end -->
@endsection


@section('javascript')
    <script>
         function create() {
            window.location.href = "{{ route('addJournal')}}";
        }

        $(document).ready(function() {
            table = $('#manageJournalTable').DataTable({
                'ajax': "{{route('getJournalData')}}",
                processing:true,
            });
        });

        function journalDetails(id){
            window.open("{{url('journal/details')}}"+"/"+id);
        }


    </script>
@endsection

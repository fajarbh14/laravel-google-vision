@extends('layouts.admin.master')
@section('title','Log Activity')
@push('css')
<!-- DataTables -->
<link href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" /> 
@endpush
@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h4 class="mb-sm-0 font-size-18">Log Activity</h4>
@endslot
<li class="breadcrumb-item">Log Activity</li>
@slot('action')
    <li><a class="btn btn-success btn-sm" href="#" data-refresh-btn><i data-feather="refresh-cw"></i><span class="me-3">&nbsp; Refresh</span></a></li>
@endslot
@endcomponent
<div class="row">
    <div class="col-12">
    <div class="table-responsive">
        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Subjek</th>
                    <th>URL</th>
                    <th>Method</th>
                    <th>IP</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        var dt;
        var API_URL = "{{ url('/log/api') }}";

        $(document).ready(function() {
            dt = $("#datatable").DataTable({
                ajax: {
                    url: API_URL,
                    type: "GET"
                },
                processing: true,
                serverSide: true,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'user', name: 'user'},
                    {data: 'subject', name: 'subject'},
                    {data: 'url', name: 'url'},
                    {data: 'method', name: 'method'},
                    {data: 'ip', name: 'ip'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $("[data-refresh-btn]").click(function(e) {
                e.preventDefault();
                
                toastAlert("info", "Update data");
                dt.ajax.reload();
            })
        })
    </script>
    @endpush

@endsection
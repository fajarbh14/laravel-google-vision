@extends('layouts.admin.master')
@section('title','Ingredient')
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
<h4 class="mb-sm-0 font-size-18">Ingredient</h4>
@endslot
<li class="breadcrumb-item">Ingredient</li>
@slot('action')
    <li><a class="btn btn-primary btn-sm" href="#" onclick="openForm('{{ url('/ingredient/create') }}', 'create')"><i data-feather="plus"></i><span class="me-3"> Create</span></a></li>
    &nbsp;
    <li><a class="btn btn-success btn-sm" href="#" data-refresh-btn><i data-feather="refresh-cw"></i><span class="me-3">&nbsp; Refresh</span></a></li>
@endslot
@endcomponent
<div class="row">
    <div class="col-12">
        <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


@push('scripts')
<!-- Required datatable js -->
<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script>
        var dt;
        var API_URL = "{{ url('/ingredient/api') }}";

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
                    {data: 'name', name: 'name'},
                    {data: 'type', name: 'type'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });

            $("[data-refresh-btn]").click(function(e) {
                e.preventDefault();
                toastAlert("info", "Update data");
                dt.ajax.reload();
            })

            $(document).on("submit", "#create-form", function() {
                $.ajax({
                    url: "{{ url('/ingredient/store') }}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("button").attr("disabled", true);
                    },
                    success: function(response) {
                        $("button").attr("disabled", false);
                        if (response.status_code == 500) return toastAlert("error", response.message);
                        if (response.status_code == 400) return populateErrorMessage(response.errors);

                        toastAlert("success", response.message);
                        $("#create-form").trigger("reset");
                        dt.ajax.reload();
                        formModal.hide();
                    },
                    error: function(reject) {
                        $("button").attr("disabled", false);
                        toastAlert("error", "An error occurred on the server");
                        formModal.hide();
                    }
                })
            })

            $(document).on("submit", "#edit-form", function() {
                $.ajax({
                    url: $(this).data("target"),
                    type: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("button").attr("disabled", true);
                    },
                    success: function(response) {
                        $("button").attr("disabled", false);
                        if (response.status_code == 500) return toastAlert("error", response.message);
                        if (response.status_code == 400) return populateErrorMessage(response.errors);

                        toastAlert("success", response.message);
                        $("#create-form").trigger("reset");
                        dt.ajax.reload();
                        formModal.hide();
                    },
                    error: function(reject) {
                        $("button").attr("disabled", false);
                        toastAlert("error", "Terjadi kesalahan pada server");
                        formModal.hide();
                    }
                })
            })
        })
    </script>
@endpush
@endsection

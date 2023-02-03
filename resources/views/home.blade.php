@extends('layouts.admin.master')
@section('title', 'Dashboard')
@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h4 class="mb-sm-0 font-size-18">Dashboard</h4>
@endslot
<li class="breadcrumb-item">Dashboard</li>
@endcomponent

@if(Auth::user()->role_id == 2)
    @include("admin.dashboard.user")
@else  
    @include("admin.dashboard.admin")
@endif

@endsection
@section('assets-footer')
<script>

</script>
@endsection

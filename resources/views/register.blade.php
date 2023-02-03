@extends('layouts.auth.master')
@section('title')
 Register Account
@endsection
@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-lg-4 col-lg-5">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100" >
                        <div class="d-flex flex-column h-100" >
                            <div class="auth-content my-auto card" style="padding:20px;box-shadow: 0 1px 6px 0 var(--color-shadow,rgba(49,53,59,0.12));">
                                <div class="text-center">
                                    <h5 class="mb-0">Register Account</h5>
                                    <p class="text-muted mt-2">Register to continue create account</p>
                                </div>
                                <form class="theme-form login-form mb-3" onsubmit="return false;" data-form>
                                {{ csrf_field() }}
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="name" class="form-control" id="name" name="name"
                                            placeholder="Enter Name">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter Email">
                                    </div>
                                    <div class="mb-3">
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <label class="form-label">Password</label>
                                            </div>
                                        </div>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="Enter password"
                                                aria-label="Password" aria-describedby="password-addon" name="password">
                                            <button class="btn btn-light shadow-none ms-0" type="button"
                                                id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Register</button>
                                    </div>
                                </form>
                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Do you have account ? <a href="{{ route('login') }}"
                                            class="text-primary fw-semibold"> Log In </a> </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {
            $("[data-form]").submit(function(e) {
                $.ajax({
                    url: "{{ url('/register') }}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("[data-submit-btn]").attr("disabled", true);
                    },
                    success: function(response) {
                        $("[data-submit-btn]").attr("disabled", false);
                        if(response.status_code == 200) {
                            toastAlert("success", response.message);
                            setTimeout(function() {
                                window.location.replace("{{ url('login')}}");
                            }, 1500);
                        }
                        else {
                            toastAlert("error", response.message);
                        }
                    },
                    error: function(reject) {
                        $("[data-submit-btn]").attr("disabled", false);
                        toastAlert("error", "An error occurred on the server");
                    }
                })    
            })
        });
    </script>
    @endpush

@endsection
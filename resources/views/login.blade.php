@extends('layouts.auth.master')
@section('title')
Login
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
                                    <h5 class="mb-0">Welcome To Recipy !</h5>
                                    <p class="text-muted mt-2">Sign in to continue to Recipy.</p>
                                </div>
                                <form class="theme-form login-form mb-3" onsubmit="return false;" data-form>
                                {{ csrf_field() }}
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
                                    <div class="row mb-4">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember-check">
                                                <label class="form-check-label" for="remember-check">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>
                                </form>
                                <div class="mt-5 text-center">
                                    <p class="text-muted mb-0">Don't have an account ? <a href="{{ route('register') }}"
                                            class="text-primary fw-semibold"> Signup now </a> </p>
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
                    url: "{{ url('/login') }}",
                    type: "POST",
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        toastAlert("info", "Try To Login");
                        $("[data-submit-btn]").attr("disabled", true);
                    },
                    success: function(response) {
                        $("[data-submit-btn]").attr("disabled", false);
                        if (response.status_code == 500) return toastAlert("error", response.message);
                        
                        toastAlert("success", response.message);
                        setTimeout(function() {
                            window.location.replace(response.redirect_to);
                        }, 1500);
                    },
                    error: function(reject) {
                        $("[data-submit-btn]").attr("disabled", false);
                        toastAlert("error", "An error occurred on the server");
                    }
                })    
            })

            $("#show-hide").click(function() {
                var passwordEl  = $("[name='password']");
                var stateEl     = $("[data-state]");

                if (passwordEl.attr("type") == "password") {
                    passwordEl.attr("type", "text");
                    stateEl.attr("data-state", "hide");
                } else {
                    passwordEl.attr("type", "password");
                    stateEl.attr("data-state", "show");
                }
            });
        });
    </script>
    @endpush

@endsection
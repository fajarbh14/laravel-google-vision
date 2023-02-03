<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <!-- core css -->
    @includeIf('layouts.admin.partials.css')
</head>
<body>
    <div id="layout-wrapper">
        <header id="page-topbar">
                @includeIf('layouts.admin.partials.header')
        </header>
        <div class="vertical-menu">
            <div class="h-100">
                @includeIf('layouts.admin.partials.sidebar')
            </div>
        </div>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>document.write(new Date().getFullYear())</script> © Recipy.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Develop by <a href="https://www.instagram.com/rubahsakti_/" class="text-decoration-underline">Rubahsakti</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="modal" tabindex="-1" data-form-modal>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" data-modal-title></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body" data-modal-body></div>
        </div>
      </div>
    </div>
</body>
</html>
@includeIf('layouts.admin.partials.js')          
<script>
        feather.replace()
</script>
<script>
    var formModal;

        document.querySelector("[data-form-modal]").addEventListener("hidden.bs.modal", function() {
        document.querySelector("[data-modal-title]").innerText = "";
        document.querySelector("[data-modal-body]").innerHTML = "";
        });

        $(document).on("submit", "form", function () {
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").remove();
        });

        function populateErrorMessage(errors) {
            var ObjToArray = Object.entries(errors);
            ObjToArray.forEach((value) => {
                var input = $(`[name='${value[0]}']`);
                var feedback = `<div class='invalid-feedback'>${value[1][0]}</div>`;

                
            if (input.length > 1) {
                $(`[data-input='${value[0]}']`).append(`<p class='d-block invalid-feedback text-danger' style='margin-top: 0.25rem; font-size: 0.875em'>${value[1][0]}</p>`);
                } else {
                input.addClass("is-invalid");
                input.after(feedback);
                }
            });
        }

        function openForm(url, type = "create") {
        var title = {
          create: "Tambah Data",
          edit: "Edit Data",
          detail: "Detail Data",
        };

        var modalTitle  = title[type] ? title[type] : "";

        $.ajax({
          url: url,
          type: "GET",
          success: function(response) {
            $("[data-modal-title]").text(modalTitle);
            $("[data-modal-body]").html(response);
            formModal = new bootstrap.Modal(document.querySelector("[data-form-modal]"), {});
            formModal.show();
          },
          error: function(reject) {
            toastAlert("error", "An error occurred on the server");
            console.log(reject)
          }
        })
      }

      function deleteAlert(url) {
        Swal.fire({
          title: 'Are you sure you want to delete data?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete',
          cancelButtonText: 'Cancel'
        }).then(function(result) {
          if (!result.isConfirmed) return;
          $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                if (response.status_code == 500) return toastAlert("error", response.message);

                toastAlert("success", response.message);
                dt.ajax.reload();
            },
            error: function(reject) {
                toastAlert("error", "An error occurred on the server");
            }
          })
        })
      }
</script>
<script>
function logout() {
    $.ajax({
        url: "{{ url('logout') }}",
        type: "GET",
        beforeSend: function() {
        toastAlert("info", "Try Logout");
        },
        success: function() {
        window.location.replace("{{ url('login') }}");
        },
        error: function(reject) {
        console.log(reject);
        }
    })
    }
</script>

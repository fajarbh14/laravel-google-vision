@extends('layouts.admin.master')
@section('title','Favorite Recipe')
@push('css')
<style>
    .costum-card-list {
        border: 0px;
        width: 370px;
        margin-top: 10px;
    }

    .costum-card-list span {
        color: black;
        font-family: montserrat-bold;
        white-space: normal;
        font-size: 15px;
        line-height: 20px;
        font-weight: bold;
    }

    .costum-card-list p {
        font-family: montserrat-semi;
        font-size: 12px;
        line-height: 24px;
        color: #666;

    }

    .costum-card-list .info {
        margin-bottom: 4px;
    }

    .costum-card-list .author {
        font-size: 11px;
        margin-right: 7px;
        color: #999;
        text-transform: uppercase;
    }

    .costum-card-img {
        width: 330px;
        margin: 10px 18px 0px;
    }

    .rounded {
        border-radius: 20px !important;
    }

</style>
@endpush
@section('content')
@component('components.breadcrumb')
@slot('breadcrumb_title')
<h4 class="mb-sm-0 font-size-18">Favorite Recipe</h4>
@endslot
<li class="breadcrumb-item">Favorite Recipe</li>
@endcomponent
<div class="row">
    <div class="col-12 mt-3">
        <form id="remove-favorite" onsubmit="return false;">
            {{ csrf_field() }}
            <div class="row" id="recipeList">
                @foreach($recipes as $row)
                  <div class="costum-card-list">
                      <a href="{{$row->url}}" target="_blank"><img class="costum-card-img" src="{{$row->image}}"></a>
                      <div class="card-body">
                          <a href="{{$row->url}}" target="_blank"><h5>{{$row->name}}</h5></a>
                          <div class="info">
                              <button onclick="removeFavorite('{{url("/favorite-recipe/delete/".$row->id)}}')" class="btn btn-sm btn-danger">Remove Favorite</button>
                          </div>
                      </div>
                  </div>
                @endforeach
            </div>
    </div>
    </form>
</div>
</div>
@push('scripts')
<script>
function removeFavorite(url) {
        Swal.fire({
          title: 'Are you sure you want to Remove Recipe?',
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
                location.reload();
            },
            error: function(reject) {
                toastAlert("error", "An error occurred on the server");
            }
          })
        })
      }
</script>
@endpush
@endsection

@extends('layouts.admin.master')
@section('title','Recipe')
@push('css')
<style>
.costum-card-list{
  border:0px;
  width: 370px;
  margin-top: 10px;
}

.costum-card-list span{
  color:black;
  font-family: montserrat-bold;
  white-space: normal;
  font-size: 15px;
  line-height:20px;
  font-weight: bold;
}

.costum-card-list p{
  font-family: montserrat-semi;
  font-size: 12px;
  line-height: 24px;
  color: #666;

}

.costum-card-list .info{
  margin-bottom: 4px;
}

.costum-card-list .author{
  font-size: 11px;
  margin-right: 7px;
  color: #999;
  text-transform: uppercase;
}

.costum-card-img{
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
<h4 class="mb-sm-0 font-size-18">Search Recipe</h4>
@endslot
<li class="breadcrumb-item">Search Recipe</li>
@endcomponent
<div class="row">
    <div class="col-12">
        <form method="post" id="recipe-form" onsubmit="return false;" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="mb-3">
                <label for="">Find By</label>
                <select name="findby" id="findby" class="form-control">
                    <option value="image">Image</option>
                    <option value="ingredient">Ingredient</option>
                </select>
            </div>
            <div class="form-group mb-3" id="ingredientImage" style="display:none">
                <label>Select Image:</label>
                <input type="file" name="ingredientImage" class="form-control">
            </div>
            <div class="form-group mb-3" id="ingredientOption" style="display:none">
                <label>Select Ingredient</label>
                <select name="ingredient" class="form-select">
                @foreach(\App\Models\Ingredient::get() as $row)
                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                @endforeach
                </select>
            </div>
            <button type="submit" style="display:none" id="button" class="btn btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12 mt-3">
            <div class="row" id="recipeList">
            </div>
    </div>
</div>

@push('scripts')
<script>
    $('#findby').change(function(){
        if ($(this).val() == "image") {
            $("#ingredientImage").show()
            $("#button").show()
            $("#ingredientOption").hide()
        }else if($(this).val() == "ingredient") {
            $("#ingredientOption").show()
            $("#button").show()
            $("#ingredientImage").hide()
        }
    });

    $(document).on("submit", "#recipe-form", function() {
        $.ajax({
            url: "{{ url('/recipe/searchRecipe') }}",
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
                if (response.status_code == 400) return toastAlert("error",response.errors[0]);
                toastAlert("success", response.message);
                let recipesLi ='';
                response.data.forEach(row => $('#recipeList').html(recipesLi  += `<div class="costum-card-list">
                <a href="https://spoonacular.com/${string_to_slug(row.title)}-${row.id}" target="_blank"><img class="costum-card-img" src="${row.image}" ></a>
						<div class="card-body">
							<a href="https://spoonacular.com/${string_to_slug(row.title)}-${row.id}" target="_blank"><h5>${row.title}</h5></a>
                                <div class="info">
                                    <button type="button" class="btn btn-sm btn-danger" onClick="addToFavourites('{{ '${row.id}' }}','{{ '${row.image}' }}','{{ 'https://spoonacular.com/${string_to_slug(row.title)}-${row.id}' }}','{{ '${remove_special_character(row.title)}' }}')">Add To Favorites</button>
                                </div>
						</div>
					</div>
				</div>`));
            },
            error: function(reject) {
                $("button").attr("disabled", false);
                toastAlert("error", "An error occurred on the server");
            }
        })
    })

    function string_to_slug (str) {
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();
    
        // remove accents, swap ñ for n, etc
        var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
        var to   = "aaaaeeeeiiiioooouuuunc------";
        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes

        return str;
    }

    function remove_special_character (str) {
        str = str.replace(/[^\w\s]/gi, '');
        return str;
    }

    function addToFavourites(recipe_id,image,url,name) {
        var recipe_id = recipe_id;
        var image = image;
        var url = url;
        var name = name;
        console.log(name)
        $.ajax({
            url: "{{ url('/recipe/favoriteRecipe') }}",
            type: "POST",
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { "recipe_id": recipe_id, "image": image, "url": url, "name": name},
            dataType: "json",
            beforeSend: function() {
                $("button").attr("disabled", true);
            },
            success: function(response) {
                $("button").attr("disabled", false);
                if (response.status_code == 500) return toastAlert("error", response.message);
                if (response.status_code == 400) return toastAlert("info",response.errors);
                toastAlert("success", response.message);
            },
            error: function(reject) {
                $("button").attr("disabled", false);
                toastAlert("error", "An error occurred on the server");
            }
        })
    }

</script>
@endpush
@endsection
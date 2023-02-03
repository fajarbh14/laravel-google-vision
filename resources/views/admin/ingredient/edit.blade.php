<form id="edit-form" onsubmit="return false;" data-target="{{ url('ingredient/update/'.$data->id) }}">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="name">Name</label>
        <input class="form-control" id="name" name="name" type="text" value="{{ $data->name }}" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="type">Type</label>
        <select class="form-control" id="type" name="type">
        @foreach(\App\Models\Enumeration::where('key','Ingredient')->get() as $row)
            <option value="{{ $row->name }}">{{ $row->name }}</option>
        @endforeach
        </select>
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Update</button>
    </div>
</form>
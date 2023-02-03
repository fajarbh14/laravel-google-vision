<form class="theme-form" id="edit-form" onsubmit="return false;" data-target="{{ url('enumeration/update/'.$data->id) }}">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="key">Key</label>
        <input class="form-control" id="key" name="key" type="text" value="{{ $data->key }}" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="name">Name</label>
        <input class="form-control" id="name" name="name" type="text" value="{{ $data->name }}" required />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Update</button>
    </div>
</form>
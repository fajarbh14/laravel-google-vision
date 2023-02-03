<form id="create-form" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0" for="key">Key</label>
        <input class="form-control" id="key" name="key" type="text" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0" for="name">Name</label>
        <input class="form-control" id="name" name="name" type="text" required />
    </div>
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Save</button>
    </div>
</form>
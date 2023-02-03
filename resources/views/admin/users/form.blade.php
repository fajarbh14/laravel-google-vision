<form id="{{$data == null ? "create-form" : "edit-form"}}" data-target="{{$data == null ? "" : url('users/update/'.$data->id)}}" onsubmit="return false;">
    {{ csrf_field() }}
    <div class="mb-3">
        <label class="form-label pt-0">Nama</label>
        <input class="form-control" id="name" name="name" value="{{ $data == null ? "" : $data->name}}" type="text" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Email</label>
        <input class="form-control" id="email" name="email" value="{{ $data == null ? "" : $data->email}}" type="email" required />
    </div>
    <div class="mb-3">
        <label class="form-label pt-0">Password</label>
        <div class="input-group">
            <input class="form-control" id="password" name="password" type="password"{{ $data == null ? "required" : ""}} />
            <div id="show-hide"><span data-state="show"></span></div>
        </div>
    </div>
    @if(Auth::user()->role_id == 1)
    <div class="mb-3">
        <label class="form-label pt-0">Role</label>
        <select name="role_id" id="role_id" class="form-select" required>
            <option value="2">User</option>
            <option value="1" {{$data != null ? $data->role_id == 1 ? "selected" : "" : ""}}>Superadmin</option>
        </select>
    </div> 
    @endif   
    <div class="d-flex flex-row-reverse">
        <button class="btn btn-primary" type="submit">Send</button>
    </div>
</form>
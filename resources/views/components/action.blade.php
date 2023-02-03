@if ($edit)
    <a href="#" onclick="openForm('{{ $edit }}', 'edit')" class="btn btn-xs btn-primary" ><i class="fa fa-pen"></i></a>
@endif

@if ($delete)
    <a href="#" onclick="deleteAlert('{{ $delete }}')" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
@endif
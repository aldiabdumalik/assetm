<div class="btn-group">
    <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border-color: rgb(240, 240, 240);">
        <i class="fa fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu" style="font-size: 10px !important">
        <a class="dropdown-item edit-model" href="javascript:void(0)" data-href="{{ route('item.edit.model', [$id]) }}">Edit Tipe</a>
        <a class="dropdown-item edit-brand" href="javascript:void(0)" data-href="{{ route('item.edit.brand', [$brand_id]) }}">Edit Merk</a>
        <a class="dropdown-item edit-type" href="javascript:void(0)" data-href="{{ route('item.edit.type', [$type_id]) }}">Edit Jenis</a>
        <a class="dropdown-item delete-model" href="javascript:void(0)" data-href="{{ route('item.delete.model', [$id]) }}">Delete Tipe</a>
        <a class="dropdown-item delete-brand" href="javascript:void(0)" data-href="{{ route('item.delete.brand', [$brand_id]) }}">Delete Merk</a>
        <a class="dropdown-item delete-type" href="javascript:void(0)" data-href="{{ route('item.delete.type', [$type_id]) }}">Delete Jenis</a>
    </div>
</div>
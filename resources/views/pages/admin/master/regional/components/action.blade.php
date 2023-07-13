<div class="btn-group dropright">
    <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border-color: rgb(240, 240, 240);">
        <i class="fa fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item edit-regional" href="javascript:void(0)" data-href="{{ route('regional.edit', [$regional_id]) }}">Edit Regional</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item edit-wilayah" href="javascript:void(0)" data-href="{{ route('regional.edit.wilayah', [$id]) }}">Edit Wilayah</a>
        {{-- <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="javascript:void(0)" data-href="{{ route('arrival.edit', [$id]) }}">Delete Wilayah</a> --}}
        {{-- <div class="dropdown-divider"></div> --}}
    </div>
</div>
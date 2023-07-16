<div class="btn-group dropright">
    <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border-color: rgb(240, 240, 240);">
        <i class="fa fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item scan-item" href="{{ route('packing.scan', [$id]) }}" data-href="{{ route('packing.scan', [$id]) }}">
            {{ $status == 2 ? 'Lihat' : 'Scan Barcode' }}
        </a>
        @if ($status == 0)
        <div class="dropdown-divider"></div>
        <a class="dropdown-item edit-item" href="javascript:void(0)" data-href="{{ route('packing.edit', [$id]) }}">Edit</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item delete-item" href="javascript:void(0)" data-href="{{ route('packing.delete', [$id]) }}">Delete</a>
            
        @endif
    </div>
</div>
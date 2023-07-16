<div class="btn-group dropright">
    <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border-color: rgb(240, 240, 240);">
        <i class="fa fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('scanning.view', [$id]) }}" data-href="{{ route('scanning.view', [$id]) }}">View</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item edit-item" href="javascript:void(0)" data-href="{{ route('arrival.edit', [$id]) }}">Edit</a>
        {{-- <div class="dropdown-divider"></div> --}}
        {{-- <a class="dropdown-item" href="javascript:void(0)" data-href="{{ route('arrival.edit', [$id]) }}">Upload</a> --}}
        {{-- <div class="dropdown-divider"></div> --}}
    </div>
</div>
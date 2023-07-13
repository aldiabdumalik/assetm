<div class="btn-group dropright">
    <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: transparent;border-color: rgb(240, 240, 240);">
        <i class="fa fa-ellipsis-v"></i>
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item edit-user" href="javascript:void(0)" data-href="{{ route('user.edit', [$id]) }}">Edit</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item set-user" href="javascript:void(0)" data-href="{{ route('user.setpassword', [$id]) }}">Set Password</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item delete-user" href="javascript:void(0)" data-href="{{ route('user.delete', [$id]) }}">Delete</a>
    </div>
</div>
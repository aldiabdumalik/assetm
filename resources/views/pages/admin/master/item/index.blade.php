@extends('layouts.admin')
@section('title', 'Master Item')
@section('content')
<div class="mb-3">
    <div class="btn-group mb-2">
        <button type="button" class="btn btn-custom">Input Data</button>
        <button type="button" class="btn btn-custom dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(84px, 35px, 0px);">
            <a id="input_type" class="dropdown-item" href="javascript:void(0)">Jenis</a>
            <div class="dropdown-divider"></div>
            <a id="input_brand" class="dropdown-item" href="javascript:void(0)">Merk</a>
            <div class="dropdown-divider"></div>
            <a id="input_model" class="dropdown-item" href="javascript:void(0)">Tipe</a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card-box">
            <div class="table-rep-plugin">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="item_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tipe</th>
                                <th>Merk</th>
                                <th>Jenis</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/master_item.js')}}"></script>
@endpush
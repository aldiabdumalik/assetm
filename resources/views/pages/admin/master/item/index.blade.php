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
<div id="modal-type" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-type-title">Tambah Data</h4>
        </div>
        <div class="modal-body">
          <form id="form-type" action="{{route('item.add.type')}}">
            <div class="form-row align-items-center">
              <div id="type_name" class="col-12 mb-2">
                  <label for="tname">Nama Jenis</label>
                  <input type="text" name="tname" id="tname" class="form-control" autocomplete="off" required>
              </div>
              <div class="col-12 mb-2">
                <button type="submit" id="submit-type" class="btn btn-custom btn-block">Tambah</button>
              </div>
            </div>
  
          </form>
        </div>
      </div>
    </div>
</div>

<div id="modal-brand" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-brand-title">Tambah Data</h4>
        </div>
        <div class="modal-body">
          <form id="form-brand" action="{{route('item.add.brand')}}">
            <div class="form-row align-items-center">
                <div class="col-12 mb-2">
                    <label for="bjenis">Jenis</label>
                    <select name="bjenis" id="bjenis" class="form-control" required></select>
                </div>
                <div class="col-12 mb-2">
                    <label for="bname">Merk Name</label>
                    <input type="text" name="bname" id="bname" class="form-control" autocomplete="off" required>
                </div>
                <div class="col-12 mb-2">
                    <button type="submit" id="submit-brand" class="btn btn-custom btn-block">Tambah</button>
                </div>
            </div>
  
          </form>
        </div>
      </div>
    </div>
</div>

<div id="modal-model" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-model-title">Tambah Data</h4>
        </div>
        <div class="modal-body">
          <form id="form-model" action="{{route('item.add.model')}}">
            <div class="form-row align-items-center">
                <div class="col-12 mb-2">
                    <label for="mjenis">Jenis</label>
                    <select name="mjenis" id="mjenis" class="form-control" required></select>
                </div>
                <div class="col-12 mb-2">
                    <label for="mbrand">Merk</label>
                    <select name="mbrand" id="mbrand" class="form-control" required></select>
                </div>
                <div class="col-12 mb-2">
                    <label for="mname">Tipe Name</label>
                    <input type="text" name="mname" id="mname" class="form-control" autocomplete="off" required>
                </div>
                <div class="col-12 mb-2">
                    <button type="submit" id="submit-model" class="btn btn-custom btn-block">Tambah</button>
                </div>
            </div>
  
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/master_item.js')}}"></script>
@endpush
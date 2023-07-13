@extends('layouts.admin')
@section('title', 'Master')
@section('content')
<div class="mb-3">
    <div class="btn-group mb-2">
        <button type="button" class="btn btn-custom">Input Data</button>
        <button type="button" class="btn btn-custom dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(84px, 35px, 0px);">
            <a id="input_regional" class="dropdown-item" href="javascript:void(0)">Regional</a>
            <div class="dropdown-divider"></div>
            <a id="input_wilayah" class="dropdown-item" href="javascript:void(0)">Wilayah</a>
        </div>
    </div>
</div>
<div class="row">
  <div class="col-12 col-md-12">
    <div class="card-box">
      <div class="table-rep-plugin">
        <div class="table-responsive" data-pattern="priority-columns">
          <table id="regional_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
            <thead>
              <tr>
                <th class="text-center">Regional</th>
                <th class="text-center">NO.</th>
                <th class="text-center">WILAYAH</th>
                <th class="text-center">ACTION</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-regional" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="modal-regioanal-title">Tambah Data</h4>
      </div>
      <div class="modal-body">
        <form id="form-regional" action="{{route('regional.add')}}">
          <div class="form-row align-items-center">
            <div id="regional_name" class="col-12 mb-2">
                <label for="regname">Nama Regional</label>
                <input type="text" name="regname" id="regname" class="form-control" autocomplete="off" required>
            </div>
            <div class="col-12 mb-2">
              <button type="submit" id="submit" class="btn btn-custom btn-block">Tambah</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<div id="modal-wilayah" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="modal-wilayah-title">Tambah Data</h4>
      </div>
      <div class="modal-body">
        <form id="form-wilayah" action="{{route('regional.add.wilayah')}}">
          <div class="form-row align-items-center">
              <div id="regional_id" class="col-12 mb-2">
                  <label for="regional">Regional</label>
                  <select name="regional" id="regional" class="form-control" required></select>
              </div>
              <div id="branch_name" class="col-12 mb-2">
                  <label for="branchname">Nama Wilayah</label>
                  <input type="text" name="branchname" id="branchname" class="form-control" autocomplete="off" required>
              </div>
              <div class="col-12 mb-2">
                  <button type="submit" id="submit2" class="btn btn-custom btn-block">Tambah</button>
              </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/master_regional.js')}}"></script>
@endpush
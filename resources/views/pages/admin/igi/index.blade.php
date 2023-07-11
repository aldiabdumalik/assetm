@extends('layouts.admin')
@section('title', 'Monitoring')
@section('content')
<div class="mb-3">
  <button type="button" id="add-item" class="btn btn-custom ">Input Baru</button>
</div>
<div class="row">
  <div class="col-12 col-md-12">
    <div class="card-box">
      <p class="text-center" style="font-size:12px;"><i>Double click on raw to view detail</i></p>
      <div class="table-rep-plugin">
        <div class="table-responsive" data-pattern="priority-columns">
          <table id="arrival_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
            <thead>
              <tr>
                <th class="text-center">Regional</th>
                <th class="text-center">TGL.DATANG</th>
                <th class="text-center">Surat Jalan</th>
                <th class="text-center">TOTAL BAPB</th>
                <th class="text-center">TOTAL SCAN</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="modal-igi" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="myLargeModalLabel">Tambah Data Kedatangan</h4>
      </div>
      <div class="modal-body">
        <form id="form-igi" action="javascript:void(0)">
          <div class="form-row align-items-center">
            <div id="arrival_date" class="col-12 mb-2">
                <label for="tgl">Tgl. Datang</label>
                <input type="text" name="tgl" id="tgl" class="form-control this_datepicker" autocomplete="off" value="{{ date('d/m/Y') }}">
                {{-- <span class="text-danger font-italic">harus diisi</span> --}}
              </div>
            <div id="f_po" class="col-12 mb-2">
              <label for="po">No. PO</label>
              <input type="text" name="po" id="po" class="form-control" autocomplete="off">
            </div>
            <div class="col-12 mb-2 mt-2">
              <h6 class="card-header">Dikirim oleh:</h6>
            </div>
            <div id="regional_desc" class="col-12 mb-2">
              <label for="regional">Regional</label>
              <select name="regional" id="regional" class="form-control"></select>
            </div>
            <div id="branch_id" class="col-12 mb-2">
              <label for="branch">Wilayah</label>
              <select name="branch" id="branch" class="form-control"></select>
            </div>
            <div id="delivery_pic" class="col-12 mb-2">
              <label for="dpic">Nama PIC</label>
              <input type="text" name="dpic" id="dpic" class="form-control" autocomplete="off">
            </div>
            <div class="col-12 mb-2 mt-2">
              <h6 class="card-header">Diterima oleh:</h6>
            </div>
            <div id="user_pic" class="col-12 mb-2">
              <label for="pic">Nama PIC</label>
              <input type="text" name="pic" id="pic" class="form-control" autocomplete="off" value="{{auth()->user()->name}}">
            </div>
            <div id="arrival_total" class="col-12 mb-2">
              <label for="total">Jumlah</label>
              <input type="number" name="total" id="total" class="form-control" autocomplete="off">
            </div>
            <div id="arrival_note" class="col-12 mb-2">
              <label for="note">Keterangan <span class="">(optional)</span></label>
              <textarea name="note" id="note" class="form-control" autocomplete="off"></textarea>
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
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/arrival.js')}}"></script>
@endpush
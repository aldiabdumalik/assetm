@extends('layouts.admin')
@section('title', 'Pengiriman')
@section('content')
<div class="mb-3">
    <button type="button" id="btn-add" class="btn btn-custom">Buat Pengiriman</button>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
        {{-- <p class="text-center font-italic" style="font-size:12px;">Double click on raw regional to view detail</p> --}}
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="pengiriman_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                            <th class="text-center">TUJUAN</th>
                            <th class="text-center">JUMLAH</th>
                            <th class="text-center">AWB / NO. RESI</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">ACTION</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="modal-pengiriman" data-backdrop="static" data-keyboard="false" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-pengiriman-title">Buat Pengiriman</h4>
        </div>
        <div class="modal-body">
          <form id="form-pengiriman" action="{{route('pengiriman.add')}}">
            <div class="form-row align-items-center">
              
              <div class="col-12 mb-2">
                <label for="tujuan">Tujuan</label>
                <div class="row no-gutters">
                  <div class="col-3">
                    <select name="type_tujuan" id="type_tujuan" class="form-control" required>
                      <option value="RC">RC</option>
                      <option value="WHOS">WHOS</option>
                    </select>
                  </div>
                  <div class="col-9">
                    <select name="tujuan" id="tujuan" class="form-control" required></select>
                  </div>
                </div>
              </div>
              <div id="" class="col-12 mb-2">
                <label for="resi">No. Resi / AWB</label>
                <input type="text" name="resi" id="resi" class="form-control" autocomplete="off" required>
              </div>
              <div id="" class="col-12 mb-2">
                <label for="estimasi">Estimasi Tgl Tiba</label>
                <input type="text" name="estimasi" id="estimasi" class="form-control this_datepicker" autocomplete="off" value="{{ date('d/m/Y') }}" required>
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
    <script type="module" src="{{asset('custom/js/pengiriman.js')}}"></script>
@endpush
@extends('layouts.admin')
@section('title', 'Koreksi Barcode')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form id="form-scan" action="{{ route('revisi.detail')}}">
                <div class="form-group row">
                    <label class="col-2 col-form-label">Barcode</label>
                    <div class="col-4">
                        <input type="text" name="barcode_scan" id="barcode_scan" class="form-control" autocomplete="off">
                    </div>
                </div>
            </form>
            <form id="form-update" action="{{ route('revisi.update')}}" hidden>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Barcode</label>
                    <div class="col-4">
                        <input type="text" name="barcode" id="barcode" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Jenis / Merk / Tipe</label>
                    <div class="col-2" id="type_id">
                        <select name="jenis" id="jenis" class="form-control"></select>
                    </div>
                    <div class="col-2" id="brand_id">
                        <select name="merk" id="merk" class="form-control"></select>
                    </div>
                    <div class="col-2" id="model_id">
                        <select name="tipe" id="tipe" class="form-control"></select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" id="btn-update" class="btn btn-block btn-custom">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-8">
                    <h3>Riwayat Aktivitas</h3>
                    <div class="table-rep-plugin mt-5">
                        <div class="table-responsive" data-pattern="priority-columns">
                          <table id="scan_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                            <thead>
                              <tr>
                                <th class="text-center">Aktivitas</th>
                                <th class="text-center">TGL</th>
                                <th class="text-center">Username</th>
                              </tr>
                            </thead>
                          </table>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <h3>Status Pengiriman</h3>
                    <div class="mt-5 text-center" id="text-status"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/koreksi.js')}}"></script>
@endpush
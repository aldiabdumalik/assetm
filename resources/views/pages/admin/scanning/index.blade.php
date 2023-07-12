@extends('layouts.admin')
@section('title', 'AMS INCOMING GOODS INSPECTION')
@section('content')
<div class="row mb-3">
    <div class="col-4">
        <a href="{{ route('arrival') }}" class="btn btn-custom"><i class="fa fa-arrow-left"></i> Monitoring</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card-box">
            <div class="form-group row">
                <label class="col-2 col-form-label">RC</label>
                <div class="col-4">
                    <input type="text" class="form-control" readonly value="{{ $data->branch->branch_name }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">REGIONAL</label>
                <div class="col-4">
                    <input type="text" class="form-control" readonly value="{{ $data->branch->regional->regional_name }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">WILAYAH</label>
                <div class="col-4">
                    <input type="text" class="form-control" readonly value="{{ $data->branch->branch_name }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 col-form-label">TGL. DATANG</label>
                <div class="col-4">
                    <input type="text" class="form-control" readonly value="{{ date('d/m/Y', strtotime($data->arrival_date)) }}">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card-box">
            <form id="form-scan" action="{{route('scanning.add', [$id])}}">
                <div class="form-group row">
                    <label class="col-2 col-form-label">Box</label>
                    <div class="col-4" id="scan_box">
                        <input type="text" name="box" id="box" class="form-control" autocomplete="off">
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
                    <label class="col-2 col-form-label">Scan Serial Number</label>
                    <div class="col-4" id="scan_sn">
                        <input type="text" name="sn" id="sn" class="form-control" autocomplete="off">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label">Scan MAC Address</label>
                    <div class="col-4" id="scan_mac">
                        <input type="text" name="mac" id="mac" class="form-control" autocomplete="off">
                    </div>
                </div>
            </form>
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table id="scan_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">SCAN TIME</th>
                        <th class="text-center">BARCODE</th>
                        <th class="text-center">MAC / ID</th>
                        <th class="text-center">JENIS</th>
                        <th class="text-center">MERK</th>
                        <th class="text-center">TYPE</th>
                        <th class="text-center">BOX</th>
                        <th class="text-center">ACTION</th>
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
    <script type="module" src="{{asset('custom/js/scanning.js')}}"></script>
@endpush
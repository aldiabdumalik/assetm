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
                    <input type="text" class="form-control" readonly value="{{ $user->branch->branch_name }}">
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
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table id="scanview_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
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
                        <th class="text-center"></th>
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
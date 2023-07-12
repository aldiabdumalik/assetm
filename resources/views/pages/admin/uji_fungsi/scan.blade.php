@extends('layouts.admin')
@section('title', 'AMS UJI FUNGSI')
@section('content')
<div class="row mb-3">
    <div class="col-4">
        <a href="{{ route('testing.update') }}" class="btn btn-custom"><i class="fa fa-arrow-left"></i> Monitoring</a>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form id="form-ujiscan" action="{{route('arrival.add')}}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">RC</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" id="rc" class="form-control" autocomplete="off" readonly value="{{ $branch }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">System Test Result</label>
                            <div class="col-6" id="status">
                                <select name="sts" id="sts" class="form-control">
                                    <option value="1">OK</option>
                                    <option value="0">NOK</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Scan Barcode</label>
                            <div class="col-6" id="barcode">
                                <input type="text" name="sn" id="sn" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Box OK</label>
                            <div class="col-6" id="box_ok">
                                <input type="text" name="bok" id="bok" class="form-control" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Box NOK</label>
                            <div class="col-6" id="box_nok">
                                <input type="text" name="bon" id="bon" class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table id="scan_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                    <thead>
                      <tr>
                        <th class="text-center">UJI FUNGSI TIME</th>
                        <th class="text-center">BARCODE</th>
                        <th class="text-center">JENIS</th>
                        <th class="text-center">MERK</th>
                        <th class="text-center">TYPE</th>
                        <th class="text-center">RESULT</th>
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
    <script type="module" src="{{asset('custom/js/uji_scan.js')}}"></script>
@endpush
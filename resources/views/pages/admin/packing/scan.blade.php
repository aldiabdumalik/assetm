@extends('layouts.admin')
@section('title', 'Packing List Items')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form id="form-ujiscan" action="{{route('arrival.add')}}">
                <div class="row no-gutters">
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">RC</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$data->branch->branch_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Regional</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$data->branch->regional->regional_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">No. Box</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$data->pl_code}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Scan Barcode</label>
                            <div class="col-6" id="barcode">
                                <input type="text" name="sbarcode" id="sbarcode" class="form-control" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Jenis Barang</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$data->pl_type}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Jumlah Item</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="scan_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                            <th class="text-center">Barcode</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Merk</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Scan Time</th>
                            <th class="text-center">Scan By</th>
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
    <script type="module" src="{{asset('custom/js/packing.js')}}"></script>
@endpush
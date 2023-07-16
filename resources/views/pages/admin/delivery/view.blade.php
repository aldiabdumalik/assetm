@extends('layouts.admin')
@section('title', 'Kirim Packing List')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <form id="form-kirim" action="javascript:void(0)">
                <div class="row no-gutters">
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">RC</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$user_branch}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Regional</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$user_regional}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">No. Pengiriman</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{$data->delivery_no}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Jumlah Item</label>
                            <div class="col-6" id="">
                                <input type="text" name="jmlh" class="form-control" autocomplete="off" readonly value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row">
                            <label class="col-4 col-form-label">Tujuan</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{ $data->branchDelivery->branch_type }} {{ $data->branchDelivery->branch_name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">No. Resi / AWB</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{ $data->delivery_resi }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 col-form-label">TGL. Estimasi</label>
                            <div class="col-6" id="">
                                <input type="text" name="rc" class="form-control" autocomplete="off" readonly value="{{ date('d/m/Y', strtotime($data->estimasi)) }}">
                            </div>
                        </div>
                        @if ($data->status == 0)
                        <div class="row">
                            <div class="col-12">
                                <button type="button" id="btn-kirim" class="btn btn-custom btn-block">Proses Kirim</button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    @if ($data->status == 0)
    <div class="col-6">
        <div class="card-box">
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="belum_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                            <th class="text-center">Packing List</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @endif
    <div class="{{ $data->status == 0 ? 'col-6' : 'col-12' }}">
        <div class="card-box">
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="sudah_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                            <th class="text-center">Packing List</th>
                            <th class="text-center">Jenis</th>
                            <th class="text-center">Jumlah</th>
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
    <script type="module" src="{{asset('custom/js/pengiriman_add.js')}}"></script>
@endpush
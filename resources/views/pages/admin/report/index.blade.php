@extends('layouts.admin')
@section('title', 'Download Report')
@section('content')
<div class="row">
    <div class="col-6">
        <div class="card-box">
            <div class="form-row align-items-center"> 
                <div id="" class="col-12 mb-2">
                    <label for="rc">RC</label>
                    <input type="text" name="rc" id="rc" class="form-control" readonly value="{{$user->branch->branch_name}}">
                </div>
                <div id="" class="col-12 mb-2">
                    <label for="start">TGL. AWAL</label>
                    <input type="text" name="start" id="start" class="form-control this_datepicker">
                </div>
                <div id="" class="col-12 mb-2">
                    <label for="end">TGL. AKHIR</label>
                    <input type="text" name="end" id="end" class="form-control this_datepicker">
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-box">
            <div class="form-row align-items-center"> 
                <div id="" class="col-12 mb-3">
                    <button type="button" data-download="igi" class="btn btn-block btn-download btn-warning">Download Data I.G.I</button>
                </div>
                <div id="" class="col-12 mb-3">
                    <button type="button" data-download="uji_fungsi" class="btn btn-block btn-download btn-info">Download Data Uji Fungsi</button>
                </div>
                <div id="" class="col-12 mb-3">
                    <button type="button" data-download="packing_list" class="btn btn-block btn-download btn-custom">Download Data Packing List</button>
                </div>
                <div id="" class="col-12 mb-3">
                    <button type="button" data-download="pengiriman" class="btn btn-block btn-download btn-success">Download Data Pengiriman</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/reporting.js')}}"></script>
    <script type="module">
        import * as module from './custom/js/module.js';
        $(document).ready(function () {
            @if(Session::has('errorMsg') != '')
                module.send_notif({
                    icon: 'error',
                    message: `{!! Session::get('errorMsg') !!}`
                })
            @endif
        })
    </script>
@endpush
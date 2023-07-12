@extends('layouts.admin')
@section('title', 'Monitoring')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">

            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                  <table id="uji_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                    <thead>
                      <tr>
                        <th class="text-center">REGIONAL</th>
                        <th class="text-center">JENIS</th>
                        <th class="text-center">FUNGSI OK</th>
                        <th class="text-center">FUNGSI NOK</th>
                        <th class="text-center">TOTAL UJI FUNGSI</th>
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
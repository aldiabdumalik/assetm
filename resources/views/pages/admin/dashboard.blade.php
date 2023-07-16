@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card-box widget-flat border-custom bg-custom text-white">
                        <i class="fa fa-briefcase"></i>
                        <h3 class="m-b-10">{{ $total_item }}</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Item</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card-box bg-primary widget-flat border-primary text-white">
                        <i class="fa fa-thumbs-up"></i>
                        <h3 class="m-b-10">{{ $total_ok }}</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Item OK</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card-box widget-flat border-success bg-success text-white">
                        <i class="fa fa-archive"></i>
                        <h3 class="m-b-10">{{ $total_pl }}</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Packing List</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card-box bg-danger widget-flat border-danger text-white">
                        <i class="fa fa-car"></i>
                        <h3 class="m-b-10">{{ $total_pengiriman }}</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Pengiriman</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
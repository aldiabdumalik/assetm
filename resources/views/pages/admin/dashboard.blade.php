@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-6 col-xl-3">
                    <div class="card-box widget-flat border-custom bg-custom text-white">
                        <i class="fi-tag"></i>
                        <h3 class="m-b-10">25563</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Item</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card-box bg-primary widget-flat border-primary text-white">
                        <i class="fi-archive"></i>
                        <h3 class="m-b-10">6952</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Item Scan</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card-box widget-flat border-success bg-success text-white">
                        <i class="fi-help"></i>
                        <h3 class="m-b-10">18361</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Item Packing</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="card-box bg-danger widget-flat border-danger text-white">
                        <i class="fi-delete"></i>
                        <h3 class="m-b-10">250</h3>
                        <p class="text-uppercase m-b-5 font-13 font-600">Total Item Dikirim</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
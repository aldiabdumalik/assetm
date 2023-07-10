@extends('layouts.layout')
@section('page', 'account-pages')
@section('layout')
<div class="accountbg" style="background: url('{{asset('files/img/bg-1s.jpg')}}');background-size: cover;background-position: center;"></div>
<div class="wrapper-page account-page-full">
    <div class="card">
        <div class="card-block">
            <div class="account-box">
                <div class="card-box p-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    <div class="m-t-40 text-center">
        <p class="account-copyright">2022 &copy; updu.tech</p>
    </div>
</div>
@endsection
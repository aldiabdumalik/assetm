@extends('layouts.layout')
@section('layout')
<div id="wrapper">
    @include('layouts.sidebar')
    <div class="content-page">
        @include('layouts.topbar')
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <footer class="footer">
            2022 &copy; updu.tech
        </footer>
    </div>
</div>
@endsection
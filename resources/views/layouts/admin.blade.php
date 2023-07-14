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
            2023 &copy; reza suhendi
        </footer>
    </div>
</div>
@endsection
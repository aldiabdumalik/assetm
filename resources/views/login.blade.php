@extends('layouts.page')
@section('title', 'Login')
@section('content')
<h2 class="text-uppercase text-center pb-4">
    <a href="#" class="text-success">
        <img src="{{asset('files/img/inti.png')}}" width="80" alt="" class="img-responsive">
    </a>
</h2>

<form id="login-form" class="form-horizontal">
    <div class="form-group m-b-20 row">
        <div class="col-12">
            <label for="login-id">Email</label>
            <input type="text" name="login-id" class="form-control" id="login-id" required="" autocomplete="off" placeholder="Masukan Email Anda">
        </div>
    </div>

    <div class="form-group row m-b-20">
        <div class="col-12">
            <a href="#" class="text-muted float-right" data-target="#login-modal" data-toggle="modal"><small>Lupa password?</small></a>
            <label for="login-password">Password</label>
            <input type="password" name="login-password" id="login-password" class="form-control" required="" placeholder="Masukan password Anda">
        </div>
    </div>

    <div class="form-group row text-center m-t-10">
        <div class="col-12">
            <button type="submit" id="login-submit" class="btn btn-block btn-custom waves-effect waves-light" type="button">Masuk</button>
        </div>
    </div>

</form>
@endsection

@push('page-js')
    <script type="module" src="{{asset('custom/js/login.js')}}"></script>
@endpush
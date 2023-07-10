@extends('layouts.admin')
@section('title', 'User')
@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card-box">
                <p class="text-center" style="font-size:12px;"><i>Double click on raw to Update data</i></p>
                <div class="table-rep-plugin">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="user_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIK</th>
                                    <th>Name</th>
                                    <th>Password</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card-box">
                <div class="clearfix">
                    <button type="button" id="delete" class="btn btn-sm btn-danger float-right d-none"><i class="fa fa-trash"></i> Delete</button>
                </div>
                <form action="javasript:void(0)" id="form-user">
                    <div class="form-row align-items-center">
                        <div class="col-12">
                            <label for="nik">NIK</label>
                            <input type="text" name="nik" id="nik" class="form-control mb-2" autocomplete="off" readonly required>
                        </div>
                        <div class="col-12">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control mb-2" autocomplete="off" readonly required>
                        </div>
                        <div class="col-12">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control mb-2" autocomplete="off" required>
                        </div>
                        <div class="col-12">
                            <label for="password2">Ulangi Password</label>
                            <input type="password" name="password2" id="password2" class="form-control mb-2" autocomplete="off" required>
                        </div>
                        <div class="col-12 mb-2">
                            <button type="submit" id="submit" class="btn btn-custom btn-block">Set</button>
                        </div>
                        <div class="col-12">
                            <button type="button" id="cancel" class="btn btn-block">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/users.js')}}"></script>
@endpush
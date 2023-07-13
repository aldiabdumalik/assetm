@extends('layouts.admin')
@section('title', 'Master User')
@section('content')
<div class="mb-3">
    <button type="button" id="add-user" class="btn btn-custom ">Input Baru</button>
</div>
<div class="row">
    <div class="col-12 col-md-12">
        <div class="card-box">
            {{-- <p class="text-center" style="font-size:12px;"><i>Double click on raw to Update data</i></p> --}}
            <div class="table-rep-plugin">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="user_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Regional</th>
                                <th>Wilayah</th>
                                <th>Level</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-user" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-user-title">Tambah Data</h4>
        </div>
        <div class="modal-body">
          <form id="form-user" action="{{route('user.add')}}">
            <div class="form-row align-items-center">
              <div id="name" class="col-12 mb-2">
                  <label for="uname">Nama</label>
                  <input type="text" name="uname" id="uname" class="form-control" autocomplete="off" required>
              </div>
              <div id="username" class="col-12 mb-2">
                <label for="usname">Username</label>
                <input type="text" name="usname" id="usname" class="form-control" autocomplete="off" required>
            </div>
            <div id="email" class="col-12 mb-2">
                <label for="umail">Email</label>
                <input type="text" name="umail" id="umail" class="form-control" autocomplete="off" required>
            </div>
            <div id="regional_id" class="col-12 mb-2">
                <label for="regional">Regional</label>
                <select name="regional" id="regional" class="form-control" autocomplete="off" required></select>
            </div>
            <div id="branch_id" class="col-12 mb-2">
                <label for="branch">Wilayah</label>
                <select name="branch" id="branch" class="form-control" autocomplete="off" required></select>
            </div>
            <div id="level" class="col-12 mb-2">
                <label for="ulevel">Level</label>
                <select name="ulevel" id="ulevel" class="form-control" autocomplete="off" required>
                    <option value="">Pilih Level</option>
                    <option value="1">Admin</option>
                    <option value="2">Staff</option>
                </select>
            </div>
              <div class="col-12 mb-2">
                <button type="submit" id="submit" class="btn btn-custom btn-block">Tambah</button>
              </div>
            </div>
  
          </form>
        </div>
      </div>
    </div>
</div>

<div id="modal-password" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-password-title">Set Password User</h4>
        </div>
        <div class="modal-body">
          <form id="form-password">
            <div class="form-row align-items-center">
                <div class="col-12 mb-2">
                    <label for="pusname">Username</label>
                    <input type="text" name="pusname" id="pusname" class="form-control" autocomplete="off" readonly>
                </div>
                <div class="col-12 mb-2" id="password">
                    <label for="new_pw">Password</label>
                    <input type="password" name="new_pw" id="new_pw" class="form-control" autocomplete="off" required>
                </div>
                <div class="col-12 mb-2" id="re_password">
                    <label for="new_pw2">Ulangi Password</label>
                    <input type="password" name="new_pw2" id="new_pw2" class="form-control" autocomplete="off" required>
                </div>
                <div class="col-12 mb-2">
                    <button type="submit" id="submit2" class="btn btn-custom btn-block">Set Password</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/users.js')}}"></script>
@endpush
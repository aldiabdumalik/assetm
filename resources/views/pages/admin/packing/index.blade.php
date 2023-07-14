@extends('layouts.admin')
@section('title', 'Packing List')
@section('content')
<div class="mb-3">
    <button type="button" id="btn-add" class="btn btn-custom">Tambah Packing List</button>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
        {{-- <p class="text-center font-italic" style="font-size:12px;">Double click on raw regional to view detail</p> --}}
            <div class="table-rep-plugin mt-5">
                <div class="table-responsive" data-pattern="priority-columns">
                    <table id="packing_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                        <thead>
                            <tr>
                            <th class="text-center">PACKING CODE</th>
                            <th class="text-center">JUMLAH</th>
                            <th class="text-center">JENIS</th>
                            <th class="text-center">STATUS</th>
                            <th class="text-center">ACTION</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="modal-packing" data-backdrop="static" data-keyboard="false" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title" id="modal-packing-title">Buat Packing List</h4>
        </div>
        <div class="modal-body">
          <form id="form-packing" action="{{route('packing.add')}}">
            <div class="form-row align-items-center">
              
              <div id="pl_type" class="col-12 mb-2">
                <label for="jenis">Jenis</label>
                <select name="jenis" id="jenis" class="form-control" required>
                    <option value="transfer">Transfer</option>
                    <option value="refurbish">Refurbish</option>
                    <option value="damage">Damage</option>
                    <option value="service_handling">Service Handling</option>
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
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/packing.js')}}"></script>
@endpush
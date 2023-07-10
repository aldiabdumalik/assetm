@extends('layouts.admin')
@section('title', 'Event')
@section('content')
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card-box">
                <p class="text-center" style="font-size:12px;"><i>Double click on raw to Update data</i></p>
                <div class="table-rep-plugin">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="event_table" class="table table-striped dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%; cursor: pointer">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Color</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card-box">
                <ul class="nav nav-tabs tabs-bordered">
                    <li class="nav-item">
                        <a href="#generate-tabs" data-toggle="tab" aria-expanded="false" class="nav-link">
                            <i class="fi-monitor mr-2"></i> Generate
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#create-tabs" data-toggle="tab" aria-expanded="true" class="nav-link active">
                            <i class="fi-head mr-2"></i> Create
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" id="generate-tabs">
                        @include('pages.admin.event.components.tabs-generate')
                    </div>
                    <div class="tab-pane show active" id="create-tabs">
                        @include('pages.admin.event.components.tabs-create')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('page-js')
    <script type="module" src="{{asset('custom/js/event.js')}}"></script>
@endpush
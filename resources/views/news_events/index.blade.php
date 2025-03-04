@extends('layouts.app')

@section('title', 'News and Events')

@section('content')

<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

    <style>
        #name:hover {
            font-weight: bold;
        }
        .custom-input {
            height: 30px;
        }
        .select2-search { display: none; }
        span.select2-selection.select2-selection--single {
            height: 30px !important;
        }

        .input-daterange > input {
            height: 30px;
        }
        .input-daterange > span {
            height: 30px;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">News and Events</a></li>
    </ol>
    <h1 class="page-header">News and Events List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-xs" onclick="location.href='/news_events/create'">
                        <i class="fa fa-plus"></i> Add New
                    </button>
                </div>

                <form id="form-search" style="">
                    <input type="hidden" name="filter" value="true">
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="title" name="title"
                                    value="{{ $title }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label class="form-label">Category</label>
                            <select class="select2 form-control" id="category" name="category">
                                <option value="">All</option>
                                <option value="news" {{ $category == "news" ? 'selected' : '' }}>News</option>
                                <option value="event" {{ $category == "events" ? 'selected' : '' }}>Events</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-4">
                            <label class="form-label">Date Range</label>
                            <div class="input-group input-daterange">
                                <input type="text" class="form-control" id="date_from" name="date_from" value="{{ $date_from }}" placeholder="Start Date">
                                <span class="input-group-addon input-group-text">to</span>
                                <input type="text" class="form-control" id="date_to" name="date_to" value="{{ $date_to }}" placeholder="End Date">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 mt-2">
                            <div class="d-flex" style="margin-top:8%">
                                <button class="btn btn-primary btn-xs px-2 m-1"> Search</button>
                                <button type="button" onclick="clearsearchfield()"
                                    class="btn btn-outline-primary btn-xs px-2 m-1"> Clear</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="mt-1">
                    <table id="data-table-scroller" width="100%"
                        class="table table-striped table-bordered align-middle table-responsive table-sm">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">Date</th>
                                <th class="text-center">Title</th>
                                <th class="text-center" width="10%">Category</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($news_events as $ne)
                                <tr>
                                    <td class="text-center" width="10%">{{ date('m-d-Y', strtotime($ne->date)) }}</td>
                                    <td class="text-center" id="name" style="cursor: pointer"
                                        onclick="location.href='/news_events/{{ $ne->ne_id }}/edit'">{{ $ne->title }}</td>
                                    <td class="text-center" width="10%">
                                        @if($ne->category == 'event')
                                            <span class="badge" style="background-color: orange;">Event</span>
                                        @else
                                            <span class="badge bg-info">News</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center" width="10%">{{ date('m-d-Y', strtotime($ne->date)) }}</td>
                                    <td class="text-center" id="name" style="cursor: pointer"
                                        onclick="location.href='/news_events/{{ $ne->ne_id }}'">{{ $ne->title }}</td>
                                    <td class="text-center" width="10%">
                                        @if($ne->category == 'event')
                                            <span class="badge" style="background-color: orange;">Event</span>
                                        @else
                                            <span class="badge bg-info">News</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="/assets/plugins/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="/assets/plugins/datatables.net-scroller-bs5/js/scroller.bootstrap5.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/assets/plugins/moment/min/moment.min.js"></script>

    <script>
        $('#news_events').addClass('active');

        var tblrows = 0;
        var height = screen.height;
        $("#pannel-body").attr("style", 'height: 78vh;');
        tblrows = parseInt(height * 0.45) - 30;

        $('#data-table-scroller').DataTable({
            deferRender: true,
            responsive: true,
            scrollY: tblrows,
            scrollCollapse: true,
            scroller: true,
            paging: true,
        });

        function clearsearchfield() {
            $('#title').val('');
            $('#category').val('');
            $('#date_from').val('');
            $('#date_to').val('');
        }

        var userTarget = "";
        var exit = false;
        $('.input-daterange').datepicker({
            format: "mm/dd/yyyy",
        });
        $('.input-daterange').focusin(function(e) {
            userTarget = e.target.name;
        });
        $('.input-daterange').on('changeDate', function(e) {
            if (exit) return;
            if (e.target.name != userTarget) {
                exit = true;
                if ($(e.target).data('datepicker')) {
                    $(e.target).datepicker('clearDates');
                }
            }
            exit = false;
        });
    </script>

@endsection
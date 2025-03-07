@extends('layouts.app')

@section('title', 'Blogs')

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
        <li class="breadcrumb-item"><a href="javascript:;">Blogs</a></li>
    </ol>
    <h1 class="page-header">Blogs List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-xs" onclick="location.href='/blogs/create'">
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

                        <div class="col-lg-2 col-md-2">
                            <label class="form-label">Status</label>
                            <select class="select2 form-control" id="enabled" name="enabled">
                                <option value="">All</option>
                                <option value="1" {{ $enabled == 1 ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ $enabled == 0 ? 'selected' : '' }}>Disabled</option>
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
                                <th class="text-center" width="15%">Date</th>
                                <th class="text-center">Title</th>
                                <th class="text-center" width="10%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($blogs as $b)
                                <tr>
                                    <td class="text-center" width="15%">{{ date('F d, Y', strtotime($b->date)) }}</td>
                                    <td class="" id="name" style="cursor: pointer"
                                        onclick="location.href='/blogs/{{ $b->b_id }}'">{{ $b->title }}</td>
                                    <td class="text-center" width="10%">
                                        @if($b->enabled)
                                            <i class="fa fa-check text-success"></i>
                                        @else
                                            <i class="fa fa-times text-danger"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end mt-1">
                        {{ $blogs->links('pagination::bootstrap-4') }}
                    </div>
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
        $("#pannel-body").attr("style", 'min-height: 78vh;');
        $('#blogs').addClass('active');

        var tblrows = 0;
        var height = screen.height;
        tblrows = parseInt(height * 0.8) - 30;

        $('#data-table-scroller').DataTable({
            deferRender: true,
            responsive: true,
            scrollY: tblrows,
            scrollCollapse: true,
            scroller: true,
            paging: true,
            order: [[0, 'desc']],
        });

        function clearsearchfield() {
            $('#title').val('');
            $('#enabled').val('').trigger('change');
            $('#date_from').val('');
            $('#date_to').val('');
        }

        var userTarget = "";
        var exit = false;
        $('.input-daterange').datepicker({
            format: 'M d, yyyy',
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
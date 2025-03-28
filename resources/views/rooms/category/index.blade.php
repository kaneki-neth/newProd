@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <style>
        /* @can('category-write')
            #name:hover {
                font-weight: bold;
                color: #28acb5;
            }

        @endcan */ .custom-input {
            height: 30px;
        }

        .select2-search {
            display: none;
        }

        span.select2-selection.select2-selection--single {
            height: 30px !important;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Categories</a></li>
    </ol>
    <h1 class="page-header">Category List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-xs" onclick="add_category()">
                        <i class="fa fa-plus"></i> Add New
                    </button>
                </div>

                <form id="form-search" style="">
                    <input type="hidden" name="filter" value="true">
                    <div class="row mb-3">
                        <div class="col-lg-2 col-md-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control custom-input" id="name" name="name" value="{{ $name }}"
                                placeholder="..." autocomplete="off">
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label class="form-label">Daily Rate</label>
                            <input type="text" class="form-control custom-input" id="daily_rate" name="daily_rate"
                                value="{{ $daily_rate }}" placeholder="..." autocomplete="off">
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <label class="form-label">Hourly Rate</label>
                            <input type="text" class="form-control custom-input" id="hourly_rate" name="hourly_rate"
                                value="{{ $hourly_rate }}" placeholder="..." autocomplete="off">
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
                        class="table table-striped table-bordered align-middle text-nowrap table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center" style="width: 50%">Daily Rate</th>
                                <th class="text-center" style="width: 50%">Hourly Rate</th>
                                <th class="text-center" style="width: 50%">Max Occupancy</th>
                                <th class="text-center" style="width: 50%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td id="name" style="color:#28acb5; cursor:pointer;"
                                        onclick="showmodaledit(`{{ $category->c_id }}`)">
                                        {{ $category->name }}
                                    </td>
                                    <td class="text-center">{{ $category->daily_rate }}</td>
                                    <td class="text-center">{{ $category->hourly_rate }}</td>
                                    <td class="text-center">{{ $category->max_occupancy }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $category->enabled == 1 ? 'success' : 'danger' }}">
                                            {{ $category->enabled == 1 ? 'Active' : 'Inactive' }}
                                        </span>
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
    <script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="/assets/plugins/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="/assets/plugins/datatables.net-scroller-bs5/js/scroller.bootstrap5.min.js"></script>

    <script>
        $('#categories').addClass('active');

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
            $("#name").val('');
            $("#daily_rate").val('');
            $("#hourly_rate").val('');
        }

        function add_category() {
            $.ajax({
                method: 'get',
                url: '{{ route("categories.create") }}',
                contentType: false,
                processData: false,
                success: (response) => {
                    $("#main_modal").modal('show');
                    $("#modal-title").html('Add Category');
                    $("#modal-body").html(response);
                }, error: (error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please contact your system admin',
                    })
                }
            })
        }

        function showmodaledit(id) {
            let url = '{{ route("categories.edit", ["id" => ":id"]) }}';
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                contentType: false,
                processData: false,
                success: (response) => {
                    $("#main_modal").modal('show');
                    $("#modal-title").html('Edit Category');
                    $("#modal-body").html(response);
                }, error: (error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please contact your system admin',
                    })
                }
            });
        }
    </script>

@endsection
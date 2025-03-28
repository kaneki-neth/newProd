@extends('layouts.app')

@section('title', 'Guests')

@section('content')

    <style>
        .custom-input {
            height: 30px;
        }

        .select2-search {
            display: none;
        }

        span.select2-selection.select2-selection--single {
            height: 30px !important;
        }

        .btnRoles:hover {
            font-weight: bold;
            color: #28acb5;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="/companies">Companies</a></li>
    </ol>

    <h1 class="page-header">Guests List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">

            <div class="d-flex justify-content-end">
                <a class="btn btn-primary btn-xs" href="/guests/create"><i class="fa fa-plus"></i> Add New</a>
            </div>

            <div>
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control form-control-sm" id="name" value="{{ $name }}"
                                    name="name" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="penalty" class="form-label">Status</label>
                                <select class="form-control form-control-sm select2" id="status" name="status">
                                    <option value="">All</option>
                                    <option value="1" {{ $status == 1 ? 'selected' : '' }}>Enabled</option>
                                    <option value="0" {{ $status == 0 ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="d-flex" style="margin-top:22px">
                                <button class="btn btn-primary btn-xs m-1"> Search</button>
                                <button type="button" onclick="clearsearchfield()"
                                    class="btn btn-outline-primary btn-xs px-2 m-1"> Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="">
                <table id="data-table-scroller" width="100%"
                    class="table table-striped table-bordered align-middle text-nowrap table-sm">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guests as $guest)
                            <tr>
                                <td class="text-center btnRoles" style="color:#28acb5; cursor:pointer;"
                                    onclick="window.location.href='/guests/view/{{ $guest->g_id }}'">
                                    {{ $guest->first_name }} {{ $guest->middle_name }} {{ $guest->last_name }}
                                </td>
                                <td class="text-center">{{ $guest->email}}</td>
                                <td class="text-center">{{ $guest->contact_number}}</td>
                                @if($guest->company_name)
                                    <td class="text-center">{{ $guest->company_name}}</td>
                                @else
                                    <td class="text-center">-</td>
                                @endif
                                @if($guest->enabled == 1)
                                    <td class="text-center"><span class="badge bg-success">Active</span></td>
                                @else
                                    <td class="text-center"><span class="badge bg-danger">Inactive</span></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

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
    <script>

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


    </script>


    <script>
        $("#guests").addClass("active");
        $(document).ready(function () {
            $("#status").select2();
        });

        function clearsearchfield() {
            $("#penalty").val('');
            $("#status").val('').trigger('change');
        }

    </script>
@endsection
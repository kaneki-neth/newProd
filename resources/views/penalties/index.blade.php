@extends('layouts.app')

@section('title', 'Roles')

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
        <li class="breadcrumb-item"><a href="/penalties">Penalties</a></li>
    </ol>

    <h1 class="page-header">Penalties List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">

            <div class="d-flex justify-content-end">
                <button class="btn btn-primary btn-xs" onclick="add_penalty()"><i class="fa fa-plus"></i> Add New</button>
            </div>

            <div>
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="penalty" class="form-label">Penalty Name</label>
                                <input type="text" class="form-control form-control-sm" id="penalty" value="{{ $penalty }}"
                                    name="penalty" placeholder="..." autocomplete="off">
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
                            <th class="text-center" style="width: 5%">No.</th>
                            <th class="text-center">Penalty</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penalties as $penalty)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center btnRoles" style="color:#28acb5; cursor:pointer;"
                                    onclick="showmodaledit(`{{ $penalty->p_id }}`)">{{ $penalty->name }}
                                </td>
                                <td class="text-center">{{ $penalty->amount}}</td>
                                @if($penalty->enabled == 1)
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
        $("#penalties").addClass("active");
        $(document).ready(function () {
            $("#status").select2();
        });

        function clearsearchfield() {
            $("#penalty").val('');
            $("#status").val('').trigger('change');
        }

        function add_penalty() {
            $.ajax({
                method: 'get',
                url: '{{ route("penalties.create") }}',
                contentType: false,
                processData: false,
                success: (response) => {
                    $("#main_modal").modal('show');
                    $("#modal-title").html(`Penalty (Add)`);
                    $("#modal-body").html(response);
                }, error: function (reject) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please contact your system admin',
                    })
                }
            });
        }


        function showmodaledit(penalty_id) {
            $.ajax({
                method: 'get',
                url: '{{ route("penalties.edit", ["id" => ":id"]) }}'.replace(':id', penalty_id),
                contentType: false,
                processData: false,
                success: (response) => {
                    $("#main_modal").modal('show');
                    $("#modal-title").html(`Penalty (Update)`);
                    $("#modal-body").html(response);
                }, error: function (reject) {
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
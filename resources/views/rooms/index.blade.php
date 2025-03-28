@extends('layouts.app')

@section('title', 'Rooms')

@section('content')
    <style>
        .select2-container {
            width: 100%;
        }

        .custom-input {
            height: 30px;
        }

        .select2-dropdown {
            z-index: 1056 !important;
        }

        span.select2-selection.select2-selection--single {
            height: 30px !important;
        }
    </style>
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Rooms</a></li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Rooms List</h1>
    <!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-xs" onclick="add_room()"><i class="fa fa-plus"></i>
                        Add New</button>
                </div>
                <form id="form-search" style="">
                    <input type="hidden" name="filter" value="true">
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Room Number</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="room_number"
                                    name="room_number" value="{{ $room_number }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Floor Number</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="floor_number"
                                    name="floor_number" value="{{ $floor_number }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="category"
                                    name="category" value="{{ $category }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control form-control-sm select2" id="status" name="status"
                                    placeholder="..." autocomplete="off">
                                    <option value="">Select Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 mt-2">
                            <div class="d-flex" style="margin-top:8%">
                                <button class="btn btn-primary btn-xs px-2 m-1" type="submit"> Search</button>
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
                                <th class="text-center" width="10%">Room No.</th>
                                <th class="text-center" width="10%">Floor No.</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Enabled</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                                <tr>
                                    <td class="text-center" id="room_number" style="color:#28acb5; cursor:pointer;"
                                        onclick="showmodaledit(`{{ $room->r_id }}`)">
                                        {{ $room->room_number }}
                                    </td>
                                    <td class="text-center">{{ $room->floor_number }}</td>
                                    <td class="text-center">{{ $room->category_name }}</td>
                                    <td class="text-center">{{ $room->status }}</td>
                                    <td class="text-center"><span
                                            class="badge bg-{{ $room->enabled == 1 ? 'success' : 'danger' }}">{{ $room->enabled == 1 ? 'Active' : 'Inactive' }}</span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- end panel -->
    <script src="/assets/js/jquery-3.6.4.min.js"></script>
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
            order: [[0, 'asc']],
            pageLength: 20,
        });

    </script>

    <script>
        $(document).ready(function () {
            $('#status').select2();
            $('#category').select2();
        });

        $("#rooms").addClass("active");

        function add_room() {
            // Clear the modal content before making the new request
            $("#modal-body").html('');

            $.ajax({
                method: 'get',
                url: '{{ route("rooms.create") }}',
                contentType: false,
                processData: false,
                success: (response) => {
                    $("#main_modal").modal('show');
                    $("#modal-title").html('Add Room');
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
            let url = '{{ route("rooms.edit", ["id" => ":id"]) }}';
            url = url.replace(':id', id);
            $.ajax({
                method: 'get',
                url: url,
                contentType: false,
                processData: false,
                success: (response) => {
                    $("#main_modal").modal('show');
                    $("#modal-title").html('Edit Room');
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

        function clearsearchfield() {
            $("#room_number").val('');
            $("#floor_number").val('');
            $("#category").val('');
            $("#status").val('');
            $("#status").select2().trigger('change');
        }

    </script>
@endsection
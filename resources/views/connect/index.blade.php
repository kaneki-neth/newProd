@extends('layouts.app')

@section('title', 'Connect')

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

    .table th {
        font-weight: 600;
        color: #495057;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(40, 172, 181, 0.05);
    }

    .btn-link:hover {
        color: #1a7179 !important;
    }
</style>

<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="javascript:;">Connect</a></li>
</ol>
<h1 class="page-header">Connect Mails</h1>

<div class="panel panel-inverse">
    <div class="panel-body" id="pannel-body">

        <form id="form-search" class="mt-4">
            <input type="hidden" name="filter" value="true">
            <div class="row">
                <div class="col-lg-2 col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control form-control-sm custom-input" id="name" name="name" value="{{ request('name') }}" placeholder="..." autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-2 col-md-2">
                    <label class="form-label">Purpose</label>
                    <select class="select2 form-control form-control-sm" id="purpose" name="purpose">
                        <option value="">Select....</option>
                        @foreach($purposes as $purpose)
                        <option value="{{ $purpose }}" {{ request('purpose') == $purpose ? 'selected' : '' }}>{{ $purpose }}</option>
                        @endforeach
                    </select>
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

        <!-- <div class="card-body my-2 w-full">
            <p class="my-3 fw-bolder">Emails</p>
            <div style="overflow-x: auto; overflow-y: auto; max-height: 400px;">
                <table width="100%" class="table table-hover table-striped table-bordered align-middle text-nowrap table-sm">
                    <thead>
                        <tr>
                            <th style="background: lightgray;" class="text-center">Name</th>
                            <th style="background: lightgray;" class="text-center">Purpose</th>
                            <th style="background: lightgray;" class="text-center">Email Address</th>
                            <th style="background: lightgray;" class="text-center">Read</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($connects as $con)
                        <tr>
                            @if($con->is_read === 0)
                            <td style="font-weight: bold">{{ $con->name }}</td>
                            <td style="font-weight: bold">
                                <button type="button" class="fw-bold dropdown-item btnpart" style="color: #28acb5;" onclick="read_email(`{{ $con->connect_id }}`)">{{$con->purpose}}</button>
                            </td>
                            <td style="font-weight: bold">{{ $con->email }}</td>
                            @else
                            <td style="font-weight: normal">{{ $con->name }}</td>
                            <td style="font-weight: normal">
                                <button type="button" class="fw-normal dropdown-item btnpart" style="color: #28acb5;" onclick="read_email(`{{ $con->connect_id }}`)">{{$con->purpose}}</button>
                            </td>
                            <td style="font-weight: normal">{{ $con->email }}</td>
                            @endif
                            <td id="status-icon-{{ $con->connect_id }}" class="text-center">
                                @if($con->is_read === 1)
                                <i class="fa-solid fa-check-double" style="color: #007e33;"></i>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-body my-2 w-full">
            <p class="my-3 fw-bolder">Subscribed</p>
            <div style="overflow-x: auto; overflow-y: auto; max-height: 300px;">
                <table width="100%" class="table table-hover table-striped table-bordered align-middle text-nowrap table-sm">
                    <thead>
                        <tr>
                            <th style="background: lightgray;" class="text-center">#</th>
                            <th style="background: lightgray;" class="text-center">Full Name</th>
                            <th style="background: lightgray;" class="text-center">Email Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscription as $sub)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $sub->name }}</td>
                            <td>{{ $sub->email }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center">No MATIX Subscription records found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> -->

        <!-- Email Table Section -->
        <div class="my-5 card shadow-sm rounded-lg overflow-hidden mb-4">
            <div class="card-header bg-white text-sm py-2 d-flex justify-content-between align-items-center">
                <p class="mb-0 fw-bold">Emails</p>
                <span class="badge bg-secondary fw-bold rounded-pill px-3 py-2">{{ count($connects) }} Emails</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 400px;">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th style="font-size: 12px;" class="px-3 py-2 border-0">Name</th>
                                <th style="font-size: 12px;" class="px-3 py-2 border-0">Purpose</th>
                                <th style="font-size: 12px;" class="px-3 py-2 border-0">Email Address</th>
                                <th style="font-size: 12px;" class="px-3 py-2 border-0 text-center" width="80">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($connects as $con)
                            <tr class="{{ $con->is_read === 0 ? 'table-active' : '' }}">
                                <td style="font-size: 11px;" class="px-3 py-2 align-middle {{ $con->is_read === 0 ? 'fw-bold' : '' }}">
                                    {{ $con->name }}
                                </td>
                                <td class="px-3 py-2 align-middle {{ $con->is_read === 0 ? 'fw-bold' : '' }}">
                                    <button type="button"
                                        class="btn btn-link p-0 text-decoration-none {{ $con->is_read === 0 ? 'fw-bold' : '' }}"
                                        style="font-size: 11px; color: #28acb5;"
                                        onclick="read_email(`{{ $con->connect_id }}`)">
                                        {{$con->purpose}}
                                    </button>
                                </td>
                                <td style="font-size: 11px;" class="px-3 py-2 align-middle {{ $con->is_read === 0 ? 'fw-bold' : '' }}">
                                    <a href="mailto:{{ $con->email }}" style="color: #000000;" class="text-decoration-none">{{ $con->email }}</a>
                                </td>
                                <td style="font-size: 11px;" id="status-icon-{{ $con->connect_id }}" class="px-3 py-2 align-middle text-center">
                                    @if($con->is_read === 1)
                                    <i class="fa-solid fa-check-double fa-lg" style="color: #007e33;"></i>
                                    @else
                                    <i class="fa-solid fa-envelope fa-lg" style="color: #444444;"></i>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-inbox fa-2x mb-3 d-block"></i>
                                    No email records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Subscription Table Section -->
        <div class="my-5 card shadow-sm rounded-lg overflow-hidden mb-4">
            <div class="card-header bg-white text-sm py-2 d-flex justify-content-between align-items-center">
                <p class="mb-0 fw-bold">Subscribed</p>
                <span class="badge bg-secondary rounded-pill px-3 py-2">{{ count($subscription) }} Subscribers</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 300px;">
                    <table class="table table-hover table-sm mb-0">
                        <thead>
                            <tr class="bg-light">
                                <th style="font-size: 12px;" class="px-3 py-2 border-0" width="60">#</th>
                                <th style="font-size: 12px;" class="px-3 py-2 border-0">Name</th>
                                <th style="font-size: 12px;" class="px-3 py-2 border-0">Email Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscription as $sub)
                            <tr>
                                <td style="font-size: 11px;" class="px-3 py-2 align-middle">{{ $loop->iteration }}</td>
                                <td style="font-size: 11px;" class="px-3 py-2 align-middle">{{ $sub->name }}</td>
                                <td style="font-size: 11px;" class="px-3 py-2 align-middle">
                                    <a href="mailto:{{ $sub->email }}" style="color: #000000;" class="text-decoration-none">{{ $sub->email }}</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-user-plus fa-2x mb-3 d-block"></i>
                                    No MATIX Subscription records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
    $('#connect').addClass('active');

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
        order: [
            [0, 'desc']
        ],
        columnDefs: [{
            targets: 0,
            type: 'date'
        }]
    });

    function clearsearchfield() {
        $('#name').val('');
        $('#purpose').val('').trigger('change');
        document.getElementById('form-search').submit();
    }

    function read_email(connect_id) {
        $.ajax({
            method: 'get',
            url: '/read_email?_connect_id=' + connect_id,
            contentType: false,
            processData: false,
            success: (response) => {
                $("#main_modal").modal('show');
                $("#modal-title").html(`Connect Mail (View)`);
                $('div#modal-dialog').addClass('modal-lg');
                $("#modal-body").html(response);

                $("#status-icon-" + connect_id).html('<i class="fa-solid fa-check-double" style="color: #007e33;"></i>');
                $("#status-icon-" + connect_id).closest('tr').find('td').css('font-weight', 'normal');
            },
            error: function(reject) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! Please contact your system admin',
                });
            }
        });
    }
</script>

@endsection
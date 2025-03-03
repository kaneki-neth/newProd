@extends('layouts.app')

@section('title', 'Materials')

@section('content')
    <style>
        #name:hover {
            font-weight: bold;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Materials</a></li>
    </ol>
    <h1 class="page-header">Materials List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-xs" onclick="location.href='/material/create'"><i
                            class="fa fa-plus"></i> Add
                        New</button>
                </div>

                <form id="form-search" style="">
                    <input type="hidden" name="filter" value="true">
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="name" name="name"
                                    value="{{ $name }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Material Code</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="material_code"
                                    name="material_code" value="{{ $material_code }}" placeholder="..." autocomplete="off">
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
                                <th class="text-center" width="30%">Material Code</th>
                                <th width="60%">Material Name</th>
                                <th class="text-center" width="10%">Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materials as $material)
                                <tr>
                                    <td>{{ $material->material_code }}</td>
                                    <td id="name" style="color:#28acb5"
                                        onclick="location.href='/material/show/{{ $material->m_id }}'">
                                        {{ $material->name }}
                                    </td>
                                    <td class="text-center">{{ $material->year }}</td>
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

    <script>
        $('#material').addClass('active');

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
            $("#material_code").val('');
        }
    </script>

@endsection
@extends('layouts.app')

@section('title', 'Application Lookup')


@section('content')
<style>
    .btnLookup{
        color: #28acb5; 
        width: 1%
    }

    .btnLookup:hover{
        font-weight: bold;
        color: #28acb5; 
    }

    span.select2-selection.select2-selection--single {
        height: 30px!important;
    }
    .custom-input {
        width: 100%;
        height: 30px; /* Set the desired height for input elements */
    }
    .btnItems:hover{
        font-weight: bold;
    }
    .table tbody td {
        margin-top: 2px; /* Adjust the top margin as per your preference */
        margin-bottom: -2px; /* Adjust the bottom margin as per your preference */
    }
    .dataTables_info{
        display: none;
    }

    @media only screen and (max-height: 704px) { /* 0px to 600px */
        .panel-body {
            height: 77vh;
        }
    }

    @media only screen and (min-height: 705px) and (max-height: 759px) { /* 705px to 759px */
        .panel-body {
            height: 80vh;
        }
    }

    @media only screen and (min-height: 760px)  and (max-height: 899px) { /* 760px and above */
        .panel-body {
            height: 83vh;
        }
    }

    @media only screen and (min-height: 900px) { /* 760px and above */
        .panel-body {
            height: 83vh;
        }
    }
</style>
	<ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript: void(0);">Application Settings</a></li>
        <li class="breadcrumb-item"><a href="javascript: void(0);">Developer</a></li>
        <li class="breadcrumb-item active"><a href="app_lookup">Lookups</a></li>
	</ol>
	<h1 class="page-header">Application Lookup</h1>
	<div class="panel panel-inverse">
		<div class="panel-body">

                <div class="d-flex justify-content-end">
                    @if(Auth::user()->can('look_up_full'))
                    <button class="btn btn-primary btn-xs" onclick="add_lookup()"><i class="fa fa-plus"></i> Add Lookup</button>
                    @endif
                </div>

                <div>
                    <form>
                        <div class="row">
                            <div class="col-md-2" hidden>
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-sm" id="filter" name="filter" value="true"  placeholder="...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="_lookup_type" class="form-label">Type</label>
                                    <input type="text" class="form-control form-control-sm custom-input" id="_lookup_type" value="{{$lookup_type}}"  name="_lookup_type"  placeholder="..." autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="_meaning" class="form-label">Meaning</label>
                                    <input type="text" class="form-control form-control-sm custom-input" id="_meaning" value="{{$meaning}}" name="_meaning"  placeholder="..." autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="d-flex" style="margin-top:22px">
                                    <button class="btn btn-primary btn-xs m-1"> Search</button>
                                    <button type="button" onclick="clearsearchfield()" class="btn btn-outline-primary btn-xs px-2 m-1"> Clear</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
              
                <div id="table-div">
                <table id="data-table-scroller" width="100%" class="table table-striped table-bordered align-middle text-nowrap table-sm">
                        <thead>
                            <tr>
                                <th style="width: 25%">Type</th>
                                <th>Code</th>
                                <th>Meaning</th>
                                <th>Enabled</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($lookups) > 0)
                                @foreach($lookups as $lookup)
                                    <tr>
                                        <td> 
                                            @if(Auth::user()->can('look_up_full'))
                                            <button class="dropdown-item btnLookup" onclick="showmodaledit(`<?php echo $lookup->lookup_code ?>`)" > {{$lookup->lookup_type}} </button>
                                            @elseif(Auth::user()->can('look_up_view'))
                                            <button class="dropdown-item btnLookup" onclick="showmodalview(`<?php echo $lookup->lookup_code ?>`)"> {{$lookup->lookup_type}} </button>
                                            @endif
                                        <td>{{$lookup->lookup_code}}</td>
                                        <td>{{$lookup->meaning}}</td>
                                        <td>
                                            @if($lookup->enabled === 1)
                                                <i class="fa fa-check text-success"></i>
                                            @else
                                                <i class="fa fa-x text-danger"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
	</div>
    <!-- <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/js/sweetalert.min.js"></script> -->
    <!-- dependencies -->
    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <script src="/assets/plugins/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="/assets/plugins/datatables.net-scroller-bs5/js/scroller.bootstrap5.min.js"></script>
<!-- dependencies -->
	
    <script>
        $("#application").addClass("active");
        $("#developer").attr("style", "display: block; box-sizing: border-box;");
        $("#lookup").addClass("active");
		$("#look").addClass("active");
        
        initializeDtable();

        function initializeDtable(){
            var scrollYValue;

            if (window.matchMedia('(max-height: 704px)').matches) {
                    scrollYValue = '42vh'; // Adjusted to match the smallest height range
                } else if (window.matchMedia('(min-height: 705px) and (max-height: 760px)').matches) {
                    scrollYValue = '48vh'; 
                } else if (window.matchMedia('(min-height: 761px) and (max-height: 900px)').matches) {
                    scrollYValue = '55vh'; 
                } else if (window.matchMedia('(min-height: 900px)').matches) {
                    scrollYValue = '61vh'; 
                }

            $('#data-table-scroller').DataTable({
                deferRender: true,
                responsive: true,
                scrollY: scrollYValue,
                scrollCollapse: true,
                scroller: true,
                paging: true
            });
        }

        function clearsearchfield(){
            $("#_lookup_type").val('');
            $("#_meaning").val('');
        }

        function add_lookup(){
            $.ajax({
                method: 'get',
                url: '/app/app_lookup/create',
                contentType: false,
                processData: false,
                success: (response) => { 
                    $("#main_modal").modal('show');
                    $("#modal-title").html(`Lookup (Add)`);
                    $("#modal-body").html(response);
                }, error: function(reject){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please contact your system admin',
                    })
                }
            });
        }
        
        function showmodaledit(lookup_code){
            $.ajax({
                method: 'get',
                url: '/app/app_lookup/update?_lookup_code='+lookup_code,
                contentType: false,
                processData: false,
                success: (response) => { 
                    $("#main_modal").modal('show');
                    $("#modal-title").html(`Lookup (Update)`);
                    $("#modal-body").html(response);
                }, error: function(reject){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please contact your system admin',
                    })
                }
            });
        }

        function showmodalview(lookup_code){
            $.ajax({
                method: 'get',
                url: '/app/app_lookup/view?_lookup_code='+lookup_code,
                contentType: false,
                processData: false,
                success: (response) => { 
                    $("#main_modal").modal('show');
                    $("#modal-title").html(`Lookup (View)`);
                    $("#modal-body").html(response);
                }, error: function(reject){
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
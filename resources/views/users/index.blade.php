@extends('layouts.app')

@section('title', 'Users')

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Users</a></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Users List</h1>
	<!-- end page-header -->

	<!-- begin panel -->
	<div class="panel panel-inverse">
		<div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary btn-xs" onclick="location.href='/sys_admin/user/create'"><i class="fa fa-plus"></i> Add New</button> 
                </div>
                <form id="form-search" style="">
                    <input type="hidden" name="filter" value="true">
                    <div class="row">
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Alias</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="alias" name="alias" value="{{ $alias }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="email" name="email" value="{{ $email }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">First Name</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="first_name" name="first_name" value="{{ $first_name }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="mb-3">
                                <label for="name" class="form-label">Last Name</label>
                                <input type="text" class="form-control form-control-sm custom-input" id="last_name" name="last_name" value="{{ $last_name }}" placeholder="..." autocomplete="off">
                            </div>
                        </div>
                        
                        <div class="col-lg-2 col-md-3 mt-2">
                            <div class="d-flex" style="margin-top:8%">
                                <button class="btn btn-primary btn-xs px-2 m-1"> Search</button>
                                <button type="button" onclick="clearsearchfield()" class="btn btn-outline-primary btn-xs px-2 m-1"> Clear</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="mt-1">
                    <table id="data-table-scroller" width="100%" class="table table-striped table-bordered align-middle text-nowrap table-sm">
                        <thead>
                            <tr>
                                <th>Alias</th>
                                <th>First name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Last Login</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->alias }}</td>
                                <td>
                                    <button class="dropdown-item btnRoles" style="color:#28acb5; width:10%" onclick="location.href='/sys_admin/user/edit?_user={{ $user->id }}'">{{ $user->first_name }}</button>
                                </td>
                                <td>{{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->enabled)
                                    <i class="fa fa-check text-success"></i>
                                    @else
                                    <i class="fa fa-times text-danger"></i>
                                    @endif
                                </td>
                                <td>{{ is_null($user->last_login) ? ' ' : date('M d, Y h:i A', strtotime($user->last_login)) }}</td>
                            </tr>
                            @endforeach
                        
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
    
	</div>

	<!-- end panel -->
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
        tblrows = parseInt(height*0.45)-30;

        $('#data-table-scroller').DataTable({
            deferRender:    true,
            responsive:     true,
            scrollY:        tblrows,
            scrollCollapse: true,
            scroller:       true,
            paging: true,
        });

    </script>

	<script>
        $(document).ready(function() {
            $('#bu_id').select2();
            $('.select2').select2();
        });
        
        $("#SysAdmin").addClass("active");
        $("#Sys_admin").attr("style", "display: block; box-sizing: border-box;");
        $("#user").addClass("active");

        function clearsearchfield(){
            $("#alias").val('');
            $("#email").val('');
            $("#first_name").val('');
            $("#last_name").val('');
            $("#bu_id").val('');
            $('#bu_id').select2().trigger('change');
        }

	</script>
@endsection
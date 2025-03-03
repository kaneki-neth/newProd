@extends('layouts.app')

@section('title', 'Roles')

@section('content')

<style>
    .btnRoles{
        color: #28acb5; 
        width: 1%
    }

    .btnRoles:hover{
        font-weight: bold;
        color: #28acb5; 
    }
</style>

	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="/app/role_controller">Roles</a></li>
	</ol>

	<h1 class="page-header">Roles List</h1>

	<div class="panel panel-inverse">
		<div class="panel-body" id="pannel-body">

            <div class="d-flex justify-content-end">
                @if(Auth::user()->can('role-full'))
                    <button class="btn btn-primary btn-xs" onclick="add_role()"><i class="fa fa-plus"></i> Add New</button>
                @endcan
            </div>

            <div>
                <form>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label for="_role_type" class="form-label">Roles</label>
                                <input type="text" class="form-control form-control-sm" id="_role_type" value="{{$role_type}}"  name="_role_type"  placeholder="..." autocomplete="off">
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

            <div class="">
                <table id="data-table-scroller" width="100%" class="table table-striped table-bordered align-middle text-nowrap table-sm">
                    <thead>
                        <tr>
                            <th style="width: 50%">Role</th>
                            <th class="text-center">Users</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role as $r)
                            <tr>
                                <td>    
                                    @if(Auth::user()->can('role-full') && Auth::user()->can('role-view'))
                                    <button class="dropdown-item btnRoles" onclick="showmodaledit(`<?php echo $r->id ?>`)">{{$r->name}}</button>
                                    @elseif(Auth::user()->can('role-full'))
                                    <button class="dropdown-item btnRoles" onclick="showmodaledit(`<?php echo $r->id ?>`)">{{$r->name}}</button>
                                    @else
                                    <button class="dropdown-item btnRoles" onclick="showmodalview(`<?php echo $r->id ?>`)">{{$r->name}}</button>
                                    @endif
                                </td>
                                <td class="text-center">{{ $r->role_count}}</td>
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

    $("#SysAdmin").addClass("active");
    $("#Sys_admin").attr("style", "display: block; box-sizing: border-box;");
    $("#role").addClass("active");
    

    function clearsearchfield(){
        $("#_role_type").val('');
    }

    function add_role(){
        $.ajax({
            method: 'get',
            url: '{{ route("roles.create") }}',
            contentType: false,
            processData: false,
            success: (response) => { 
                $("#main_modal").modal('show');
                $("#modal-title").html(`Roles (Add)`);
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


    function showmodaledit(role){
            $.ajax({
                method: 'get',
                url: '{{ route("roles.edit") }}?_role='+role,
                contentType: false,
                processData: false,
                success: (response) => { 
                    $("#main_modal").modal('show');
                    $("#modal-title").html(`Role (Update)`);
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

    function showmodalview(role){
        $.ajax({
            method: 'get',
            url: '{{ route("roles.view") }}?_role='+role,
            contentType: false,
            processData: false,
            success: (response) => { 
                $("#main_modal").modal('show');
                $("#modal-title").html(`Role (View)`);
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
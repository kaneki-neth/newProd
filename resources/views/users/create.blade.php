@extends('layouts.app')

@section('title', 'Users')

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Users</a></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Create User</h1>
	<!-- end page-header -->
    <style>
        .select2.select2-container .selection .select2-selection.select2-selection--single {
            height: 28px !important;
        }
    </style>
    <div class="panel panel-inverse">
        <div class="panel-body">
            <form method="POST" id="add_user" autocomplete="off">
                <div class="row">
                    <style>
                        .status_id_ .select2-container .select2-selection--single {
                            height: 30px!important;
                        }
                    </style>
                </div>

                <div class="row mt-2">

                    <label for="type" class="col-sm-2 col-form-label form-label">Alias <span style="color:red">*</span></label>
                    <div class="col-sm-3" id="div-alias">
                        <input type="text" class="form-control form-control-sm" id="alias" name="alias" onkeyup="remove_error(this)" placeholder="...">
                        <span id="alias-msg" class="text-danger"></span>
                    </div>
                    
                    {{-- <label for="type" class="col-sm-2 col-form-label form-label">User Name <span style="color:red">*</span></label>
                    <div class="col-sm-3" id="div-user_name">
                        <input type="text" class="form-control form-control-sm" id="user_name" name="user_name" onkeyup="remove_error(this)" placeholder="...">
                        <span id="user_name-msg" class="text-danger"></span>
                    </div> --}}

                    <label for="type" class="col-sm-3 col-form-label form-label text-end">Next Password Change</span></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control form-control-sm" id="next_password_change" name="next_password_change" onkeyup="remove_error(this)" placeholder="..." disabled>
                        <span id="next_password_change-msg" class="text-danger"></span>
                    </div>

                </div>
                
                <div class="row">

                    <label for="type" class="col-sm-2 col-form-label form-label">First Name <span style="color:red">*</span></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control form-control-sm" id="first_name" name="first_name" onkeyup="remove_error(this)" placeholder="...">
                        <span id="first_name-msg" class="text-danger"></span>
                    </div>
                
                    <label for="type" class="col-sm-3 col-form-label form-label text-end">Last Password Change</span></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control form-control-sm" id="last_password_change" name="last_password_change" onkeyup="remove_error(this)" placeholder="..." disabled>
                        <span id="last_password_change-msg" class="text-danger"></span>
                    </div>

                </div>

                <div class="row">
                    
                    <label for="type" class="col-sm-2 col-form-label form-label">Last Name <span style="color:red">*</span></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control form-control-sm" id="last_name" name="last_name" onkeyup="remove_error(this)" placeholder="...">
                        <span id="last_name-msg" class="text-danger"></span>
                    </div>

                    <label for="type" class="col-sm-3 col-form-label form-label text-end">Last Login</span></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control form-control-sm" id="last_login" name="last_login" onkeyup="remove_error(this)" placeholder="..." disabled>
                        <span id="last_login-msg" class="text-danger"></span>
                    </div>
                    
                </div>

                <div class="row">

                    <label for="type" class="col-sm-2 col-form-label form-label">Email <span style="color:red">*</span></label>
                    <div class="col-sm-3">
                        <input type="email"  class="form-control form-control-sm" id="email" name="email" onkeyup="this.value = this.value.toLowerCase(); remove_error(this);" placeholder="...">
                        <span id="email-msg" class="text-danger"></span>
                    </div>

                    <label for="type" class="col-sm-3 col-form-label form-label text-end">Last Login IP</span></label>
                    <div class="col-sm-3">
                        <input type="text"  class="form-control form-control-sm" id="last_login_ip" name="last_login_ip" onkeyup="remove_error(this)" placeholder="..." disabled>
                        <span id="last_login_ip-msg" class="text-danger"></span>
                    </div>
                    
                </div>

                <div class="row">

                    <label for="type" class="col-sm-2 col-form-label form-label">Password <span style="color:red">*</span></label>
                    <div class="col-sm-3">
                        <input type="password" class="form-control form-control-sm" id="password" name="password" onkeyup="remove_error(this)" placeholder="...">
                        <span id="password-msg" class="text-danger"></span>
                    </div>

                    <label for="type" class="col-sm-3 col-form-label form-label text-end">Reset On Login</span></label>
                    <div class="col-sm-3">
                        {{-- <input type="text"  class="form-control form-control-sm" id="resent_on_login" name="resent_on_login" onkeyup="remove_error(this)" placeholder="..." disabled>
                        <span id="resent_on_login-msg" class="text-danger"></span> --}}
                        <div class="form-check" style="padding-left: 0; margin-top:2%">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="resent_on_login" name="resent_on_login" checked>
                                <span id="resent_on_login-msg" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <label for="type" class="col-sm-2 col-form-label form-label">Confirm Password <span style="color:red">*</span></label>
                    <div class="col-sm-3">
                        <input type="password"  class="form-control form-control-sm" id="confirmPassword" name="confirmPassword" onkeyup="remove_error(this)" placeholder="...">
                        <span id="confirmPassword-msg" class="text-danger"></span>
                    </div>
                </div>

                <div class="row">
                    <label for="type" class="col-sm-2 col-form-label form-label">Enabled <span style="color:red">*</span></label>
                    <div class="col-sm-3">
                        <div class="form-check" style="padding-left: 0; margin-top:2%">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" checked>
                                <span id="enabled-msg" class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="mt-3 mb-4">

                <div class="row" style="margin-top: 2%;">
                    <div class="col-sm-12">
                    
                        <style>
                            a.nav-link.active {
                                background-color:#28acb5!important;
                                color:white;
                            }
                
                            a.nav-link.active span{
                                color:white;
                            }
                        </style>
                        <div class="col-sm-6">
                            <ul class="nav nav-tabs">
                                <li class="nav-item" id="business_unit_details">
                                    <a href="#business_unit-tab" data-bs-toggle="tab" class="nav-link active">
                                        <span class="d-sm-none">Business Unit </span>
                                        <span class="d-sm-block d-none">Business Unit</span>
                                    </a>
                                </li>
                                <li class="nav-item" id="roles_details">
                                    <a href="#roles-tab" data-bs-toggle="tab" class="nav-link">
                                        <span class="d-sm-none"> Roles & Permission</span>
                                        <span class="d-sm-block d-none"> Roles & Permission</span>
                                    </a>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="tab-content panel rounded-0 p-3 m-0" style="border-top: 1px solid #28acb5;">
                            <div class="tab-pane fade active show" id="business_unit-tab">
                                
                                @foreach($businessUnits as $bu)
                                    <div class="col-6">
                                        <div class="form-check my-2" id="businessUnitCheckbox">
                                            <input class="form-check-input business_unit_checkbox" type="checkbox" name="business_unit_enabled[]" id="business_unit_enabled_{{ $bu->bu_id }}" value="{{ $bu->bu_id }}">
                                            <label class="form-check-label" for="business_unit_enabled_{{ $bu->bu_id }}">
                                                {{ $bu->bu_code }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>

                            <!-- END tab-pane -->
                            <!-- BEGIN tab-pane -->
                            <div class="tab-pane fade" id="roles-tab">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <table class="table table-responsive" id="roles_table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Roles details</th>
                                                    <th style="text-align: right;"><button style="width: 50px" type="button" id="addRowBtnRoles" onclick="addRowRoles()" class="btn btn-primary btn-xs"><i class="fa fa-add"></i> Add</button></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                                <tr>
                                                    <td style="width:100%"> 
                                                        <div>
                                                            <select class="form-select form-select-xs select2" name="roles[]" id="roles_0" style="width:100%" onchange="checkRoleIfSelected()">
                                                                <option value="">Select....</option>
                                                                @foreach($roles as $rol)
                                                                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="roles-msg_0" class="text-danger"></span>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @php
                                                    $roleCount = count($roles);
                                                @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-6">
                                        <table class="table table-responsive" id="roles_table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Direct Permission</th>
                                                    <th style="text-align: right;"><button style="width: 50px" type="button" id="addPermissionBtnRoles" onclick="addRowPermission()" class="btn btn-primary btn-xs"><i class="fa fa-add"></i> Add</button></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBody2">
                                                <tr>
                                                    <td style="width:100%"> 
                                                        <div>
                                                            <select class="form-select form-select-xs select2" name="permissions[]" id="permissions_0" style="width:100%" onchange="checkPermissionIfSelected()">
                                                                <option value="">Select....</option>
                                                                @foreach($permissionname as $pname)
                                                                    <option value="{{$pname->id}}">{{$pname->display_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span id="permissions-msg_0" class="text-danger"></span>
                                                        </div>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @php
                                                    $perCount = count($permissionname);
                                                @endphp
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a type="button" href="/sys_admin/user" class="btn btn-secondary btn-xs px-2 m-1" style="float: right">Back</a>
                <button type="submit" class="btn btn-primary btn-xs px-2 m-1" style="float: right">Save</button>
            </form>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            
            //Change event listener to the initial select element
            document.getElementById('roles_0').addEventListener('change', checkRoleIfSelected);
            document.getElementById('permissions_0').addEventListener('change', checkPermissionIfSelected);
        });

        $("#SysAdmin").addClass("active");
        $("#Sys_admin").attr("style", "display: block; box-sizing: border-box;");
        $("#user").addClass("active");
        
        let roleIndex = 1;
        const roleCount = @php echo $roleCount; @endphp;
  
        function addRowRoles() {
            // Get the roles table body
            let tableBody = document.getElementById('tableBody');
            let currentRows = document.querySelectorAll('#tableBody tr').length;
            
            if (currentRows < roleCount) {
                // Create a new row
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                        <td style="width:100%">
                            <div>
                                <select class="form-select form-select-xs select2" name="roles[]" id="roles_${roleIndex}" style="width:100%" onchange="checkRoleIfSelected()">
                                    <option value="">Select....</option>
                                    @foreach($roles as $rol)
                                        <option value="{{$rol->id}}" >{{$rol->name}}</option>
                                    @endforeach
                                </select>
                                <span id="roles-msg_${roleIndex}" class="text-danger"></span>
                            </div>
                        </td>
                        <td>
                            <div class="mt-1 text-center text-danger">
                                <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRole(this)"></i>
                            </div>
                        </td>
                    `;

                // Add the new row to the table body
                tableBody.appendChild(newRow);

                // Initialize Select2 for the newly added select box
                $('.select2').select2();

                //Change event listener to the new select element
                document.getElementById(`roles_${roleIndex}`).addEventListener('change', checkRoleIfSelected);

                roleIndex++;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You have selected all available roles!',
                });
            }
        }

        function checkRoleIfSelected() {

            let selects = document.querySelectorAll('select[name="roles[]"]');
            let selectedValues = [];

            selects.forEach(select => {
                let selectedValue = select.value;
                if (selectedValue !== "" && selectedValues.includes(selectedValue)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'This role ID is already selected!',
                    });
                    select.value = "";
                    $('.select2').select2();
                } else {
                    selectedValues.push(selectedValue);
                }
            }); 
        }

        function removeRole(button) {
            let row = button.closest('tr');
            row.remove();
            checkRoleIfSelected();
        }

        let perIndex = 1;
        const perCount = @php echo $perCount; @endphp;

        function addRowPermission() {
            let tableBody = document.getElementById("tableBody2");
            let currentRows = document.querySelectorAll('#tableBody2 tr').length;

            if (currentRows < perCount) {
                let newRow = document.createElement("tr");
                newRow.innerHTML = `
                    <td style="width:100%">
                        <div>
                            <select class="form-select form-select-xs select2" name="permissions[]" id="permissions_${perIndex}" style="width:100%" onchange="checkPermissionIfSelected()">
                                <option value="">Select....</option>
                                @foreach($permissionname as $pname)
                                    <option value="{{$pname->id}}" >{{$pname->display_name}}</option>
                                @endforeach
                            </select>
                            <span id="permissions-msg_${perIndex}" class="text-danger"></span>
                        </div>
                    </td>
                    <td>
                        <div class="mt-1 text-center text-danger">
                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removePermission(this)"></i>
                        </div>
                    </td>
                `;

                tableBody.appendChild(newRow);

                $('.select2').select2();

                document.getElementById(`permissions_${perIndex}`).addEventListener('change', checkPermissionIfSelected);
                
                perIndex++;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You have selected all available permissions!',
                });
            }
        }

        function checkPermissionIfSelected() {

            let selects = document.querySelectorAll('select[name="permissions[]"]');
            let selectedValues = [];

            selects.forEach(select => {
                let selectedValue = select.value;
                if (selectedValue !== "" && selectedValues.includes(selectedValue)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'This permission ID is already selected!',
                    });
                    select.value = "";
                    $('.select2').select2();
                } else {
                    selectedValues.push(selectedValue);
                }
            });
        }

        function removePermission(button) {
            let row = button.closest('tr');
            row.remove();
            checkPermissionIfSelected();
        }

        function convertToUpperCase(element) {
            element.value = element.value.toUpperCase();
        }

        $('#add_user').submit(function(e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);

            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);
            formData.set('enabled', $('#enabled').is(':checked') ? 'on' : 'off');
            formData.set('resent_on_login', $('#resent_on_login').is(':checked') ? 'on' : 'off');

            let selectedBusinessUnits = [];
            $('#businessUnitCheckbox input[name="business_unit_enabled[]"]:checked').each(function() {
                let buId = $(this).val();
                selectedBusinessUnits.push(buId);
            });

            // Append selected business unit IDs to formData
            selectedBusinessUnits.forEach(function(buId) {
                formData.append('selected_business_units[]', buId);
            });

            // Extract unique roles from the roles table
            let uniqueRolesSet = new Set(); // Create a Set to store unique role IDs
            $('#tableBody select[name="roles[]"]').each(function() {
                let roleId = $(this).val();
                if (roleId !== "") {
                    uniqueRolesSet.add(roleId); // Add role ID to the Set
                }
            });
            
            let roles = [];

            uniqueRolesSet.forEach(function(roleId) {
                roles.push(roleId); // Convert Set to array
            });

            // Append roles to formData
            if (roles.length > 0) {
                roles.forEach(function(role) {
                    if (role) {
                        formData.append('roles[]', role);
                    }
                });
            }

            // Extract unique permissions from the permission table
            let uniquePermissionSet = new Set(); // Create a Set to store unique permission IDs
            $('#tableBody2 select[name="permissions[]"]').each(function() {
                let permissionId = $(this).val();
                if (permissionId !== "") {
                    uniquePermissionSet.add(permissionId); // Add permission ID to the Set
                }
            });

            let permissions = []; // Array to store unique permission IDs

            uniquePermissionSet.forEach(function(permissionId) {
                permissions.push(permissionId); // Convert Set to array
            });

            // Append permissions to formData
            if (permissions.length > 0) {
                permissions.forEach(function(permission) {
                    if (permission) {
                        formData.append('permissions[]', permission);
                    }
                });
            }

            // Check if neither roles nor permissions are provided
            if (roles.length === 0 && permissions.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You must provide either roles or permissions.',
                });
                $(".btn").attr("disabled", false);
                return;
            }

            $.ajax({
                method: 'post',
                url: '/sys_admin/user/store',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    window.location.href = '/sys_admin/user';
                },
                error: function(reject){
                    var errors = $.parseJSON(reject.responseText);
                    $(".btn").attr("disabled", false);
                    $.each(errors.errors, function (field, messages) {

                        if (field === 'selected_business_units') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: messages[0],
                            });
                            return;
                        }

                        $("#" + field).css('border', '1px solid red');
                        $("span#" + field + "-msg").text(messages[0]);
                    });
                }
            });
        });
    </script>

@endsection
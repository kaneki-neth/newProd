@extends('layouts.app')

@section('title', 'Users')

@section('content')
	<!-- begin breadcrumb -->
	<ol class="breadcrumb float-xl-end">
		<li class="breadcrumb-item"><a href="javascript:;">Users</a></li>
	</ol>
	<!-- end breadcrumb -->
	<!-- begin page-header -->
	<h1 class="page-header">Edit User</h1>
	<!-- end page-header -->

    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-body">
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4"></div>
                <div class="col-4 d-flex justify-content-start">
                    <button class="btn btn-primary btn-xs" onclick="showResetPassword({{$userInfo->id}})">Reset Password</button>
                </div>
            </div>
            <form method="POST" id="update_user" autocomplete="off">
                    <div class="row mt-2">
                        <input type="text" class="form-control form-control-sm" id="user_id" name="user_id" value="{{$userInfo->id}}" hidden>
                        <label for="type" class="col-sm-2 col-form-label form-label">Alias </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control form-control-sm" value="{{$userInfo->alias}}" id="alias" name="alias" onkeyup="remove_error(this)" placeholder="...">
                            <span id="alias-msg" class="text-danger"></span>
                        </div>

                        <label for="type" class="col-sm-3 col-form-label form-label text-end">Next Password Change</span></label>
                        <div class="col-sm-3">
                            <input type="text" style="background: #e7e7e7; color: gray;" class="form-control form-control-sm" id="next_password_change" name="next_password_change" value="{{date('M d, Y', strtotime($userInfo->next_pwd_change))}}"  onkeyup="remove_error(this)" placeholder="..." disabled>
                            <span id="next_password_change-msg" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="row mt-2">
                        
                        <label for="type" class="col-sm-2 col-form-label form-label">First Name </label>
                        <div class="col-sm-3">
                            <input type="text"  class="form-control form-control-sm" value="{{$userInfo->first_name}}" id="first_name" name="first_name" onkeyup="remove_error(this)" placeholder="...">
                            <span id="first_name-msg" class="text-danger"></span>
                        </div>

                        <label for="type" class="col-sm-3 col-form-label form-label text-end">Last Password Change</span></label>
                        <div class="col-sm-3">
                            <input type="text" style="background: #e7e7e7; color: gray;" class="form-control form-control-sm" id="last_password_change" name="last_password_change" value="{{date('M d, Y h:i A', strtotime($userInfo->last_password_change))}}" onkeyup="remove_error(this)" placeholder="..." disabled>
                            <span id="last_password_change-msg" class="text-danger"></span>
                        </div>
                        
                    </div>

                    <div class="row mt-2">

                        <label for="type" class="col-sm-2 col-form-label form-label">Last Name </label>
                        <div class="col-sm-3">
                            <input type="text"  class="form-control form-control-sm" value="{{$userInfo->last_name}}" id="last_name" name="last_name" onkeyup="remove_error(this)" placeholder="...">
                            <span id="last_name-msg" class="text-danger"></span>
                        </div>

                        <label for="type" class="col-sm-3 col-form-label form-label text-end">Last Login</span></label>
                        <div class="col-sm-3">
                            <input type="text" style="background: #e7e7e7; color: gray;" class="form-control form-control-sm" id="last_login" name="last_login" value="{{ $userInfo->last_login ? date('M d, Y h:i A', strtotime($userInfo->last_login)) : '' }}" onkeyup="remove_error(this)" placeholder="..." readonly>
                            <span id="last_login-msg" class="text-danger"></span>
                        </div>
                        
                    </div>

                    <div class="row mt-2">

                        <label for="type" class="col-sm-2 col-form-label form-label">Email </label>
                        <div class="col-sm-3">
                            <input type="email"  class="form-control form-control-sm"  value="{{$userInfo->email}}" id="email" name="email" onkeyup="this.value = this.value.toLowerCase(); remove_error(this);" placeholder="...">
                            <span id="email-msg" class="text-danger"></span>
                        </div>

                        <label for="type" class="col-sm-3 col-form-label form-label text-end">Last Login IP</span></label>
                        <div class="col-sm-3">
                            <input type="text" style="background: #e7e7e7; color: gray;" class="form-control form-control-sm" id="last_login_ip" name="last_login_ip" value="{{ $userInfo->last_login_ip }}" onkeyup="remove_error(this)" placeholder="..." readonly>
                            <span id="last_login_ip-msg" class="text-danger"></span>
                        </div>
                        
                    </div>

                    <div class="row mt-2">

                        <label for="type" class="col-sm-2 col-form-label form-label">Enabled </label>
                        <div class="col-sm-3">
                            <div class="form-check" style="padding-left: 0; margin-top:2%">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled" <?php if($userInfo->enabled === 1){ echo "checked";}?>>
                                </div>
                            </div>
                        </div>

                        <label for="type" class="col-sm-3 col-form-label form-label text-end">Reset On Login</span></label>
                        {{-- <div class="col-sm-3">
                            <input type="text"  class="form-control form-control-sm" id="resent_on_login" name="resent_on_login" onkeyup="remove_error(this)" placeholder="..." disabled>
                            <span id="resent_on_login-msg" class="text-danger"></span>
                        </div> --}}

                        <div class="col-sm-3 form-check" style="padding-left: 0; margin-top: 1%; margin-left: 1%">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="resent_on_login" name="resent_on_login" <?php if($userInfo->reset_on_login === 1){ echo "checked";}?>>
                                <span id="resent_on_login-msg" class="text-danger"></span>
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
                                <!-- BEGIN tab-pane -->
                                <div class="tab-pane fade active show" id="business_unit-tab">
                                    {{-- Checkbox List of Business Units --}}
                                    @foreach($tbl_businessUnit as $bu)
                                        @php
                                            $isChecked = $enabledBusinessUnits->contains('bu_id', $bu->bu_id);
                                        @endphp
                                        <div class="col-6">
                                            <div class="form-check my-2" id="businessUnitCheckbox">
                                                <input class="form-check-input business_unit_checkbox" type="checkbox" name="business_unit_enabled[]" id="business_unit_enabled_{{ $bu->bu_id }}" value="{{ $bu->bu_id }}" {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="business_unit_enabled_{{ $bu->bu_id }}">
                                                    {{ $bu->bu_code }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="tab-pane fade" id="roles-tab">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <table class="table table-responsive" id="roles_table">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Roles</th>
                                                        <th style="text-align: right;"><button style="width: 50px" type="button" id="addRowBtnRoles" onclick="addRowRoles()" class="btn btn-primary btn-xs"><i class="fa fa-add"></i> Add</button></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                    @foreach($roleInfo as $index => $role)
                                                    <tr>
                                                        <td style="width:100%">
                                                            <div>
                                                                <select class="form-select form-select-xs select2" name="role[]" id="roles_{{ $index }}" style="width:100%" onchange="checkRoleIfSelected(this)">
                                                                    <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                                                    @foreach($tbl_roles as $tbl_role)
                                                                        <option value="{{$tbl_role->id}}" @if($tbl_role->id == $role->id) selected @endif>{{$tbl_role->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="mt-1 text-center text-danger">
                                                                <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                @php
                                                    $roleCount = count($tbl_roles);
                                                    $initialRoleIndex = count($roleInfo);
                                                @endphp
                                            </table>
                                        </div>
                                        <div class="col-sm-1"></div>
                                        <div class="col-sm-6">
                                            <table class="table table-responsive" id="roles_permission">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Direct Permission</th>
                                                        <th style="text-align: right;">
                                                            <button style="width: 50px" type="button" id="addPermissionBtnRoles" onclick="addRowPermission()" class="btn btn-primary btn-xs"><i class="fa fa-add"></i> Add</button>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody2">
                                                    @foreach($perInfo as $index => $per)
                                                    <tr>
                                                        <td style="width:100%">
                                                            <select class="form-select form-select-xs select2" name="permission[]" id="{{ $per->id }}_permission" style="width:100%" onchange="checkPermissionIfSelected(this)">
                                                                <option value="{{ $per->id }}" selected>{{ $per->name }}</option>
                                                                @foreach($tbl_permission as $tbl_per)
                                                                    <option value="{{$tbl_per->id}}" @if ($tbl_per->id == $per->id) selected @endif>{{$tbl_per->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <div class="mt-1 text-center text-danger">
                                                                <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                @php
                                                    $perCount = count($tbl_permission);
                                                    $initialPerIndex = count($perInfo);
                                                @endphp
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
        $(function(){
            $('.select2').select2();
            roleRowChanged();
            perRowChanged();
        });

        $("#SysAdmin").addClass("active");
        $("#Sys_admin").attr("style", "display: block; box-sizing: border-box;");
        $("#user").addClass("active");


        let roleIndex = @php echo $initialRoleIndex; @endphp;
        const roleCount = @php echo $roleCount; @endphp;

        function addRowRoles() {
            let tableBody = document.getElementById('tableBody');
            let currentRows = document.querySelectorAll('#tableBody tr').length;

            if (currentRows < roleCount) {
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td style="width:100%">
                        <div>
                            <select class="form-select form-select-xs select2" name="role[]" id="roles_${roleIndex}" style="width:100%" onchange="checkRoleIfSelected(this)">
                                <option value="">Select....</option>
                                @foreach($tbl_roles as $tbl_role)
                                    <option value="{{$tbl_role->id}}">{{$tbl_role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="mt-1 text-center text-danger">
                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                        </div>
                    </td>
                `;
                tableBody.appendChild(newRow);
                $('.select2').select2();
                roleRowChanged();
                roleIndex++;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You have selected all available roles!',
                });
            }
        }

        function roleRowChanged() {
            document.querySelectorAll('select[name="role[]"]').forEach(select => {
                select.dataset.previousValue = select.value;
                select.addEventListener('change', function() {
                    checkRoleIfSelected(select);
                });
            });
        }

        function checkRoleIfSelected(select) {
            let selects = document.querySelectorAll('select[name="role[]"]');
            let otherSelects = Array.from(selects).filter(s => s !== select);
            let roleIds = otherSelects.map(select => select.dataset.roleId || select.value);

            // let roleIds = Array.from(selects).map(select => select.dataset.roleId || select.value);
            // let indexValue = select.getAttribute('index');
            let selectedValue = select.value;
            
            // let selectedValues = new Set();
            // console.log(roleIds);
            // console.log(selectedValue);
            
            if (roleIds.includes(selectedValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'This role ID is already selected!',
                });
                select.value = select.dataset.previousValue;
                $('.select2').select2();
            } else {
                select.dataset.previousValue = selectedValue;
            }
        }

        let permissionIndex = @php echo $initialPerIndex; @endphp;
        const permissionCount = @php echo $perCount; @endphp;
        
        function addRowPermission() {
            let tableBody = document.getElementById('tableBody2');
            let currentRows = document.querySelectorAll('#tableBody2 tr').length;

            if (currentRows < permissionCount) {
                let newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td style="width:100%">
                        <select class="form-select form-select-xs select2" name="permission[]" id="permissions_${permissionIndex}" style="width:100%" onchange="checkPermissionIfSelected(this)">
                            <option value="">Select....</option>
                            @foreach($tbl_permission as $tbl_per)
                                <option value="{{$tbl_per->id}}">{{$tbl_per->name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <div class="mt-1 text-center text-danger">
                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                        </div>
                    </td>
                `;
                
                tableBody.appendChild(newRow);
                $('.select2').select2();
                perRowChanged();
                permissionIndex++;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You have selected all available permissions!',
                });
            }
        }

        function perRowChanged() {
            // Add change event listeners to all select elements
            document.querySelectorAll('select[name="permission[]"]').forEach(select => {
                // Store the initial value
                select.dataset.previousValue = select.value;
                select.addEventListener('change', function() {
                    checkPermissionIfSelected(select);
                });
            });
        }

        function checkPermissionIfSelected(select) {
            let selects = document.querySelectorAll('select[name="permission[]"]');
            let otherSelects = Array.from(selects).filter(s => s !== select);
            let perIds = otherSelects.map(select => select.dataset.perId || select.value);

            let selectedValue = select.value;

            if (perIds.includes(selectedValue)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'This role ID is already selected!',
                });
                select.value = select.dataset.previousValue;
                $('.select2').select2();
            } else {
                select.dataset.previousValue = selectedValue;
            }
        }

        function removeRow(button) {
            let row = button.closest('tr');
            row.remove();
        }

        $('#update_user').submit(function(e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);

            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);
            formData.set('enabled', $('#enabled').is(':checked') ? 'on' : 'off');
            formData.set('resent_on_login', $('#resent_on_login').is(':checked') ? 'on' : 'off');

            let roles = [];
            let permissions = [];

            let checkedBuIds = [];
            let uncheckedBuIds = [];

            $('#businessUnitCheckbox input[name="business_unit_enabled[]"]').each(function() {
                let buId = $(this).val();

                if ($(this).is(':checked')) {
                    checkedBuIds.push(buId);
                } else {
                    uncheckedBuIds.push(buId);
                }
            });

            // Append checked business unit IDs to formData
            for (let i = 0; i < checkedBuIds.length; i++) {
                formData.append('business_units_checked[]', checkedBuIds[i]);
            }

            // Append unchecked business unit IDs to formData
            for (let i = 0; i < uncheckedBuIds.length; i++) {
                formData.append('business_units_unchecked[]', uncheckedBuIds[i]);
            }


            // Extract unique roles from the roles table
            $('#tableBody select[name="role[]"]').each(function() {
                let role = $(this).val();
                if (role !== "") {
                    roles.push(role);
                }
            });

            // Append roles to formData
            roles.forEach(function(role) {
                formData.append('roles[]', role);
            });

            // Extract permissions from the permissions table
            $('#tableBody2 select[name="permission[]"]').each(function() {
                let permission = $(this).val();
                if (permission !== "") {
                    permissions.push(permission);
                }
            });

            // Append permissions to formData
            permissions.forEach(function(permission) {
                formData.append('permissions[]', permission);
            });

            if (roles.length === 0 && permissions.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'You must provide either roles or permissions.',
                });
                $(".btn").attr("disabled", false);
                return false;
            }

            $.ajax({
                method: 'post',
                url: '/sys_admin/user/update',
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    console.log(response);
                    window.location.href = '/sys_admin/user';
                },
                error: function(reject){
                    var errors = $.parseJSON(reject.responseText);
                    $(".btn").attr("disabled", false);
                    $.each(errors.errors, function (field, messages) {

                        if (field === 'business_units_checked') {
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

        function showResetPassword(user_id){
            console.log("showResetPassword function called with user_id:", user_id);
        
            $.ajax({
                method: 'get',
                url: '/sys_admin/user/reset_password/' + user_id,
                contentType: false,
                processData: false,
                success: (response) => {
                    console.log("we got thru indeed success");
                    var myModal = new bootstrap.Modal(document.getElementById('main_modal'), {});
                    myModal.show();
                    $("#modal-title").html(`Users (Reset Password)`);
                    $("#modal-body").html(response);
                }, error: function(reject){
                    var errors = $.parseJSON(reject.responseText);
                    $(".btn").attr("disabled", false);
                    $.each(errors.errors, function (field, messages) {
                        $("#" + field).css('border', '1px solid red');
                        $("span#" + field + "-msg").text(messages[0]);
                    });
                }
            });
        }
    </script>
@endsection
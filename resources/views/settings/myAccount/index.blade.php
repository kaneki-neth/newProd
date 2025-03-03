@extends('layouts.app')

@section('title', 'My Account')

@section('content')

    <style>
        .btnRoles {
            color: #28acb5;
            width: 1%;
        }

        .btnRoles:hover {
            font-weight: bold;
            color: #28acb5;
        }

        .scrollable-container {
            max-height: 90px;
            /* Adjust height as needed */
            overflow-y: auto;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="/settings/myAccount">My Account</a></li>
    </ol>

    <h1 class="page-header">My Account</h1>

    <div class="panel panel-inverse">
        <div class="panel-body">
            <form method="POST" id="update_user" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        @php
                            $profileImage = $user->user_profile ? url($user->user_profile) : url('assets/userProfile/no-image-avail.jpg');
                        @endphp

                        <img id="preview-image" src="{{ $profileImage }}"
                            onerror="this.onerror=null; this.src='{{ url('assets/userProfile/no-image-avail.jpg') }}';"
                            alt="Image not Found" width="320px" style="border: 1px solid #d1c3c0">

                        <div class="form-group mt-3 col-md-6">
                            <input class="form-control" type="file" accept="image/*" id="user_profile" name="user_profile"
                                onchange="displayImage(this)">
                            <span id="user_profile-msg" class="text-danger"></span>
                        </div>
                    </div>



                    <div class="col-6">
                        <div class="row">
                            <label for="alias" class="col-sm-4 col-form-label form-label">Alias</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-sm" name="alias" id="alias"
                                    value="{{ $user->alias }}" onkeyup="remove_error(this)">
                                <span id="alias-msg" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row">
                            <label for="first_name" class="col-sm-4 col-form-label form-label">First Name</label>
                            <div class="col-sm-6">
                                <input type="text" readonly style="background: #e7e7e7;"
                                    class="form-control form-control-sm" name="first_name" id="first_name"
                                    value="{{ $user->first_name }}" onkeyup="remove_error(this)">
                                <span id="first_name-msg" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row">
                            <label for="last_name" class="col-sm-4 col-form-label form-label">Last Name</label>
                            <div class="col-sm-6">
                                <input type="text" readonly style="background: #e7e7e7;"
                                    class="form-control form-control-sm" name="last_name" id="last_name"
                                    value="{{ $user->last_name }}" onkeyup="remove_error(this)">
                                <span id="last_name-msg" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row">
                            <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control form-control-sm"
                                    style="background: #e7e7e7;" name="user_email" id="user_email"
                                    value="{{ $user->email }}">
                            </div>
                        </div>

                        <div class="row">
                            <label for="last_login" class="col-sm-4 col-form-label form-label">Last Login</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control form-control-sm"
                                    style="background: #e7e7e7;"
                                    value="{{ date('F d, Y H:i:s', strtotime($user->last_login)) }}">
                            </div>
                        </div>

                        <div class="row">
                            <label for="last_pwd_change" class="col-sm-4 col-form-label form-label">Last Password
                                Change</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control form-control-sm"
                                    style="background: #e7e7e7;"
                                    value="{{ date('F d, Y H:i:s', strtotime($user->last_password_change)) }}">
                            </div>
                        </div>

                        <div class="row">
                            <label for="last_pwd_change" class="col-sm-4 col-form-label form-label">Next Password
                                Change</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control form-control-sm"
                                    style="background: #e7e7e7;"
                                    value="{{ date('F d, Y', strtotime($user->next_pwd_change)) }}">
                            </div>
                        </div>

                        <div class="row">
                            <label for="last_login_ip" class="col-sm-4 col-form-label form-label">Last Login IP</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control form-control-sm"
                                    style="background: #e7e7e7;" value="{{ $user->last_login_ip }}">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="user_roles" class="col-sm-4 col-form-label form-label">User Role/s</label>
                            <div class="col-md-6" style="line-height: 30px;">
                                <div class="scrollable-container">
                                    @forelse ($roles as $role)
                                        <span class="badge bg-primary">{{ $role }}</span>
                                    @empty
                                        <span class="badge bg-secondary"></span>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label for="user_permissions" class="col-sm-4 col-form-label form-label">User
                                Permission/s</label>
                            <div class="col-md-6" style="line-height: 20px;">
                                <div class="scrollable-container">
                                    @forelse ($permissions as $permission)
                                        <span class="badge bg-primary">{{ $permission->display_name }}</span>
                                    @empty
                                        <span class="badge bg-secondary"></span>
                                    @endforelse
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <button type="button" class="btn btn-warning btn-xs m-1" data-bs-toggle="modal"
                        data-bs-target="#changepass_modal">Change Password</button>
                    <button type="submit" class="btn btn-primary btn-xs m-1">Submit</button>
                </div>
            </form>
        </div>

        <!-- modal for change password -->
        <div class="modal fade" id="changepass_modal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" id="changepass_form">
                        <div class="modal-header">
                            <h4 class="modal-title">Change Password</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                        </div>

                        <div class="modal-body">

                            <div class="alert alert-danger">
                                <h5><i class="fa fa-info-circle"></i> Warning</h5>
                                <p>Please Remember your Credentials</p>
                            </div>

                            <div class="row">
                                <label for="email" class="col-sm-4 col-form-label form-label">Email</label>
                                <div class="col-sm-8">
                                    <input type="email" readonly class="form-control form-control-sm"
                                        style="background: #e7e7e7;" name="email" id="email" value="{{ $user->email }}">
                                    <span id="email-msg" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="row">
                                <label for="cur_password" class="col-sm-4 col-form-label form-label">Current
                                    Password</label>
                                <div class="col-sm-8">
                                    <input type="password" id="current_password" class="form-control form-control-sm"
                                        name="current_password" autocomplete="off" onkeyup="remove_error(this)">
                                    <span id="current_password-msg" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="row">
                                <label for="new_password" class="col-sm-4 col-form-label form-label">New Password</label>
                                <div class="col-sm-8">
                                    <input type="password" id="password" class="form-control form-control-sm"
                                        name="password" autocomplete="off" onkeyup="remove_error(this)">
                                    <span id="password-msg" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="row">
                                <label for="confirm_password" class="col-sm-4 col-form-label form-label">Confirm New
                                    Password</label>
                                <div class="col-sm-8">
                                    <input type="password" id="confirm-password" name="confirm-password"
                                        class="form-control form-control-sm" autocomplete="off"
                                        onkeyup="remove_error(this)">
                                    <span id="confirm-password-msg" class="text-danger"></span>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <a href="javascript:;" class="btn btn-white" data-bs-dismiss="modal">Close</a>
                            <button type="submit" id="changepass_btn" name="changepass_btn"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end modal for change password -->

    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script>
        $("#menu_profile").addClass("active");
        $("#appSidebarProfileMenu").addClass("expand");
        $("#appSidebarProfileMenu").attr("style", "display: block; box-sizing: border-box;");
        $("#myAccount").addClass("active");

        $('#user_name').keypress(function () {
            if ($(this).val().length >= 30) {
                $(this).val($(this).val().slice(0, 30));
                return false;
            }
        });

        $('#first_name').keypress(function () {
            if ($(this).val().length >= 50) {
                $(this).val($(this).val().slice(0, 50));
                return false;
            }
        });

        $('#last_name').keypress(function () {
            if ($(this).val().length >= 50) {
                $(this).val($(this).val().slice(0, 50));
                return false;
            }
        });

        $('#new_password').keypress(function () {
            if ($(this).val().length >= 255) {
                $(this).val($(this).val().slice(0, 255));
                return false;
            }
        });

        $('#email').keypress(function () {
            if ($(this).val().length >= 50) {
                $(this).val($(this).val().slice(0, 50));
                return false;
            }
        });

        function displayImage(input) {
            var reader;

            if (input.files && input.files[0]) {
                reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('preview-image').style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#update_user').submit(function (e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);
            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);

            $.ajax({
                method: 'post',
                url: '/settings/myAccount/user_update',
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Data Successfully Updated!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    top.location.href = "/settings/myAccount";
                },
                error: function (reject) {
                    $(".btn").attr("disabled", false);
                    var errors = $.parseJSON(reject.responseText);
                    $("#modal-content").addClass("modal-before");
                    $("#div-modal-loader").attr('style', 'display:block!important');
                    $.each(errors.errors, function (field, messages) {
                        $("input#" + field).css('border', '1px solid red');
                        $("span#" + field + "-msg").text(messages[0]);
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $('#changepass_form').submit(function (e) {
                e.preventDefault();
                let formData = new FormData(this);
                formData.append('_token', `{{ csrf_token() }}`);

                // Clear previous error messages
                $('#current_password-msg').text('');
                $('#password-msg').text('');
                $('#confirm-password-msg').text('');

                $.ajax({
                    url: '{{ route("user.changepass") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#changepass_btn").attr("disabled", false);
                        if (!response.success) {

                            if (response.errors.cur_password) {
                                $('#current_password-msg').text(response.errors.cur_password[0]);
                            }
                            if (response.errors.password) {
                                $('#password-msg').text(response.errors.password[0]);
                                $('#confirm-password-msg').text(response.errors.password[0]);
                            }
                        } else {
                            $("#changepass_btn").attr("disabled", false);
                            $('#changepass_modal').modal('hide');
                            $('#changepass_form')[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Password successfully changed!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            top.location.href = "/settings/myAccount";
                        }
                    },
                    error: function (reject) {
                        $("#changepass_btn").attr("disabled", false);
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function (field, messages) {
                            $("#" + field).css('border', '1px solid red');
                            $("span#" + field + "-msg").text(messages[0]);
                        });
                    }
                });
            });
        });
    </script>


@endsection
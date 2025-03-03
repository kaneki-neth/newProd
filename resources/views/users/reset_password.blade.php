<form method="POST" id="user_reset_password" autocomplete="off">
    <input type="text" class="form-control form-control-sm select2" id="user_id" name="user_id" value="{{$user->id}}" onkeyup="remove_error(this)"placeholder="..." hidden>
    <div class="row mb-2" id="div-new_password">
        <label for="new_password" class="col-sm-3 col-lg-4 col-form-label form-label">New Password</label>
        <div class="col-sm-9 col-lg-8">
            <input type="password" class="form-control form-control-sm select2" id="new_password" name="new_password" onkeyup="remove_error(this)"placeholder="...">
            <span id="new_password-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row mb-2">
        <label for="confirmed_password" class="col-sm-3 col-lg-4 col-form-label form-label">Confirmed Password </label>
        <div class="col-sm-9 col-lg-8" id="div-confirmed_password"> 
            <input type="password" class="form-control form-control-sm select2" id="confirmed_password" name="confirmed_password" onkeyup="remove_error(this)"placeholder="...">
            <span id="confirmed_password-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row justify-content-end">
        <label class="col-sm-3 col-lg-4 col-form-label form-label" for="">Reset on Login</label>
        <div class="col-sm-9 col-lg-8">
            <div class="form-check mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="reset_on_login" name="reset_on_login" checked>
                </div>
            </div>
            <div style="margin-top: 2%">
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-xs px-2 m-1" style="float: right">Close</button>
                <button type="submit" class="btn btn-primary btn-xs px-2 m-1" style="float: right">Save</button>
            </div>
        </div>
    </div>
</form>
<script src="/assets/js/jquery-3.6.4.min.js"></script>
<script>
   $(document).ready(function () {
        console.log("awawaa teststse awaawawa");
        
        function toggleConfirmedPassword() {
            const newPassword = $('#new_password').val();

            if (newPassword.trim() !== '') {
                $('#confirmed_password').prop('disabled', false);
                $('#confirmed_password-msg').text(''); 
            } else {
                $('#confirmed_password').prop('disabled', true);
                $('#confirmed_password').val('');
                $('#confirmed_password-msg').text(''); 
            }
        }
        $('#new_password').on('keyup', toggleConfirmedPassword);
        toggleConfirmedPassword();
        function comparePasswords() {
            const newPassword = $('#new_password').val(); 
            const confirmedPassword = $('#confirmed_password').val();
            if (newPassword && confirmedPassword && newPassword !== confirmedPassword) {
                $("#confirmed_password").css('border', '1px solid red');
                $('#confirmed_password-msg').text('Password do not match');
                return false;
            } else {
                $('#confirmed_password-msg').text(''); 
                return true;
            }
        }
        $('#confirmed_password').on('keyup', comparePasswords);
        $('#user_reset_password').on('submit', function (e) {
            if (!comparePasswords()) {
                e.preventDefault(); 
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Mismatch',
                    text: 'New Password and Confirmed Password do not match.',
                });
                return false;
            }
            $(".btn").attr("disabled", true);
            return true; 
        });
    });


    $('#user_reset_password').submit(function (e) {
        e.preventDefault();
        $(".btn").attr("disabled", true);

        let formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        formData.set('reset_on_login', $('#reset_on_login').is(':checked') ? 'on' : 'off');

        // $("#modal-content").addClass("modal-before");
        // $("#div-modal-loader").attr('style', 'display:block!important');

        $.ajax({
            method: 'post',
            url: '/sys_admin/user/save/save_reset_password',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                location.reload();
            },
            error: function (reject) {
                $(".btn").attr("disabled", false);
                var errors = $.parseJSON(reject.responseText);

                // $("#modal-content").removeClass("modal-before");
                // $("#div-modal-loader").attr('style', 'display:none!important');
 
                $.each(errors.errors, function (field, messages) {
                    $("#" + field).css('border', '1px solid red');
                    $("span#" + field + "-msg").text(messages[0]);
                });
            }
        });
    });
</script>
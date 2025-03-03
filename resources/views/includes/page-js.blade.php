<!-- ================== BEGIN core-js ================== -->
<script src="/assets/js/vendor.min.js"></script>
<script src="/assets/js/app.min.js"></script>


<script src="/assets/plugins/switchery/dist/switchery.min.js"></script>
<script src="/assets/plugins/abpetkov-powerange/dist/powerange.min.js"></script>
<script src="/assets/js/demo/form-slider-switcher.demo.js"></script>
<script src="/assets/plugins/@highlightjs/cdn-assets/highlight.min.js"></script>
<script src="/assets/js/demo/render.highlight.js"></script>
<!-- ================== END core-js ================== -->

<!-- ================== BEGIN page-js ================== -->
<script src="{{ asset('assets/plugins/masonry-layout/dist/masonry.pkgd.min.js') }}"></script>
<!-- ================== END page-js ================== -->

<script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
<script>

    $( document ).ready(function() {
        $(".select2").select2();

        var fullUrl = window.location.href;
        var path = window.location.pathname;

        if(path != '/login'){
            $.ajax({
                method: 'get',
                url: '{{ route("users.verify") }}',
                success: (response) => {
                   if(response == "true"){
                        $('#main_changes_pass').modal({backdrop: 'static', keyboard: false});
                        $("#main_changes_pass").modal('show');
                   }
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


        $('#changepass_form_onlogin').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);

            // Clear previous error messages
            $('#current_password_l-msg').text('');
            $('#password_l-msg').text('');
            $('#confirm-password_l-msg').text('');
            
            $.ajax({
                url: '{{ route('user.changepass.on_login') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    $("#changepass_btn_l").attr("disabled", false);
                    if(response.success == true || response.success == 'true'){
                        $("#changepass_btn_l").attr("disabled", false);
                        $('#main_changes_pass').modal('hide');
                        $('#changepass_form_onlogin')[0].reset();
                        location.reload();
                    }else{
                        if (response.errors.cur_password) {
                            $('#current_password-msg').text(response.errors.cur_password[0]);
                        }
                        if (response.errors.password) {
                            $('#password-msg').text(response.errors.password[0]);
                            $('#confirm-password-msg').text(response.errors.password[0]);
                        }
                    }
                },
                error: function (reject) {
                    $("#changepass_btn").attr("disabled", false);
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function(field, messages) {
                        $("#" + field).css('border', '1px solid red');
                        $("span#" + field + "-msg").text(messages[0]);
                    });
                }
            });
        });

        
    });

    function remove_error(e){
        var _id = $(e).attr('id');
        $("#" + _id).css('border', '1px solid gray');
        $("#" + _id + "-msg").text('');
    }
</script>
@stack('scripts')
<form method="POST" id="add_lookup" autocomplete="off">

    <div class="row" >
        <label for="type" class="col-sm-3 col-form-label form-label">Type <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" oninput="convertToUpperCase(this)" id="type" name="type" onkeyup="remove_error(this)" placeholder="...">
            <span id="type-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row">
        <label for="code" class="col-sm-3 col-form-label form-label">Code <span class="text-danger">*</span></label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" oninput="convertToUpperCase(this)" id="code" name="code" onkeyup="remove_error(this)" placeholder="...">
            <span id="code-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row">
        <label for="meaning" class="col-sm-3 col-form-label form-label">Meaning</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" name="meaning" id="meaning" onkeyup="remove_error(this)"placeholder="...">
            <span id="meaning-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row mb-1">
        <label for="tag" class="col-sm-3 col-form-label form-label">Tag</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" name="tag" id="tag" onkeyup="remove_error(this)"placeholder="...">
            <span id="tag-msg" class="text-danger"></span>
        </div>
    </div>


    <div class="row justify-content-end">
        <div class="col-sm-9">

            <div class="form-check mb-4" style="padding-left: 0;">
                <div class="form-check form-switch">
                    <input class="form-check-input form-check-sm" type="checkbox" name="enable" id="enable" checked>
                    <label class="form-check-label" for="">Enabled</label>
                </div>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-xs m-1">Save</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-xs px-2 m-1">Cancel</button>
            </div>
        </div>
    </div>
</form>

<script>
        $('#type').keypress(function() {
            if($(this).val().length >= 30) {
                $(this).val($(this).val().slice(0, 30));
                return false;
            }
        });
        
        $('#code').keypress(function() {
            if($(this).val().length >= 20) {
                $(this).val($(this).val().slice(0, 20));
                return false;
            }
        });

        $('#meaning').keypress(function() {
            if($(this).val().length >= 30) {
                $(this).val($(this).val().slice(0, 30));
                return false;
            }
        });

        $('#tag').keypress(function() {
            if($(this).val().length >= 100) {
                $(this).val($(this).val().slice(0, 100));
                return false;
            }
        });
    
    function convertToUpperCase(element) {
        element.value = element.value.toUpperCase();
    }

    $('#add_lookup').submit(function(e) {
        e.preventDefault();

        $(".btn").attr("disabled", false);

        
        let formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        formData.set('enable', $('#enable').is(':checked') ? 'on' : 'off');

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');
        
        $.ajax({
            method: 'post',
            url: '/app/app_lookup/store',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                Swal.fire({
                    icon: 'success',
                    title: 'Data successfully created!',
                    showConfirmButton: false,
                    timer: 1500
                })
                top.location.href = "/app/app_lookup";
            }, error: function (reject) {
                $(".btn").attr("disabled", false);
                var errors = $.parseJSON(reject.responseText);
                $("#modal-content").removeClass("modal-before");
                $("#div-modal-loader").attr('style', 'display:none!important');
                $.each(errors.errors, function (field, messages) {
                    $("#" + field).css('border', '1px solid red');
                    $("span#" + field + "-msg").text(messages[0]);
                });
            }
        });
    });

</script>
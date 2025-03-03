<form method="POST" id="update_lookup" autocomplete="off">

    <div class="row">
        <label for="lookup_type" class="col-sm-3 col-form-label form-label">Type</label>
        <div class="col-sm-9 mt-3">
            <b>{{$lookups->lookup_type}}</b>
        </div>
    </div>

    <div class="row">
        <label for="lookup_code" class="col-sm-3 col-form-label form-label">Code</label>
        <div class="col-sm-9 mt-2">
            <b>{{$lookups->lookup_code}}</b>
        </div>
    </div>

    <div class="row">
        <label for="meaning" class="col-sm-3 col-form-label form-label">Meaning</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" id="meaning" name="meaning" value="{{$lookups->meaning}}" onkeyup="remove_error(this)"placeholder="...">
            <span id="meaning-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row mb-1">
        <label for="tag" class="col-sm-3 col-form-label form-label">Tag</label>
        <div class="col-sm-9">
            <input type="text" class="form-control form-control-sm" id="tag" name="tag" value="{{$lookups->tag}}" onkeyup="remove_error(this)"placeholder="...">
            <span id="tag-msg" class="text-danger"></span>
        </div>
    </div>

    <div class="row justify-content-end">
        <div class="col-sm-9">

            <div class="form-check mb-4" style="padding-left: 0;">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled" <?php if($lookups->enabled === 1){echo "checked";}?>>
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
    $(function() {

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


        $('#update_lookup').submit(function(e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);
            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);
            var enabled;
            if ($('#enabled').is(':checked')) {
                enabled = 1;
            } else {
                enabled = 0;
            }

            formData.append('_enabled', enabled);
            formData.append('_lookup_code', `{{$lookups->lookup_code}}`);

            $("#modal-content").addClass("modal-before");
            $("#div-modal-loader").attr('style', 'display:block!important');

            $.ajax({
                method: 'post',
                url: '/app/app_lookup/store_update',
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
                top.location.href = "/app/app_lookup";
                }, error: function(reject){
                
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
    });
</script>
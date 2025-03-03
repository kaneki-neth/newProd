<form id="form-company-business-unit" autocomplete="off">
    <div class="row p-1">
        <div class="col-12">

            <div class="row">
                <label class="form-label col-form-label col-md-3">BU Code <span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                    <input onkeyup="remove_error(this)" type="text" name="bu_code" id="bu_code" value="" class="form-control form-control-sm mb-5px" placeholder="BU Code">
                    <span id="bu_code-msg" class="text-danger" style="left: 19px; position: absolute; bottom: 2px; background: white; line-height: 9px; "></span>
                </div>
            </div>
            
            <div class="row">
                <label class="form-label col-form-label col-md-3"> BU Name<span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                <input onkeyup="remove_error(this)" type="text" id="bu_name" name="bu_name" value="" class="form-control form-control-sm mb-5px" placeholder="BU Name">
                <span id="bu_name-msg" class="text-danger" style="left: 19px; position: absolute; bottom: 2px; background: white; line-height: 9px; "></span>
                </div>
            </div>

            <div class="row">
                <label class="form-label col-form-label col-md-3">Telephone Number</label>
                <div class="col-md-9" >
                <input type="text" id="bu_tel_num" name="bu_tel_num" value="" class="form-control form-control-sm mb-5px" placeholder="Telephone Number">
                </div>
            </div>

            <div class="row">
                <label class="form-label col-form-label col-md-3">Address 1 <span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                <input onkeyup="remove_error(this)" type="text" id="bu_address_line1" name="bu_address_line1" value="" class="form-control form-control-sm mb-5px" placeholder="Address 1">
                <span id="bu_address_line1-msg" class="text-danger " style="left: 19px; position: absolute; bottom: 2px; background: white; line-height: 9px; "></span>
                </div>
            </div>

            <div class="row">
                <label class="form-label col-form-label col-md-3">Address 2</label>
                <div class="col-md-9">
                <input type="text" id="bu_address_line2" name="bu_address_line2" value="" class="form-control form-control-sm mb-5px" placeholder="Address 2">
                </div>
            </div>

            <div class="row">
                <label class="form-label col-form-label col-md-3">City <span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                <input onkeyup="remove_error(this)" type="text" id="bu_city" name="bu_city" value="" class="form-control form-control-sm mb-5px" placeholder="City">
                <span id="bu_city-msg" class="text-danger" style="left: 19px; position: absolute; bottom: 2px; background: white; line-height: 9px; "></span>
                </div>
            </div>

            <div class="row">
                <label class="form-label col-form-label col-md-3">Province <span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                <input onkeyup="remove_error(this)" type="text" id="bu_province" name="bu_province" value="" class="form-control form-control-sm mb-5px" placeholder="Province">
                <span id="bu_province-msg" class="text-danger" style="left: 19px; position: absolute; bottom: 2px; background: white; line-height: 9px; "></span>
                </div>
            </div>  

            <div class="row">       
                <label class="form-label col-form-label col-md-3">Postal Code <span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                <input onkeyup="remove_error(this)" type="text" id="bu_postal_code" name="bu_postal_code" value="" class="form-control form-control-sm mb-5px" placeholder="Postal Code">
                <span id="bu_postal_code-msg" class="text-danger"></span>
                </div>
            </div>
            <div class="row">
                <label class="form-label col-form-label col-md-3">Country <span style="color:red">*</span></label>
                <div class="col-md-9" style="position:relative">
                <input onkeyup="remove_error(this)" type="text" id="bu_country" name="bu_country" value="" class="form-control form-control-sm mb-5px" placeholder="Country">
                <span id="bu_country-msg" class="text-danger " style="left: 19px; position: absolute; bottom: 2px; background: white; line-height: 9px; "></span>
                </div>
            </div>

            <div class="row mt-4">
                <label class="form-label col-form-label col-md-3">&nbsp;</label>
                <div class="col-md-9">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="enabled" name="enabled" checked>
                        <label class="form-check-label" for="">Enabled</label>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-primary btn-xs px-4" > SAVE</button>
        </div>

    </div>
</form>

<script>

    $('#bu_code').keypress(function() {
        if($(this).val().length >= 5) {
            $(this).val($(this).val().slice(0,5));
            return false;
        }
    });

    $('#bu_name').keypress(function() {
        if($(this).val().length >= 30) {
            $(this).val($(this).val().slice(0, 30));
            return false;
        }
    });

    $('#bu_tel_num').keypress(function() {
        if($(this).val().length >= 50) {
            $(this).val($(this).val().slice(0, 50));
            return false;
        }
    });

    $('#bu_address_line1').keypress(function() {
        if($(this).val().length >= 50) {
            $(this).val($(this).val().slice(0, 50));
            return false;
        }
    });

    $('#bu_address_line2').keypress(function() {
        if($(this).val().length >= 50) {
            $(this).val($(this).val().slice(0, 50));
            return false;
        }
    });

    $('#bu_city').keypress(function() {
        if($(this).val().length >= 50) {
            $(this).val($(this).val().slice(0, 50));
            return false;
        }
    });

    $('#bu_province').keypress(function() {
        if($(this).val().length >= 30) {
            $(this).val($(this).val().slice(0, 30));
            return false;
        }
    });

    $('#bu_postal_code').keypress(function() {
        if($(this).val().length >= 10) {
            $(this).val($(this).val().slice(0, 10));
            return false;
        }
    });

    $('#bu_country').keypress(function() {
        if($(this).val().length >= 2) {
            $(this).val($(this).val().slice(0, 2));
            return false;
        }
    });


    $('#form-company-business-unit').submit(function(e) {
            e.preventDefault();
			$(".btn").attr("disabled", true);
            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);
            formData.set('enabled', $('#enabled').is(':checked') ? 1 : 0);
            $.ajax({
                method: 'post',
                url: '/settings/company/bu/create',
                data: formData,
                contentType: false,
                processData: false,
                success: (response) => { 
                    location.reload();
                },
                error: function(reject){
                    $(".btn").attr("disabled", false);
                    var errors = $.parseJSON(reject.responseText);
                    $.each(errors.errors, function (field, messages) {
                        // Highlight the form field with an error
                        $("input#" + field).css('border', '1px solid red');
                        // Display the first error message
                        $("span#" + field + "-msg").text(messages[0]);
                    });

                }
            });
        });
</script>
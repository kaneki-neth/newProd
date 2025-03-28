<style>
    .add_modal_form {
        max-height: 400px;
        overflow-y: auto;
        overflow-x: hidden;
        padding-right: 15px;
    }

    ::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 7px;
    }

    ::-webkit-scrollbar-thumb {
        border-radius: 4px;
        background-color: rgba(0, 0, 0, .5);
        -webkit-box-shadow: 0 0 1px rgba(255, 255, 255, .5);
    }

    .error-msg {
        position: relative;
        top: -5px;
        background-color: white;
    }
</style>


<form method="POST" id="add_category" autocomplete="off">
    <div class="row">
        <label for="name" class="col-sm-4 col-form-label form-label">Name <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="...">
            <span id="name-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="description" class="col-sm-4 col-form-label form-label">Description <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="description" name="description"
                placeholder="...">
            <span id="description-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="daily_rate" class="col-sm-4 col-form-label form-label">Daily Rate <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="daily_rate" name="daily_rate"
                placeholder="...">
            <span id="daily_rate-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="hourly_rate" class="col-sm-4 col-form-label form-label">Hourly Rate <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="hourly_rate" name="hourly_rate"
                placeholder="...">
            <span id="hourly_rate-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="max_occupancy" class="col-sm-4 col-form-label form-label">Max Occupancy <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="max_occupancy" name="max_occupancy"
                placeholder="...">
            <span id="max_occupancy-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="enabled" class="col-sm-4 col-form-label form-label">Enabled</label>
        <div class="col-sm-8">
            <div class="form-check form-switch align-middle">
                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" checked>
            </div>
        </div>
    </div>
    <div class="mt-2 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary btn-xs m-1">Save</button>
        <button type="button" data-bs-dismiss="modal" class="btn btn-secondary btn-xs px-2 m-1">Cancel</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        ['#name', '#description', '#daily_rate', '#hourly_rate', '#max_occupancy'].forEach(function (selector) {
            $(selector).keypress(function () {
                if ($(this).val().length >= 50) {
                    $(this).val($(this).val().slice(0, 50));
                    return false;
                }
            }).keyup(function (e) {
                if (e.keyCode === 13) return;
                remove_error(this);
            });
        });
    });

    $('#add_category').submit(function (e) {
        e.preventDefault();
        $(".btn").attr("disabled", false);
        let formData = new FormData(this);

        formData.append('_token', '{{ csrf_token() }}');
        formData.set('enabled', $('#enabled').is(':checked') ? 1 : 0);

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        $.ajax({
            method: 'post',
            url: '{{ route("categories.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                location.reload();
            },
            error: function (xhr, status, error) {
                $(".btn").attr("disabled", false);
                $("#modal-content").removeClass("modal-before");
                $("#div-modal-loader").attr('style', 'display:none!important');
                if (xhr.status === 400) {
                    const errors = xhr.responseJSON.errors;
                    $("input").css('border', '');
                    $(".error-msg").text('');
                    Object.keys(errors).forEach(field => {
                        $(`#${field}`).css('border', '1px solid red');
                        $(`#${field}-msg`).text(errors[field]);
                    });
                }
            }
        });
    });

    // Add proper modal cleanup when the modal is hidden
    $('#main_modal').on('hidden.bs.modal', function () {
        // Reset the form
        $('#add_category')[0].reset();

        // Clear error messages and styling
        $("input").css('border', '');
        $(".error-msg").text('');

        // Remove modal states
        $("#modal-content").removeClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:none!important');
    });
</script>
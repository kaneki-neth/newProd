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


<form method="POST" id="add_charges_item" autocomplete="off">

    <div class="row">
        <div class="row">
            <label for="name" class="col-sm-4 col-form-label form-label">Name <span class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="...">
                <span id="name-msg" class="error-msg text-danger"></span>
            </div>
        </div>
        <div class="row">
            <label for="description" class="col-sm-4 col-form-label form-label">Description</label>
            <div class="col-sm-8">
                <input type="text" class="form-control form-control-sm" id="description" name="description"
                    placeholder="...">
                <span id="description-msg" class="error-msg text-danger"></span>
            </div>
        </div>
        <div class="row mt-1">
            <label for="amount" class="col-sm-4 col-form-label form-label">Amount <span
                    class="text-danger">*</span></label>
            <div class="col-sm-8">
                <input type="number" class="form-control form-control-sm" id="amount" name="amount" placeholder="...">
                <span id="amount-msg" class="error-msg text-danger"></span>
            </div>
        </div>
        <div class="row mt-1">
            <label for="enabled" class="col-sm-4 col-form-label form-label">Enabled</label>
            <div class="col-sm-8">
                <div class="form-check form-switch align-middle mt-1">
                    <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" checked>
                </div>
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
        ['#name', '#amount', '#description'].forEach(function (selector) {
            $(selector).keyup(function (e) {
                if (e.keyCode === 13) return;
                remove_error(this);
            });
        });
    });

    $('#add_charges_item').submit(function (e) {
        e.preventDefault();

        $(".btn").attr("disabled", false);

        let formData = new FormData(this);
        formData.append('enabled', $('#enabled').is(':checked') ? 1 : 0);
        formData.append('_token', '{{ csrf_token() }}');

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        $.ajax({
            method: 'post',
            url: '{{ route("charges_items.store") }}',
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
</script>
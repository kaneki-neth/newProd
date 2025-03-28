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

<form method="POST" id="edit_amenity_item" autocomplete="off">
    <div class="row">
        <label for="type" class="col-sm-4 col-form-label form-label">Name <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="name" name="name" onkeyup="remove_error(this)"
                value="{{ $amenity_item->name }}">
            <span id="name-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="description" class="col-sm-4 col-form-label form-label">Description <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="description" name="description"
                onkeyup="remove_error(this)" value="{{ $amenity_item->description }}">
            <span id="description-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="price" class="col-sm-4 col-form-label form-label">Price <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="price" name="price"
                onkeyup="remove_error(this)" value="{{ $amenity_item->price }}">
            <span id="price-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="quantity" class="col-sm-4 col-form-label form-label">Quantity <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="quantity" name="quantity"
                onkeyup="remove_error(this)" value="{{ $amenity_item->quantity }}">
            <span id="quantity-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="enabled" class="col-sm-4 col-form-label form-label">Enabled</label>
        <div class="col-sm-8">
            <div class="form-check form-switch align-middle">
                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" {{ $amenity_item->enabled == 1 ? 'checked' : '' }}>
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
        ['#name', '#description', '#price', '#quantity'].forEach(function (selector) {
            $(selector).keyup(function (e) {
                if (e.keyCode === 13) return;
                remove_error(this);
            });
        });
    });

    $('#edit_amenity_item').submit(function (e) {
        e.preventDefault();
        $(".btn").attr("disabled", true);
        let formData = new FormData(this);

        formData.append('_token', `{{ csrf_token() }}`);
        formData.append('enabled', $('#enabled').is(':checked') ? 1 : 0);

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        let url = "/amenity-items/update/" + {{ $amenity_item->ai_id }};
        $.ajax({
            method: 'post',
            url: url,
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
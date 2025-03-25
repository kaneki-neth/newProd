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

    .select2-container {
        width: 100%;
    }

    .custom-input {
        height: 30px;
    }

    .select2-dropdown {
        z-index: 1056 !important;
    }
</style>


<form method="POST" id="add_room" autocomplete="off">
    <div class="row">
        <label for="room_number" class="col-sm-4 col-form-label form-label">Room Number <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="room_number" name="room_number"
                placeholder="...">
            <span id="room_number-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="floor_number" class="col-sm-4 col-form-label form-label">Floor Number <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="number" class="form-control form-control-sm" id="floor_number" name="floor_number"
                placeholder="...">
            <span id="floor_number-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="room_type" class="col-sm-4 col-form-label form-label">Room Type <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select class="form-control select2" id="room_type" name="room_type" placeholder="..." autocomplete="off">
                <option value="" selected disabled>Select Room Type</option>
                @foreach ($room_types as $room_type)
                    <option value="{{ $room_type->rt_id }}">{{ $room_type->name }}</option>
                @endforeach
            </select>
            <span id="room_type-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="status" class="col-sm-4 col-form-label form-label">Status <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="status" name="status" placeholder="...">
            <span id="status-msg" class="error-msg text-danger"></span>
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
        $('#room_type').select2();

        $('#room_number, #floor_number, #room_type, #status').on('keyup change', function (e) {
            if (e.keyCode === 13) return;
            remove_error(this);
        });
    });

    function remove_error(element) {
        $(element).css('border', '');
        $(`#${element.id}-msg`).text('');
    }

    $('#add_room').submit(function (e) {
        e.preventDefault();
        $(".btn").attr("disabled", false);
        let formData = new FormData(this);

        formData.append('_token', '{{ csrf_token() }}');
        formData.set('enabled', $('#enabled').is(':checked') ? 1 : 0);

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        $.ajax({
            method: 'post',
            url: '{{ route("rooms.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log("AJAX error response:", xhr);
                $(".btn").attr("disabled", false);
                $("#modal-content").removeClass("modal-before");
                $("#div-modal-loader").attr('style', 'display:none!important');
                if (xhr.status === 400) {
                    const errors = xhr.responseJSON.errors;
                    $("input, select").css('border', '');
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
        $('#add_room')[0].reset();

        // Clear error messages and styling
        $("input").css('border', '');
        $(".error-msg").text('');

        // Remove modal states
        $("#modal-content").removeClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:none!important');
    });
</script>
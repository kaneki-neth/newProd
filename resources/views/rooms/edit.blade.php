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

<form method="POST" id="edit_room" autocomplete="off">
    <div class="row">
        <label for="room_number" class="col-sm-4 col-form-label form-label">Room Number <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="room_number" name="room_number"
                onkeyup="remove_error(this)" value="{{ $room->room_number }}">
            <span id="room_number-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="floor_number" class="col-sm-4 col-form-label form-label">Floor Number <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="floor_number" name="floor_number"
                onkeyup="remove_error(this)" value="{{ $room->floor_number }}">
            <span id="floor_number-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="room_type" class="col-sm-4 col-form-label form-label">Room Type <span
                class="text-danger">*</span></label>
        <div class="col-sm-8">
            <select class="form-control form-control-sm select2" id="room_type" name="room_type"
                onkeyup="remove_error(this)">
                @foreach ($room_types as $room_type)
                    @if ($room_type->rt_id == $room->rt_id)
                        <option value="{{ $room_type->rt_id }}" selected>{{ $room_type->name }}</option>
                    @else
                        <option value="{{ $room_type->rt_id }}">{{ $room_type->name }}</option>
                    @endif
                @endforeach
            </select>
            <span id="room_type-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="status" class="col-sm-4 col-form-label form-label">Status <span class="text-danger">*</span></label>
        <div class="col-sm-8">
            <input type="text" class="form-control form-control-sm" id="status" name="status"
                onkeyup="remove_error(this)" value="{{ $room->status }}">
            <span id="status-msg" class="error-msg text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="enabled" class="col-sm-4 col-form-label form-label">Enabled</label>
        <div class="col-sm-8">
            <div class="form-check form-switch align-middle">
                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" {{ $room->enabled == 1 ? 'checked' : '' }}>
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
    });

    $('#edit_room').submit(function (e) {
        e.preventDefault();
        $(".btn").attr("disabled", true);
        let formData = new FormData(this);

        formData.append('_token', `{{ csrf_token() }}`);
        formData.append('enabled', $('#enabled').is(':checked') ? 1 : 0);

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        let url = '{{ route("rooms.update", ["id" => ":id"]) }}';
        url = url.replace(':id', {{ $room->r_id }});
        $.ajax({
            method: 'post',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                location.reload();
            },
            error: function (reject) {
                $(".btn").attr("disabled", false);
                $("#modal-content").removeClass("modal-before");
                $("#div-modal-loader").attr('style', 'display:none!important');
                if (reject.status === 400) {
                    $("#room_number").css('border', '1px solid red');
                    $("#room_number-msg").text(reject.responseJSON.errors.room_number);
                }
            }
        });
    });
</script>
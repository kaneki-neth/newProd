<style>
    span.select2-selection.select2-selection--single {
        height: 30px !important;
    }

    .update_modal_form {
        max-height: 350px;
        overflow-y: auto;

        padding-right: 15px;
    }

    .table-update-wrapper {
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
        height: 320px;
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

    #trash-icon {
        color: red;
        font-size: 17px;
        text-align: left;
    }

    #icon-td {
        padding-left: 0;
    }
</style>

<form method="POST" id="update_charges_items" autocomplete="off">

    <div class="row">
        <label for="type" class="col-sm-4 col-form-label form-label">Name</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-sm" id="name" value="{{$charges_item->name}}"
                name="name" onkeyup="remove_error(this)" placeholder="...">
            <span id="name-msg" class="text-danger"></span>
        </div>
    </div>
    <div class="row">
        <label for="description" class="col-sm-4 col-form-label form-label">Description</label>
        <div class="col-sm-7">
            <input type="text" class="form-control form-control-sm" id="description"
                value="{{$charges_item->description}}" name="description" onkeyup="remove_error(this)"
                placeholder="...">
            <span id="description-msg" class="text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="amount" class="col-sm-4 col-form-label form-label">Amount</label>
        <div class="col-sm-7">
            <input type="number" class="form-control form-control-sm" id="amount" value="{{$charges_item->amount}}"
                name="amount" onkeyup="remove_error(this)" placeholder="...">
            <span id="amount-msg" class="text-danger"></span>
        </div>
    </div>
    <div class="row mt-1">
        <label for="enabled" class="col-sm-4 col-form-label form-label">Enabled</label>
        <div class="col-sm-8">
            <div class="form-check form-switch align-middle mt-1">
                <input class="form-check-input" type="checkbox" id="enabled" name="enabled" value="1" {{ $charges_item->enabled == 1 ? 'checked' : '' }}>
            </div>
        </div>
    </div>
    <div class="mt-3 d-flex justify-content-end">
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

    $('#update_charges_items').submit(function (e) {
        e.preventDefault();
        $(".btn").attr("disabled", true);
        let formData = new FormData(this);

        formData.append('enabled', $('#enabled').is(':checked') ? 1 : 0);
        formData.append('_token', `{{ csrf_token() }}`);

        $("#modal-content").addClass("modal-before");
        $("#div-modal-loader").attr('style', 'display:block!important');

        $.ajax({
            method: 'post',
            url: '{{ route('charges_items.update', ['id' => $charges_item->ci_id]) }}',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                location.reload();
            }, error: function (xhr, status, error) {
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
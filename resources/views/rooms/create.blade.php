@extends('layouts.app')

@section('title', 'Add Video')

@section('content')
    <style>
        html,
        body {
            overflow-x: hidden;
        }

        .custom-input {
            height: 30px;
        }

        .form-control {
            height: 30px;
        }


        .error-msg {
            position: relative;
            top: -5px;
            background-color: white;
        }

        .error-msg#description-msg {
            position: relative;
            background-color: white;
            top: 0px;
        }

        .error-msg#mainImagePreview {
            position: relative;
            background-color: white;
            top: 0px !important;
        }

        .error-input {
            border: 1px solid red !important;
        }
    </style>
    <link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}">Rooms</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Room</a></li>
    </ol>
    <h1 class="page-header">Room (Add)</h1>

    <!-- make new -->

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-start gap-2">
                    <a href="/rooms" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>
            <div class="row mt-3 g-0" style="margin: 0px;">
                <!-- diri content sa left -->
                <div class="col-8">
                    <div class="row">
                        <!-- Room NUmber -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Room Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="title" placeholder="...">
                            <span class="error-message" style="color: red;"></span>
                        </div>

                        <!-- Floor Number -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Floor Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="title" placeholder="...">
                            <span class="error-message" style="color: red;"></span>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label for="title" class="form-label">Status <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" name="title" placeholder="...">
                            <span class="error-message" style="color: red;"></span>
                        </div>

                        <!-- Room Type -->
                        <div class="col-12 mt-3">
                            <label for="description" class="form-label">Room Type <span class="text-danger">*</span></label>
                            <span id="description-msg" class="error-msg text-danger"></span>
                            <select id="form-select select2-selection select2-container select2" class="border"
                                style="border-radius: 4px">
                                @foreach($room_types as $room_type)
                                    <option value="{{ $room_type->rt_id }}">{{ $room_type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 d-flex justify-content-start mt-3">
                            <button class="btn btn-primary btn-xs" onclick="submitData()">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="/assets/plugins/summernote/dist/summernote-lite.min.js"></script>

    <script>
        $('#rooms').addClass('active');
        $("#pannel-body").attr("style", 'height: 78vh;');
        $(document).ready(function () {

            // Clear error message and remove is-invalid class when input changes
            $("input").on("input", function () {
                $(this).next(".error-message").text("");
                $(this).removeClass("is-invalid");
            });
        });

        function submitData() {
            showLoading();
            let formData = new FormData();

            formData.append('room_number', document.querySelector('input[name="room_number"]').value);
            formData.append('floor_number', document.querySelector('input[name="floor_number"]').value);
            formData.append('status', document.querySelector('input[name="status"]').value);
            formData.append('room_type', document.querySelector('textarea[name="room_type"]').value);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('rooms.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 400) {
                        const errors = xhr.responseJSON.errors;
                        console.log(errors);
                        Object.keys(errors).forEach(field => {
                            const errorMessage = errors[field][0];
                            const inputField = $(`[name="${field}"]`);

                            for (const key in errors) {
                                if (Object.hasOwnProperty.call(errors, key)) {
                                    const element = errors[key];
                                    let $input_id = key;

                                    $("#" + $input_id).addClass('error-input')
                                        .on('keyup change', function () {
                                            rm_error(this);
                                        });
                                    $('#' + key + '-msg').text(element[0]);

                                    Swal.close()
                                }
                            }

                            if (inputField.hasClass('select2')) {
                                // Handle Select2 fields
                                inputField.next('.select2-container')
                                    .find('.select2-selection')
                                    .addClass('is-invalid');
                            } else {
                                // Handle regular inputs
                                inputField.addClass('is-invalid');
                            }

                            // Display error message
                            const errorSpan = inputField.siblings('.error-message');
                            if (errorSpan.length) {
                                errorSpan.text(errorMessage);
                            } else {
                                // For select2, add error message after the select2 container
                                if (inputField.hasClass('select2')) {
                                    inputField.next('.select2-container').after(`<span class="error-message">${errorMessage}</span>`);
                                } else {
                                    // inputField.after(`<span class="error-message">${errorMessage}</span>`);
                                }
                            }
                        });
                    }
                    swal.close();
                }
            });
        }
    </script>
@endsection
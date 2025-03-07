@extends('layouts.app')

@section('title', 'Add Video')

@section('content')
    <style>
        html,
        body {
            overflow-x: hidden;
        }

        .dropzone-container {
            width: 100%;
            max-width: 300px;
            /* Adjust as needed */
            aspect-ratio: 1 / 1;
            /* Maintain square aspect ratio */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: clamp(10px, 2.5vw, 15px);
            /* Makes text responsive */
            padding: 10px;
        }

        .dropzone {
            width: 100%;
            height: 100%;
            min-height: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    </style>
    <link href="../assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
    <link href="../assets/plugins/dropzone/dist/min/dropzone.min.css" rel="stylesheet" />
    <script src="../assets/plugins/dropzone/dist/min/dropzone.min.js"></script>

    <link href="../assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('videos.index') }}">Videos</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Add Video</a></li>
    </ol>
    <h1 class="page-header">Add Video</h1>

    <!-- make new -->

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body" style="padding: 65px !important;">
            <div class="row mb-3 g-0" style="margin: 0px;">
                <!-- diri content sa left -->
                <div class="col-8">
                    <!-- initial text inputs: name, code, category, year -->
                    <form action="/videos/store" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-xs" name="title" placeholder="...">
                                <span class="error-message" style="color: red;"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input class="form-control" id="datepicker-autoClose" name="date"
                                        value="{{ now()->format('Y-m-d') }}">
                                    <span class="error-message" style="color: red;"></span>
                                </div>
                            </div>
                            <!-- description module here -->
                            <div class="col-mt-6">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <div class="border" style="border-radius: 4px">
                                    <textarea class="textarea form-control" name="description" id="summernote"
                                        placeholder="Enter text ..." rows="12"></textarea>
                                    <span class="error-message" style="color: red;"></span>
                                </div>
                            </div>
                            <!-- other details -->
                            <div class="row">
                                <div class="col-12 mt-3">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-primary btn-md" style="margin: 10px;" onclick="submitData()">
                            <i class=" fa fa-plus"></i> Submit
                        </button>
                    </div>
                </div>
                <div class="col-4 d-flex align-items-end flex-column">
                    <!-- show image content -->
                    <div class="col-9 dropzone-container" style="margin-left: auto">
                        <!-- main/big image -->
                        <div style=" aspect-ratio: 1 / 1;">
                            <div id="dropzone">
                                <form action="/videos/store" class="dropzone needsclick" id="dropzoneVideo" name="video">
                                    @csrf
                                    <div class="dz-message needsclick">
                                        Drop file <b>here</b> or <b>click</b> to upload.<br />
                                    </div>
                                </form>
                                <span class="error-message" style="color: red;"></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="../assets/plugins/summernote/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#datepicker-autoClose").datepicker({
                todayHighlight: true,
                autoclose: true
            });


        });
        Dropzone.options.dropzoneVideo = {
            paramName: "video",
            acceptedFiles: "video/mp4,video/mov,video/avi,video/wmv",
            maxFiles: 1,
            maxFilesize: 100,
            dictInvalidFileType: "Only video files are allowed!",
            dictFileTooBig: "File is too large! Max size: 100MB",
            autoProcessQueue: false,
            init: function () {
                window.dropzoneInstance = this;
            }
        };


        function submitData() {
            let formData = new FormData();

            if (dropzoneInstance.files[0]) {
                formData.append('video', dropzoneInstance.files[0]);
            }

            formData.append('title', document.querySelector('input[name="title"]').value);
            formData.append('date', document.querySelector('input[name="date"]').value);
            formData.append('description', document.querySelector('textarea[name="description"]').value);
            console.log(formData);

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('videos.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    // Handle success - maybe redirect or show success message
                    window.location.href = "{{ route('videos.index') }}";
                },
                error: function (xhr) {
                    if (xhr.status === 400) {
                        const errors = xhr.responseJSON.errors;
                        console.log(errors);
                        Object.keys(errors).forEach(field => {
                            const errorMessage = errors[field][0];
                            const inputField = $(`[name="${field}"]`);

                            if (inputField.hasClass('select2')) {
                                // Handle Select2 fields
                                inputField.next('.select2-container')
                                    .find('.select2-selection--multiple')
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
                                    inputField.after(`<span class="error-message">${errorMessage}</span>`);
                                }
                            }
                        });
                    }
                }
            });
        }

        $('#summernote').summernote({
            placeholder: 'Enter description',
            height: "300",
            maximumImageFileSize: 102400, // 100MB
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    </script>
@endsection
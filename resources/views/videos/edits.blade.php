@extends('layouts.app')

@section('title', 'Add Video')

@section('content')
    <style>
        html,
        body {
            overflow-x: hidden;
        }
    </style>
    <link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
    <link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />

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
                    <form action="/videos/update/{{ $video->v_id }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-xs" name="title" placeholder="..."
                                    value="{{ $video->title }}">
                                <span class="error-message" style="color: red;"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                    <input class="form-control" id="datepicker-autoClose" name="date"
                                        value="{{ $video->date}}">
                                    <span class="error-message" style="color: red;"></span>
                                </div>
                                <div class="col-md-6">
                                    <label for="video_url" class="form-label">Video URL <span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" name="video_url" id="urlInput"
                                        placeholder="Paste video URL here" value="{{ $video->video_url }}"
                                        onchange="fetchThumbnail()">
                                    <span class="error-message" style="color: red;"></span>
                                </div>
                            </div>
                            <!-- description module here -->
                            <div class="col-mt-6">
                                <label for="description" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <div class="border" style="border-radius: 4px">
                                    <textarea class="textarea form-control" name="description" id="summernote"
                                        placeholder="Enter text ..."
                                        rows="12">{!! strip_tags($video->description, '<p><a><b><i><u><strong><em><ul><ol><li><img>') !!}</textarea>
                                    <span class="error-message" id="descriptionError" style="color: red;"></span>
                                </div>
                            </div>
                            <!-- other details -->
                            <div class="row">
                                <div class="col-6 mt-3">
                                    <div class="d-flex justify-content-start">
                                        <button class="btn btn-primary btn-md" style="margin: 10px;" onclick="submitData()">
                                            Update
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6 mt-3">
                                    <div class="d-flex justify-content-end">
                                        <label for="status" class=" form-label">Enabled </label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="status" name="status"
                                                value="1" @checked($video->status == 1)>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-4 d-flex align-items-end flex-column">
                    <!-- show image content -->
                    <div class="col-9 thumbnail-container" style="margin-left: auto">
                        <!-- main/big image -->
                        <div style="aspect-ratio: 16 / 9; width: 100%; margin-bottom: 20px;">
                            <div id="thumbnail" class="d-flex justify-content-center align-items-center border rounded"
                                style="height: 100%;">
                                <img id="thumbnailPreview" src=""
                                    style="max-width: 100%; max-height: 100%; object-fit: cover; display: none; cursor: pointer;"
                                    onclick="openVideoUrl()" />
                                <div id="thumbnailPlaceholder" class="text-center text-muted">
                                    <i class="fa fa-image fa-3x mb-2"></i>
                                    <p>Video thumbnail will appear here</p>
                                </div>
                            </div>
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
        // Initialize datepicker
        $("#datepicker-autoClose").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: "auto",
            clearBtn: true,
            // Ensure the datepicker opens when clicking the input
            showOnFocus: true
        });
        $(document).ready(function () {

            // Clear error message and remove is-invalid class when input changes
            $("input").on("input", function () {
                $(this).next(".error-message").text("");
                $(this).removeClass("is-invalid");
            });

            $("textarea").on("change", function () {
                $(this).next(".error-message").text("");
                $(this).removeClass("is-invalid");
            });
        });

        function fetchThumbnail() {
            const urlInput = document.getElementById("urlInput");
            const thumbnailPreview = document.getElementById("thumbnailPreview");
            const thumbnailPlaceholder = document.getElementById("thumbnailPlaceholder");

            let url = urlInput.value.trim();
            if (!url) {
                thumbnailPreview.style.display = "none";
                thumbnailPlaceholder.style.display = "block";
                return;
            }

            // Show loading state
            thumbnailPlaceholder.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

            fetch(`/get-thumbnail?url=${encodeURIComponent(url)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.thumbnail) {
                        thumbnailPreview.src = data.thumbnail;
                        thumbnailPreview.style.display = "block";
                        thumbnailPlaceholder.style.display = "none";
                    } else {
                        thumbnailPreview.style.display = "none";
                        thumbnailPlaceholder.innerHTML = '<i class="fa fa-exclamation-circle fa-3x mb-2"></i><p>Could not load thumbnail</p>';
                        thumbnailPlaceholder.style.display = "block";
                    }
                })
                .catch(error => {
                    console.error('Error fetching thumbnail:', error);
                    thumbnailPreview.style.display = "none";
                    thumbnailPlaceholder.innerHTML = '<i class="fa fa-exclamation-circle fa-3x mb-2"></i><p>Error loading thumbnail</p>';
                    thumbnailPlaceholder.style.display = "block";
                });
        }

        // Add event listener for input changes
        document.getElementById("urlInput").addEventListener('input', debounce(fetchThumbnail, 500));

        // Debounce function to prevent too many API calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function submitData() {
            let formData = new FormData();

            formData.append('title', document.querySelector('input[name="title"]').value);
            formData.append('date', document.querySelector('input[name="date"]').value);
            formData.append('video_url', document.querySelector('input[name="video_url"]').value);
            formData.append('description', document.querySelector('textarea[name="description"]').value);
            formData.append('status', $('#status').is(':checked') ? 1 : 0);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('videos.update', $video->v_id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // showLoading();
                    // location.reload();
                    console.log(response);
                    // // Handle success - maybe redirect or show success message
                    // showLoading();
                    // setTimeout(() => {
                    //     showSuccessMessage("Video created successfully!", "{{ route('videos.index') }}");
                    // }, 2000);
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
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ],
            callbacks: {
                onChange: function (contents) {
                    const strippedContent = $('<div>').html(contents).text().trim();
                    $('#descriptionError').toggle(strippedContent === '');
                }
            }
        });

        function openVideoUrl() {
            const url = document.getElementById('urlInput').value.trim();
            if (url) {
                window.open(url, '_blank');
            }
        }
    </script>
@endsection
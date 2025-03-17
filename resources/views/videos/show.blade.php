@extends('layouts.app')

@section('title', 'View Video')

@section('content')
    <style>
        html,
        body {
            overflow-x: hidden;
        }

        .custom-input {
            height: 30px;
        }

        .input-daterange>input {
            height: 30px;
        }

        .input-daterange>span {
            height: 30px;
        }
    </style>

    <link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('videos.index') }}">Videos</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Video</a></li>
    </ol>
    <h1 class="page-header">Video (View)</h1>

    <!-- make new -->

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="row" style="margin-bottom: 10px;">
                <div class="col-md-6 d-flex justify-content-start gap-2">
                    <a href="/videos" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back</a>
                    @if (Auth::user()->hasPermissionTo('video-write'))
                        <div class="col-md-6 d-flex justify-content-start gap-2">
                            <button class="btn btn-primary btn-xs" onclick="location.href='/videos/edit/{{ $video->v_id }}'">
                                Edit</button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row mt-3 g-0" style="margin: 0px;">

                <div class="col-8">
                    <!-- initial text inputs: name, code, category, year -->
                    <form action="/videos/update/{{ $video->v_id }}" method="post">
                        @csrf
                        <div class="row">
                            <!-- Title -->
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control form-control-xs" name="title" placeholder="..."
                                    value="{{ $video->title }}" readonly style="background-color: #f0f0f0;">
                                <span class="error-message" style="color: red;"></span>
                            </div>

                            <!-- Date -->
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input class="form-control" id="datepicker-autoClose" name="date"
                                    value="{{ date('F d, Y', strtotime($video->date)) }}" readonly
                                    style="background-color: #f0f0f0;">
                                <span class="error-message" style="color: red;"></span>
                            </div>

                            <!-- Video URL -->
                            <div class="col-md-6 mt-3">
                                <label for="video_url" class="form-label">Video URL</label>
                                <input class="form-control" name="video_url" id="urlInput"
                                    placeholder="Paste video URL here" value="{{ $video->video_url }}"
                                    onchange="fetchThumbnail()" readonly style="background-color: #f0f0f0;">
                                <span class="error-message" style="color: red;"></span>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mt-3 d-flex align-items-center justify-content-end">
                                <div class="form-check form-switch">
                                    @if($video->status == 1)
                                        <span class="badge bg-secondary rounded-pill">Enabled</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Disabled</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12 mt-3">
                                <label for="description" class="form-label">Description</label>
                                <div class="border p-2 rounded">
                                    <textarea class="textarea form-control" name="description" id="summernote"
                                        placeholder="Enter text ..." rows="12" readonly
                                        style="background-color: #f0f0f0;">{!! strip_tags($video->description, '<p><a><b><i><u><strong><em><ul><ol><li><img>') !!}</textarea>
                                    <span class="error-message" id="descriptionError" style="color: red;"></span>
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
                                    style="max-width: 100%; max-height: 100%; object-fit: cover; display: none; cursor: pointer;" />
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
    <script src="/assets/plugins/summernote/dist/summernote-lite.min.js"></script>

    <script>
        $("#pannel-body").attr("style", 'min-height: 78vh;');
        $('#videos').addClass('active');
        // $("#pannel-body").attr("style", 'height: 78vh;');
        $(document).ready(function () {
            fetchThumbnail();
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
            ],
            callbacks: {
                onInit: function () {
                    $('#summernote').summernote('disable'); // Make it read-only
                }
            }
        });
    </script>
@endsection
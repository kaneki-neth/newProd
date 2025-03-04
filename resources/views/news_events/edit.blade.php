@extends('layouts.app')

@section('title', 'News and Events')

@section('content')

<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
<link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2-search { display: none; }

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

    #img-container {
        max-width: 80%;
        margin: auto;
    }
    #main-img-container {
        aspect-ratio: 1 / 1;
        margin-left: 0 !important;
        margin-right: 0 !important;
        cursor: pointer;
    }
    #main-img-container img {
        border: 1px solid var(--bs-component-border-color);
        border-radius: 4px;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="{{ route('news_events.index') }}">News and Events</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Edit News/Event</a></li>
</ol>
<h1 class="page-header">News and Events List</h1>

<div class="panel panel-inverse">
    <div class="panel-body" id="pannel-body">
        <div class="row">
            <div id="fields" class="col-md-7 mb-3">
                <div class="form-group">
                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="category" name="category">
                        <option value="news" {{ $news_event->category == 'news'? 'selected':'' }}>News</option>
                        <option value="events" {{ $news_event->category == 'events'? 'selected':'' }}>Events</option>
                    </select>
                    <span id="category-msg" class="error-msg text-danger"></span>
                </div>

                <div class="form-group mt-2">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title">
                    <span id="title-msg" class="error-msg text-danger"></span>
                </div>

                <div class="form-group mt-2">
                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="date" name="date" placeholder="Date">
                    <span id="date-msg" class="error-msg text-danger"></span>
                </div>

                <div class="row mt-2 g-0">
                    <label for="description" class="form-label" >Description <span class="text-danger">*</span></label>
                    <span id="description-msg" class="error-msg text-danger"></span>
                    <div id="description-container" class="border" style="border-radius: 4px">
                        <textarea class="textarea form-control" name="description" id="summernote"
                            placeholder="Enter text ..." rows="12"></textarea>
                    </div>
                </div>
            </div>

            <div id="images" class="col-md-5 mb-3">
                <div id="img-container">
                    <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                    <div id="main-img-container" class="row g-0">
                        <span id="mainImage-msg" class="error-msg text-danger"></span>
                        <img src='/assets/userProfile/no-image-avail.jpg' id="mainImagePreview" onclick="document.getElementById('mainImage').click();">
                        <input type="file" accept="image/*" id="mainImage" name="mainImage" style="display: none;" onchange="displayMainImage(this)">
                    </div>
                    <span id="sub_images-msg" class="error-msg text-danger"></span>
                    <div id="imageGallery"
                        style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                        <div id="createButton"
                            style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;"
                            onclick="document.getElementById('sub_images').click();">
                            <input type="file" accept="image/*" id="sub_images" style="display: none;"
                                onchange="displayImage(this)">
                            <i class="fa fa-plus fa-2x text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-start">
            <button class="btn btn-primary" onclick="submitData()">Submit</button>
        </div>
    </div>
</div>

<script src="/assets/js/jquery-3.6.4.min.js"></script>
<script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        let news_event = @json($news_event);
        document.querySelector('select[name="category"]').value = news_event.category;
        $('#title').val(news_event.title);
        $('#date').val(news_event.date);
        $('#mainImagePreview').attr('src', '/storage/' + news_event.image_file + '?t=' + new Date().getTime());
        
        $.getScript("/assets/plugins/summernote/dist/summernote-lite.min.js", function() {
            $('#summernote').summernote({
                placeholder: 'Enter description',
                height: "300",
                maximumImageFileSize: 102400000, // 100MB
                callbacks: {
                    onImageUploadError: function (msg) {
                        // console.log(msg + ' (1 MB)');
                    }
                }
            });
            $('#summernote').summernote('code', news_event.description);
        });

        if(news_event.sub_images) {
            news_event.sub_images.forEach(sub_image => {
                $('#imageGallery').append(
                    '<div style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;">' +
                    '<img src="' + sub_image + '" style="width: 100%; height: 100%; object-fit: cover;">' +
                    '</div>'
                );
            });
        }
    });

    $('#date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom"
    });
</script>
<script>
    function displayMainImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#mainImagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function displayImage(input) {
        if (input.files && input.files[0]) {
            if (input.files[0].size > 102400000) {
                swal("File is too large! Please select an image that is 100MB or under.");
                return;
            }
            var reader = new FileReader();
            reader.onload = function (e) {
            $('#imageGallery').append(
                '<div style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;">' +
                '<img src="' + e.target.result + '" style="width: 100%; height: 100%; object-fit: cover;">' +
                '</div>'
            );
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function submitData() {
        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}'); 
        formData.append('category', document.querySelector('select[name="category"]').value);
        formData.append('title', $('#title').val());
        formData.append('date', $('#date').val());
        formData.append('description', $('#summernote').val());
        if($('#mainImage')[0].files[0]){
            formData.append('mainImage', $('#mainImage')[0].files[0]);
        }

        var subImages = $('#sub_images')[0].files;
        for (var i = 0; i < subImages.length; i++) {
            formData.append('sub_images[]', subImages[i]);
        }

        $.ajax({
            url: '{{ route("news_events.update", ['ne_id' => $news_event->ne_id]) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                location.reload();
            },
            error: function (xhr, status, error) {
                const errors = xhr.responseJSON.errors;

                for (const key in errors) {
                    if (Object.hasOwnProperty.call(errors, key)) {
                        const element = errors[key];
                        let $input_id = key;
                        if(key == 'mainImage') {
                            $input_id = 'mainImagePreview';
                        } else if (key == 'description') {
                            $input_id = 'description-container';
                        }
                        $("#" + $input_id).css('border', '1px solid red');
                        $('#' + key + '-msg').text(element[0]);
                    }
                }
            }
        });
    }
</script>

@endsection
@extends('layouts.app')

@section('title', 'News and Events')

@section('content')

<link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="../assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
<link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

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

    #imageGallery::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    #imageGallery::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #imageGallery::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #imageGallery::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    #imageGallery {
        scrollbar-width: thin;
        scrollbar-color: #888 #f1f1f1;
    }

    .image-container {
        position: relative;
        flex: 0 0 auto;
        width: 25%;
        aspect-ratio: 1 / 1;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--bs-component-border-color);
        border-radius: 4px;
    }

    .preview-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 1px solid #d1c3c0;
    }

    .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        transition: background 0.3s ease;
    }

    .tool-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        height: 50%;
        background: var(--bs-component-border-color);
        border-radius: 10%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .tool-overlay i {
        font-size: 24px;
        color: white;
    }

    .image-container:hover .hover-overlay {
        background: rgba(0, 0, 0, 0.3);
    }

    .image-container:hover .tool-overlay {
        opacity: 1;
    }
</style>

<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="{{ route('news_events.index') }}">News and Events</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Add News/Event</a></li>
</ol>
<h1 class="page-header">News and Events List</h1>

<div class="panel panel-inverse">
    <div class="panel-body" id="pannel-body">
        <div class="row">
            <div id="fields" class="col-md-7 mb-3">
                <div class="form-group">
                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                    <select class="form-control select2" id="category" name="category">
                        <option value="news">News</option>
                        <option value="event">Events</option>
                    </select>
                    <span id="category-msg" class="error-msg text-danger"></span>
                </div>

                <div class="form-group mt-2">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Title" onkeyup="remove_error(this)">
                    <span id="title-msg" class="error-msg text-danger"></span>
                </div>

                <div class="form-group mt-2">
                    <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="date" name="date" placeholder="Date" onkeyup="remove_error(this)">
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
<script src="../assets/plugins/summernote/dist/summernote-lite.min.js"></script>
<script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
<script>
    $('#date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom"
    });
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
</script>
<script>
    function displayMainImage(input) {
        $('mainImagePreview').css('border', '1px solid #ccc');
        $('#mainImage-msg').text('');
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#mainImagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    let imageCount = 0;
    let imageFiles = [];
    let deletedImageFileIndexes = [];
    function displayImage(input) {
        if (input.files.length > 0) {
            let file = input.files[0];
            if (file.size > 102400000) {
                swal("File is too large! Please select an image that is 100MB or under.");
                return;
            }

            let reader = new FileReader();
            reader.onload = function (e) {
                let newDiv = document.createElement('div');
                newDiv.classList.add('image-container');
                
                let img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('preview-image');
                img.id = `preview-image-${imageCount}`;

                let hoverOverlay = document.createElement('div');
                hoverOverlay.classList.add('hover-overlay');

                let toolOverlay = document.createElement('div');
                toolOverlay.classList.add('tool-overlay');
                toolOverlay.innerHTML = '<i class="fa fa-trash"></i>';

                var currentCount = imageCount;
                
                toolOverlay.addEventListener('click', function() {
                    deleteSubImage(newDiv, currentCount); 
                });

                newDiv.appendChild(img);
                newDiv.appendChild(hoverOverlay);
                newDiv.appendChild(toolOverlay);

                document.getElementById('imageGallery').appendChild(newDiv);
                imageFiles.push(file);
                imageCount++;
            };
            reader.readAsDataURL(file);
        }
    }

    function deleteSubImage(element, index) {
        element.remove();
        deletedImageFileIndexes.push(index);
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

        imageFiles.forEach((file, index) => {
            if(!deletedImageFileIndexes.includes(index)) {
                formData.append('sub_images[]', file);
            }
        });

        $.ajax({
            url: '{{ route("news_events.store") }}',
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
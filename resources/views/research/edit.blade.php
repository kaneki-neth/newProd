@extends('layouts.app')

@section('title', 'Research')

@section('content')

    <link href="/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css" rel="stylesheet" />
    <link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        html,
        body {
            overflow-x: hidden;
        }

        td,
        th {
            border: none;
        }

        .select2-search {
            display: none;
        }

        span.select2-selection.select2-selection--single {
            height: 30px !important;
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
            object-fit: contain;
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
        <li class="breadcrumb-item"><a href="{{ route('research.index') }}">Research</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Research</a></li>
    </ol>
    <h1 class="page-header">Research (Update)</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-start gap-2">
                    <a href="/research/{{ $research->r_id }}" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i>
                        View</a>
                </div>
            </div>
            <div class="row mt-3">
                <div id="fields" class="col-md-7">
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

                    <div class="form-group mt-2">
                        <label for="uploadFile" class="form-label">Upload File </label>
                        <input type="file" class="form-control" id="uploadFile" name="uploadFile"
                            accept=".pdf,.doc,.docx,.ppt,.pptx" multiple>
                        <span id="uploadFile-msg" class="error-msg text-danger"></span>
                    </div>

                    <div class="row mt-2 g-0">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <span id="description-msg" class="error-msg text-danger"></span>
                        <div id="description-container" class="border" style="border-radius: 4px">
                            <textarea class="textarea form-control" name="description" id="summernote"
                                placeholder="Enter text ..." rows="12"></textarea>
                        </div>
                    </div>
                    <div class="row g-0 mt-3">
                        <div class="col-12">
                            <div>
                                <table class="properties_table table table-responsive" id="properties_table"
                                    style="border-radius: 4px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Research Author</th>
                                            <th></th>
                                            <th class="col-span-2" style="text-align: right;"><button style="width: 50px"
                                                    type="button" id="addRowBtnRoles" onclick="addAuthorRow()"
                                                    class="btn btn-primary btn-xs"><i class="fa fa-add"></i>
                                                </button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="authors_tableBody" style="border-radius: 4px;">
                                        @foreach($authors as $author)
                                            <tr>
                                                <td style="width:100% !important" colspan="2">
                                                    <div>
                                                        <label class="form-label" for="author">Author Name </label>
                                                        <input class="author-name form-control form-control-xs "
                                                            name="author_name" style="width:100%" value="{{ $author }}">
                                                    </div>
                                                </td>
                                                <td class="d-flex justify-content-center align-items-center"
                                                    style="height:100%">
                                                    <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3"
                                                        style="height: 23px">
                                                        <i type="button" class="fas fa-lg fa-fw fa-trash-can"
                                                            onclick="removeRow(this)"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="images" class="col-md-5">
                    <div id="img-container">
                        <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                        <div id="main-img-container" class="row g-0">
                            <span id="mainImage-msg" class="error-msg text-danger"></span>
                            <img src='/assets/userProfile/no-image-avail.jpg' id="mainImagePreview"
                                onclick="document.getElementById('mainImage').click();">
                            <input type="file" accept="image/*" id="mainImage" name="mainImage" style="display: none;"
                                onchange="displayMainImage(this)">
                        </div>
                        <span id="sub_images-msg" class="error-msg text-danger"></span>
                        <div id="imageGallery"
                            style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                            <div id="createButton"
                                style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                onclick="document.getElementById('sub_images').click();">
                                <input type="file" accept="image/*" id="sub_images" style="display: none;"
                                    onchange="displayImage(this)" multiple>
                                <i class="fa fa-plus fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column mt-3 mx-auto" style="max-width: 80%">
                        <h5>Uploaded Files:</h5>
                        <ul class="list-unstyled">
                            @foreach($files as $file)
                                <li class="file-display d-flex align-items-center mb-2">
                                    <a href="{{ asset('storage/' . $file->file_path) }}" class="btn btn-primary btn-xs me-2"
                                        download>
                                        <i class="fa fa-file-pdf"></i>
                                        {{ basename($file->file_path) }}
                                    </a>
                                    <i class="fa-solid fa-xmark text-danger" style="cursor: pointer;"
                                        onclick="deleteFile(this, '{{ $file->file_path }}')"></i>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="mt-3 d-flex flex-row gap-2">
                <label class="form-label" for="enabled">Enabled <span class="text-danger">*</span></label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="enabled" name="enabled" {{ $research->enabled ? 'checked' : '' }}>
                </div>
            </div>
            <div class="d-flex justify-content-start mt-5">
                <button class="btn btn-primary btn-xs" onclick="submitData()">Update</button>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script>
        $('#research').addClass('active');
        var deleteOldSubImageIds = [];
        var deleteOldFileIds = [];
        $(document).ready(function () {
            let subImages = @json($subImages);
            let research = @json($research);
            $('#title').val(research.title);
            let date = new Date(research.date);
            let formattedDate = date.toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            $('#date').val(formattedDate);
            $('#mainImagePreview').attr('src', '/storage/' + research.image_file + '?t=' + new Date().getTime());

            $.getScript("/assets/plugins/summernote/dist/summernote-lite.min.js", function () {
                $('#summernote').summernote({
                    placeholder: 'Enter description',
                    height: "300",
                    maximumImageFileSize: 102400000, // 100MB
                    callbacks: {
                        onImageUploadError: function (msg) {
                            swal("File is too large! Please select an image that is 100MB or under.");
                            return;
                        }
                    }
                });
                $('#summernote').summernote('code', research.description);
            });

            if (subImages) {
                subImages.forEach(sub_image => {
                    imagePath = '/storage/' + sub_image.image_file + '?t=' + new Date().getTime();

                    let newDiv = document.createElement('div');
                    newDiv.classList.add('image-container');

                    let img = document.createElement('img');
                    img.src = imagePath;
                    img.classList.add('preview-image');

                    let hoverOverlay = document.createElement('div');
                    hoverOverlay.classList.add('hover-overlay');

                    let toolOverlay = document.createElement('div');
                    toolOverlay.classList.add('tool-overlay');
                    toolOverlay.innerHTML = '<i class="fa fa-trash"></i>';

                    toolOverlay.addEventListener('click', function () {
                        let ri_id = sub_image.ri_id;
                        console.log(ri_id);
                        deleteOldSubImage(newDiv, ri_id);
                    });

                    newDiv.appendChild(img);
                    newDiv.appendChild(hoverOverlay);
                    newDiv.appendChild(toolOverlay);

                    document.getElementById('imageGallery').appendChild(newDiv);
                });
            }
        });

        function deleteOldSubImage(element, id) {
            deleteOldSubImageIds.push(id);
            element.remove();
        }

        $('#date').datepicker({
            format: 'M d, yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: "bottom"
        }).on('changeDate', function () {
            rm_error(this);
        });

        function displayMainImage(input) {
            $('#mainImagePreview').removeClass('error-input');
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
            for (let i = 0; i < input.files.length; i++) {
                let file = input.files[i];
                if (file.size > 102400000) {
                    swal("File is too large! Please select an image that is 100MB or under.");
                    continue;
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

                    toolOverlay.addEventListener('click', function () {
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

        function deleteFile(element, filePath) {
            deleteOldFileIds.push(filePath);
            element.closest('li').remove();
        }

        function submitData() {
            showLoading();
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('title', $('#title').val());
            formData.append('date', $('#date').val());
            formData.append('description', $('#summernote').val());
            formData.append('enabled', $('#enabled').is(':checked') ? 1 : 0);

            let authors = [];
            document.querySelectorAll('#authors_tableBody tr').forEach((row, index) => {
                let authorInput = row.querySelector('input[name="author_name"]');
                if (authorInput && authorInput.value.trim()) {
                    authors.push(authorInput.value.trim());
                    formData.append(`authors[${index}]`, authorInput.value.trim());
                }
            });

            console.log('Authors to submit:', authors);

            if ($('#uploadFile')[0].files.length > 0) {
                for (let i = 0; i < $('#uploadFile')[0].files.length; i++) {
                    formData.append('uploadFiles[]', $('#uploadFile')[0].files[i]);
                }
            }

            if ($('#mainImage')[0].files[0]) {
                formData.append('mainImage', $('#mainImage')[0].files[0]);
            }

            deleteOldSubImageIds.forEach(id => {
                formData.append('subImagesToDelete[]', id);
            });

            deleteOldFileIds.forEach(path => {
                formData.append('filesToDelete[]', path);
            });

            imageFiles.forEach((file, index) => {
                if (!deletedImageFileIndexes.includes(index)) {
                    formData.append('sub_images[]', file);
                }
            });

            let url = '/research/' + {{ $research->r_id }} + '/edit';
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    window.location.href = '/research/' + {{ $research->r_id }};
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 413) {
                        console.log('inside 413');
                        Swal.fire({
                            icon: 'error',
                            title: 'Content Too Large',
                            html: 'The contents are too large!<br>Please reduce the size of the contents.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                    const errors = xhr.responseJSON.errors;

                    for (const key in errors) {
                        if (Object.hasOwnProperty.call(errors, key)) {
                            const element = errors[key];
                            let $input_id = key;
                            if (key == 'mainImage') {
                                $input_id = 'mainImagePreview';
                            } else if (key == 'description') {
                                $input_id = 'description-container';
                            }
                            $("#" + $input_id).addClass('error-input')
                                .on('keyup change', function () {
                                    rm_error(this);
                                });
                            $('#' + key + '-msg').text(element[0]);

                            Swal.close()
                        }
                    }
                }
            });
        }

        function addAuthorRow() {
            let tableBody = document.getElementById('authors_tableBody');

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                            <td style="width:100% !important" colspan="2">
                                <div>
                                    <label class="form-label" for="author">Author Name </label>
                                    <input class="author-name form-control form-control-xs"
                                        name="author_name" style="width:100%">
                                </div>
                            </td>
                            <td class="d-flex justify-content-center align-items-center" style="height:100%">
                                <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3" style="height: 23px">
                                    <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                </div>
                            </td>
                        `;
            tableBody.appendChild(newRow);
        }
        function removeRow(button) {
            let currentRows = document.querySelectorAll('#authors_tableBody tr').length;
            let row = button.closest('tr');
            row.remove();

        }

        function rm_error(element) {
            $(element).removeClass('error-input');
            let msg_id = element.id;
            if (msg_id == "description-container") {
                msg_id = "description";
            }
            $('#' + msg_id + '-msg').text('');
        }
    </script>

@endsection
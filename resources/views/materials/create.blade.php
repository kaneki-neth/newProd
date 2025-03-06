@extends('layouts.app')

@section('title', 'Add Material')

@section('content')
    <style>
        html, body {
            overflow-x: hidden;
        }

        td, th {
            border: none;
        }

        .col-4 > .row {
            width: 100%; 
            min-width: 100%; 
        }

        div img#mainImage {
            width: 100%;
            height: auto;     
            object-fit: cover;        
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
        .error-msg#mainImage {
            position: relative;
            background-color: white;
            top: 0px !important;
        }
        .error-input {
            border: 1px solid red !important;
        }

        .error-message {
            color: red;
            font-size: 12px;
            display: block;
            margin-top: 5px;
            position: relative;
            background-color: white;
        }

        .select2 {
            width: 100% !important;
        }

        .input-container {
            position: relative;
            display: inline-block;
        }

        .select2-container {
            position: relative;
        }

        .select2-container--default .select2-selection--multiple.is-invalid {
            border-color: red !important;
        }

        .select2-container--default .select2-selection--single:has(+ select:invalid) {
            border: 1px solid red !important;
        }

        .is-invalid {
            border-color: red !important;
        }

        input.is-invalid {
            border-color: red !important;
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
    </style>


    <link href="../assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Materials</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Add Material</a></li>
    </ol>
    <h1 class="page-header">Add Material</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body" style="padding: 45px !important;">
            <div class="row mb-3 g-0" style="margin: 0px;">
                <div class="col-8">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-xs validate" name="name" placeholder="..." id="name">
                            <span id="name-msg" class="error-message"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-xs validate @error('code') is-invalid @enderror" id="code"
                                name="code" value="{{ old('code') }}" placeholder="...">
                                <span id="code-msg" class="error-message"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="categories" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-control select2 validate" id="multiple-select-field"
                                    name="categories" type="text" onkeyup="remove_error(this)" multiple>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->c_id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span id="categories-msg" class="error-message"></span>
                                </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <select class="form-control select2-container select2" id="year" name="year">
                                @for ($i = 1984; $i <= (date('Y') + 5); $i++)
                                    @if ($i == date('Y'))
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 g-0">
                        <label for="material_description" class="form-label" >Description <span class="text-danger">*</span></label>
                        <span id="description-msg" class="error-msg text-danger" ></span>
                        <div id="description" class="border form-control" style="border-radius: 4px; padding: 0px;" >
                            <textarea class="textarea form-control" name="material_description" id="summernote"
                                placeholder="Enter text ..." rows="12"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div style="border-radius: 4px;">
                                <table class="properties_table table table-responsive" id="properties_table" style="border-radius: 4px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Properties</th>
                                            <th></th>
                                            <th class="col-span-2" style="text-align: right;"><button
                                                    style="width: 50px" type="button" id="addRowBtnRoles"
                                                    onclick="addPropertyRow()" class="btn btn-primary btn-xs"><i
                                                        class="fa fa-add"></i>
                                                </button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="properties_tableBody" style="border-radius: 4px;">
                                        <tr>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Name </label>
                                                    <input class="property-name form-control form-control-xs "
                                                        name="property_name" id="property-name-field"
                                                        style=" width:100%">
                                                    
                                                </div>
                                            </td>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Value </label>
                                                    <input type="text" class="form-control form-control-xs "
                                                        name="property_value" style=" width:100%">
                                                    
                                                </div>
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="technical_properties_table table table-responsive"
                                    id="technical_properties_table" style="border-radius: 4px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Technical Properties</th>
                                            <th></th>
                                            <th class="col-span-2" style="text-align: right;"><button
                                                    style="width: 50px" type="button" id="addRowBtnRoles"
                                                    onclick="addTechnicalPropertyRow()"
                                                    class="btn btn-primary btn-xs"><i class="fa fa-add"></i>
                                                </button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="technical_properties_tableBody">
                                        <tr>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Name </label>
                                                    <input class="form-control form-control-xs "
                                                        name="technical_property_name" style="width:100%">
                                                    
                                                </div>
                                            </td>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Value </label>
                                                    <input type="text" class="form-control form-control-xs "
                                                        name="technical_property_value" style=" width:100%">
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="sustainability_table table table-responsive" id="sustainability_table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sustainability and Application</th>
                                            <th></th>
                                            <th class="col-span-2" style="text-align: right;"><button
                                                    style="width: 50px" type="button" id="addRowBtnRoles"
                                                    onclick="addSustainabilityRow()" class="btn btn-primary btn-xs"><i
                                                        class="fa fa-add"></i>
                                                </button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="sustainability_tableBody">
                                        <tr>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Name </label>
                                                    <input class="form-control form-control-xs "
                                                        name="sustainability_property_name" style="width:100%">
                                                    
                                                </div>
                                            </td>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Value </label>
                                                    <input type="text" class="form-control form-control-xs "
                                                        name="sustainability_property_value" style=" width:100%">
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 d-flex align-items-end flex-column" style="height: 100%">
                    <div class="row g-0">
                        <div class="col-9" style="margin-left: auto">
                            <div class="alert alert-yellow fade" id="imageError"></div>
                            <label class="form-label">Upload Image</label>
                            <div style="border:1px solid var(--bs-component-border-color); border-radius:4px; aspect-ratio: 1 / 1; margin-left: 0 !important; margin-right: 0 !important; cursor: pointer;"
                                class="row g-0" onclick="document.getElementById('main_material_image').click();">
                                <input type="file" accept="image/*" id="main_material_image" style="display: none;"
                                        onchange="displayMainImage(this)">
                                <img src='/assets/userProfile/no-image-avail.jpg' id="mainImage">
                            </div>
                            <div id="imageGallery"
                                style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                                <div id="createButton"
                                    style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                    onclick="document.getElementById('material_image').click();">
                                    <input type="file" accept="image/*" id="material_image" style="display: none;"
                                        onchange="displayImage(this)" multiple>
                                    <i class="fa fa-plus fa-2x text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="d-flex justify-content-start">
                        <button class="btn btn-primary btn-md" style="margin: 10px;" onclick="submitData()">
                            <i class="fa fa-plus"></i> Submit
                        </button>
                    </div>
            </div>
        </div>
    </div>
    

    <script src="/assets/js/jquery-3.6.4.min.js"></script>

    <script src="../assets/plugins/summernote/dist/summernote-lite.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="../assets/plugins/blueimp-load-image/js/load-image.all.min.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-process.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-image.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-ui.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-validate.js"></script>
    <script src="../assets/plugins/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        let imageCount = 0;
        let imageFiles = [];
        let mainImage;
        const MAX_FILE_SIZE = 100 * 1024 * 1024;
        
        $('#summernote').summernote({
            placeholder: 'Enter description',
            height: "300",
            maximumImageFileSize: 102400000,
            callbacks: {
                onImageUploadError: function (msg) {
                }
            }
        });

        $(document).ready(function () {            
            $('#imageError').removeClass("show");
            $('#imageError').hide();
            $('#imageError').empty();
            $('#descriptionError').removeClass("show");
            $('#descriptionError').hide();
            $('#descriptionError').empty();
            $(document).on('input', '.validate', function () {
                let $field = $(this);
                $field.removeClass('is-invalid');
                $field.siblings('.error-message').text('');
                $field.siblings('.error-message-sub').text('');
                $field.css('border-color', '#ced4da');
            });

            $('#multiple-select-field').select2({ placeholder: "Select Categories", width: "100%" })
                .on('change', function () {
                    $(this).next('.select2-container')
                        .find('.select2-selection--multiple')
                        .removeClass('is-invalid');
                    $(this).siblings('.error-message').text('');
                    $(this).siblings('.error-message-sub').text('');
                });

        });
        

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

        function deleteSubImage(element, count) { 
            if (element) {
                element.remove(); 
            }
            imageFiles[count] = "";
        }

        function displayMainImage(input) {            
            if(input) {
                let file = input.files[0];
                
                if (file.size > MAX_FILE_SIZE) {
                        swal("File is too large! Please select an image that is 100MB or under.");
                        return;
                    }

                let reader = new FileReader();
                reader.onload = function (e) {
                    mainImage = file;
                    updateMainImageItself(e.target.result);
                };
                reader.readAsDataURL(file); 
            }
        }
        
        function updateMainImageItself(mainImgSrc) {            
            let img = document.getElementById('mainImage');
            img.src = mainImgSrc;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
        }

        function updateMainImage(imageId) {

            let clickedImage = document.getElementById(imageId);            
            if (!clickedImage) return;
            let img = document.getElementById('mainImage');

            img.src = clickedImage.src;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
        }

        function submitData() {
            let formData = new FormData();
            formData.append('code', document.querySelector('input[name="code"]').value);
            formData.append('name', document.querySelector('input[name="name"]').value);
            formData.append('year', document.querySelector('select[name="year"]').value);
            formData.append('year', document.querySelector('select[name="year"]').value);
            formData.append('description', document.querySelector('textarea[name="material_description"]').value);

            if ($("#main_material_image").val()) {
                $('#imageError').removeClass("show");
                $('#imageError').hide();    
                $('#imageError').empty(); 
            }

            if ($("#summernote").val()) {
                $('#descriptionError').removeClass("show");
                $('#descriptionError').hide();    
                $('#descriptionError').empty(); 
            }

            let categories = $('#multiple-select-field').val();
            categories.forEach((c_id, index) => {
                formData.append(`categories[${index}]`, c_id);
            });

            let properties = [];
            document.querySelectorAll('#properties_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="property_name"]').value;
                
                let value = row.querySelector('input[name="property_value"]').value;
                if(name && value) {
                    properties.push({ name, value, type: 'soft' });
                }
            });
            document.querySelectorAll('#technical_properties_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="technical_property_name"]').value;
                let value = row.querySelector('input[name="technical_property_value"]').value;
                if(name && value) {
                    properties.push({ name, value, type: 'technical' });
                }
            });
            document.querySelectorAll('#sustainability_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="sustainability_property_name"]').value;
                let value = row.querySelector('input[name="sustainability_property_value"]').value;
                if(name && value) {
                    properties.push({ name, value, type: 'application' });
                }
                
            });
            properties.forEach((prop, index) => {
                if (prop.name && prop.value){              
                    formData.append(`properties[${index}][name]`, prop.name);
                    formData.append(`properties[${index}][value]`, prop.value);
                    formData.append(`properties[${index}][type]`, prop.type);
                }

            });
            imageFiles.forEach((file, index) => {
                if(file){
                    formData.append('imageFiles[]', file);
                }
            });
            formData.append('mainImage', mainImage ?? "")

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('materials.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log(response);
                    showLoading();
                    setTimeout(() => {
                        showSuccessMessage("Material created successfully!", "{{ route('materials.index') }}");
                    }, 2000);

                },
                error: function (xhr) {
                    if (xhr.status === 400) {
                        const errors = xhr.responseJSON.errors;
                        console.log("these the errors", errors);
                        
                        for (const key in errors) {
                            if (Object.hasOwnProperty.call(errors, key)) {
                                const element = errors[key];
                                let $input_id = key;
                                if(key == 'categories') {
                                    $('.select2-container .selection .select2-selection--multiple').addClass('error-input');
                                    $('#' + key + '-msg').text(element[0]);
                                } else {
                                    $("#" + $input_id).addClass('error-input')
                                        .on('keyup change', function() {
                                            rm_error(this);
                                        });
                                    $('#' + key + '-msg').text(element[0]);
                                }
                            }
                        }

                        Swal.close();
                    }
                    else if(xhr.status === 413) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Content Too Large',
                            html: 'The contents are too large!<br>Please reduce the size of the contents.',
                            confirmButtonText: 'OK'
                        });
                        return;
                    }
                }
            });

            function rm_error(element) {
                $(element).removeClass('error-input');
                $('#' + element.id + '-msg').text('');
            }

            
        }

        function addPropertyRow() {
            let tableBody = document.getElementById('properties_tableBody');
            let currentRows = document.querySelectorAll('#properties_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                            <td style="width:50%">
                                <div>
                                    <label for="property">Name </label>
                                    <input class="property-name form-control form-control-xs" name="property_name"
                                        style=" width:100%">
                                    
                                </div>
                            </td>
                            <td style="width:50%">
                                <div>
                                    <label for="property">Value </label>
                                    <input type="text" class="form-control form-control-xs" name="property_value"
                                        style=" width:100%">
                                    
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
            let currentRows = document.querySelectorAll('#properties_tableBody tr').length;
            let row = button.closest('tr');
            row.remove();
            
        }

        ////////////////////////
        function addTechnicalPropertyRow() {
            let tableBody = document.getElementById('technical_properties_tableBody');
            let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td style="width:50%">
                    <div>
                        <label for="property">Name</label>
                        <input class="form-control form-control-xs validate" name="technical_property_name"
                            style="width:100%">
                        
                    </div>
                </td>
                <td style="width:50%">
                    <div>
                        <label for="property">Value </label>
                        <input type="text" class="form-control form-control-xs validate" name="technical_property_value"
                            style=" width:100%">
                        
                    </div>
                </td>
                <td class="d-flex justify-content-center align-items-center" style="height:100%">
                    <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3" style="height: 23px">
                        <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeTechRow(this)"></i>
                    </div>
                </td>
                `;
            tableBody.appendChild(newRow);
        }

        function removeTechRow(button) {
            let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;
            let row = button.closest('tr');
            
            row.remove();
            
        }

        function addSustainabilityRow() {
            let tableBody = document.getElementById('sustainability_tableBody');
            let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                    <td style="width:50%">
                    <div>
                        <label for="property">Name </label>
                        <input class="form-control form-control-xs validate" name="sustainability_property_name"
                            style="width:100%">
                        
                    </div>
                    </td>
                    <td style="width:50%">
                    <div>
                        <label for="property">Value </label>
                        <input type="text" class="form-control form-control-xs validate" name="sustainability_property_value"
                            style=" width:100%">
                        
                    </div>
                    </td>
                    <td class="d-flex justify-content-center align-items-center" style="height:100%">
                        <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3" style="height: 23px">
                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeSusRow(this)"></i>
                        </div>
                    </td>
                    `;
            tableBody.appendChild(newRow);
        }

        function removeSusRow(button) {
            let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;
            let row = button.closest('tr');
            row.remove();
            
        }
    </script>
@endsection
@extends('layouts.app')

@section('title', 'Edit Material')

@section('content')
    <script>
        let properties = @json($properties);
        let techProperties = @json($techProperties);
        let susProperties = @json($susProperties);
    </script>

<style>
        html, body {
            overflow-x: hidden;
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

        /* Image Styles */
        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 1px solid #d1c3c0;
        }

        /* Grayed-Out Hover Overlay */
        .hover-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0); /* Fully transparent by default */
            transition: background 0.3s ease;
        }

        /* Small Tool Overlay (Trash Icon) */
        .tool-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%; /* Adjust percentage as needed */
            height: 50%; /* Adjust percentage as needed */
            background: var(--bs-component-border-color);
            border-radius: 10%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0; /* Initially hidden */
            transition: opacity 0.3s ease;
        }

        /* Trash Icon inside Tool Overlay */
        .tool-overlay i {
            font-size: 24px;
            color: white; /* Adjust color if needed */
        }

        /* Hover Effects (CSS-Only) */
        .image-container:hover .hover-overlay {
            background: rgba(0, 0, 0, 0.3); /* Grayed out on hover */
        }

        .image-container:hover .tool-overlay {
            opacity: 1; /* Tool overlay appears fully */
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
            /* Makes the scrollbar thinner */
            height: 8px;
            /* Adjusts horizontal scrollbar thickness */
        }

        #imageGallery::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* Light gray background */
            border-radius: 10px;
        }

        #imageGallery::-webkit-scrollbar-thumb {
            background: #888;
            /* Darker gray for the scrollbar handle */
            border-radius: 10px;
        }

        #imageGallery::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* Darker on hover */
        }

        #imageGallery {
            scrollbar-width: thin;
            /* Makes the scrollbar thinner */
            scrollbar-color: #888 #f1f1f1;
            /* Thumb color and track color */
        }
    </style>
    <link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Materials</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Edit Material</a></li>
    </ol>
    <h1 class="page-header">Edit Material</h1>

    <!-- make new -->
    
    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body" style="padding: 65px !important;">
            <div class="row mb-3 g-0" style="margin: 0px;">
                <!-- diri content sa left -->
                <div class="col-8">
                <!-- Initial text inputs: name, code, category, year -->
                <div class="row">
                    <div class="col">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-xs validate" name="name" 
                            value="{{ old('name', $material->name) }}" placeholder="...">
                        <span class="error-message"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-xs validate" name="code" 
                            value="{{ old('material_code', $material->material_code) }}" placeholder="...">
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="categories" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control select2 validate" id="multiple-select-field"
                            name="categories[]" type="text" multiple>
                            @foreach ($categories as $category)
                                <option value="{{ $category->c_id }}" 
                                    {{ in_array($category->c_id, $selectedCategories) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="error-message"></span>
                    </div>
                    <div class="col-md-2">
                        <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                        <select class="form-control select2-container select2" id="year" name="year">
                            @for ($i = 1984; $i <= (date('Y') + 5); $i++)
                                <option value="{{ $i }}" {{ $i == old('year', $material->year) ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Description module -->
                <div class="row mt-3 g-0">
                    <div class="alert alert-yellow fade" style="display: none;" id="descriptionError"></div>
                    <label for="material_description" class="form-label">Description <span class="text-danger">*</span></label>
                    <div class="border" style="border-radius: 4px">
                        <textarea class="textarea form-control" name="material_description" id="summernote"
                            placeholder="Enter text ..." rows="12">
                            {{ old('material_description', $material->description) }}
                        </textarea>
                    </div>
                </div>
                <!-- properties module -->
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
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

            </div>
                <!-- end of content on the left -->

                <!-- content on the right aka image and submit button -->
                <div class="col-4 d-flex align-items-end flex-column" style="height: 100%">
                    <!-- show image content -->
                    <div class="row g-0">
                        <div class="col-9" style="margin-left: auto">
                            <div class="alert alert-yellow fade" id="imageError"></div>
                            <label class="form-label">Upload Image</label>
                            <!-- main/big image -->
                            <div style="border:1px solid var(--bs-component-border-color); border-radius:4px; aspect-ratio: 1 / 1; margin-left: 0 !important; margin-right: 0 !important; cursor: pointer;"
                                class="row g-0" onclick="document.getElementById('main_material_image').click();">
                                <input type="file" accept="image/*" id="main_material_image" style="display: none;"
                                        onchange="displayMainImage(this)">
                                <img src='/assets/userProfile/no-image-avail.jpg' id="mainImage">
                            </div>
                            <!-- container for the stuff to append -->
                            <div id="imageGallery"
                                style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                                <!-- Add Button Square -->
                                <div id="createButton"
                                    style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                    onclick="document.getElementById('material_image').click();">
                                    <input type="file" accept="image/*" id="material_image" style="display: none;"
                                        onchange="displayImage(this)">
                                    <i class="fa fa-plus fa-2x text-white"></i>
                                </div>
                                <!-- Dynamically added squares will be appended here -->
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- end of content on the right -->
                <div class="d-flex justify-content-start">
                        <button class="btn btn-primary btn-md" style="margin: 10px;" onclick="submitData()">
                            <i class="fa fa-plus"></i> Submit
                        </button>
                    </div>
            </div>
        </div>
    </div>
    
    <script src="/assets/js/jquery-3.6.4.min.js"></script>
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
        
        properties.forEach((element, index) => {
                if (index == 0 ){
                    addPropertyRow(element, true);
                } else addPropertyRow(element, false); 
            });

            techProperties.forEach((element, index) => {
                if (index == 0 ){
                    addTechnicalPropertyRow(element, true);
                } else addTechnicalPropertyRow(element, false); 
            });
            
            susProperties.forEach((element, index) => {
                if (index == 0 ){
                    addSustainabilityRow(element, true);
                } else addSustainabilityRow(element, false); 
            });

        $(document).ready(function () {
            console.log("mainIMage is:", mainImage);
            console.log("mainIMage is type:", typeof mainImage);
            
            // Add input handler for all input fields
            $('#imageError').removeClass("show");
            $('#imageError').hide();
            $('#imageError').empty();
            $('#descriptionError').removeClass("show");
            $('#descriptionError').hide();
            $('#descriptionError').empty();
            $(document).on('input', '.validate', function () {
                let $field = $(this);
                // Remove invalid class
                $field.removeClass('is-invalid');
                // Remove error messages (both types)
                $field.siblings('.error-message').text('');
                $field.siblings('.error-message-sub').text('');
                // Reset border color
                $field.css('border-color', '#ced4da');
                console.log("docu input .validate");
            });

            // Select2 initialization with validation clear
            $('#multiple-select-field').select2({ placeholder: "Select Categories", width: "100%" })
                .on('change', function () {
                    // Clear validation styling when user makes a selection
                    $(this).next('.select2-container')
                        .find('.select2-selection--multiple')
                        .removeClass('is-invalid');
                    $(this).siblings('.error-message').text('');
                    $(this).siblings('.error-message-sub').text('');
                });


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
                let material_description = @json($material->description);
                $('#summernote').summernote('code', material_description);
            });
        });


        function displayImage(input) {
            console.log("test display image");
            if (input.files.length > 0) {
                let file = input.files[0];
                if (file.size > MAX_FILE_SIZE) {
                    swal("File is too large! Please select an image that is 100MB or under.");
                    return;
                }

                let reader = new FileReader();
                reader.onload = function (e) {
                    let newDiv = document.createElement('div');
                    newDiv.classList.add('image-container'); // Assign class for CSS styling

                    let img = document.createElement('img');
                    img.src = e.target.result;
                    // console.log("cursed e target result sent", img.src);
                    img.classList.add('preview-image'); // Assign class for CSS styling
                    img.id = `preview-image-${imageCount}`;

                    let hoverOverlay = document.createElement('div'); // Grayed-out effect on hover
                    hoverOverlay.classList.add('hover-overlay');

                    let toolOverlay = document.createElement('div'); // Small tool overlay
                    toolOverlay.classList.add('tool-overlay');
                    toolOverlay.innerHTML = '<i class="fa fa-trash"></i>'; // FontAwesome trash icon

                    var currentCount = imageCount;
                    console.log(`this the count of ${img.id} right now: `, currentCount);
                    
                    toolOverlay.addEventListener('click', function() {
                        deleteSubImage(newDiv, currentCount); 
                    });

                    // Append elements in the correct order
                    newDiv.appendChild(img);
                    newDiv.appendChild(hoverOverlay);
                    newDiv.appendChild(toolOverlay);

                    document.getElementById('imageGallery').appendChild(newDiv);
                    imageFiles.push(file);
                    imageCount++;

                };

                reader.readAsDataURL(file);
            }
            console.log("this the current imageFiles list", imageFiles);
        }

        function deleteSubImage(element, count) { 
            if (element) {
                element.remove(); // Remove from DOM
            }
            imageFiles[count] = "";
            console.log(`hello image removed at ${count}: `, imageFiles);
        }

        function displayMainImage(input) {
            console.log("hello wawahahiawjhoaihahaoj");
            
            if(input) {
                let file = input.files[0];
                console.log(typeof file);
                console.log("file object from input or file list", file);
                
                if (file.size > MAX_FILE_SIZE) {
                        //dapat swal ni
                        swal("File is too large! Please select an image that is 100MB or under.");
                        return;
                    }

                let reader = new FileReader();
                reader.onload = function (e) {
                    console.log("this is the file object inside readeronload", file);
                    mainImage = file;
                    console.log("this is after setting mainImage to file", mainImage);
                    updateMainImageItself(e.target.result);
                };
                reader.readAsDataURL(file); 
            }
            console.log("u inputted in mainImage and set as file object now", mainImage);
        }
        
        function updateMainImageItself(mainImgSrc) {
            console.log("reached update updateMainImageItself fcn");
            
            let img = document.getElementById('mainImage');
            img.src = mainImgSrc;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
        }

        // update main image sa taas
        function updateMainImage(imageId) {

            let clickedImage = document.getElementById(imageId);
            console.log("this the imageId for clickedImage", clickedImage.id);
            
            if (!clickedImage) return;

            let img = document.getElementById('mainImage');

            img.src = clickedImage.src;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
        }

        //purely for testing naunsa na ang images
        $('#update_user').submit(function (e) {
            e.preventDefault();
            $(".btn").attr("disabled", true);
            let formData = new FormData(this);
            formData.append('_token', `{{ csrf_token() }}`);
            console.log("this the image files array", imageFiles);

            imageFiles.forEach((file, index) => {
                formData.append(`material_image_${index}`, file);
                console.log("this the file appended just now", file);
            });

        });


        function submitData() {
            let formData = new FormData();
            formData.append('code', document.querySelector('input[name="code"]').value);
            formData.append('name', document.querySelector('input[name="name"]').value);
            formData.append('year', document.querySelector('select[name="year"]').value);
            formData.append('year', document.querySelector('select[name="year"]').value);
            formData.append('description', document.querySelector('textarea[name="material_description"]').value);
            // for(var pair of formData.entries()){
            //     console.log(pair[0], pair[1]);
            // }

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

            // Append categories as array
            let categories = $('#multiple-select-field').val();
            categories.forEach((c_id, index) => {
                formData.append(`categories[${index}]`, c_id);
            });

            // Collect properties from all tables
            let properties = [];
            // Regular properties (soft)
            document.querySelectorAll('#properties_tableBody tr').forEach(row => {
                console.log("this the row", row);
                let name = row.querySelector('input[name="property_name"]').value;
                console.log("name check if null ba or not", name);
                console.log("name check if null ba or not (type)", typeof name);
                
                let value = row.querySelector('input[name="property_value"]').value;
                console.log("value check if null ba or not", value);
                console.log("value check if null ba or not(type)", typeof value);
                if(name && value) {
                    console.log("yes u did put for normal properties");
                    properties.push({ name, value, type: 'soft' });
                }else console.log("no norm");   
            });
            // Technical properties
            document.querySelectorAll('#technical_properties_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="technical_property_name"]').value;
                let value = row.querySelector('input[name="technical_property_value"]').value;
                if(name && value) {
                    console.log("yes u did put for tech properties");
                    properties.push({ name, value, type: 'technical' });
                } else console.log("no tech");
            });
            // Sustainability properties
            document.querySelectorAll('#sustainability_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="sustainability_property_name"]').value;
                let value = row.querySelector('input[name="sustainability_property_value"]').value;
                if(name && value) {
                    console.log("yes u did put for sus properties");
                    properties.push({ name, value, type: 'application' });
                } else console.log("no sus");
                
            });

            console.log("properties array", properties);
            
            // Append properties to FormData
            properties.forEach((prop, index) => {
                if (prop.name && prop.value){              
                    console.log("append becoz has both naem adn value");
                    formData.append(`properties[${index}][name]`, prop.name);
                    formData.append(`properties[${index}][value]`, prop.value);
                    formData.append(`properties[${index}][type]`, prop.type);
                } else console.log("did not append becoz no value in both naem adn value");

            });

            // Append image files
            imageFiles.forEach((file, index) => {
                formData.append('imageFiles[]', file);
            });
            console.log("appending mainImage now", mainImage);
            formData.append('mainImage', mainImage ?? "")

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('materials.update', $material->m_id) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log("work??????????");
                    
                    console.log(response);
                    // Handle success - maybe redirect or show success message
                    showLoading();
                    setTimeout(() => {
                        showSuccessMessage("Material created successfully!", "{{ route('materials.index') }}");
                    }, 2000);

                },
                error: function (xhr) {
                    if (xhr.status === 400) {
                        const errors = xhr.responseJSON.errors;
                        console.log("these the errors: ", errors);
                        // Display each error message
                        Object.keys(errors).forEach(field => {
                            console.log("the field currently is: ", field);
                            const errorMessage = errors[field][0];
                            const inputField = $(`[name="${field}"]`);
                            
                            if (field === "mainImage") {
                                console.log("wow mainimage field error");
                                $('#imageError').addClass("show");
                                $('#imageError').show();
                                $('#imageError').text(errorMessage);
                            }
                            if (field === "description"){
                                $('#descriptionError').addClass("show");
                                $('#descriptionError').show();
                                $('#descriptionError').text(errorMessage);
                            }

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

            // Local validation
            $(".validate").each(function () {
                let $field = $(this);
                let $container = $field.is("select") ? $field.next(".select2-container") : $field; // Handle Select2 and normal fields

                if (!$field.val()) {
                    if ($container.find(".select2-selection").length) {
                        $container.find(".select2-selection").css("border", "1px solid red");
                    } else {
                        $field.addClass('is-invalid');
                    }

                    // Remove existing error messages
                    $container.siblings('.error-message').remove();
                    // Add new error message
                    $container.after('<span class="error-message" style="color: red;">This field should not be empty</span>');
                }
            });
        }

        function addPropertyRow(properties, first) {
            let tableBody = document.getElementById('properties_tableBody');
            let currentRows = document.querySelectorAll('#properties_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                            <td style="width:50%">
                                <div>
                                    <label for="property">Name <span class="text-danger">*</span></label>
                                    <input class="property-name form-control form-control-xs" name="property_name" value=properties.property_name ()
                                        style=" width:100%">
                                    
                                </div>
                            </td>
                            <td style="width:50%">
                                <div>
                                    <label for="property">Value <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-xs" name="property_value" value=properties.value
                                        style=" width:100%">
                                    
                                </div>
                            </td>` + (!first ? `<td>
                                <div class="mt-1 text-center text-danger">
                                    <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                </div>
                            </td>` : `<td> </td>`);
            tableBody.appendChild(newRow);
        }
        function removeRow(button) {
            let currentRows = document.querySelectorAll('#properties_tableBody tr').length;
            let row = button.closest('tr');
            if (currentRows > 1) {
                row.remove();
            }
        }

        function addTechnicalPropertyRow(properties, first) {
            let tableBody = document.getElementById('technical_properties_tableBody');
            let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td style="width:50%">
                    <div>
                        <label for="property">Name <span class="text-danger">*</span></label>
                        <input class="form-control form-control-xs validate" name="technical_property_name" value=properties.property_name
                            style="width:100%">
                        
                    </div>
                </td>
                <td style="width:50%">
                    <div>
                        <label for="property">Value <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-xs validate" name="technical_property_value" value=properties.value
                            style=" width:100%">
                        
                    </div>
                </td>` + (!first ? `<td>
                                <div class="mt-1 text-center text-danger">
                                    <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                </div>
                            </td>` : `<td> </td>`);
                
            tableBody.appendChild(newRow);
        }

        function removeTechRow(button) {
            let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;
            let row = button.closest('tr');
            if (currentRows > 1) {
                row.remove();
            }
        }

        function addSustainabilityRow(properties, first) {
            let tableBody = document.getElementById('sustainability_tableBody');
            let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                    <td style="width:50%">
                    <div>
                        <label for="property">Name <span class="text-danger">*</span></label>
                        <input class="form-control form-control-xs validate" name="sustainability_property_name" value=properties.property_name
                            style="width:100%">
                        
                    </div>
                    </td>
                    <td style="width:50%">
                    <div>
                        <label for="property">Value <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-xs validate" name="sustainability_property_value" value=properties.property_name
                            style=" width:100%">
                        
                    </div>
                    </td>` + (!first ? `<td>
                                <div class="mt-1 text-center text-danger">
                                    <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                </div>
                            </td>` : `<td> </td>`);
            tableBody.appendChild(newRow);
        }

        function removeSusRow(button) {
            let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;
            let row = button.closest('tr');
            if (currentRows > 1) {
                row.remove();
            }
        }
    </script>
@endsection

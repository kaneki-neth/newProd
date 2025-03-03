@extends('layouts.app')

@section('title', 'Add Material')

@section('content')
    <style>
        html, body {
            overflow-x: hidden;
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


    <link href="../assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Materials</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Add Material</a></li>
    </ol>
    <h1 class="page-header">Add Material</h1>

    <!-- make new -->
    
    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body" style="padding: 65px !important;">
            <div class="row mb-3 g-0" style="margin: 0px;">
                <!-- diri content sa left -->
                <div class="col-8">
                    <!-- initial text inputs: name, code, category, year -->
                    <div class="row">
                        <div class="col">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-xs validate" name="name" placeholder="...">
                            <span class="error-message"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-xs validate @error('code') is-invalid @enderror"
                                name="code" value="{{ old('code') }}" placeholder="...">
                            <span class="error-message"></span>
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
                            <span class="error-message"></span>
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
                    <!-- description module here -->
                    <div class="row mt-3 g-0">
                        <label for="material_description" class="form-label" >Description <span class="text-danger">*</span></label>
                        <div class="border" style="border-radius: 4px">
                            <textarea class="textarea form-control" name="material_description" id="summernote"
                                placeholder="Enter text ..." rows="12"></textarea>
                        </div>
                    </div>
                    <!-- other details -->
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
                                                    <label class="form-label" for="property">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input class="property-name form-control form-control-xs validate"
                                                        name="property_name" id="property-name-field"
                                                        style=" width:100%">
                                                    <span class="error-message-sub"></span>
                                                </div>
                                            </td>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Value <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-xs validate"
                                                        name="property_value" style=" width:100%">
                                                    <span class="error-message-sub"></span>
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
                                                    <label class="form-label" for="property">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control form-control-xs validate"
                                                        name="technical_property_name" style="width:100%">
                                                    <span class="error-message-sub"></span>
                                                </div>
                                            </td>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Value <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-xs validate"
                                                        name="technical_property_value" style=" width:100%">
                                                    <span class="error-message-sub"></span>
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
                                                    <label class="form-label" for="property">Name <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control form-control-xs validate"
                                                        name="sustainability_property_name" style="width:100%">
                                                    <span class="error-message-sub"></span>
                                                </div>
                                            </td>
                                            <td style="width:50%">
                                                <div>
                                                    <label class="form-label" for="property">Value <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-xs validate"
                                                        name="sustainability_property_value" style=" width:100%">
                                                    <span class="error-message-sub"></span>
                                                </div>
                                            </td>
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
                            <label class="form-label">Upload Image</label>
                            <!-- main/big image -->
                            <div style="border:1px solid var(--bs-component-border-color); border-radius:4px; aspect-ratio: 1 / 1; margin-left: 0 !important; margin-right: 0 !important;"
                                class="row g-0">
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
        const MAX_FILE_SIZE = 100 * 1024 * 1024;

        $(document).ready(function () {
            // Add input handler for all input fields
            $(document).on('input', '.validate', function () {
                let $field = $(this);
                // Remove invalid class
                $field.removeClass('is-invalid');
                // Remove error messages (both types)
                $field.siblings('.error-message').text('');
                $field.siblings('.error-message-sub').text('');
                // Reset border color
                $field.css('border-color', '#ced4da');
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

        });
        $('#summernote').summernote({
            placeholder: 'Enter description',
            height: "300",
            maximumImageFileSize: 102400, // 100MB
            callbacks: {
                onImageUploadError: function (msg) {
                    // console.log(msg + ' (1 MB)');
                }
            }
        });



        function displayImage(input) {
            if (input.files.length > 0) {
                let file = input.files[0];

                if (file.size > MAX_FILE_SIZE) {
                    //dapat swal ni
                    swal("File is too large! Please select an image that is 100MB or under.");
                    return;
                }

                let reader = new FileReader();
                reader.onload = function (e) {
                    let newDiv = document.createElement('div');
                    newDiv.style.flex = '0 0 auto';
                    newDiv.style.width = '25%';
                    newDiv.style.aspectRatio = '1 / 1';
                    newDiv.style.overflow = 'hidden';
                    newDiv.style.display = 'flex';
                    newDiv.style.alignItems = 'center';
                    newDiv.style.justifyContent = 'center';
                    newDiv.style.border = '1px solid var(--bs-component-border-color)';
                    newDiv.style.borderRadius = '4px';

                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.border = '1px solid #d1c3c0';
                    img.id = `preview-image-${imageCount}`;
                    img.onclick = function () {
                        updateMainImage(img.id);

                    };

                    newDiv.appendChild(img);
                    document.getElementById('imageGallery').appendChild(newDiv);

                    imageFiles.push(file);
                    imageCount++;

                    updateMainImage(img.id);
                };


                reader.readAsDataURL(file);
            }
            console.log(imageFiles);
        }

        // update main image sa taas
        function updateMainImage(imageId) {
            let clickedImage = document.getElementById(imageId);
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

            if ($("#material_image").val() === "") {
                swal("Image should not be empty!");
                e.preventDefault();
            }
            if ($("#summernote").val() === "") {
                swal("Description should not be empty!");
                e.preventDefault();
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
                let name = row.querySelector('input[name="property_name"]').value;
                let value = row.querySelector('input[name="property_value"]').value;
                properties.push({ name, value, type: 'soft' });
            });
            // Technical properties
            document.querySelectorAll('#technical_properties_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="technical_property_name"]').value;
                let value = row.querySelector('input[name="technical_property_value"]').value;
                properties.push({ name, value, type: 'technical' });
            });
            // Sustainability properties
            document.querySelectorAll('#sustainability_tableBody tr').forEach(row => {
                let name = row.querySelector('input[name="sustainability_property_name"]').value;
                let value = row.querySelector('input[name="sustainability_property_value"]').value;
                properties.push({ name, value, type: 'application' });
            });

            // Append properties to FormData
            properties.forEach((prop, index) => {
                formData.append(`properties[${index}][name]`, prop.name);
                formData.append(`properties[${index}][value]`, prop.value);
                formData.append(`properties[${index}][type]`, prop.type);
            });

            // Append image files
            imageFiles.forEach((file, index) => {
                formData.append('imageFiles[]', file);
            });

            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('materials.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
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

                        // Display each error message
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

        function addPropertyRow() {
            let tableBody = document.getElementById('properties_tableBody');
            let currentRows = document.querySelectorAll('#properties_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                            <td style="width:50%">
                                <div>
                                    <label for="property">Name <span class="text-danger">*</span></label>
                                    <input class="property-name form-control form-control-xs validate" name="property_name"
                                        style=" width:100%">
                                    <span class="error-message-sub"></span>
                                </div>
                            </td>
                            <td style="width:50%">
                                <div>
                                    <label for="property">Value <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-xs validate" name="property_value"
                                        style=" width:100%">
                                    <span class="error-message-sub"></span>
                                </div>
                            </td>
                            <td>
                                <div class="mt-1 text-center text-danger">
                                    <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                </div>
                            </td>
                            `;
            tableBody.appendChild(newRow);
        }
        function removeRow(button) {
            let currentRows = document.querySelectorAll('#properties_tableBody tr').length;
            let row = button.closest('tr');
            if (currentRows > 1) {
                row.remove();
            }
        }

        ////////////////////////
        function addTechnicalPropertyRow() {
            let tableBody = document.getElementById('technical_properties_tableBody');
            let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td style="width:50%">
                    <div>
                        <label for="property">Name <span class="text-danger">*</span></label>
                        <input class="form-control form-control-xs validate" name="technical_property_name"
                            style="width:100%">
                        <span class="error-message-sub"></span>
                    </div>
                </td>
                <td style="width:50%">
                    <div>
                        <label for="property">Value <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-xs validate" name="technical_property_value"
                            style=" width:100%">
                        <span class="error-message-sub"></span>
                    </div>
                </td>
                <td>
                    <div class="mt-1 text-center text-danger">
                        <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeTechRow(this)"></i>
                    </div>
                </td>
                `;
            tableBody.appendChild(newRow);
        }

        function removeTechRow(button) {
            let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;
            let row = button.closest('tr');
            if (currentRows > 1) {
                row.remove();
            }
        }

        function addSustainabilityRow() {
            let tableBody = document.getElementById('sustainability_tableBody');
            let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;

            let newRow = document.createElement('tr');
            newRow.innerHTML = `
                    <td style="width:50%">
                    <div>
                        <label for="property">Name <span class="text-danger">*</span></label>
                        <input class="form-control form-control-xs validate" name="sustainability_property_name"
                            style="width:100%">
                        <span class="error-message-sub"></span>
                    </div>
                    </td>
                    <td style="width:50%">
                    <div>
                        <label for="property">Value <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-xs validate" name="sustainability_property_value"
                            style=" width:100%">
                        <span class="error-message-sub"></span>
                    </div>
                    </td>
                    <td>
                    <div class="mt-1 text-center text-danger">
                        <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeSusRow(this)"></i>
                    </div>
                    </td>
                    `;
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
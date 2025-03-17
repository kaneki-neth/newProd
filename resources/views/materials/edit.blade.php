@extends('layouts.app')

@section('title', 'Edit Material')

@section('content')

<style>
    html,
    body {
        overflow-x: hidden;
    }

    td,
    th {
        border: none;
    }

    .custom-input {
        height: 30px;
    }

    .select2.select2-container .selection .select2-selection.select2-selection--multiple {
        min-height: 30px !important;
    }

    .select2.select2-container .selection .select2-selection.select2-selection--single {
        min-height: 30px !important;
    }

    .col-4>.row {
        width: 100%;
        min-width: 100%;
    }

    div img#mainImage {
        width: 100%;
        height: 100%;
        object-fit: contain;
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

    .delete-option {
        position: absolute;
        top: 50%;
        left: 50%;
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
        display: inline;
        margin-top: 5px;
        position: relative;
        background-color: white;
        bottom: 10px;
        left: 8px;
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

<link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Materials</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">Material</a></li>
</ol>
<h1 class="page-header">Material (Update)</h1>
<div class="panel panel-inverse">
    <div class="panel-body" id="pannel-body" style="padding: 45px !important;">
        <form method="POST" id="form-update-materials">
            @csrf
            <div class="row mb-3 g-0" style="margin: 0px;">
                <div class="d-flex justify-content-start">
                    <button class="btn btn-primary btn-xs" onclick="location.href=`/material/show/{{$material->m_id}}`">
                        <i class="fa fa-eye"></i> View
                    </button>
                </div>

                <div class="col-8 mt-3">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-xs validate custom-input" name="name" id="name"
                                value="{{ old('name', $material->name) }}" placeholder="...">
                            <span id="name-msg" class="error-message"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-xs validate custom-input" name="code"
                                value="{{ old('material_code', $material->material_code) }}" placeholder="..." id="code">
                            <span id="code-msg" class="error-message"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label for="categories" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm select2 validate" id="categories"
                                name="categories[]" type="text" multiple>
                                @foreach ($categories as $category)
                                <option value="{{ $category->c_id }}"
                                    {{ in_array($category->c_id, $selectedCategories) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            <span id="categories-msg" class="error-message"></span>
                        </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                            <select class="form-control form-control-sm select2" id="year" name="year">
                                @for ($i = 1984; $i <= (date('Y') + 5); $i++)
                                    <option value="{{ $i }}" {{ $i == old('year', $material->year) ? 'selected' : '' }}>
                                    {{ $i }}
                                    </option>
                                    @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row g-0 mt-3">
                        <div class="d-flex flex-row gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="enabled" name="enabled" {{ $material->enabled ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 g-0">
                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                        <span id="description-msg" class="error-msg text-danger"></span>
                        <div id="description" class="border form-control form-control-sm" style="padding: 0px;">
                            <textarea class="textarea form-control" name="description" id="summernote"
                                placeholder="Enter text ..." rows="12">
                                </textarea>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-12 mt-3">
                            <div>
                                <table class="properties_table table table-responsive" id="properties_table" style="border-radius: 4px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Soft Properties</th>
                                            <th></th>
                                            <th class="col-span-2" style="text-align: right;">
                                                <button
                                                    style="width: 50px" type="button" id="addRowBtnRoles"
                                                    onclick="addPropertyRow()" class="btn btn-primary btn-xs"><i
                                                        class="fa fa-add"></i>
                                                </button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="properties_tableBody" style="border-radius: 4px;">
                                        @if(count($properties) < 1)
                                            <tr id="no-data-row">
                                            <td colspan="3">
                                                <span>No Data available..</span>
                                            </td>
                                            </tr>
                                            @endif
                                            @forEach($properties as $prop)
                                            <tr>
                                                <td style="width:100% !important" colspan="2">
                                                    <div>
                                                        <label class="form-label" for="property">Name </label>
                                                        <input class="property-name form-control form-control-xs" name="property_name[]" value="{{$prop->name}}" style=" width:100%">
                                                    </div>
                                                </td>
                                                <td class="d-flex justify-content-center align-items-center" style="height:100%">
                                                    <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3" style="height: 23px">
                                                        <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="oldRemoveRow(this, {{ $prop->p_id }})"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col">
                            <label for="material_source" class="form-label">Material Source</label>
                            <input type="text" class="form-control form-control-xs validate custom-input" name="material_source"
                                placeholder="..." id="material_source" value="{{ old('name', $material->material_source) }}">
                            <span id="material_source-msg" class="error-message"></span>
                        </div>
                    </div>
                    <div class="row mt-3 g-0">
                        <div class="col-12">
                            <div style="border-radius: 4px;">
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
                                        @if(count($techProperties) < 1)
                                            <tr id="no-techData-row">
                                            <td colspan="3">
                                                <span>No Data available..</span>
                                            </td>
                                            </tr>
                                            @endif
                                            @forEach($techProperties as $techprop)
                                            <tr>
                                                <td style="width:50%">
                                                    <div>
                                                        <label class="form-label" for="property">Name </label>
                                                        <input class="property-name form-control form-control-xs" name="tech_property_name[]" value="{{$techprop->name}}" style=" width:100%">

                                                    </div>
                                                </td>
                                                <td style="width:50%">
                                                    <div>
                                                        <label class="form-label" for="property">Value </label>
                                                        <input type="text" class="form-control form-control-xs" name="tech_property_value[]" value="{{$techprop->value}}" style=" width:100%">

                                                    </div>
                                                </td>
                                                <td class="d-flex justify-content-center align-items-center" style="height:100%">
                                                    <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3" style="height: 23px">

                                                        <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="oldRemoveTechRow(this, {{ $techprop->p_id }})"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
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
                                        @if(count($susProperties) < 1)
                                            <tr id="no-appData-row">
                                            <td colspan="3">
                                                <span>No Data available..</span>
                                            </td>
                                            </tr>
                                            @endif
                                            @forEach($susProperties as $appprop)
                                            <tr>
                                                <td style="width:50%">
                                                    <div>
                                                        <label class="form-label" for="property">Name </label>
                                                        <input class="property-name form-control form-control-xs" name="app_property_name[]" value="{{$appprop->name}}" style=" width:100%">

                                                    </div>
                                                </td>
                                                <td style="width:50%">
                                                    <div>
                                                        <label class="form-label" for="property">Value </label>
                                                        <input type="text" class="form-control form-control-xs" name="app_property_value[]" value="{{$techprop->value}}" style=" width:100%">

                                                    </div>
                                                </td>
                                                <td class="d-flex justify-content-center align-items-center" style="height:100%">
                                                    <div class="d-flex flex-column justify-content-end align-items-center text-danger mt-3" style="height: 23px">
                                                        <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="oldRemoveSusRow(this, {{ $appprop->p_id }})"></i>
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
                <div class="col-4 d-flex align-items-end flex-column" style="height: 100%">
                    <div class="row g-0">
                        <div class="col-9" style="margin-left: auto">
                            <label class="form-label">Upload Image <span class="text-danger">*</span></label>
                            <div class="w-100 overflow-hidden ratio ratio-1x1" style="border:1px solid var(--bs-component-border-color); border-radius:4px; margin-left: 0 !important; margin-right: 0 !important; cursor: pointer;"
                                class="row g-0" onclick="document.getElementById('main_material_image').click();">
                                <input type="file" accept="image/*" id="main_material_image" style="display: none;"
                                    onchange="displayMainImage(this)">
                                <img class="w-100 h-100 object-fit-cover" src='/assets/userProfile/no-image-avail.jpg' id="mainImage">
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

                <div class="mt-5 d-flex justify-content-start">
                    <button class="btn btn-primary btn-xs" type="submit">
                        Update
                    </button>
                </div>
        </form>
    </div>
</div>

<script src="/assets/js/jquery-3.6.4.min.js"></script>
<script src="/assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="/assets/plugins/blueimp-load-image/js/load-image.all.min.js"></script>
<script src="/assets/plugins/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="/assets/plugins/blueimp-file-upload/js/jquery.fileupload.js"></script>
<script src="/assets/plugins/blueimp-file-upload/js/jquery.fileupload-process.js"></script>
<script src="/assets/plugins/blueimp-file-upload/js/jquery.fileupload-image.js"></script>
<script src="/assets/plugins/blueimp-file-upload/js/jquery.fileupload-ui.js"></script>
<script src="/assets/plugins/blueimp-file-upload/js/jquery.fileupload-validate.js"></script>
<script src="/assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $('#material').addClass('active');
    let imageCount = 0;
    let imageFiles = [];
    let mainImage;
    const MAX_FILE_SIZE = 100 * 1024 * 1024;

    function displayImage(input) {
        for (let i = 0; i < input.files.length; i++) {
            let file = input.files[i];
            if (file.size > 102400000) {
                swal("File is too large! Please select an image that is 100MB or under.");
                continue;
            }

            let reader = new FileReader();
            reader.onload = function(e) {
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
        if (input) {
            let file = input.files[0];

            if (file.size > MAX_FILE_SIZE) {
                swal("File is too large! Please select an image that is 100MB or under.");
                return;
            }

            let reader = new FileReader();
            reader.onload = function(e) {
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

    function addPropertyRow() {
        let tableBody = document.getElementById('properties_tableBody');
        let currentRows = document.querySelectorAll('#properties_tableBody tr').length;
        let noDataRow = document.getElementById('no-data-row');

        if (noDataRow) {
            noDataRow.remove();
        }
        let newRow = document.createElement('tr');
        newRow.innerHTML = `
                            <td style="width:100% !important" colspan="2">
                                <div>
                                    <label class="form-label" for="property">Name </label>
                                    <input class="property-name form-control form-control-xs" name="property_name[]"
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

    function oldRemoveRow(button, id) {
        deleteOldProps.push(id);
        let tableBody = document.getElementById('properties_tableBody');
        let currentRows = document.querySelectorAll('#properties_tableBody tr').length;
        let row = button.closest('tr');
        row.remove();
    }

    function removeRow(button) {
        let tableBody = document.getElementById('properties_tableBody');
        let currentRows = document.querySelectorAll('#properties_tableBody tr').length;
        let row = button.closest('tr');
        row.remove();
    }

    function addTechnicalPropertyRow() {
        let tableBody = document.getElementById('technical_properties_tableBody');
        let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;
        let noDataRow = document.getElementById('no-techData-row');

        if (noDataRow) {
            noDataRow.remove();
        }

        let newRow = document.createElement('tr');
        newRow.innerHTML = `
                <td style="width:50%">
                    <div>
                        <label class="form-label" for="property">Name </label>
                        <input class="form-control form-control-xs validate" name="tech_property_name[]"
                            style="width:100%">
                        
                    </div>
                </td>
                <td style="width:50%">
                    <div>
                        <label class="form-label" for="property">Value </label>
                        <input type="text" class="form-control form-control-xs validate" name="tech_property_value[]"
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

    function oldRemoveTechRow(button, id) {
        deleteOldTechProps.push(id);
        let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;
        let row = button.closest('tr');
        row.remove();
    }

    function removeTechRow(button) {
        let currentRows = document.querySelectorAll('#technical_properties_tableBody tr').length;
        let row = button.closest('tr');
        row.remove();
    }

    function addSustainabilityRow(properties, first) {
        let tableBody = document.getElementById('sustainability_tableBody');
        let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;
        let noDataRow = document.getElementById('no-appData-row');

        if (noDataRow) {
            noDataRow.remove();
        }
        let newRow = document.createElement('tr');
        newRow.innerHTML = `
                    <td style="width:50%">
                    <div>
                        <label class="form-label" for="property">Name </label>
                        <input class="form-control form-control-xs validate" name="app_property_name[]"
                            style="width:100%">
                        
                    </div>
                    </td>
                    <td style="width:50%">
                    <div>
                        <label class="form-label" for="property">Value </label>
                        <input type="text" class="form-control form-control-xs validate" name="app_property_value[]"
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

    function oldRemoveSusRow(button, id) {
        deleteOldAppProps.push(id);
        let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;
        let row = button.closest('tr');
        row.remove();
    }

    function removeSusRow(button) {
        let currentRows = document.querySelectorAll('#sustainability_tableBody tr').length;
        let row = button.closest('tr');
        row.remove();
    }

    var deleteOldProps = [];
    var deleteOldTechProps = [];
    var deleteOldAppProps = [];
    var deleteOldSubImageIds = [];
    $(document).ready(function() {
        $('#imageError').removeClass("show");
        $('#imageError').hide();
        $('#imageError').empty();
        $('#descriptionError').removeClass("show");
        $('#descriptionError').hide();
        $('#descriptionError').empty();
        // $(document).on('input', '.validate', function () {
        //     let $field = $(this);
        //     $field.removeClass('is-invalid');
        //     $field.siblings('.error-message').text('');
        //     $field.siblings('.error-message-sub').text('');
        //     $field.css('border-color', '#ced4da');
        // });

        $('#categories').select2({
                placeholder: "Select Categories",
                width: "100%"
            })
            .on('change keyup', function() {
                $(".select2-container .selection .select2-selection--multiple").removeClass('error-input');
                $('categories-msg').text('');
            });

        let material = @json($material);
        $('#mainImage').attr('src', '/storage/' + material.image_file + '?t=' + new Date().getTime())
        $.getScript("/assets/plugins/summernote/dist/summernote-lite.min.js", function() {
            $('#summernote').summernote({
                placeholder: 'Enter description',
                height: "300",
                maximumImageFileSize: 102400000,
                callbacks: {
                    onImageUploadError: function(msg) {}
                }
            });
            $('#summernote').summernote('code', material.description);
        });

        let oldSubImages = @json($images);
        if (oldSubImages) {
            oldSubImages.forEach(sub_image => {
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

                toolOverlay.addEventListener('click', function() {
                    let mi_id = sub_image.mi_id;
                    deleteOldSubImage(newDiv, mi_id);
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


    $("#form-update-materials").on("submit", function(event) {
        showLoading();
        event.preventDefault();

        let formData = new FormData(this);

        //---------------------------------------------------------------
        let properties = [];
        let propertyNames = document.getElementsByName('property_name[]');


        let techPropertyNames = document.getElementsByName('tech_property_name[]');
        let appPropertyNames = document.getElementsByName('app_property_name[]');
        let propertyValues = document.getElementsByName('property_value[]');
        let techPropertyValues = document.getElementsByName('tech_property_value[]');
        let appPropertyValues = document.getElementsByName('app_property_value[]');

        for (let i = 0; i < propertyNames.length; i++) {
            properties.push({
                name: propertyNames[i].value,
                value: 'No Value',
                type: 'soft'
            });
        }

        for (let i = 0; i < techPropertyNames.length; i++) {
            properties.push({
                name: techPropertyNames[i].value,
                value: techPropertyValues[i].value,
                type: 'technical'
            });
        }

        for (let i = 0; i < appPropertyNames.length; i++) {
            properties.push({
                name: appPropertyNames[i].value,
                value: appPropertyValues[i].value,
                type: 'application'
            });
        }

        properties.forEach((property, index) => {
            formData.append(`properties[${index}][name]`, property.name);
            formData.append(`properties[${index}][value]`, property.value);
            formData.append(`properties[${index}][type]`, property.type);
        });

        imageFiles.forEach((file, index) => {
            formData.append('imageFiles[]', file);
        });

        if ($('#main_material_image')[0].files[0]) {
            formData.append('mainImage', $('#main_material_image')[0].files[0]);
        }
        //---------------------------------------------------------------

        deleteOldSubImageIds.forEach(id => {
            formData.append('deleteOldSubImageIds[]', id);
        });

        deleteOldProps.forEach(element => {
            formData.append('deleteOldProps[]', element);
        });
        deleteOldTechProps.forEach(element => {
            formData.append('deleteOldTechProps[]', element);
        });
        deleteOldAppProps.forEach(element => {
            formData.append('deleteOldAppProps[]', element);
        });

        formData.set('enabled', $('#enabled').is(':checked') ? 1 : 0);

        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: "{{ route('materials.update', $material->m_id) }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                window.location.href = `/material/show/{{$material->m_id}}`;
            },
            error: function(xhr) {
                if (xhr.status === 400) {
                    const errors = xhr.responseJSON.errors;

                    for (const key in errors) {
                        if (Object.hasOwnProperty.call(errors, key)) {
                            const element = errors[key];
                            let $input_id = key;

                            if (key == 'categories') {
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
                } else if (xhr.status === 413) {
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
    });

    function rm_error(element) {
        $(element).removeClass('error-input');
        $('#' + element.id + '-msg').text('');
    }
</script>
@endsection
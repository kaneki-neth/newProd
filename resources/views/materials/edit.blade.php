@extends('layouts.app')

@section('title', 'Edit Material')

@section('content')


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
            <form method="POST" id="form-update-materials">
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
                                                <tr>
                                                    <td colspan="3">
                                                        <span>No Data available..</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @forEach($properties as $prop)
                                                <tr>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property">Name <span class="text-danger">*</span></label>
                                                            <input class="property-name form-control form-control-xs" name="property_name[]" value="{{$prop->name}}" style=" width:100%">
                                                            
                                                        </div>
                                                    </td>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property">Value <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-xs" name="property_value[]" value="{{$prop->value}}" style=" width:100%">
                                                            
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mt-1 text-center text-danger">
                                                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
                                                        </div>
                                                    </td>  
                                                </tr>
                                            @endforeach
                                            
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
                                            @if(count($techProperties) < 1)
                                                <tr>
                                                    <td colspan="3">
                                                        <span>No Data available..</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @forEach($techProperties as $techprop)
                                                <tr>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property">Name <span class="text-danger">*</span></label>
                                                            <input class="property-name form-control form-control-xs" name="property_name[]" value="{{$techprop->name}}" style=" width:100%">
                                                            
                                                        </div>
                                                    </td>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property">Value <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-xs" name="property_value[]" value="{{$techprop->value}}" style=" width:100%">
                                                            
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mt-1 text-center text-danger">
                                                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
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
                                                <tr>
                                                    <td colspan="3">
                                                        <span>No Data available..</span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @forEach($susProperties as $appprop)
                                                <tr>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property">Name <span class="text-danger">*</span></label>
                                                            <input class="property-name form-control form-control-xs" name="property_name[]" value="{{$appprop->name}}" style=" width:100%">
                                                            
                                                        </div>
                                                    </td>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property">Value <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control form-control-xs" name="property_value[]" value="{{$techprop->value}}" style=" width:100%">
                                                            
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mt-1 text-center text-danger">
                                                            <i type="button" class="fas fa-lg fa-fw fa-trash-can" onclick="removeRow(this)"></i>
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
            
                <div class="d-flex justify-content-start">
                    <button class="btn btn-primary btn-md" type="submit" style="margin: 10px;" onclick="submitData()">
                        <i class="fa fa-plus"></i> Submit
                    </button>
                </div>
            </form>
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
        $(document).ready(function () {
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

        $( "#form-update-materials" ).on( "submit", function( event ) {
            event.preventDefault();

            let formData = new FormData(this);
            formData.append('_token', '{{ csrf_token() }}');
                
                

        });


    </script>
      
@endsection

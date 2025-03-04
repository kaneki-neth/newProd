@extends('layouts.app')

@section('title', 'Vuew Material')

@section('content')
    <style>
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
        <li class="breadcrumb-item"><a href="javascript:;">Material</a></li>
    </ol>
    <h1 class="page-header">View Material</h1>

    <!-- make new -->
    
    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary btn-xs" onclick="window.location.href='/material/{{$material->m_id}}/edit'">
                    Update</button>
            </div>
            <div class="row mb-3 g-0" style="margin: 0px;">
                <!-- diri content sa left -->
                <div class="col-8">
                    <!-- initial text inputs: name, code, category, year -->
                    <div class="row">
                        <div style="width: 50%">
                            <label for="name" class="form-label">Name </label>
                            <input type="text" class="form-control form-control-xs" name="name"
                                value="{{ $material->name }}" readonly>
                        </div>
                        <div style="width: 50%" class="col-md-4">
                            <label for="code" class="form-label">Code </label>
                            <input type="text" class="form-control form-control-xs" name="code"
                                value="{{ $material->material_code }}" readonly>
                            <span class="error-message"></span>
                        </div>
                        <div style="width: 80%">
                            <label for="categories" class="form-label">Category </label>
                            @foreach ($categories as $category)
                                <p>{{ $category->category_name }}</p>
                            @endforeach
                        </div>
                        <div style="width: 20%" class="col-md-2">
                            <label for="year" class="form-label">Year </label>
                            <input type="text" class="form-control form-control-xs" name="year"
                                value="{{ $material->year }}" readonly>
                        </div>
                    </div>
                    <!-- description module here -->
                    <div class="row mt-3 g-0">
                        <label for="material_description" class="form-label">Description </label>
                        <div class="border" style="border-radius: 4px">
                            <p>{{ $material->description }}</p>
                        </div>
                    </div>
                    <!-- other details -->
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div style="border-radius: 4px;">
                                <table class="properties_table table table-responsive" id="properties_table"
                                    style="border-radius: 4px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Properties</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="properties_tableBody" style="border-radius: 4px;">
                                        <tr>
                                            <td style="width:50%">
                                                <div>
                                                    @foreach ($soft_properties as $property)
                                                        <input class="property-name form-control form-control-xs"
                                                            name="property_name" id="property-name-field" style=" width:100%"
                                                            value="{{ $property->property_name }} " readonly>
                                                    @endforeach
                                                </div>
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
                                        </tr>
                                    </thead>
                                    <tbody id="technical_properties_tableBody">
                                        <tr>
                                            <td style="width:50%">
                                                <div>
                                                    @foreach ($technical_properties as $property)
                                                        <input class="form-control form-control-xs"
                                                            name="technical_property_name" style="width:100%"
                                                            value="{{ $property->property_name }}" readonly>
                                                    @endforeach
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
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody id="sustainability_tableBody">
                                        <tr>
                                            <td style="width:50%">
                                                <div>
                                                    @foreach ($application_properties as $property)
                                                        <input class="form-control form-control-xs"
                                                            name="sustainability_property_name" style="width:100%"
                                                            value="{{ $property->property_name }}" readonly>
                                                    @endforeach
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
                            <!-- main/big image -->
                            <div style="border:1px solid var(--bs-component-border-color); border-radius:4px; aspect-ratio: 1 / 1; margin-left: 0 !important; margin-right: 0 !important;"
                                class="row g-0">
                                <img src="{{ asset('material_images/' . basename(optional($images)->first())) }}"
                                    id="mainImage">
                            </div>
                            <!-- container for the stuff to append -->

                            <div id="imageGallery"
                                style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                                <!-- Add Button Square -->
                                <div
                                    style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                    @if (optional($images)->first())
                                        @foreach ($images as $image)
                                            @if ($image != optional($images)->first())
                                                <img src="{{ asset('material_images/' . basename($image)) }}"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <!-- Dynamically added squares will be appended here -->
                            </div>
                        </div>
                    </div>

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
    </script>
@endsection
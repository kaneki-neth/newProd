@extends('layouts.app')

@section('title', 'Add Material')

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
        <li class="breadcrumb-item"><a href="javascript:;">View Material</a></li>
    </ol>
    <h1 class="page-header">View Material</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="d-flex justify-content-end">
                <button class="btn btn-primary btn-xs"><i class="fa fa-plus"></i>
                    Update</button>
            </div>
            <div class="row" style="padding: 20px;">
                <div class="col-8" style="margin: 0px; padding: 0px;">
                    <div>
                        <div class="row">
                            <p style="font-size: 25px;" class="col-6" for="name">Name :
                                {{ $material->name }}
                            </p>
                            <p style="font-size: 25px;" class="col-6" for="year">Year :
                                {{ $material->year }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p style=" font-size: 25px;" for="code">Code :
                            {{ $material->material_code }}
                        </p>
                    </div>

                    <div class="category-list">
                        <ul for="categories">
                            <p style="font-size: 25px;">Categories :</p>
                        </ul>
                        @foreach ($categories as $category)
                            <li class="category-item" for="categories">
                                <p style="font-size: 25px;">{{ $category->category_name }}</p>
                            </li>
                        @endforeach
                    </div>
                    <div>
                        <p style="font-size: 25px;" for="description">Description :</p>
                        <p style="font-size: 25px;">{!! strip_tags($material->description, '<p><br><strong><em><ul><ol><li>') !!}</p>
                    </div>
                    <div>
                        <p style="font-size: 25px;" for="soft_properties">Soft Properties :</p>
                        @foreach ($soft_properties as $soft_property)
                            <p style="font-size: 25px;" for="soft_properties">
                                {{ $soft_property->property_name }}</p>
                        @endforeach
                    </div>

                    <div>
                        <p style="font-size: 25px;" for="technical_properties">Technical
                            Properties :</p>
                        @foreach ($technical_properties as $technical_property)
                            <p style="font-size: 25px;" for="technical_properties">
                                {{ $technical_property->property_name }}</p>
                        @endforeach
                    </div>

                    <div>
                        <p style="font-size: 25px;" for="application_properties">Application
                            Properties :</p>
                        @foreach ($application_properties as $application_property)
                            <p style="font-size: 25px;" for="application_properties">
                                {{ $application_property->property_name }}</p>
                        @endforeach
                    </div>
                </div>
                <div class="col-4">
                    <div class="row g-0">
                        <div class="col-9" style="margin-left: auto">
                            <!-- main/big image -->
                            <div style="border:1px solid var(--bs-component-border-color); border-radius:4px; aspect-ratio: 1 / 1; margin-left: 0 !important; margin-right: 0 !important;"
                                class="row g-0">
                                <img src="{{ asset('material_images/' . basename($images[0])) }}" id="mainImage">
                            </div>
                            <!-- container for the stuff to append -->

                            <div id="imageGallery"
                                style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                                <!-- Add Button Square -->
                                <div id="createButton"
                                    style="border-radius: 4px; flex: 0 0 auto; width: 25%; aspect-ratio: 1/1; background: var(--bs-component-border-color); display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                    @foreach ($images as $image)
                                        @if ($image != $images[0])
                                            <img src="{{ asset('material_images/' . basename($image)) }}"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    @endforeach
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
    <script src="../assets/plugins/blueimp-load-image/js/load-image.all.min.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-process.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-image.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-ui.js"></script>
    <script src="../assets/plugins/blueimp-file-upload/js/jquery.fileupload-validate.js"></script>

    <script>

    </script>
@endsection
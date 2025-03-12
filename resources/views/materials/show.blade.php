@extends('layouts.app')

@section('title', 'Vuew Material')

@section('content')
<style>
        html, body {
            overflow-x: hidden;
        }

        td, th {
            border: none;
        }
        
        div img#mainImage {
            width: 100%;
            height: 100%;
            object-fit: cover;        
            object-fit: contain;
        }

        .col-4 > .row {
            width: 100%;
            min-width: 100%; 
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
            width: 50%; /* Adjust percentage as needed */
            height: 50%; /* Adjust percentage as needed */
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
    <link href="/assets/plugins/summernote/dist/summernote-lite.css" rel="stylesheet" />
    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="{{ route('materials.index') }}">Materials</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Material</a></li>
    </ol>
    <h1 class="page-header">Material</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body" style="padding: 45px !important;">
            <div class="d-flex justify-content-start gap-2">
                <button class="btn btn-primary btn-xs" type="submit" style="" onclick="location.href='/material'">
                    <i class="fa fa-arrow-left"></i> 
                    Back
                </button>
                <button class="btn btn-primary btn-xs" type="submit" style="" onclick="location.href=`/material/{{$material->m_id}}/edit`">
                    <i class="fa fa-edit"></i> 
                    Edit
                </button>
            </div>
            <form method="POST" id="form-update-materials">
                @csrf
                <div class="row mb-3 g-0" style="margin: 0px;">
                    <div class="col-8 mt-3">
                    <div class="row">
                        <div class="col">
                            <label for="name" class="form-label">Name </label>
                            <div class="form-control">
                                {{ $material->name}}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="code" class="form-label">Code </label>
                            <div class="form-control">
                                {{ $material->material_code}}
                            </div>
                        </div>
                    </div>
    
                    <div class="row mt-3">
                        <div class="col">
                            <label class="form-label">Category</label>
                            <div class="form-control">
                                @foreach ($categories as $category)
                                    @if(in_array($category->c_id, $selectedCategories))
                                        <span class="badge" style="background-color: #28acb5">{{ $category->name }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <label class="form-label">Year</label>
                            <div class="form-control">
                                {{ $material->year }}
                            </div>
                        </div>
                    </div>

                    <div class="row g-0 mt-3">
                        <div class="d-flex align-items-center justify-around">
                            @php
                                //<label class="form-label mr-3" for="enabled">Enabled:</label>
                                //@if($material->enabled == 1)
                                //    <span class="badge bg-primary rounded-pill">Enabled</span>
                                //@else
                                //    <span class="badge bg-warning rounded-pill">Disabled</span>
                                //@endif
                            @endphp                         
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="enabled" name="enabled" {{$material->enabled ? 'checked' : ''}} 
                            onclick="return false;" onkeydown="return false;" 
                            style="pointer-events: none;">
                        </div>
                    </div>
    
                    <div class="row mt-3 g-0">
                        <div class="alert alert-yellow fade" style="display: none;" id="descriptionError"></div>
                        <label for="description" class="form-label">Description </label>
                        <div class="border form-control" style="border-radius: 4px; height: 350px; overflow: auto;">
                            @php
                                echo $material->description;
                            @endphp
                        </div>
                    </div>
                    
                    <div class="row g-0 mt-3">
                        <div class="col-12">
                            <div>
                                <table class="properties_table table table-responsive" id="properties_table" style="border-radius: 4px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Soft Properties</th>
                                            <th></th>
                                            <th></th>
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
                                                <td style="width:100% !important" colspan="2">
                                                    <div>
                                                        <label for="property" class="form-label">Name</label> 
                                                        <div class="form-control">
                                                            {{ $prop->name }}
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td> </td>  
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
                            <div class="form-control">
                                @if ($material->material_source)
                                    {{ $material->material_source}}
                                @else
                                    <p></p>
                                @endif                                
                            </div>
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
                                                <th></th>
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
                                            @forEach($techProperties as $techProp)
                                                <tr>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property" class="form-label">Name</label> 
                                                            <div class="form-control">
                                                                {{ $techProp->name }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property" class="form-label">Value</label>
                                                            <div class="form-control">
                                                                {{ $techProp->value }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> </td>  
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <table class="sustainability_table table table-responsive" id="sustainability_table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sustainability and Application</th>
                                                <th></th>
                                                <th></th>
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
                                            @foreach($susProperties as $appProp)
                                                <tr>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property" class="form-label">Name</label> 
                                                            <div class="form-control">
                                                                {{ $appProp->name }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width:50%">
                                                        <div>
                                                            <label for="property" class="form-label">Value</label>
                                                            <div class="form-control">
                                                                {{ $appProp->value }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td> </td>  
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
                            <div class="alert alert-yellow fade" id="imageError"></div>
                            <label class="form-label">Image</label>
                            <div class="w-100 overflow-hidden ratio ratio-1x1" style="border:1px solid var(--bs-component-border-color); border-radius:4px; margin-left: 0 !important; margin-right: 0 !important;"
                                class="row g-0">
                                <img class="w-100 h-100 object-fit-cover"" src='{{ asset('storage').'/'.$material->image_file}}' id="mainImage">
                            </div>
                            @if (count($images) > 0)
                                <div id="imageGallery"
                                    style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                                    @foreach ($images as $image)
                                        <div class="image-container">
                                            <img class="preview-image" src="{{ asset('/storage' . '/' . $image->image_file) }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script src="/assets/plugins/select2/dist/js/select2.min.js"></script>

    <script>
        $('#material').addClass('active');
        $(document).ready(function () {
            $('#imageError').removeClass("show");
            $('#imageError').hide();
            $('#imageError').empty();
            let material = @json($material);
        });

        
    </script>
@endsection
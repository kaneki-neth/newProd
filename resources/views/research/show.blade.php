@extends('layouts.app')

@section('title', 'Research')

@section('content')

    <style>
        .file-display {
            margin-bottom: 10px;
        }

        .file-display a {
            text-decoration: none;
        }

        .file-display a:hover {
            text-decoration: underline;
        }

        .file-display i {
            margin-right: 5px;
            /* Space between icon and text */
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

        #main-img-container {
            aspect-ratio: 1 / 1;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="/research">Research</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Research</a></li>
    </ol>
    <h1 class="page-header">Research (View)</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-start gap-2">
                    <a href="/research" class="btn btn-primary btn-xs"><i class="fa fa-arrow-left"></i> Back</a>
                    @can('research-write')
                        <a href="/research/{{ $research->r_id }}/edit" class="btn btn-primary btn-xs"><i class="fa fa-edit"></i>
                            Edit</a>
                    @endcan
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-7">
                    <div class="d-flex align-items-center">
                        <h2 class="me-2">{{ $research->title }}</h2>
                        @if($research->enabled == 1)
                            <span class="badge bg-secondary rounded-pill">Enabled</span>
                        @else
                            <span class="badge bg-secondary rounded-pill">Disabled</span>
                        @endif
                    </div>
                    <p><i class="fa fa-calendar"></i> {{ date('F j, Y', strtotime($research->date)) }}</p>
                    <p><strong>Authors:</strong> {{ implode(', ', $authors) }}</p>
                    <p><?php echo $research->description ?></p>
                </div>
                <div class="col-md-5">
                    <div class="d-flex flex-column mx-auto" style="max-width: 80%">
                        <div id="main-img-container"
                            class="opacity-75 img-thumbnail d-flex justify-content-center align-items-center">
                            <img src="{{ asset('storage/' . $research->image_file) }}" alt="Image"
                                style="width: 100%; height:100%; object-fit: contain;">
                        </div>
                        @if(count($subImages) > 0)
                            <div id="imageGallery"
                                style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                                @foreach($subImages as $subImage)
                                    <div class="image-container">
                                        <img class="opacity-75" src="{{ asset('storage/' . $subImage->image_file) }}"
                                            style="width: 100%; height: 100%; border: 1px solid #d1c3c0">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-column mt-3 mx-auto" style="max-width: 80%">
                        <h5>Uploaded Files:</h5>
                        <ul class="list-unstyled">
                            @foreach($files as $file)
                                <li class="file-display d-flex align-items-center mb-2">
                                    <a class="btn btn-primary btn-xs me-2">
                                        <i class="fa fa-file-pdf"></i>
                                        {{ basename($file->file_path) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery-3.6.4.min.js"></script>
    <script>
        $('#research').addClass('active');
        $("#pannel-body").attr("style", 'min-height: 78vh;');
    </script>

@endsection('content')
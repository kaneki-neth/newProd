@extends('layouts.app')

@section('title', 'News and Events')

@section('content')

<style>
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
</style>

<ol class="breadcrumb float-xl-end">
    <li class="breadcrumb-item"><a href="/news_events">News and Events</a></li>
    <li class="breadcrumb-item"><a href="javascript:;">View</a></li>
</ol>
<h1 class="page-header">{{ $news_event->category == "news"? "News" : "Event" }} View</h1>

<div class="panel panel-inverse">
    <div class="panel-body" id="pannel-body">
        <div class="row">
            <div class="col-md-7">
                <h3>{{ $news_event->title }}</h3>
                <p><i class="fa fa-calendar"></i> {{ date('M d, Y', strtotime($news_event->date)) }}</p>
                <p><?php echo $news_event->description ?></p>
            </div>
            <div class="col-md-5">
                <div class="d-flex flex-column mx-auto" style="max-width: 60%">
                    <div>
                        <img src="{{ asset('storage/'.$news_event->image_file) }}" class="img-thumbnail" alt="Image">
                    </div>
                    <div id="imageGallery" style="display: flex; gap: 10px; overflow-x: auto; padding: 5px; border: 1px solid #ccc; border-radius: 4px; margin-top: 8px">
                        @foreach($subImages as $subImage)
                            <div class="image-container">
                                <img src="{{ asset('storage/'.$subImage->image_file) }}" style="width: 100%; height: 100%; border: 1px solid #d1c3c0">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#pannel-body").attr("style", 'height: 78vh;');
</script>

@endsection('content')

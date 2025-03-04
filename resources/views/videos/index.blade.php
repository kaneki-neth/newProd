@extends('layouts.app')

@section('title', 'Videos')

@section('content')
    <style>
        .scrollable-cell {
            max-height: 100px;
            overflow-y: auto;
        }
    </style>

    <ol class="breadcrumb float-xl-end">
        <li class="breadcrumb-item"><a href="javascript:;">Videos</a></li>
    </ol>
    <h1 class="page-header">Videos List</h1>

    <div class="panel panel-inverse">
        <div class="panel-body" id="pannel-body">
            <div class="table-responsive" style="overflow-x: hidden">
                <div class="d-flex justify-content-end" style="margin: 10px;">
                    <button class="btn btn-primary btn-xs" onclick="location.href='/videos/create'"><i
                            class="fa fa-plus"></i> Add
                        New</button>
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Video URL</th>
                            <th>Date</th>
                            <th class="text-center" width="5%">View</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videos as $video)
                            <tr>
                                <td id="name" style="color:#28acb5" onclick="location.href='/videos/edit/{{ $video->v_id }}'">
                                    {{ $video->title }}
                                </td>
                                <td>
                                    <div class="scrollable-cell">
                                        {!! strip_tags($video->description, '<p><a><b><i><u><strong><em><ul><ol><li><img>') !!}
                                    </div>
                                </td>
                                <td id="video_url" style="color:#28acb5"
                                    onclick="window.open('{{ $video->video_url }}', '_blank')">
                                    {{ $video->video_url }}
                                </td>
                                <td>{{ $video->date }}</td>
                                <td class="text-center">
                                    <a href="/videos/show/{{ $video->v_id }}" class="btn btn-primary btn-xs">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#pannel-body').DataTable({
                responsive: true
            });
        });
    </script>
@endsection
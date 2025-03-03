@extends('layouts.app')

@section('title', 'Videos')

@section('content')
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videos as $video)
                            <tr>
                                <td>{{ $video->title }}</td>
                                <td>{{ $video->description }}</td>
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
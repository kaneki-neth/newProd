@extends('web.layout.default')

@section('content')
<style>
    .active>.page-link, .page-link.active {
        border-color: #37423b;
        background-color: #37423b;
    }
    .active>.page-link:hover, .page-link.active{
        color: #fff;
        border: 1px solid #37423b !important;
    }

    .page-link:hover {
        border-color: #e2e6de;
        color: #37423b;
    }
    
    .page-link {
        color: #37423b;
    }
</style>

<main class="main main-archive">
    <div class="archive-wrapper container">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
                <div class="d-flex justify-content-between gap-2">
                    <p style="">search results for</p>
                    <h3 style="">"{{ $searchTerm }}"<h3/>
                </div>    
                <div class="search-bar-archive mt-3 mt-md-0">
                    @if (count($materials) == 0)
                        <p>No materials found</p>
                    @else
                        <p>{{ count($materials) }} results</p>
                    @endif
                </div>
            </div>

            <!-- First Row - Mobile: full width -->
            @foreach ($materials as $material)
                <div class="col-6 col-md-3 mt-5">
                    <div class="archive-item">
                        <a href="{{ url('/digital_archive_content/' . $material->m_id) }}">
                            <div class="w-100 overflow-hidden ratio ratio-1x1">
                                <img src='{{ asset('storage') . '/' . $material->image_file}}' alt="Material Image"
                                    class="w-100 h-100 object-fit-cover" />
                            </div>
                            <h5 class="archive-item-title">{{ $material->name }}</h5>
                            <div class="tag">{{ explode(',', $material->category_name)[0] }}</div>
                        </a>
                    </div>
                </div>
            @endforeach
            <div class="d-flex justify-content-center" style="margin-top:100px !important">
                {{ $materials->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</main>







@endsection
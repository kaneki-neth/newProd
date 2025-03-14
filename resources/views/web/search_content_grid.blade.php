@extends('web.layout.default')

@section('content')
<style>
    .active>.page-link,
    .page-link.active {
        border-color: #37423b;
        background-color: #37423b;
    }

    .active>.page-link:hover,
    .page-link.active {
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
        <div class="row mb-4">
            <div class="col-12">
                <div class="search-spec d-flex justify-content-between align-items-center">
                    <div>
                        <span>search results for </span>
                        <span class="search-term-text">"{{ $searchTerm }}"</span>
                    </div>
                    <div>
                        @if (count($materials) == 0)
                        <span>No materials found</span>
                        @else
                        <span>{{ count($materials) }} results</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($materials as $material)
            <div class="col-6 col-md-3 mb-4">
                <div class="archive-item">
                    <a href="{{ url('/digital_archive_content/' . $material->m_id) }}">
                        <div class="w-100 overflow-hidden ratio ratio-1x1">
                            <img src="{{ asset('storage') . '/' . $material->image_file}}"
                                class="w-100 h-100 object-fit-cover" />
                        </div>
                        <h5 class="archive-item-title">{{ $material->name }}</h5>
                        <div class="tag">{{ explode(',', $material->category_name)[0] }}</div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($materials) > 0)
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $materials->links('pagination::bootstrap-4') }}
            </div>
        </div>
        @endif
    </div>
</main>
@endsection
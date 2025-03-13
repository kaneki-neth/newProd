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

<div class="row">
    <div class="swatches-count col-12 mb-1">
        @if(count($materials) > 0)
            <p>{{ count($materials) }} swatches</p>
        @endif
    </div>

    <!-- First Row - Mobile: full width -->
    @if (count($materials) == 0)
        <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
            <h3 style="color: #bbb;">No materials found</h3>
        </div>
    @endif
    @foreach ($materials as $material)
        <div class="col-6 col-md-4 mt-5">
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
        {{ $materials->appends(['categories' => $categories, 'selectedYear' => $selectedYear, 'sortOptions' => $sortOptions, 'selectedCategories' => $selectedCategories, 'searchQuery' => $searchQuery])->links('pagination::bootstrap-4') }}
    </div>
</div>

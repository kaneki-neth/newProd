@extends('web.layout.default')

@section('content')
    <main class="main main-archive">
        <div class="archive-wrapper container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
                <h1 class="archive-title">Digital Archive</h1>
                <div class="search-bar-archive mt-3 mt-md-0">
                    <input type="text" id="search-bar" class="form-control" placeholder="Search by name, code or keyword" value={{ $searchQuery }}>
                </div>
            </div>

            <div class="row">
                <!-- Mobile Filter Toggle Button -->
                <div class="archive-filter-btn col-12 d-lg-none mb-3">
                    <button class="btn btn-outline-secondary w-100" type="button" data-bs-toggle="collapse"
                        data-bs-target="#filterCollapse">
                        <i class="bi bi-funnel me-2"></i>Filter & Sort Options
                    </button>
                </div>

                <!-- filter section starts here - collapsible on mobile -->
                <div class="col-lg-3">
                    <div class="filter-section collapse d-lg-block" id="filterCollapse">
                        <form id="formOptions" method="GET">
                        <h4>Sort by</h4>
                        <div class="filter-option">
                            <input type="checkbox" id="recently-added" class="sort-checkbox" {{ in_array('recently-added', $sortOptions) ? 'checked' : '' }}>
                            <label for="recently-added">Recently Added</label>
                        </div>
                        <div class="filter-option">
                            <input type="checkbox" id="alphabetical" class="sort-checkbox" {{ in_array('alphabetical', $sortOptions) ? 'checked' : '' }}>
                            <label for="alphabetical">Alphabetical</label>
                        </div>

                        <h4 class="mt-4">Filter</h4>

                        <div class="filter-category">
                            <div class="filter-header d-flex justify-content-between align-items-center"
                                id="categoryDropdownToggle">
                                <h4 class="mb-2">Category</h4>
                                <i class="bi bi-caret-down-fill" id="categoryCaret"></i>
                            </div>
                            <div class="category-options" id="categoryOptions" style="display: none">
                                @foreach ($categories as $category)
                                    <div class="filter-option">
                                        <input type="checkbox" class="category-checkbox" id="category_{{ $category->c_id }}" {{ in_array($category->c_id, $selectedCategories) ? 'checked' : '' }} />
                                        <label for="category_{{ $category->c_id }}">{{ $category->name }}</label>
                                    </div>
                                @endforeach
                                
                            </div>
                        </div>

                        <div class="filter-category w-50">
                            <div class="filter-header d-flex justify-content-between align-items-center" id="yearToggle">
                                <h4 class="mb-2">Year</h4>
                                <i class="bi bi-caret-down-fill" id="yearCaret"></i>
                            </div>
                            <div class="year-options" id="yearOptions"
                                style="display: none; max-height: 200px; overflow-y: auto">
                                <div class="year-option-container">
                                    @for($i = date('Y') + 5; $i >= 1984; $i--)
                                        <div class="year-option">{{$i}}</div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                <!-- filter section ends here -->

                <!-- Archive Items Grid -->
                <div class="col-lg-9">
                    <div id="content-area">
                        @include('web.archive.digital_archive_grid', ['materials' => $materials])
                    </div>
                    
                </div>
            </div>
        </div>
    </main>

    <script>
        $("#nav-archive").addClass("active");
        let selectedYear = @json($selectedYear);
        document.querySelectorAll(".year-option-container .year-option").forEach((option) => {
            if (option.textContent.trim() == selectedYear) {
                option.classList.add("selected"); 
            }
        });
        $(document).ready(function () {
            submitFilters(); 

            $("#search-bar").on("keypress", function (event) {
                if (event.key === "Enter") {
                    let searchQuery = $(this).val().trim(); 
                    submitFilters(selectedYear, searchQuery);
                }
            });

            function submitFilters() {
                let queryParams = {};
                queryParams.page = new URLSearchParams(window.location.search).get("page") || 1;

                let sortOptions = $(".sort-checkbox:checked")
                    .map((_, el) => el.id)
                    .get();

                if (sortOptions.length) {
                    queryParams.sort = sortOptions;
                }

                let searchValue = $("#search-bar").val().trim();
                if (searchValue) {
                    queryParams.search = searchValue;
                }

                if (selectedYear) {
                    queryParams.year = selectedYear;
                }

                let selectedCategories = $(".category-checkbox:checked")
                    .map((_, el) => el.id.replace("category_", ""))
                    .get();

                if (selectedCategories.length) {
                    queryParams.selectedCategories = selectedCategories;
                }

                if (selectedCategories.length > 0) {
                    queryParams.selectedCategories = selectedCategories; 
                }
                console.log("Query Params Object:", queryParams);
                let queryString = $.param(queryParams);
                console.log("Query string:", queryString);

                $.ajax({
                    url: "/digital_archive?" + queryString,
                    type: "GET",
                    success: function(response) {
                        $("#content-area").empty().html(response.html);
                        window.history.pushState({}, "", "/digital_archive?" + queryString);
                    }
                });
            }
            // Year selection
        document.querySelectorAll(".year-option").forEach((option) => {
            option.addEventListener("click", function () {
                document.querySelectorAll(".year-option").forEach((opt) => opt.classList.remove("selected"));
                this.classList.add("selected");
                selectedYear = this.dataset.year || this.textContent.trim();
                submitFilters(selectedYear, $("#search-bar").val().trim());
                });
        });

        // Checkbox filtering
        $("input[type='checkbox']").on("change", function() {
            submitFilters(selectedYear, $("#search-bar").val().trim());
        });

        $("#alphabetical, #recently-added").on("change", function() {
            submitFilters(selectedYear, $("#search-bar").val().trim());
        });
        });
        // Category dropdown toggle
        document
            .getElementById("categoryDropdownToggle")
            .addEventListener("click", function () {
                const categoryOptions = document.getElementById("categoryOptions");
                const categoryCaret = document.getElementById("categoryCaret");

                if (categoryOptions.style.display === "none") {
                    categoryOptions.style.display = "block";
                    categoryCaret.classList.remove("bi-caret-down-fill");
                    categoryCaret.classList.add("bi-caret-up-fill");
                } else {
                    categoryOptions.style.display = "none";
                    categoryCaret.classList.remove("bi-caret-up-fill");
                    categoryCaret.classList.add("bi-caret-down-fill");
                }
            });
        
        // Year dropdown toggle
        document
            .getElementById("yearToggle")
            .addEventListener("click", function() {
            const yearOptions = document.getElementById("yearOptions");
            const yearCaret = document.getElementById("yearCaret");

            if (yearOptions.style.display === "none") {
                yearOptions.style.display = "block";
                yearCaret.classList.remove("bi-caret-down-fill");
                yearCaret.classList.add("bi-caret-up-fill");
            } else {
                yearOptions.style.display = "none";
                yearCaret.classList.remove("bi-caret-up-fill");
                yearCaret.classList.add("bi-caret-down-fill");
            }

            const selected = document.querySelector('.year-option.selected');
            if (selected) {
                const currentYear = new Date().getFullYear() + 5;
                const yearDiff = currentYear - parseInt(selectedYear);
                yearOptions.scrollTop = selected.offsetHeight * yearDiff;
            }
            });
    </script>
@endsection
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
        <div class="d-flex justify-content-between align-items-center mt-5 flex-column flex-md-row">
            <h1 class="archive-title">New Materials Developed</h1>
            <div class="search-bar-archive mt-3 mt-md-0">
                <input type="text" id="search-bar" class="form-control" placeholder="Search by name, code or keyword" value={{ $searchQuery }}>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="d-flex justify-content-end align-items-center mb-4 flex-column flex-md-row">
                <div class="search-bar-archive mt-3 mt-md-0">
                    @if (count($materials) == 0)
                    <p>No materials found</p>
                    @else
                    <p class="mt-5">{{ count($materials) }} swatches</p>
                    @endif
                </div>
            </div>
            <div class="col-lg-9">
                <div id="content-area">
                    @include('web.archive.archive_new_grid', ['materials' => $materials])
                </div>
            </div>
            <!-- First Row - Mobile: full width -->
        </div>
    </div>
</main>

<script>
    $("#nav-archive").addClass("active");

    $(document).ready(function() {

        $("#search-bar").on("keypress", function(event) {
            if (event.key === "Enter") {
                submitFilters();
            }
        });

        function submitFilters(pageNumber = 1) {
            let queryParams = {};
            queryParams.page = pageNumber;
            console.log(queryParams);

            let searchValue = $("#search-bar").val().trim();
            if (searchValue) {
                queryParams.searchQuery = searchValue;
            }
            console.log("Query Params Object:", queryParams);
            let queryString = $.param(queryParams);
            console.log("Query string:", queryString);
            console.log("im gona put this thru the url", "/digital_archive_new?" + queryString);
            $.ajax({
                url: "/digital_archive_new?" + queryString,
                type: "GET",
                dataType: "json",
                cache: false,
                success: function(response) {
                    window.history.pushState({}, "", "/digital_archive_new?" + queryString);
                    $("#content-area").empty().html(response.html);
                },
                error: function() {
                    window.location.href = "/digital_archive_new?" + queryString; // Fallback to full page reload if AJAX fails
                }
            });

        }

    });
</script>

@endsection
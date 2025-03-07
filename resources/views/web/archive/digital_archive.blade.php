@extends('web.layout.default')

@section('content')
<main class="main main-archive">
  <div class="archive-wrapper container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-column flex-md-row">
      <h1 class="archive-title">Digital Archive</h1>
      <div class="search-bar-archive mt-3 mt-md-0">
        <input
          type="text"
          class="form-control"
          placeholder="Search by name, code or keyword" />
      </div>
    </div>

    <div class="row">
      <!-- Mobile Filter Toggle Button -->
      <div class="archive-filter-btn col-12 d-lg-none mb-3">
        <button class="btn btn-outline-secondary w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
          <i class="bi bi-funnel me-2"></i>Filter & Sort Options
        </button>
      </div>

      <!-- filter section starts here - collapsible on mobile -->
      <div class="col-lg-3">
        <div class="filter-section collapse d-lg-block" id="filterCollapse">
          <h4>Sort by</h4>
          <div class="filter-option">
            <input type="checkbox" id="recently-added" />
            <label for="recently-added">Recently Added</label>
          </div>
          <div class="filter-option">
            <input type="checkbox" id="alphabetical" />
            <label for="alphabetical">Alphabetical</label>
          </div>

          <h4 class="mt-4">Filter</h4>

          <div class="filter-category">
            <div
              class="filter-header d-flex justify-content-between align-items-center"
              id="categoryDropdownToggle">
              <h4 class="mb-2">Category</h4>
              <i class="bi bi-caret-down-fill" id="categoryCaret"></i>
            </div>
            <div
              class="category-options"
              id="categoryOptions"
              style="display: none">
              <div class="filter-option">
                <input type="checkbox" id="metals" />
                <label for="metals">Metals (click this)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="polymers" />
                <label for="polymers">Polymers (then this)</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="composite" />
                <label for="composite">Composite</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="ceramics" />
                <label for="ceramics">Ceramics</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="woods" />
                <label for="woods">Woods & Natural Fibers</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="textiles" />
                <label for="textiles">Textiles</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="glass" />
                <label for="glass">Glass</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="nanomaterials" />
                <label for="nanomaterials">Nanomaterials</label>
              </div>
              <div class="filter-option">
                <input type="checkbox" id="experimental" />
                <label for="experimental">Experimental/Hybrid</label>
              </div>
            </div>
          </div>

          <div class="filter-category">
            <div
              class="filter-header d-flex justify-content-between align-items-center"
              id="yearToggle">
              <h4 class="mb-2">Year</h4>
              <i class="bi bi-caret-down-fill" id="yearCaret"></i>
            </div>
            <div
              class="year-options"
              id="yearOptions"
              style="display: none; max-height: 200px; overflow-y: auto">
              <div class="year-option-container">
                <div class="year-option">2025</div>
                <div class="year-option">2024</div>
                <div class="year-option">2023</div>
                <div class="year-option">2022</div>
                <div class="year-option">2021</div>
                <div class="year-option">2020</div>
                <div class="year-option">2019</div>
                <div class="year-option">2018</div>
                <div class="year-option">2017</div>
                <div class="year-option">2016</div>
                <div class="year-option">2015</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- filter section ends here -->

      <!-- Archive Items Grid -->
      <div class="col-lg-9">
        <div class="row">
          <div class="swatches-count col-12 mb-1">
            <p>50 swatches</p>
          </div>

          <!-- First Row - Mobile: full width -->
          <div class="col-6 col-md-4">
            <div class="archive-item">
              <a href="/digital_archive_content">
                <img src="{{url('web/assets/img/matix/materials/digital_archive.png')}}" alt="Abaca + Bacbac Mat #125" class="img-fluid" />
                <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
                <div class="tag">Metals</div>
              </a>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125" 
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Polymers</div>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Polymers</div>
            </div>
          </div>

          <!-- Second Row -->
          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Textiles</div>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Textiles</div>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Textiles</div>
            </div>
          </div>

          <!-- Third Row -->
          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Textiles</div>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Textiles</div>
            </div>
          </div>

          <div class="col-6 col-md-4">
            <div class="archive-item">
              <img
                src="{{url('web/assets/img/matix/materials/digital_archive.png')}}"
                alt="Abaca + Bacbac Mat #125"
                class="img-fluid" />
              <h5 class="archive-item-title">Abaca + Bacbac Mat #125</h5>
              <div class="tag">Textiles</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>

  $("#nav-archive").addClass("active");

  // Category dropdown toggle
  document
    .getElementById("categoryDropdownToggle")
    .addEventListener("click", function() {
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
    });

  // Make year options selectable
  document.querySelectorAll(".year-option").forEach((option) => {
    option.addEventListener("click", function() {
      // Remove selected class from all options
      document.querySelectorAll(".year-option").forEach((opt) => {
        opt.classList.remove("selected");
      });

      // Add selected class to clicked option
      this.classList.add("selected");

      // You can add your filtering logic here
      console.log("Selected year:", this.textContent);

      // Optionally close the dropdown after selection
      // document.getElementById('yearOptions').style.display = 'none';
    });
  });
</script>
@endsection
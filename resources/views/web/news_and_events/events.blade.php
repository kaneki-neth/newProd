@extends('web.layout.default')

@section('content')
<main class="main-news">
  <div class="news-wrapper container">
    <h1 class="news-title">News & Events</h1>

    <div class="mobile-dropdown">
      <select id="category-dropdown">
        <option value="news">News</option>
        <option value="events">Events</option>
        <option value="research">Research</option>
        <option value="blogs">Blog</option>
        <option value="videos">Videos</option>
      </select>
    </div>

    <div class="content-layout">
      <div class="sidebar-news">
        <label>
          <input type="radio" name="category" value="news" checked />
          News
        </label>
        <label>
          <input type="radio" name="category" value="events" />
          Events
        </label>
        <label>
          <input type="radio" name="category" value="research" />
          Research
        </label>
        <label>
          <input type="radio" name="category" value="blogs" />
          Blog
        </label>
        <label>
          <input type="radio" name="category" value="videos" />
          Videos
        </label>
      </div>

      <!-- News section -->
      <div class="news-section"></div>
    </div>
  </div>
</main>

<script src="/assets/js/jquery-3.6.4.min.js"></script>

<script>
  $("#nav-events").addClass("active");

  $('#category-dropdown').change(function() {
    var selectedCategory = $(this).val();
    // Update radio button selection
    $('input[name="category"][value="' + selectedCategory + '"]').prop('checked', true);
    // Fetch data
    fetchData();
  });

  // Simple JavaScript to handle the category switching
  document.addEventListener("DOMContentLoaded", function() {

    const radioButtons = document.querySelectorAll(
      'input[name="category"]'
    );
    const categoryContents = document.querySelectorAll(".category-content");

    // Add event listeners to radio buttons
    radioButtons.forEach((radio) => {
      radio.addEventListener("change", function() {
        if (this.checked) {
          // Hide all categories
          categoryContents.forEach((content) => {
            content.classList.remove("active");
          });

          // Show selected category
          const selectedCategory = document.getElementById(this.value);
          if (selectedCategory) {
            selectedCategory.classList.add("active");
          }
        }
      });
    });

    const categoryDropdown = document.getElementById('category-dropdown');

    if (categoryDropdown) {
      // Set initial dropdown value based on which radio is checked
      const checkedRadio = document.querySelector('input[name="category"]:checked');
      if (checkedRadio) {
        categoryDropdown.value = checkedRadio.value;
      }

      // Add change event listener to the dropdown
      categoryDropdown.addEventListener('change', function() {
        // Hide all category content
        document.querySelectorAll('.category-content').forEach(function(content) {
          content.classList.remove('active');
        });

        // Show the selected category content
        const selectedCategory = this.value;
        document.getElementById(selectedCategory).classList.add('active');

        // Also update the radio button state (for larger screens)
        const radioToSelect = document.querySelector(`input[name="category"][value="${selectedCategory}"]`);
        if (radioToSelect) {
          radioToSelect.checked = true;
        }
      });
    }



  });


  function fetchThumbnail(urlValue, element) {
    // Find the specific thumbnail inside this particular card
    const thumbnailPreview = element.querySelector("#thumbnailPreview");
    const thumbnailPlaceholder = element.querySelector("#thumbnailPlaceholder");

    let url = urlValue.trim();
    if (!url) {
      thumbnailPreview.style.display = "none";
      thumbnailPlaceholder.style.display = "block";
      return;
    }

    // Show loading state
    thumbnailPlaceholder.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';

    fetch(`/fetch-thumbnail?url=${encodeURIComponent(url)}`)
      .then(response => response.json())
      .then(data => {
        if (data.thumbnail) {
          thumbnailPreview.src = data.thumbnail;
          thumbnailPreview.style.display = "block";
          thumbnailPlaceholder.style.display = "none";
        } else {
          thumbnailPreview.style.display = "none";
          thumbnailPlaceholder.innerHTML = '<i class="fa fa-exclamation-circle fa-3x mb-2"></i><p>Could not load thumbnail</p>';
          thumbnailPlaceholder.style.display = "block";
        }
      })
      .catch(error => {
        console.error('Error fetching thumbnail:', error);
        thumbnailPreview.style.display = "none";
        thumbnailPlaceholder.innerHTML = '<i class="fa fa-exclamation-circle fa-3x mb-2"></i><p>Error loading thumbnail</p>';
        thumbnailPlaceholder.style.display = "block";
      });
  }
</script>

<script>
  $(document).ready(function() {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);

    var category = urlParams.get('category');
    if (category) {
      $('input[name="category"][value="' + category + '"]').prop('checked', true);
      $('#category-dropdown').val(category);
    }

    var page = urlParams.get('page');
    if (page) {
      fetchData(page, false);
    } else {
      fetchData(null, false);
    }

    window.addEventListener('popstate', function(event) {
      var currentUrlParams = new URLSearchParams(window.location.search);
      var currentCategory = currentUrlParams.get('category');
      var currentPage = currentUrlParams.get('page');

      if (currentCategory) {
        $('input[name="category"][value="' + currentCategory + '"]').prop('checked', true);
        $('#category-dropdown').val(currentCategory);
      }

      fetchData(currentPage, false);
    });
  });

  $('input[name="category"]').change(function() {
    fetchData();
  });

  function paginate(element) {
    var page = element.innerText;
    if (page === '‹') {
      page = parseInt($('.pagination .active').text()) - 1;
    } else if (page === '›') {
      page = parseInt($('.pagination .active').text()) + 1;
    }
    fetchData(page);
  }

  function fetchData(page = null, pushState = true) {
    $('.news-section').html(
      '<div class="d-flex justify-content-center" style="margin-top: 25vh">' +
      '<div class="spinner-border text-primary" role="status">' +
      '<span class="visually-hidden">Loading...</span>' +
      '</div>' +
      '</div>'
    );

    var category = $('input[name="category"]:checked').val();
    var url = window.location.href.split('?')[0] + '?category=' + category;

    if (page) {
      url += '&page=' + page;
    }

    if (pushState) {
      window.history.pushState({
        path: url,
        category: category,
        page: page
      }, '', url);
    }

    $.ajax({
      url: url,
      type: 'GET',
      cache: false,
      success: function(response) {
        $('.news-section').html(response);
      },
      error: function(error) {
        console.log('error:', error);
      }
    });
  }
</script>


@endsection
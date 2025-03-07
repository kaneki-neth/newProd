@extends('web.layout.default')

@section('content')
  <main class="main-news">
    <div class="news-wrapper container">
    <h1 class="news-title">News & Events</h1>

    <div class="content-layout">
      <div class="sidebar-news">
      <label>
        <input type="radio" name="category" value="news" checked />
        News
      </label>
      <label>
        <input type="radio" name="category" value="research" />
        Research
      </label>
      <label>
        <input type="radio" name="category" value="blog" />
        Blog
      </label>
      <label>
        <input type="radio" name="category" value="events" />
        Events
      </label>
      <label>
        <input type="radio" name="category" value="videos" />
        Videos
      </label>
      </div>

      <!-- News section -->
      <div class="news-section">
      <!-- News Category -->
      <div id="news" class="category-content active">
        <h2 class="section-title">News</h2>

        <div class="news-grid">
        <a href="/events_news_content">
          <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-1.png')}}" />
          <div class="card-content">
            <h3 class="card-title">
            DTI launches newly inaugurated Matix UP Cebu
            </h3>
            <p class="card-date">Posted 16 Nov 2025</p>
            <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
            </p>
          </div>
          </div>
        </a>

        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-2.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            UP Cebu Product Design launches Design Week 2023
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-3.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            Prof. AJ Mallari delivers talk "Re-storying Materials and
            its Making"
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-4.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            Wa'y Ka's exhibit introduces new materials to the
            community
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        </div>
      </div>

      <!-- Research Category -->
      <div id="research" class="category-content">
        <h2 class="section-title">Research</h2>

        <div class="news-grid">
        <a href="/events_research_content">
          <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-1.png')}}" />
          <div class="card-content">
            <h3 class="card-title">
            DTI launches newly inaugurated Matix UP Cebu
            </h3>
            <p class="card-date">Posted 16 Nov 2025</p>
            <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
            </p>
          </div>
          </div>
        </a>

        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-2.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            UP Cebu Product Design launches Design Week 2023
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-3.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            Prof. AJ Mallari delivers talk "Re-storying Materials and
            its Making"
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-4.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            Wa'y Ka's exhibit introduces new materials to the
            community
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        </div>
      </div>

      <!-- Blog Category -->
      <div id="blog" class="category-content">
        <h2 class="section-title">Blog</h2>

        <div class="news-grid">
        <a href="/events_blog_content">
          <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-1.png')}}" />
          <div class="card-content">
            <h3 class="card-title">
            DTI launches newly inaugurated Matix UP Cebu
            </h3>
            <p class="card-date">Posted 16 Nov 2025</p>
            <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
            </p>
          </div>
          </div>
        </a>

        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-2.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            UP Cebu Product Design launches Design Week 2023
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-3.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            Prof. AJ Mallari delivers talk "Re-storying Materials and
            its Making"
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/news-4.png')}}" />
          <div class="card-content">
          <h3 class="card-title">
            Wa'y Ka's exhibit introduces new materials to the
            community
          </h3>
          <p class="card-date">Posted 16 Nov 2025</p>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          </div>
        </div>
        </div>
      </div>

      <!-- Events Category -->
      <div id="events" class="category-content">
        <h2 class="section-title">Events</h2>

        <div class="news-grid">
        <a href="/events_events_content">
          <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/events-1.png')}}" />
          <div class="card-content">
            <h3 class="card-title">Matix Launching Event</h3>
            <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
            </p>
            <div class="mt-3 card-info">
            <span class="event-date">Friday, March 21 2025</span>
            <span class="event-time">10:00 AM</span>
            <span class="event-location">Fabrication Laboratory UP Cebu</span>
            </div>
          </div>
          </div>
        </a>

        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/events-2.png')}}" />
          <div class="card-content">
          <h3 class="card-title">Material Dev Workshop</h3>
          <p class="card-excerpt">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            Nunc non justo nec urna euismod pulvinar.
          </p>
          <div class="mt-3 card-info">
            <span class="event-date">Friday, March 21 2025</span>
            <span class="event-time">10:00 AM</span>
            <span class="event-location">Fabrication Laboratory UP Cebu</span>
          </div>
          </div>
        </div>
        </div>
      </div>

      <!-- Videos Category -->
      <div id="videos" class="category-content">
        <h2 class="section-title">Videos</h2>

        <div class="news-grid">
        @foreach ($videos as $video)
      <a class="data-item" href="{{$video->video_url}}" id="urlInput" data-value="{{$video->video_url}}"
        target="_blank">
        <div class="news-card">
        <div class="thumbnail-container" style="margin-left: auto">
        <!-- main/big image -->
        <div style="aspect-ratio: 16 / 9; width: 100%">
        <div id="thumbnail" class="d-flex justify-content-center align-items-center border rounded"
          style="height: 100%;">
          <img id="thumbnailPreview" src=""
          style="max-width: 100%; max-height: 100%; object-fit: cover; display: none; cursor: pointer;" />
          <div id="thumbnailPlaceholder" class="text-center text-muted">
          <i class="fa fa-image fa-3x mb-2"></i>
          <p>Video thumbnail will appear here</p>
          </div>
        </div>
        </div>
        </div>
        <div class="card-content">
        <h3 class="card-title-video">{{$video->title}}</h3>
        <p class="card-excerpt">
        Uploaded <span>{{date('F d, Y', strtotime($video->date))}}</span>
        </p>
        </div>
        </div>
      </a>
    @endforeach
        <div class="news-card">
          <img src="{{url('web/assets/img/matix/materials/video-1.png')}}" />
          <div class="card-content">
          <h3 class="card-title-video">Design Week 2025 Recap</h3>

          </div>
        </div>
        </div>
      </div>
      </div>
    </div>
    </div>
    </div>
  </main>

  <script src="/assets/js/jquery-3.6.4.min.js"></script>

  <script>

    $("#nav-events").addClass("active");

    // Simple JavaScript to handle the category switching
    document.addEventListener("DOMContentLoaded", function () {

    // Fetch thumbnail for each video
    document.querySelectorAll(".data-item").forEach(function (element) {
      let urlValue = element.getAttribute("data-value");
      fetchThumbnail(urlValue, element);
    });

    const radioButtons = document.querySelectorAll(
      'input[name="category"]'
    );
    const categoryContents = document.querySelectorAll(".category-content");

    // Add event listeners to radio buttons
    radioButtons.forEach((radio) => {
      radio.addEventListener("change", function () {
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

    function truncateToWordCount(element, wordCount) {
      // Get the full text from data attribute (if available) or from the element's text content
      const fullText = element.getAttribute('data-full-text') || element.textContent;
      const words = fullText.split(/\s+/);

      if (words.length <= wordCount) {
      return; // No need to truncate
      }

      element.textContent = words.slice(0, wordCount).join(' ') + '...';
    }

    // Apply word limit to all card excerpts (alternative to CSS-only solution)
    document.querySelectorAll('.card-excerpt').forEach(excerpt => {
      truncateToWordCount(excerpt, 10); // Truncate to 25 words
    });

    document.querySelectorAll('.card-title-video').forEach(excerpt => {
      truncateToWordCount(excerpt, 8); // Truncate to 25 words
    });



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

    fetch(`/get-thumbnail?url=${encodeURIComponent(url)}`)
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
@endsection
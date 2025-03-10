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
            @foreach($news as $n)
              <a href={{ route('news_content', ['n_id' => $n->n_id]) }}>
                <div class="news-card">
                  <div style="width: 100%; height: 280px;" class="d-flex justify-content-center align-items-center">
                    <img class="mw-100 mh-100" style="object-fit: contain;" src="{{ asset('storage/'.$n->image_file) }}" />
                  </div>
                  <div class="card-content">
                    <h3 class="card-title">
                      {{ $n->title }}
                    </h3>
                    <p class="card-date">Posted {{ $n->date }}</p>
                    <p class="card-excerpt" style="height: 2.8em;">
                      {{ $n->excerpt }}
                    </p>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Research Category -->
        <div id="research" class="category-content">
          <h2 class="section-title">Research</h2>

          <div class="news-grid">
            @foreach($researches as $r)
              <a href="{{ route('research_content', ['r_id' => $r->r_id]) }}">
                <div class="news-card">
                  <div style="width: 100%; height: 280px;" class="d-flex justify-content-center align-items-center">
                    <img class="mw-100 mh-100" style="object-fit: contain;" src="{{ asset('storage/'.$r->image_file) }}" />
                  </div>
                  <div class="card-content">
                    <h3 class="card-title">
                      {{ $r->title }}
                    </h3>
                    <p class="card-date">Posted {{ $r->date }}</p>
                    <p class="card-excerpt" style="height: 2.8em;">
                      {{ $r->excerpt }}
                    </p>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Blog Category -->
        <div id="blog" class="category-content">
          <h2 class="section-title">Blog</h2>

          <div class="news-grid">
            @foreach($blogs as $b)
              <a href="{{ route('blog_content', ['b_id' => $b->b_id]) }}">
                <div class="news-card">
                  <div style="width: 100%; height: 280px;" class="d-flex justify-content-center align-items-center">
                    <img class="mw-100 mh-100" style="object-fit: contain;" src="{{ asset('storage/'.$b->image_file) }}" />
                  </div>
                  <div class="card-content">
                    <h3 class="card-title">
                      {{ $b->title }}
                    </h3>
                    <p class="card-date">Posted {{ $b->date }}</p>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Events Category -->
        <div id="events" class="category-content">
          <h2 class="section-title">Events</h2>

          <div class="news-grid">
            @foreach($events as $e)
              <a href="{{ route('event_content', ['e_id' => $e->e_id]) }}">
                <div class="news-card">
                  <div style="width: 100%; height: 280px;" class="d-flex justify-content-center align-items-center">
                    <img class="mw-100 mh-100" style="object-fit: contain;" src="{{ asset('storage/'.$e->image_file) }}" />
                  </div>
                  <div class="card-content">
                    <h3 class="card-title">{{ $e->title }}</h3>
                    <p class="card-excerpt" style="height: 2.8em;">
                      {{ $e->excerpt }}
                    </p>
                    <div class="mt-3 card-info">
                      <span class="event-date">{{ $e->date }}</span>
                      <span class="event-time">{{ $e->time }}</span>
                      <span class="event-location">{{ $e->location }}</span>
                    </div>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>

        <!-- Videos Category -->
        <div id="videos" class="category-content">
          <h2 class="section-title">Videos</h2>

          <div class="news-grid">
            <a href="#" target="_blank">
              <div class="news-card">
                <img src="{{url('web/assets/img/matix/materials/video-1.png')}}" />
                <div class="card-content">
                  <h3 class="card-title-video">Teaser | What is Matix? with the Designers chuchu</h3>
                  <p class="card-excerpt">
                    Uploaded <span>25 Feb 2025</span>
                  </p>
                </div>
              </div>
            </a>

            <div class="news-card">
              <img src="{{url('web/assets/img/matix/materials/video-1.png')}}" />
              <div class="card-content">
                <h3 class="card-title-video">Design Week 2025 Recap</h3>
                <p class="card-excerpt">
                  Uploaded <span>25 Feb 2025</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>

  $("#nav-events").addClass("active");

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
</script>
@endsection
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

<div id="news" class="category-content active">
  <h2 class="section-title">{{ ucfirst($category) }}</h2>

  @if($items->isEmpty())
  <div class="d-flex justify-content-center align-items-center" style="height: 300px;">
    <h3 style="color: #bbb;">No {{ $category }} found</h3>
  </div>
  @else

  @if($category != 'videos')
  <div class="news-grid">
    @foreach($items as $item)
    <a href={{ route($routeName, [$category[0] . '_id' => $item->id]) }}>
      <div class="news-card">
        <div class="news-card-img" style="width: 100%; height: 350px; overflow: hidden;">
          <img style="width: 100%; height: 100%; object-fit: cover;" src="{{ asset('storage/' . $item->image_file) }}" />
        </div>
        <div class="card-content">
          <h3 class="card-title">
            {{ $item->title }}
          </h3>
          @if ($category != 'events')
          <p class="card-date">Posted {{ $item->date }}</p>
          <p class="card-excerpt" style="height: 2.8em;">
            {{ $item->excerpt }}
          </p>
          @else
          <p class="card-excerpt" style="height: 2.8em;">
            {{ $item->excerpt }}
          </p>
          <div class="mt-2 card-info">
            <span class="event-date">{{ $item->date }}</span>
            <span class="event-time">{{ $item->time }}</span>
            <span class="event-location">{{ $item->location }}</span>
            <button class="event-link" data-registration-link="{{ $item->registration_link }}">Register Now</button>
          </div>
          @endif
        </div>
      </div>
    </a>
    @endforeach
  </div>

  @else

  <div class="news-grid">
    @foreach ($items as $video)
    <a class="data-item" href="{{$video->video_url}}" id="urlInput" data-value="{{$video->video_url}}" target="_blank">
      <div class="news-card">
        <div class="thumbnail-container">
          <!-- main/big image -->
          <div style="aspect-ratio: 16 / 9; width: 100%">
            <div id="thumbnail" class="d-flex justify-content-center align-items-center border rounded"
              style="height: 100%;">
              <img id="thumbnailPreview" src="" style="max-width: 100%; max-height: 100%; object-fit: cover; display: none; cursor: pointer;" />
              <div id="thumbnailPlaceholder" class="text-center text-muted">
                <i class="fa fa-image fa-3x mb-2"></i>
                <p>Video thumbnail will appear here</p>
              </div>
            </div>
          </div>
        </div>
        <div class="card-content">
          <h3 class="card-title-video">{{$video->title}}</h3>
          <p class="card-excerpt card-excerpt-video">
            Uploaded <span>{{date('d M Y', strtotime($video->date))}}</span>
          </p>
        </div>
      </div>
    </a>
    @endforeach
    <script>
      document.querySelectorAll('.data-item').forEach(item => {
        fetchThumbnail(item.getAttribute('data-value'), item);
      });
    </script>
  </div>
  @endif

  <div class="d-flex justify-content-center" style="margin-top: 100px !important;">
    {{ $items->links('pagination::bootstrap-4') }}
  </div>

  <script>
    document.querySelectorAll('.pagination a').forEach(function(element) {
      element.removeAttribute('href');
      element.setAttribute('onclick', 'paginate(this)');
    });
    @endif

    function truncateToWordCount(element, wordCount) {
      const fullText = element.getAttribute('data-full-text') || element.textContent;
      const words = fullText.split(/\s+/);

      if (words.length <= wordCount) {
        return;
      }

      element.textContent = words.slice(0, wordCount).join(' ') + '...';
    }

    document.querySelectorAll('.card-excerpt').forEach(excerpt => {
      truncateToWordCount(excerpt, 10);
    });

    document.querySelectorAll('.card-title-video').forEach(excerpt => {
      truncateToWordCount(excerpt, 4);
    });
  </script>
</div>
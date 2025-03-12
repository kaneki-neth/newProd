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

<div id="news" class="category-content active">
  <h2 class="section-title">{{ ucfirst($category) }}</h2>

  @if($category != 'videos')
    <div class="news-grid">
      @foreach($items as $item)
        <a href={{ route($routeName, [$category[0].'_id' => $item->id]) }}>
          <div class="news-card">
            <div style="width: 100%; height: 280px;" class="d-flex justify-content-center align-items-center">
              <img class="mw-100 mh-100" style="object-fit: contain;"
                src="{{ asset('storage/' . $item->image_file) }}" />
            </div>
            <div class="card-content">
              <h3 class="card-title">
                {{ $item->title }}
              </h3>
              <p class="card-date">Posted {{ $item->date }}</p>
              <p class="card-excerpt" style="height: 2.8em;">
                {{ $item->excerpt }}
              </p>
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
            <div class="thumbnail-container" style="margin-left: auto">
              <!-- main/big image -->
              <div style="aspect-ratio: 16 / 9; width: 100%">
                <div id="thumbnail" class="d-flex justify-content-center align-items-center border rounded" style="height: 100%;">
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
              <p class="card-excerpt">
                Uploaded <span>{{date('F d, Y', strtotime($video->date))}}</span>
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
    document.querySelectorAll('.pagination a').forEach(function (element) {
      element.removeAttribute('href');
      element.setAttribute('onclick', 'paginate(this)');
    });
  </script>
</div>
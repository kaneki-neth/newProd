@extends('web.layout.default')

@section('content')
<main class="main-news">

  <div class="article-container">
    <a href="/events?category=news">
      <div class="article-category">News</div>
    </a>
    <h1 class="article-title">
      {{ $news->title }}
    </h1>
    <div class="article-meta">
      <p class="article-date">Posted <span>{{ $news->date }}</span></p>
      <p class="article-author">by <span>{{ $news->created_by }}</span></p>
    </div>
    <img
      src="{{ asset('storage/'.$news->image_file) }}"
      alt="{{ $news->title }}" class="article-featured-image" />

    <div class="article-content">
      <p>
        <?php echo $news->description; ?>
      </p>
    </div>
  </div>
</main>

<script>
  $("#nav-events").addClass("active");
</script>
@endsection
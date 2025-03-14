@extends('web.layout.default')

@section('content')
<main class="main-news">

  <div class="article-container">
    <a href="/events?category=research">
      <div class="article-category">Research</div>
    </a>
    <h1 class="article-title">
      {{ $research->title }}
    </h1>
    <div class="article-meta">
      <p class="article-date">Posted <span>{{ $research->date }}</span></p>
      <p class="article-author">by <span>{{ $research->created_by }}</span></p>
    </div>
    <img
      src="{{ asset('storage/'.$research->image_file) }}"
      alt="{{ $research->title }}" class="article-featured-image" />

    <div class="article-content">
      <p>
        <?php echo $research->description; ?>
      </p>
    </div>
  </div>
</main>

<script>
  $("#nav-events").addClass("active");
</script>
@endsection
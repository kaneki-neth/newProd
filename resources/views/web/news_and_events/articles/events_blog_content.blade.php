@extends('web.layout.default')

@section('content')
<main class="main-news">

  <div class="article-container">
    <div class="article-category">Blog</div>
    <h1 class="article-title">
      {{ $blog->title }}
    </h1>
    <div class="article-meta">
      <p class="article-date">Posted <span>{{ $blog->date }}</span></p>
      <p class="article-author">by <span>{{ $blog->created_by }}</span></p>
    </div>
    <img
      src="{{ asset('storage/'.$blog->image_file) }}"
      alt="{{ $blog->title }}" class="article-featured-image" />

    <div class="article-content">
      <?php echo $blog->description; ?>
    </div>
  </div>
</main>

<script>
  $("#nav-events").addClass("active");
</script>
@endsection
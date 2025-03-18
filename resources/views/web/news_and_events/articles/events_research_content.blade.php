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
      <p class="article-date">Published <span>{{ $research->date }}</span></p>
      <p class="article-author">by
      @php
      $maxAuthors = 3;
      $authorCount = count($authors);
      $displayAuthors = array_slice($authors, 0, $maxAuthors);
  @endphp
      <span>{{ implode(', ', $displayAuthors) }}</span>
      @if($authorCount > $maxAuthors)
      <span>et al.</span>
    @endif
      </p>
    </div>
    <img src="{{ asset('storage/' . $research->image_file) }}" alt="{{ $research->title }}"
      class="article-featured-image" />

    <div class="generate-qr" data-bs-toggle="modal" data-bs-target="#qrModal">
      <i class="bi bi-filetype-pdf"></i>
      @foreach($files as $file)
      <a href="" onclick="openPdf('{{ asset('storage/' . $file->file_path) }}')">
      <span>View or download PDF</span>
      </a>
    @endforeach
    </div>

    <div class="article-content">
      <p>
      <?php echo $research->description; ?>
      </p>
    </div>
    </div>
  </main>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    $("#nav-events").addClass("active");

    function openPdf(pdfUrl) {
    window.open(pdfUrl, '_blank');
    }
  </script>
@endsection
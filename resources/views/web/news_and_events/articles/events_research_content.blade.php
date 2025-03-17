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
      <p class="article-author">by <span>{{ implode(', ', $authors) }}</span></p>
    </div>
    <img src="{{ asset('storage/' . $research->image_file) }}" alt="{{ $research->title }}"
      class="article-featured-image" />

    <div class="article-content">
      @foreach($files as $file)
      <li class="file-display d-flex align-items-center mb-2">
      <a href="" onclick="openPdf('{{ asset('storage/' . $file->file_path) }}')">
      <i class="fa-solid fa-file-pdf"></i>
      <span>View or download PDF</span>
      </a>
      </li>
    @endforeach
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
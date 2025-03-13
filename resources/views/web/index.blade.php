@extends('web.layout.default')

@section('content')
<main class="main">

  <!-- hero starts here -->
  <section id="hero" class="hero section dark-background">
    <div class="container">
      <p data-aos="fade-up" data-aos-delay="100" class="mb-5 arial_narrow_7 banner-title">Sustainability and optimism for the future.</p>
    </div>
  </section>
  <!-- hero ends here -->

  <!-- desktop/tablet: here-sum-1 starts here -->
  <section id="hero-sum-1" class="mt-5">
    <div class="container mt-5">
      <div class="row">

        <div class="hero-sum-img1 col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico1.png')}}" class="img-fluid" style="width: 60%;">
          </div>
          <div class="text-center">
            <p class="hero-sum-title dmsans-semi-bold mb-0" style="font-size: 20px;">Explore 1000+ materials</p>
            <p class="dmsans-regular">A constantly growing collection of materials for various applications.</p>
          </div>
        </div>

        <div class="hero-sum-img2 col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico2.png')}}" class="img-fluid" style="width: 50%;">
          </div>
          <div class="text-center">
            <p class="hero-sum-title dmsans-semi-bold mb-0" style="margin-top:8px; font-size: 20px;">Smart categorization</p>
            <p class="dmsans-regular">Easily browse by type, industry, sustainability, and more.</p>
          </div>
        </div>

        <div class="hero-sum-img3 col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico3.png')}}" class="img-fluid" style="width: 50%;">
          </div>
          <div class="text-center">
            <p class="hero-sum-title dmsans-semi-bold mb-0" style="font-size: 20px;">Latest trends in local research</p>
            <p class="dmsans-regular">News, breakthroughs, and case studies in material design.</p>
          </div>
        </div>

        <div class="hero-sum-img4 col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico4.png')}}" class="img-fluid" style="width: 35%; margin-top: 18px;">
          </div>
          <div class="text-center">
            <p class="hero-sum-title dmsans-semi-bold mb-0" style="font-size: 20px; margin-top: 26px;">Sustainability & creativity</p>
            <p class="dmsans-regular">From biodegradable to high-tech composites.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- desktop/tablet: here-sum-1 ends here -->

  <!-- mobile: here-sum-2 starts here -->
  <section id="hero-sum-2">
    <div class="container">
      <div class="row">
        <div class="col-md-6 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="100">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico1.png')}}" class="img-fluid" style="max-width: 40%;">
          </div>
          <div class="text-center mt-3">
            <p class="dmsans-semi-bold mb-0" style="font-size: 15px;">Explore 1000+ materials</p>
            <p class="dmsans-regular" style="margin-top:10px; font-size: 12px;">A constantly growing collection of materials for various applications.</p>
          </div>
        </div>

        <div class="col-md-6 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="200">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico2.png')}}" class="img-fluid" style="max-width: 40%;">
          </div>
          <div class="text-center mt-3">
            <p class="dmsans-semi-bold mb-0" style="font-size: 15px;">Smart categorization</p>
            <p class="dmsans-regular" style="margin-top:10px; font-size: 12px;">Easily browse by type, industry, sustainability, and more.</p>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="300">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico3.png')}}" class="img-fluid" style="max-width: 40%;">
          </div>
          <div class="text-center mt-3">
            <p class="dmsans-semi-bold mb-0" style="font-size: 15px;">Latest trends in local research</p>
            <p class="dmsans-regular" style="margin-top:10px; font-size: 12px;">News, breakthroughs, and case studies in material design.</p>
          </div>
        </div>

        <div class="col-md-6 d-flex flex-column align-items-center" data-aos="fade-up" data-aos-delay="400">
          <div class="text-center">
            <img src="{{url('web/assets/img/img_ico/img_ico4.png')}}" class="img-fluid mt-3" style="max-width: 30%;">
          </div>
          <div class="text-center mt-3">
            <p class="dmsans-semi-bold mb-0" style="font-size: 15px;">Sustainability & creativity</p>
            <p class="dmsans-regular" style="margin-top:10px; font-size: 12px;">From biodegradable to high-tech composites.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- mobile: here-sum-2 ends here -->

  <!-- about starts here -->
  <section id="about" class="about section">
    <div class="container">
      <div class="row gy-4">
        @if (count($latest_news) > 0)
          <div class="about-right col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100" style="padding-left: 60px; border-left: 1px solid gray;">

            <h5 class="text-uppercase arial_narrow_7">What's New?</h5>

            <div class="about-new owl-carousel">
              @foreach($latest_news as $news)
                <div class="item">
                  <a href="{{ route('news_content', ['n_id' => $news->n_id]) }}">
                    <h3 class="dmsans-regular mt-4"><strong>{{ $news->title }}</strong></h3>
                  </a>
                  <p class="dmsans-regular">Posted {{ $news->date }}</p>
                  <div style="height: 230px;">
                    <img src="{{ asset('storage/'.$news->image_file) }}" class="mw-100 mh-100 object-fit-contain">
                  </div>
                </div>
              @endforeach
            </div>

            <div class="carousel-progress">
              <div class="carousel-progress-bar"></div>
            </div>
          </div>
        @endif

        <div class="about-left {{ count($latest_news) > 0 ? 'col-lg-6' : 'col-lg-12' }} order-2 order-lg-1 content d-flex align-items-center" 
          data-aos="fade-up" data-aos-delay="200"
          style={{ count($latest_news) > 0 ? "border-right: 1px solid gray; padding-right: 60px;" : "" }}
        >
          <div>
            <h1 class="arial_narrow_7">Materials Innovation <br>and Exploration</h1>
            <p class="dmsans-regular mt-4">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus suscipit erat in nibh auctor posuere. Donec a venenatis mauris. Mauris mollis risus eu turpis condimentum, et sagittis ex facilisis. Duis et quam a eros posuere volutpat. Morbi vel maximus leo, nec pellentesque quam. Vivamus porta iaculis ante at laoreet. Integer facilisis vehicula arcu at faucibus.
            </p>

            <a href="/about" class="read-more mt-3"><span class="arial_narrow_7">Learn More</span></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- about ends here -->

  <!-- archive starts here -->
  @if (count($recommended_materials) > 0)
    <section id="about-materials" data-aos="fade-up" data-aos-delay="100">
      <div class="container">
        <div class="row">
          <div class="col-12 d-flex justify-content-between">
            <h3 class="arial_narrow_7">
              Materials
            </h3>
            <a href="/digital_archive" class="arial_narrow_7 reroute c-black">Go to digital archives</a>
          </div>
          <div class="slides col-12 mt-5">
            <div class="materials owl-carousel owl-theme">
              @foreach ($recommended_materials as $material)
                <div class="item">
                  <div style="width: 80%; aspect-ratio: 1 / 1; overflow: hidden;">
                    <img src="{{ asset('storage') . '/' . $material->image_file }}" class="w-100 h-100 object-fit-cover">
                  </div>
                  <div>
                    <h6 class="dmsans-semi-bold mt-3 mb-2">{{ $material->material_name }}</h6>
                    <div style="height: 40px;">
                      <a href="#" class="read-more mt-3" style="padding: 7px 15px;
                        border: 1px solid #e2e2e246;
                        border-radius: 20px;
                        font-size: 12px;
                        background-color: #e2e2e246;">
                        <span class="arial_narrow_7 c-light-light-gray dmsans-regular">{{ $material->category_name }}</span>
                      </a>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif
  <!-- archive ends here -->

  <!-- mail starts here -->
  <section id="mail" class="c-orange">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-5">
          <h2 class="c-black arial_narrow_7">Join our mailing list</h2>
          <p class="dmsans-regular mt-3">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus suscipit erat in nibh auctor posuere. Donec a venenatis mauris. Mauris mollis risus eu turpis condimentum, et sagittis ex facilisis.
          </p>
        </div>

        <div class="col-md-7">
          <form method="post" action="/subscribe">
            @csrf
            <div class="row">
              <div class="col-12 col-md-6">
                <label class="dmsans-semi-bold">Full name</label>
                <input class="dmsans-regular @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" style="width: 100%; padding: 4px 25px; border: 1px solid #ccc;">
                @error('name')
                <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-12 col-md-6">
                <label class="dmsans-semi-bold">Email Address</label>
                <input class="dmsans-regular @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" style="width: 100%; padding: 4px 25px; border: 1px solid #ccc;">
                @error('email')
                <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="mt-3">
              <button type="submit" class="read-more" style="padding: 10px 30px; border: 1px solid black; display: inline-block; background: none;">
                <span class="arial_narrow_7 c-black">Subscribe</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <div class="toast-container position-fixed top-0 end-0 p-3">
    @if(session('success'))
    <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('success') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    @endif

    @if(session('warning'))
    <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          {{ session('warning') }}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
    @endif
  </div>
  <!-- mail ends here -->
</main>

@if(session('success') || session('warning'))
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function(toastEl) {
      return new bootstrap.Toast(toastEl);
    });
    toastList.forEach(toast => toast.show());
    
    // Auto-hide after 3 seconds
    setTimeout(function() {
      toastList.forEach(toast => toast.hide());
    }, 3000);
  });
</script>
@endif

<script>
  $(document).ready(function() {
    var owl = $(".about-new");

    owl.owlCarousel({
      items: 1,
      loop: true,
      nav: true,
      dots: false,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      navText: ["<", ">"]
    });

    // Progress bar
    let latest_news = @json($latest_news);
    let count = latest_news.length;
    $(".carousel-progress-bar").css("width", (100 / count) + "%");
    var p_index = 1;
    owl.on('changed.owl.carousel', function(event) {
      p_index++;
      if (p_index > count) {
        p_index = 1;
      }
      let progress = (100 / count) * p_index + "%";
      $(".carousel-progress-bar").css("width", progress);
    });
  });

  $(function() {
    // Owl Carousel
    var owl = $(".materials");
    owl.owlCarousel({
      margin: 10,
      loop: true,
      nav: false,
      autoplay: true,
      autoplayTimeout: 3000,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 2, // Show 2 items on mobile (375px and below)
          margin: 5 // Smaller margins for mobile
        },
        376: {
          items: 3 // Show 3 items for medium screens
        },
        768: {
          items: 4 // Default 4 items for larger screens
        }
      }
    });
  });
</script>
@endsection
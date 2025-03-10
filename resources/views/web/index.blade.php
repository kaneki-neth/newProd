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

        <div class="about-left col-lg-6 order-2 order-lg-1 content d-flex align-items-center" data-aos="fade-up" data-aos-delay="200" style="border-right: 1px solid gray; padding-right: 60px;">
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
            <div class="item">
              <div style="width: 80%;">
                <img src="{{url('web/assets/img/matix/materials/digital_archive.png')}}" class="">
              </div>
              <div>
                <h6 class="dmsans-semi-bold mt-3 mb-2">Abaca + Bacbac Mat #125</h6>
                <div style="height: 40px;">
                  <a href="#" class="read-more mt-3" style="padding: 7px 15px;
                border: 1px solid #e2e2e246;
                border-radius: 20px;
                font-size: 12px;
                background-color: #e2e2e246;"><span class="arial_narrow_7 c-light-light-gray dmsans-regular">Textiles</span></a>
                </div>
              </div>
            </div>

            <div class="item">
              <div style="width: 80%;">
                <img src="{{url('web/assets/img/matix/materials/image-mat-2.png')}}" class="">
              </div>
              <div>
                <h6 class="dmsans-semi-bold mt-3 mb-2">Abaca + Bacbac Mat #125</h6>
                <div style="height: 40px;">
                  <a href="#" class="read-more mt-3" style="padding: 7px 15px;
                border: 1px solid #e2e2e246;
                border-radius: 20px;
                font-size: 12px;
                background-color: #e2e2e246;"><span class="arial_narrow_7 c-light-light-gray dmsans-regular">Textiles</span></a>
                </div>
              </div>
            </div>

            <div class="item">
              <div style="width: 80%;">
                <img src="{{url('web/assets/img/matix/materials/polyem.png')}}" class="">
              </div>
              <div>
                <h6 class="dmsans-semi-bold mt-3 mb-2">Polyem Vasa</h6>
                <div style="height: 40px;">
                  <a href="#" class="read-more mt-3" style="padding: 7px 15px;
                border: 1px solid #e2e2e246;
                border-radius: 20px;
                font-size: 12px;
                background-color: #e2e2e246;"><span class="arial_narrow_7 c-light-light-gray dmsans-regular">Textiles</span></a>
                </div>
              </div>
            </div>

            <div class="item">
              <div style="width: 80%;">
                <img src="{{url('web/assets/img/matix/materials/image.png')}}" class="">
              </div>
              <div>
                <h6 class="dmsans-semi-bold mt-3 mb-2">Outdoor 008 Twisted</h6>
                <div style="height: 40px;">
                  <a href="#" class="read-more mt-3" style="padding: 7px 15px;
                border: 1px solid #e2e2e246;
                border-radius: 20px;
                font-size: 12px;
                background-color: #e2e2e246;"><span class="arial_narrow_7 c-light-light-gray dmsans-regular">Textiles</span></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
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
          <div class="row">
            <div class="col-12 col-md-6">
              <label class="dmsans-semi-bold">Full name</label>
              <input class="dmsans-regular" type="text" name="name" style="width: 100%; padding: 4px 25px; border: 1px solid #ccc;">
            </div>
            <div class="col-12 col-md-6">
              <label class="dmsans-semi-bold">Email Address</label>
              <input class="dmsans-regular" type="text" name="email" style="width: 100%; padding: 4px 25px; border: 1px solid #ccc;">
            </div>
          </div>

          <div class="mt-3">
            <a href="#" class="read-more" style="padding: 10px 30px; border: 1px solid black; display: inline-block;">
              <span class="arial_narrow_7 c-black">Subscribe</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- mail ends here -->
</main>

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
    owl.on('changed.owl.carousel', function(event) {
      var progress = (event.item.index / event.item.count) * 100;
      $(".carousel-progress-bar").css("width", progress + "%");
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
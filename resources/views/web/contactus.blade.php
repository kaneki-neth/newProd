@extends('web.layout.default')

@section('content')
<main class="main main-connect">
  <div class="connect-wrapper container">

    <div class="row">
      <div class="col-12">
        @if(session('success'))
        <div class="alert alert-success alert-sm py-2">
          {{ session('success') }}
        </div>
        @endif

        @if(session('warning'))
        <div class="alert alert-warning alert-sm py-2">
          {{ session('warning') }}
        </div>
        @endif
      </div>
    </div>

    <div class="row g-5">
      <div class="col-md-6">
        <div class="my-5">
          <h2>Connect with us</h2>
          <div class="mb-2 d-flex">
            <div class="contact-label">Email</div>
            <div class="content-left">matix.upcebu@up.edu.ph</div>
          </div>
          <div class="mb-2 d-flex">
            <div class="contact-label">Phone</div>
            <div class="content-left">(032) 232 8187</div>
          </div>
        </div>

        <div class="my-5">
          <h2>Socials</h2>
          <div class="mb-2 d-flex">
            <div class="social-label">Facebook</div>
            <a href="https://www.facebook.com/matixupcebu" target="_blank">
              <div class="content-left">matixupcebu</div>
            </a>
          </div>
          <div class="mb-2 d-flex">
            <div class="social-label">Instagram</div>
            <a href="https://www.instagram.com/matix_upc/" target="_blank">
              <div class="content-left">matix_upcebu</div>
            </a>
          </div>
          <div class="mb-2 d-flex">
            <div class="social-label">TikTok</div>
            <a href="https://www.tiktok.com/@matix_upc" target="_blank">
              <div class="content-left">matix_upcebu</div>
            </a>
          </div>
          <div class="mb-2 d-flex">
            <div class="social-label">YouTube</div>
            <a href="https://www.youtube.com/@matix_upc" target="_blank">
              <div class="content-left">matix_upcebu</div>
            </a>
          </div>
        </div>

        <div class="media-kit">
          <h2>Media Kit</h2>
          <div class="media-kit-container">
            <a href="{{url('web/assets/pdf/matix_media_kit.pdf')}}" download="matix_media_kit.pdf">
              <img src="{{url('web/assets/img/media_kit.png')}}" style="cursor: pointer;">
            </a>
            <h6>View or <a style="text-decoration: underline;" href="{{url('web/assets/pdf/matix_media_kit.pdf')}}" download="matix_media_kit.pdf">download</a> our media kit for any of your publicity and media needs.</h6>
          </div>
        </div>
      </div>

      <div class="connect-right col-md-6">

        <h2 class="mb-4">Leave us a message.</h2>

        <form method="POST" action="/email-sent">
          @csrf
          <div class="mb-3">
            <label for="fullname" class="form-label">Full name</label>
            <input type="text" class="form-input form-control form-control-sm @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-input form-control form-control-sm @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="purpose" class="form-label">Purpose</label>
            <select class="form-input form-select form-select-sm @error('purpose') is-invalid @enderror" id="purpose" name="purpose">
              <option selected disabled>see options</option>
              <option value="General Inquiry" {{ old('purpose') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
              <option value="Book a Visit" {{ old('purpose') == 'Book a Visit' ? 'selected' : '' }}>Book a Visit</option>
              <option value="Collaboration" {{ old('purpose') == 'Collaboration' ? 'selected' : '' }}>Collaboration</option>
              <option value="Event Registration" {{ old('purpose') == 'Event Registration' ? 'selected' : '' }}>Event Registration</option>
              <option value="Others" {{ old('purpose') == 'Others' ? 'selected' : '' }}>Others</option>
            </select>
            @error('purpose')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-input form-control form-control-sm @error('message') is-invalid @enderror" id="message" name="message" rows="20">{{ old('message') }}</textarea>
            @error('message')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="connect-submit btn btn-sm btn-outline-dark px-4">Submit</button>
        </form>
      </div>
    </div>

    <div class="connect-full row mt-5">
      <div class="col-12">
        <h2>Where we are</h2>

        <div class="connect-location">
          <div class="connect-location-sm">
            <div class="map-container">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4149.052641354404!2d123.89536283388834!3d10.32241948270293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a9993a4125b47f%3A0xd96f121ffee417a9!2sUniversity%20of%20the%20Philippines%20Cebu!5e0!3m2!1sen!2sph!4v1741584283811!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="connect-loc-info">
              <div class="location-info">
                <p><span class="info-first">FabLab UP Cebu</span><br>
                  University of the Philippines Cebu<br>
                  Gorordo Avenue, Lahug<br>
                  Cebu City 6000</p>
              </div>
              <a href="https://maps.app.goo.gl/y7rLR5koGMCjcqJY8" target="_blank" class="map-link">Go to Google Maps</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  $("#nav-contact").addClass("active");
</script>
@endsection
@extends('web.layout.default')

@section('content')
<main class="main main-connect">
  <div class="container">
    <div class="row g-5">
      <div class="col-md-5">
        <section class="mb-5">
          <h2>Connect with us</h2>
          <div class="mb-2 d-flex">
            <div class="contact-label">Email</div>
            <div class="content-left">matix.upcebu@up.edu.ph</div>
          </div>
          <div class="mb-2 d-flex">
            <div class="contact-label">Phone</div>
            <div class="content-left">(032) 232 8187</div>
          </div>
        </section>

        <section>
          <h2>Socials</h2>
          <div class="mb-2 d-flex">
            <div class="social-label">Facebook</div>
            <a href="" target="_blank">
              <div class="content-left">matixupcebu</div>
            </a>
          </div>
          <div class="mb-2 d-flex">
            <div class="social-label">Instagram</div>
            <a href="" target="_blank">
              <div class="content-left">matixupcebu</div>
            </a>
          </div>
          <div class="mb-2 d-flex">
            <div class="social-label">TikTok</div>
            <a href="" target="_blank">
              <div class="content-left">matixupcebu</div>
            </a>
          </div>
          <div class="mb-2 d-flex">
            <div class="social-label">YouTube</div>
            <a href="" target="_blank">
              <div class="content-left">matixupcebu</div>
            </a>
          </div>
        </section>
      </div>

      <div class="connect-right col-md-7">
        <form>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full name</label>
            <input type="text" class="form-input form-control form-control-sm" id="fullname" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-input form-control form-control-sm" id="email" required>
          </div>

          <div class="mb-3">
            <label for="purpose" class="form-label">Purpose</label>
            <select class="form-input form-select form-select-sm" id="purpose">
              <option selected>see options</option>
              <option value="0">General Inquiry</option>
              <option value="1">Book a Visit</option>
              <option value="2">Collaboration</option>
              <option value="3">Event Registration</option>
              <option value="4">Others</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-input form-control form-control-sm" id="message" rows="20"></textarea>
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
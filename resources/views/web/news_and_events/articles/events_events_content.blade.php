@extends('web.layout.default')

@section('content')
<main style="margin-bottom: 250px;" class="main-news">
  <div class="news-wrapper container">
    <a href="/events?category=events">
      <div class="article-category">Events</div>
    </a>

    <div class="row">
      <div class="col-lg-6">
        <h1 class="article-title">{{ $event->title }}</h1>

        <div class="event-meta">
          <div class="event-meta-item">
            <i class="bi bi-calendar"></i>
            <span>{{ $event->date }}</span>
          </div>
          <div class="event-meta-item">
            <i class="bi bi-clock"></i>
            <span>{{ $event->time }} PT</span>
          </div>
          <div class="event-meta-item">
            <i class="bi bi-geo-alt"></i>
            <span>{{ $event->location }}</span>
          </div>

          <div class="event-reg-link mt-5">
            @if($event->registration_link)
            <a href="{{ $event->registration_link }}" class="btn reg-btn">Register Now</a>
            @endif
          </div>
        </div>

        <div class="event-description">
          <p>
            <?php echo $event->description; ?>
          </p>
        </div>

        <!-- <div class="more-details">
              <h2 class="more-dets-events">More details</h2>
              
              <div class="detailed-description">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempor ac purus et congue. Curabitur feugiat velit lorem, a efficitur dolor porttitor at. Aliquam rhoncus porta sem, vel eleifend lorem gravida in. Curabitur ullamcorper lectus at blandit ullamcorper. Fusce lorem nulla, commodo in commodo a, posuere vitae augue. Pellentesque non justo vestibulum, volutpat nulla quis, feugiat dui. Duis diam leo, finibus eget dapibus vitae, aliquam a lorem. Sed finibus sapien in ligula dictum auctor. Nam libero justo, bibendum quis ornare in, egestas ac ipsum. Sed nisl enim, volutput odio nisl quis, pharetra feugiat arcu. Maecenas suscipit purus odio. Aenean consequat at mi eget consectetur.</p>
                
                <p>Nam ut pretium nibh, eget saonet odio. Nunc porta, sem a dignissim tincidunt, libero purus ornare augue, sit amet condimentum nisi lacus sed lacus. Etiam nec lectus purus. Sed non sem libero. Sed et quam odio. Nunc euismod eros dui, eu efficitur quam cursus blandit. Etiam molestie sed nunc eget consents nibh porta sed. Quisque mauris mi, vehicula et felis sed, porta dictum libero. Suspendisse elit amet comvallis risus.</p>
                
                <p>Suspendisse pretium, arcu ac fringilla vulputate, sem felis imperdiet ipsum, a porttitor ipsum justo at ex. Mauris duis sem porttitor eget efficitur augue, cursus sit amet tellus. Sed eget vestibulum quam. Sed vulputate ligula eget felis efficitur, at tincidunt orci ultrices. Donec sed nequa ligula. Aenean sem risus, sollicitudin sit gravida eget, aliquam porta sapien. Sed eu mollis nulla, sit amet fringilla leo. Integer phareque libero a convilis vulputate. Aliquam erat volutpat. In finibus convallis, id id consectetur. Mauris interdum viverra mauris, ac vehicula magna fermentum pulvinar.</p>
              </div>
            </div> -->
      </div>

      <div class="col-lg-6 event-image">
        <img src="{{url('storage/'.$event->image_file)}}" />
      </div>
    </div>
  </div>
</main>

<script>
  $("#nav-events").addClass("active");
</script>
@endsection
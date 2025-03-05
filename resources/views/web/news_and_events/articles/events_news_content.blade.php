@extends('web.layout.default')

@section('content')
<main class="main-news">

  <div class="article-container">
    <div class="article-category">News</div>
    <h1 class="article-title">
      DTI launches newly inaugurated Matix UP Cebu
    </h1>
    <div class="article-meta">
      <p class="article-date">Posted <span>16 Nov 2025</span></p>
      <p class="article-author">by <span>Ardinan Jag Senique</span></p>
    </div>
    <img
      src="{{url('web/assets/img/matix/materials/news-1.png')}}"
      class="article-featured-image" />

    <div class="article-content">
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis tempor
        ac purus et congue. Curabitur fringilla velit lorem, a efficitur
        dolor porttitor et. Aliquam rhoncus porta sem, vel placerat lorem
        gravida in. Curabitur ultricorper vel rhoncus blandit ullamcorper.
        Fusce lorem nulla, commodo in commodo a, posuere vitae augue.
        Pellentesque non justo vestibulum, volutpat nulla ut, egestas dui.
        Duis diam leo, luctus eget dapibus eget, aliquam a tellus. Sed
        finibus sapien in ligula dictum auctor. Nam libero justo, bibendum
        quis ornare in, egestas ac magna. Sed nisi sunt, euismod quis nisi
        quia gravida magna amet. Maecenas suscipit purus odio. Aenean
        consequat et in eget consectetur.
      </p>

      <p>
        Nam ut pretium nibh, eget laoreet odio. Nunc porta, sem a dignissim
        tincidunt, libero purus ornare augue, sit amet condimentum nisi
        tortor sed lacus. Etiam nec luctus purus. Sed non sem lorem. Sed et
        quam odio. Nunc euismod eros dui, eu efficitur quam cursus blandit.
        Etiam molestie eros amet, eget convallis nibh purus laoreet. Quisque
        mauris vehicula et felis sed, porta dictum lacus. Suspendisse sit
        amet convallis risus.
      </p>
    </div>
  </div>
</main>

<script>
  $("#nav-events").addClass("active");
</script>
@endsection
@extends('web.layout.default')

@section('content')
<main class="main main-about">

  <section class="first-about">
    <div class="about-wrapper container">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-5">
          <h1 class="about-title">About Matix UP Cebu</h1>
        </div>
        <div class="col-12 col-md-6 col-lg-7">
          <p class="about-description">
            Tatak Pinoy - MATIX UP Cebu is designed to be a multi-faceted
            innovation hub that supports material exploration, product
            development, industry collaboration, and knowledge
            dissemination. Through its Materials Research and Development,
            Business Incubation, Physical Materials Library, and Digital
            Archiving System, the center bridges the gap between research,
            design, and commercialization, making a meaningful impact on
            sustainability and material innovation in the Philippines.
          </p>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="video-container">
            <img
              src="{{url('web/assets/img/matix/about-img-0.png')}}"
              class="materials-image img-fluid"
              style="object-fit: cover" />
            <div class="play-button">
              <i class="bi bi-play-fill"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="second-about research-section">
    <div class="about-wrapper container">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-7">
          <h1>Materials Research and Development</h1>
          <h2>For the Academe: Faculty and Students</h2>

          <p class="research-description">
            MATIX UP Cebu serves as a hub for research and development (R&D)
            in materials science, engineering, and sustainable design.
            Through interdisciplinary collaboration, faculty members and
            students engage in exploring new and existing materials,
            including indigenous, bio-based, recycled, and advanced
            composites. They conduct experiments to assess the mechanical,
            thermal and environmental properties of materials, evaluating
            their viability for various applications. A key focus of their
            research is sustainability, with an emphasis on evaluating the
            life-cycle impact of materials and promoting circular economy
            principles and waste reduction. The center also encourages
            collaborative research projects by fostering partnerships with
            other universities, industry leaders, and government agencies to
            develop cutting-edge materials.
          </p>

          <p class="research-description">
            Through these initiatives, MATIX UP Cebu empowers students and
            faculty to innovate, prototype, and publish research that
            contributes to the global discourse on materials sustainability
            and innovation.
          </p>
        </div>
        <div class="col-12 col-md-6 col-lg-5">
          <div class="research-image">
            <img
              src="{{url('web/assets/img/matix/about-img-01.png')}}"
              class="img-fluid" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="third-about product-section">
    <div class="about-wrapper container">
      <div class="row">
        <div class="product-tab col-md-6 col-lg-7 col-12 order-md-1 order-2">
          <div class="product-images">
            <img
              src="{{url('web/assets/img/matix/about-img-02.png')}}"
              class="img-fluid mb-4" />
            <img
              src="{{url('web/assets/img/matix/about-img-03.png')}}"
              class="img-fluid" />
          </div>
        </div>

        <div class="col-md-6 col-12 col-lg-5 order-md-2 order-1">
          <h1>Product Development and Business Incubation</h1>
          <h2>Bringing in International Experts and Visiting Professors</h2>

          <p class="product-description">
            Beyond materials research, MATIX UP Cebu plays a pivotal role in
            bridging innovation and commercialization by providing product
            development and business incubation services. The center hosts
            expert-led workshops and training, where international experts,
            visiting professors, and industry leaders share best practices
            in product design, materials engineering, and sustainable
            manufacturing. It also offers prototyping support, assisting
            startups, designers, and entrepreneurs in developing and testing
            material-based products using the resources available in the
            lab.
          </p>

          <p class="product-description">
            In addition, MATIX UP Cebu provides business mentorship and
            incubation, connecting innovators with experienced mentors who
            guide them in refining product concepts, securing funding, and
            entering the market. The center also facilitates
            industry-academia collaboration, fostering partnerships between
            businesses and the university to drive R&D in new product lines
            and material applications.
          </p>

          <p class="product-description">
            By nurturing material-driven enterprises, MATIX UP Cebu helps
            transform research and ideas into viable, market-ready products
            that contribute to both local and global industries.
          </p>
        </div>
      </div>
    </div>
  </section>

  <div class="fourth-about library-section">
    <div class="about-wrapper container">
      <div class="row">
        <div class="col-12 col-md-6 col-lg-7">
          <h1>Materials Library</h1>
          <h2>Swatches and Resources</h2>

          <p class="library-description">
            The Materials Library at MATIX UP Cebu serves as an interactive
            repository of physical material samples, swatches, and technical
            data, providing a valuable resource for a wide range of users.
            Designers, architects, and engineers have hands-on access to a
            diverse array of materials, offering inspiration and helping
            with project specifications.
          </p>

          <p class="library-description">
            For academics and researchers, the library supports comparative
            analysis and material selection for research and prototyping.
            Entrepreneurs and manufacturers can explore innovative and
            sustainable materials for potential use in commercial products.
            The library includes bio-based materials, composites, polymers,
            textiles, recycled materials, and advanced smart materials, all
            carefully cataloged with their specifications and potential
            applications.
          </p>

          <h1 class="mt-5">Digital Archiving and Cataloging System</h1>

          <p class="library-description mt-5">
            To enhance accessibility and documentation, MATIX UP Cebu
            integrates a comprehensive Digital Archiving and Cataloging
            System. This system includes an online database of materials,
            providing a user-friendly platform that houses detailed records
            of all materials in the library, including descriptions,
            properties, and high-resolution images. It also contains
            extensive metadata about material sources, applications, case
            studies, and technical reports, ensuring long-term
            accessibility. The system's automated tagging and search
            functions allow for quick retrieval of material information
            based on categories such as sustainability impact, application
            area, and technical performance. Additionally, it offers
            seamless integration with design and research tools, including
            CAD software and Adobe Creative Suite, to streamline material
            research.
          </p>

          <p class="library-description">
            This digital repository serves as a knowledge hub for students,
            faculty, industry professionals, and researchers, making
            material data and insights more accessible and widely
            disseminated.
          </p>
        </div>

        <div class="col-12 col-md-6 col-lg-5">
          <div class="materials-grid">
            <img
              src="{{url('web/assets/img/matix/about-img-04.png')}}"
              class="img-fluid" />
          </div>

      </div>
    </div>
  </div>
</main>

<script>
  $("#nav-about").addClass("active");
</script>
@endsection
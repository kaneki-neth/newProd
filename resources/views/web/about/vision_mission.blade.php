@extends('web.layout.default')

@section('content')
<div class="container py-5">
    <!-- Vision and Mission Section -->
    <div class="row mb-5">
        <!-- Vision Section -->
        <div class="col-md-6">
            <h1 class="section-title">Vision</h1>
            <p>To be a leading hub for sustainable materials innovation and creativity in the Philippines, empowering communities, industries, and academia to pioneer cutting-edge solutions that promote environmental stewardship, cultural preservation, and economic resilience.</p>
        </div>

        <!-- Mission Section -->
        <div class="col-md-6">
            <h1 class="section-title">Mission</h1>
            <p>Matls UP Cebu is dedicated to advancing sustainable materials research, fostering interdisciplinary collaboration, and promoting innovation-driven education. Through cutting-edge technologies, industry partnerships, and community engagement, we aim to empower Filipino innovators, preserve cultural heritage, and drive economic growth while addressing global environmental challenges.</p>
        </div>
    </div>

    <!-- Core Values Section -->
    <div class="mt-4">
        <h1 class="section-title">Core Values</h1>

        <div class="divider"></div>

        <div class="row">
            <!-- First Row -->
            <div class="col-md-6 mb-4">
                <h2 class="value-title">Innovation and Creativity</h2>
                <p>We foster a culture of curiosity, experimentation, and bold thinking to develop cutting-edge materials and solutions that address societal challenges.</p>
            </div>

            <div class="col-md-6 mb-4">
                <h2 class="value-title">Excellence and Integrity</h2>
                <p>We uphold the highest standards of professionalism, ethics, and transparency in research, development, and engagement activities.</p>
            </div>

            <!-- Second Row -->
            <div class="col-md-6 mb-4">
                <h2 class="value-title">Sustainability</h2>
                <p>We are committed to promoting sustainable practices, materials, and technologies that minimize environmental impact and support long-term ecological balance.</p>
            </div>

            <div class="col-md-6 mb-4">
                <h2 class="value-title">Empowerment</h2>
                <p>We aim to empower students, researchers, and community members with the skills, knowledge, and tools to innovate and lead transformative changes.</p>
            </div>

            <!-- Third Row -->
            <div class="col-md-6 mb-4">
                <h2 class="value-title">Collaboration and Inclusivity</h2>
                <p>We value teamwork and partnerships across disciplines, industries, and communities, ensuring an inclusive and supportive environment for diverse voices and ideas.</p>
            </div>

            <div class="col-md-6 mb-4">
                <h2 class="value-title">Community-Centered Development</h2>
                <p>We are dedicated to addressing local and national needs by creating accessible and impactful solutions that benefit Filipino communities and industries.</p>
            </div>

            <!-- Fourth Row -->
            <div class="col-md-6 mb-4">
                <h2 class="value-title">Cultural Preservation</h2>
                <p>We prioritize the integration of Filipino heritage and traditional knowledge into materials innovation, celebrating our cultural identity while advancing modern solutions.</p>
            </div>
        </div>
    </div>
</div>

<script>
    $("#nav-about").addClass("active");
</script>
@endsection
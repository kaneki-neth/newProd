@extends('web.layout.default')

@section('content')
<style>
    .download-btn img:hover {
        transform: scale(1.025);
        z-index: 2;
        background-color: yellow;
    }

    .download-btn img {
        transition: 0.1s;
    }

    #max-properties {
        display: inline-block;
        color: #000;
        padding: 5px 13px;
        border-radius: 20px;
        border: 1px solid #444;
        background: none;
        font-size: 12px;
        margin-top: 5px;
        transition: all 0.3s ease;
    }
</style>

<main class="main main-archive">
    <div class="archive-wrapper">
        <div class="container py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mobile-text-sm">
                    <li class="breadcrumb-item">
                        <a href="/digital_archive">Digital Archive</a>
                    </li>
                    <li class="breadcrumb-item active dmsans-semi-bold" aria-current="page">
                        {{ $material->name }}
                    </li>
                </ol>
            </nav>

            <div class="archive-row row">
                <div class="archive-col-lg-6 col-lg-6">
                    <!-- Material Information -->
                    <h1 class="material-title">{{ $material->name }}</h1>

                    <div class="category-section d-flex align-items-center">
                        <div class="category-label">Category</div>
                        @if (count($categories))
                        @foreach ($categories as $index => $categoryOption)
                        @if ($index < 3)
                            <span class="category-tag me-2">{{ $categoryOption->name }}</span>
                            @elseif ($index === 3)
                            <span class="category-tag me-2" id="max-properties">+</span>
                            @break
                            @endif
                            @endforeach
                            @endif
                    </div>

                    <div class="year-section d-flex align-items-center">
                        <div class="year-label">Year</div>
                        <span class="year-tag me-2">{{ $material->year }}</span>
                    </div>

                    <div class="properties-section d-flex align-items-center">
                        <div class="properties-label">Properties</div>
                        @if (count($properties))
                        @foreach ($properties as $index => $property)
                        @if ($index < 3)
                            <span class="properties-tag me-2">{{ $property->name }}</span>
                            @elseif ($index === 3)
                            <span class="properties-tag me-2" id="max-properties">+</span>
                            @break
                            @endif
                            @endforeach
                            @endif
                    </div>

                    <div class="material-code d-flex align-items-center">
                        <div class="material-code-title">Material Code</div>
                        <span>{{ $material->material_code }}</span>
                    </div>

                    <div class="material-description mt-5">
                        <h3 class="archive-section-heading">Description</h3>
                        <p>
                            @php
                            echo $material->description;
                            @endphp
                        </p>
                    </div>

                    <div class="source-section mt-4">
                        <h3 class="archive-section-heading">Source</h3>
                        <p>{{ $material->material_source }}</p>
                    </div>

                    <div class="technical-properties mt-5">
                        <h3 class="archive-section-heading">Technical Properties</h3>
                        @foreach ($techProperties as $techProp)
                        <div class="technical-property">
                            <div>{{ $techProp->name }}</div>
                            <div>{{ $techProp->value }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="sustainability-section mt-5">
                        <h3 class="archive-section-heading">
                            Sustainability & Applications
                        </h3>
                        @foreach ($susProperties as $susProp)
                        <div class="sustainability-property">
                            <div>{{ $susProp->name }}</div>
                            <div>{{ $susProp->value }}</div>
                        </div>
                        @endforeach
                    </div>

                    <div class="generate-qr" data-bs-toggle="modal" data-bs-target="#qrModal">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Generate material QR code</span>
                    </div>
                </div>

                <div class="archive-col-lg-6 col-lg-6 position-relative">
                    <div class="w-100 overflow-hidden ratio ratio-1x1 material-image mobile-full-width ">
                        <img class="w-100 h-100 object-fit-cover" src="{{ asset('storage') . '/' . $material->image_file}}" />
                    </div>

                    <div class="material-thumbnails-wrapper">
                        <div class="nav-arrow prev-arrow">
                            <i class="bi bi-chevron-left"></i>
                        </div>
                        <div class="material-thumbnails mobile-full-width">
                            @foreach ($images as $image)
                            <div class="thumbnail active">
                                <img class="w-100 h-100 object-fit-cover"
                                    src="{{ asset('storage') . '/' . $image->image_file }}" />
                            </div>
                            @endforeach
                        </div>
                        <div class="nav-arrow next-arrow">
                            <i class="bi bi-chevron-right"></i>
                        </div>
                    </div>
                </div>

                <section class="mt-5 mobile-mt-1" id="about-materials" data-aos="fade-up" data-aos-delay="100">
                    <div class="container">
                        <div class="archive-row row">
                            <div class="col-12 d-flex justify-content-between">
                                <h3 class="arial_narrow_7">More Materials</h3>
                            </div>
                            <div class="slides col-12 mt-5">
                                <div class="materials owl-carousel owl-theme">
                                    <!-- need to add foreach based on dataf -->
                                    @foreach ($recommended_materials as $rec_material)
                                    <div class="item">
                                        <div style="width: 80%" class="overflow-hidden ratio ratio-1x1">
                                            <img class="w-100 h-100 object-fit-cover"
                                                src="{{ asset('storage') . '/' . $rec_material->image_file }}"
                                                onclick="window.location.href=`/digital_archive_content/{{ $rec_material->m_id }}`" />
                                        </div>
                                        <div>
                                            <h6 class="dmsans-semi-bold mt-3 mb-2">
                                                {{ $rec_material->name }}
                                            </h6>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" id="download-qr">
                            <div class="modal-body text-center">
                                <div id="qr-code" class="qr d-flex justify-content-center p-5 download-btn"></div>
                                <div class="mt-2">
                                    <h5>{{ $material->name }}</h5>
                                    <p class="mb-1">{{ $material->material_source }}</p>
                                    <img src="{{url('web/assets/img/mainlogo.png')}}" class="logo-archive img-fluid" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    let material = @json($material);
    $("#nav-archive").addClass("active");
    $(document).ready(function() {
        console.log("ttest");
        createQRCode(material['m_id']);
        document.getElementById('qr-code').addEventListener('click', function() {
            const element = document.getElementById('download-qr');
            console.log("starrttt");
            html2canvas(element).then((canvas) => {
                // Convert the canvas to a data URL 
                const imgData = canvas.toDataURL('image/png');

                // Create a link to download the image 
                const link = document.createElement('a');
                link.href = imgData;
                link.download = material['material_code'] + '.png';
                link.click();
            });
        });
    });

    function createQRCode(input) {
        console.log("u clicked to create qr code!");

        const materialId = input;
        const link = window.location.origin + "/digital_archive_content/" + materialId;
        const qrcodeContainer = document.getElementById("qr-code");

        if (!qrcodeContainer) {
            console.error("QR code container not found");
            return;
        }

        qrcodeContainer.innerHTML = "";

        try {
            new QRCode(qrcodeContainer, {
                text: link,
                width: 277,
                height: 277
            });
        } catch (error) {
            console.error("Failed to generate QR code:", error);
        }

    }


    // Elements
    const thumbnails = document.querySelectorAll(".thumbnail");
    const mainImage = document.querySelector(".material-image img");
    const thumbnailsContainer = document.querySelector(
        ".material-thumbnails"
    );
    const prevArrow = document.querySelector(".prev-arrow");
    const nextArrow = document.querySelector(".next-arrow");

    let currentIndex = 1;
    let autoplayTimer;

    // Handle thumbnail clicks
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener("click", function() {
            updateActiveImage(index);
        });
    });

    // Navigation arrows
    prevArrow.addEventListener("click", () => {
        currentIndex =
            (currentIndex - 1 + thumbnails.length) % thumbnails.length;
        updateActiveImage(currentIndex);
    });

    nextArrow.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % thumbnails.length;
        updateActiveImage(currentIndex);
    });

    // Update active image and thumbnail
    function updateActiveImage(index) {
        // Update main image
        mainImage.src = thumbnails[index].querySelector("img").src;

        // Update active class
        thumbnails.forEach((t) => t.classList.remove("active"));
        thumbnails[index].classList.add("active");

        currentIndex = index;
        resetAutoplay();
    }

    // Autoplay functions
    function startAutoplay() {
        autoplayTimer = setInterval(() => {
            currentIndex = (currentIndex + 1) % thumbnails.length;
            updateActiveImage(currentIndex);
        }, 3000);
    }

    function resetAutoplay() {
        clearInterval(autoplayTimer);
        startAutoplay();
    }

    // Start autoplay
    startAutoplay();

    // Pause on hover
    thumbnailsContainer.addEventListener("mouseenter", () =>
        clearInterval(autoplayTimer)
    );
    thumbnailsContainer.addEventListener("mouseleave", startAutoplay);

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

    function adjustForMobile() {
        if (window.innerWidth <= 375) {
            // Add mobile classes dynamically if needed
            document.querySelectorAll('.col-lg-6').forEach(col => {
                col.classList.add('mobile-full-width');
            });

            // Adjust image height if needed
            const mainImage = document.querySelector('.material-image img');
            if (mainImage) {
                mainImage.style.maxHeight = '250px';
                mainImage.style.objectFit = 'contain';
            }

            // Make thumbnails scrollable
            const thumbnailsWrapper = document.querySelector('.material-thumbnails');
            if (thumbnailsWrapper) {
                thumbnailsWrapper.style.overflowX = 'auto';
                thumbnailsWrapper.style.display = 'flex';
                thumbnailsWrapper.style.gap = '5px';
            }
        }

        if (window.innerWidth <= 1199 && window.innerWidth > 768) {
            // Adjust column widths for this specific range
            document.querySelectorAll('.archive-col-lg-6').forEach(col => {
                col.style.width = '100%';
                col.style.marginBottom = '30px';
            });

            // Adjust image container for better display
            const materialImage = document.querySelector('.material-image');
            if (materialImage) {
                materialImage.style.maxWidth = '70%';
                materialImage.style.margin = '0 auto';
            }

            // Improve thumbnails layout
            const thumbnailsWrapper = document.querySelector('.material-thumbnails-wrapper');
            if (thumbnailsWrapper) {
                thumbnailsWrapper.style.maxWidth = '70%';
                thumbnailsWrapper.style.margin = '20px auto 0';
            }
        }


    }

    // Run on page load and resize
    window.addEventListener('load', adjustForMobile);
    window.addEventListener('resize', adjustForMobile);
</script>
@endsection
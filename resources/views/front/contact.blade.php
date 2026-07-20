<x-front-layout title="Contact Us">

    <section class="hero-section dots-bg">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- CONTACT INFO --}}
                <div class="col-lg-6">

                    <span class="section-badge">
                        Contact Us
                    </span>

                    <h1 class="hero-title">
                        Get In <span>Touch</span>
                    </h1>

                    <p class="hero-desc">
                        We'd love to hear from you. Feel free to contact us for
                        orders, inquiries, feedback, or any assistance you may need.
                    </p>

                    <div class="contact-info mt-4">

                        <div class="contact-item mb-3">
                            <h6 class="mb-1">Restaurant</h6>
                            <p class="mb-0">
                                {{ $restaurant->name }}
                            </p>
                        </div>

                        <div class="contact-item mb-3">
                            <h6 class="mb-1">Phone Number</h6>
                            <p class="mb-0"> 111111111
                                {{-- <a href="tel:{{ $restaurant->phone }}">
                                    {{ $restaurant->phone }}
                                </a> --}}
                            </p>
                        </div>

                        {{-- @if($restaurant->email)
                            <div class="contact-item mb-3">
                                <h6 class="mb-1">Email</h6>
                                <p class="mb-0">
                                    <a href="mailto:{{ $restaurant->email }}">
                                        {{ $restaurant->email }}
                                    </a>
                                </p>
                            </div>
                        @endif --}}

                    </div>

                </div>

                {{-- IMAGE --}}
                <div class="col-lg-6 text-center">
                    <div class="hero-image-wrapper">

                        <img src="{{ asset('assets/images/hero/FoodGrids.jpg') }}" alt="Hero Image"
                            class="hero-image">

                    </div>
                </div>

            </div>
        </div>
    </section>

</x-front-layout>

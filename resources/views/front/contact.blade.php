<x-front-layout title="Contact Us">

    <section class="hero-section dots-bg">
        <div class="container">
            <div class="row align-items-center g-5">

                {{-- CONTACT INFO --}}
                <div class="col-lg-6">

                <h1 class="hero-title">
                    {{ trans('Get In') }} <span>{{ trans('Touch') }}</span>
                </h1>

                <p class="hero-desc">
                    {{ trans("We'd love to hear from you. Feel free to contact us for orders, inquiries, feedback, or any assistance you may need.") }}
                </p>

                <div class="contact-item mb-3">
                    <h6 class="mb-1">{{ trans('Restaurant') }}: {{ $restaurant->name }}</h6>
                </div>

                <div class="contact-item mb-3">
                    <h6 class="mb-1">{{ trans('Phone Number') }}: 0100000000</h6>
                </div>

                {{-- <div class="contact-item mb-3">
                    <h6 class="mb-1">{{ trans('Email') }}</h6>
                </div> --}}

                </div>

                {{-- IMAGE --}}
                <div class="col-lg-6 text-center">
                    <div class="hero-image-wrapper">

                        <img src="{{ asset('assets/images/hero/foodgrids.png') }}" alt="Hero Image"
                            class="hero-image">

                    </div>
                </div>

            </div>
        </div>
    </section>

</x-front-layout>

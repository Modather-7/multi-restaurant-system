<x-front-layout>

    <section class="hero-section">

        <div class="container">

            <div class="row align-items-center g-5">

                {{-- TEXT --}}
                <div class="col-lg-6">

                    <span class="hero-badge">
                        Premium Gastronomy
                    </span>

                    <h1 class="hero-title">
                        Crispy Experience<br>
                        Crafted With <span>Precision</span>
                    </h1>

                    <p class="hero-desc">
                        Fresh ingredients, bold flavors, fast delivery and a premium dining experience built for quality
                        lovers.
                    </p>

                    <a href="/menu" class="btn btn-gold hero-btn">
                        Explore Menu
                    </a>

                </div>

                {{-- IMAGE --}}
                <div class="col-lg-6 text-center">

                    <div class="hero-image-wrapper">

                        <img src="{{ asset('assets/images/hero/hero-chicken.jpg') }}" alt="Hero Image"
                            class="hero-image">

                    </div>

                </div>

            </div>

        </div>

    </section>

</x-front-layout>

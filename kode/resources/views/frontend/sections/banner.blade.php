@php
    $bannerContent = get_content("content_banner")->first();
    $heroTitle = @$bannerContent->value->title ?? "Empowering creators to grow, collaborate and earn";
    $heroDesc = @$bannerContent->value->description ?? "Boost your social media engagement, collaborate with top brands and monetise 100% of your content with Wishlink";
    $heroImg = asset('assets/frontend/images/hero_recreated.png');
@endphp

<section class="section-wishlink-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5">
                <div class="hero-content-wishlink">
                    <h1>{!! $heroTitle !!}</h1>
                    <p>{!! $heroDesc !!}</p>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="hero-image-wishlink">
                    <img src="{{ asset('assets/frontend/images/hero_final.png') }}" alt="Hero Influencer" class="influencer-main-img">
                </div>
            </div>
        </div>
    </div>

</section>






@php
   $authElements   = get_content("element_authentication_section");
@endphp

<div class="col-xl-5 col-lg-5">
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-slider-wrapper">
                <div class="swiper auth-slider">
                    <div class="swiper-wrapper">
                        @foreach ( $authElements  as $element )
                            <div class="swiper-slide">
                                <div class="auth-slider-item">
                                    <div class="mb-5">
                                        <div class="platform-content-img" style="display: flex; justify-content: center;">
                                            <img
                                                src="{{ asset('assets/images/custom/dashboard_hero.png') }}"
                                                alt="Socialyt Dashboard"
                                                loading="lazy"
                                                style="border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.2); width: 100%; max-width: 550px; height: auto;" />
                                        </div>
                                    </div>

                                    <h4>
                                        {{@$element->value->title}}
                                    </h4>
                                    <p>
                                        {!!@$element->value->description!!}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $creators = [
        [
            'name' => 'Vaibhav Keswani',
            'handle' => '@pehenawah',
            'followers' => '625k',
            'img' => 'https://i.pravatar.cc/400?u=vaibhav',
            'quote' => '"Osvioo has been a game-changer for me as it has opened up a sustainable source of income that perfectly complements my YouTube and Instagram. The seamless way of sharing product links and automating post comments has saved me countless hours, allowing me to focus on creating content."'
        ],
        [
            'name' => 'Ananya Panday',
            'handle' => '@ananyapanday',
            'followers' => '24M',
            'img' => 'https://i.pravatar.cc/400?u=ananya',
            'quote' => '"The automation features are incredible. I can finally engage with all my fans without feeling overwhelmed. Osvioo is a must-have for anyone looking to grow their digital presence authentically."'
        ],
        [
            'name' => 'Ranveer Allahbadia',
            'handle' => '@beerbiceps',
            'followers' => '7M',
            'img' => 'https://i.pravatar.cc/400?u=ranveer',
            'quote' => '"Efficiency is key when you are running multiple shows. Osvioo helps us bridge the gap between content and commerce perfectly. It\'s the future of creator monetization."'
        ]
    ];
@endphp

<section class="section-creator-love py-5" id="creator-love">
    <div class="container py-5">
        <h2 class="text-center fw-bold display-4 mb-5" style="font-family: 'Outfit', sans-serif !important;">The love we get<br>from our Creators</h2>

        <div class="creator-swiper swiper">
            <div class="swiper-wrapper">
                @foreach($creators as $creator)
                    <div class="swiper-slide">
                        <div class="creator-love-card">
                            <!-- Left: Profile Info -->
                            <div class="creator-profile-side">
                                <div class="creator-img-wrapper">
                                    <img src="{{ $creator['img'] }}" alt="{{ $creator['name'] }}">
                                </div>
                                <div class="creator-meta mt-4">
                                    <h4 class="fw-bold mb-1">{{ $creator['name'] }}</h4>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="handle">{{ $creator['handle'] }}</span>
                                        <div class="instagram-pill">
                                            <i class="fab fa-instagram"></i>
                                            <span>{{ $creator['followers'] }} Followers</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle: Perforated Line -->
                            <div class="perforated-line">
                                @for($i=0; $i<15; $i++)
                                    <div class="dot"></div>
                                @endfor
                            </div>

                            <!-- Right: Testimonial -->
                            <div class="creator-quote-side">
                                <p>{{ $creator['quote'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Pagination Dots -->
            <div class="swiper-pagination mt-4"></div>
        </div>


    </div>
</section>

<style nonce="{{ csp_nonce() }}">
    .section-creator-love {
        background-color: #F9F6F1;
        overflow: hidden;
        padding: 120px 0;
    }

    .creator-swiper {
        width: 100%;
        max-width: 950px; /* Reduced from 1100px */
        padding: 40px 20px;
        margin: 0 auto;
    }

    .creator-love-card {
        background: linear-gradient(135deg, #FF8A00 0%, #FF5C00 100%);
        border-radius: 60px 120px 120px 60px; /* Slightly more conservative blobs */
        display: flex;
        align-items: center;
        padding: 50px 60px; /* Reduced padding */
        color: #fff;
        width: 100%;
        min-height: 480px;
        position: relative;
        box-shadow: 0 30px 60px rgba(234, 88, 12, 0.25);
        border: 1px solid rgba(255,255,255,0.1);
    }

    .swiper-slide-shadow-cards {
        background: rgba(255, 138, 0, 0.1) !important; /* The tint for stacked cards */
    }

    .creator-profile-side {
        flex: 0 0 320px;
        text-align: center;
    }

    .creator-img-wrapper {
        width: 220px;
        height: 280px;
        margin: 0 auto;
        border-radius: 50px;
        border: 5px solid #FFD200;
        overflow: hidden;
        transform: rotate(-3deg);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .creator-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .creator-meta h4 {
        font-size: 1.8rem;
        letter-spacing: -0.5px;
    }

    .handle {
        font-weight: 600;
        opacity: 0.8;
    }

    .instagram-pill {
        background: rgba(255,255,255,0.15);
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .perforated-line {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 0 50px;
    }

    .perforated-line .dot {
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
        opacity: 0.4;
    }

    .creator-quote-side {
        flex: 1;
    }

    .creator-quote-side p {
        font-size: 1.4rem;
        line-height: 1.6;
        font-weight: 500;
        margin: 0;
    }

    .creator-footer-bar {
        background: #F9F6F1;
        border-radius: 100px;
        max-width: 900px;
        margin: 40px auto 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .footer-text {
        color: #B45309;
        font-size: 1.2rem;
    }

    .signup-btn-pill {
        background: linear-gradient(90deg, #F59E0B 0%, #EA580C 100%);
        color: #fff !important;
        padding: 10px 30px;
        border-radius: 100px;
        text-decoration: none !important;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .signup-btn-pill:hover {
        transform: scale(1.05);
    }

    .signup-btn-pill .icons {
        display: flex;
        gap: 8px;
        font-size: 1.2rem;
    }

    /* Swiper Dots */
    .creator-swiper .swiper-pagination {
        bottom: -20px !important;
    }

    .creator-swiper .swiper-pagination-bullet {
        background: #FF8A00 !important;
        width: 10px;
        height: 10px;
        opacity: 0.3;
        transition: all 0.3s ease;
    }

    .creator-swiper .swiper-pagination-bullet-active {
        opacity: 1 !important;
        width: 30px;
        border-radius: 10px;
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .creator-love-card {
            flex-direction: column;
            padding: 40px 20px;
            border-radius: 40px;
            text-align: center;
        }
        .creator-profile-side {
            flex: none;
            margin-bottom: 30px;
        }
        .perforated-line {
            flex-direction: row;
            margin: 30px 0;
        }
        .creator-quote-side p {
            font-size: 1.1rem;
        }
        .footer-text {
            display: none;
        }
        .creator-footer-bar {
            justify-content: center;
        }
    }
</style>

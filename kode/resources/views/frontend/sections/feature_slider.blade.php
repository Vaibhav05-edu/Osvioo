@php
    $featureSlides = [
        [
            'title' => 'Auto Reply to <span class="paint-highlight">Instagram Reel</span> Comments',
            'desc' => 'Automatically respond to every comment on your Reels with personalized DMs and links, turning engagement into sales.',
            'img' => asset('assets/frontend/images/features/dual_phones.png'),
            'type' => 'dual'
        ],
        [
            'title' => 'Redefine <span class="paint-highlight">Inbox Starters</span> with Osvioo',
            'desc' => 'Set up automated conversation starters in your Instagram inbox to guide users to your most important links immediately.',
            'img' => asset('assets/frontend/images/features/hand_phone.png'),
            'type' => 'single'
        ],
        [
            'title' => 'Sponsored Ad <span class="paint-highlight">Comment Automation</span>',
            'desc' => 'Maximize your ad spend by automatically replying to comments on your sponsored posts, ensuring no lead is left behind.',
            'img' => asset('assets/frontend/images/features/dual_phones.png'),
            'type' => 'dual'
        ],
        [
            'title' => 'AI <span class="paint-highlight">Keyword Trigger</span> System',
            'desc' => 'Our intelligent AI detects specific keywords in comments and messages to trigger precise automated responses.',
            'img' => asset('assets/frontend/images/features/money_floating.png'),
            'type' => 'single'
        ],
        [
            'title' => 'Automated <span class="paint-highlight">Product Link</span> Delivery',
            'desc' => 'Instantly send direct shopping links to users who express interest, reducing friction in the buying process.',
            'img' => asset('assets/frontend/images/features/shopping_bags.png'),
            'type' => 'single'
        ],
        [
            'title' => 'Meta <span class="paint-highlight">Official API</span> Integration',
            'desc' => 'Built directly on official Meta APIs to ensure your account stays safe and your automations remain reliable.',
            'img' => asset('assets/frontend/images/features/signpost.png'),
            'type' => 'single'
        ]
    ];
@endphp

<section class="section-feature-slider">
    <div class="container">
        <h2 class="feature-slider-heading">Unlock the influence and <span class="paint-highlight">maximize your earnings</span></h2>

        <div class="feature-slider-outer">
            <div class="swiper feature-swiper">
                <div class="swiper-wrapper">
                    @foreach($featureSlides as $slide)
                        <div class="swiper-slide">
                            <div class="feature-slide-content">
                                <div class="feature-image-wrapper {{ $slide['type'] }}-layout">
                                    <img src="{{ $slide['img'] }}" alt="{{ strip_tags($slide['title']) }}" class="feature-main-img">
                                </div>
                                <div class="feature-slide-text">
                                    <h3>{!! $slide['title'] !!}</h3>
                                    <p>{{ $slide['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Controls (Pagination and Nav) -->
            <div class="feature-slider-controls">
                <div class="swiper-pagination"></div>
                <div class="feature-slider-nav">
                    <div class="slider-nav-btn feature-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                        </svg>
                    </div>
                    <div class="slider-nav-btn feature-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



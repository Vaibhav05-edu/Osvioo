@php
    $steps = [
        [
            'number' => '01',
            'title' => 'Auto-Reply to Reel Comments',
            'desc' => 'Automatically respond to every comment on your Reels with personalized DMs and links, turning engagement into sales.',
            'img' => asset('assets/images/custom/hot_influencer_reel.jpg'),
            'type' => 'reel'
        ],
        [
            'number' => '02',
            'title' => 'Inbox Starters',
            'desc' => 'Display up to 4 conversation starters when a user navigates to your Instagram Inbox to guide them to your products.',
            'img' => asset('assets/images/custom/hot_influencer_inbox.jpg'),
            'type' => 'inbox'
        ],
        [
            'number' => '03',
            'title' => 'Sponsored Ad Automation',
            'desc' => 'Scale your ad performance by automatically replying to every lead who interacts with your sponsored content.',
            'img' => asset('assets/images/custom/hot_influencer_ad.jpg'),
            'type' => 'ad'
        ]
    ];
@endphp

<section class="section-why-socialyt">
    <div class="container">
        <div class="why-socialyt-swiper-container swiper">
            <div class="swiper-wrapper why-socialyt-wrapper">
                @foreach($steps as $step)
                    <div class="swiper-slide">
                        <div class="why-socialyt-slide">
                            <div class="why-socialyt-text">
                                <h2>Why Osvioo?</h2>
                                <div class="step-box">
                                    <div class="step-header">
                                        <div class="step-circle">{{ $step['number'] }}</div>
                                        <h3>{{ $step['title'] }}</h3>
                                    </div>
                                    <p>{{ $step['desc'] }}</p>
                                </div>
                            </div>
                            <div class="why-socialyt-image">
                                <div class="linkdm-clone-wrapper" style="background: transparent !important;">
                                    <!-- Textured Halo -->
                                    <div class="textured-halo" style="background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%) !important;"></div>
                                    
                                    <!-- 3D Phone Card -->
                                    <div class="linkdm-phone-3d-card">
                                        <img src="{{ $step['img'] }}" alt="{{ $step['title'] }}">
                                    </div>
                                    
                                    @if($step['type'] == 'reel')
                                        <!-- Floating Zoom Card -->
                                        <div class="linkdm-floating-card profile-card">
                                            <div class="notification-badge-red">1</div>
                                            <img src="{{ $step['img'] }}" style="height: 120px; width: 100%; object-fit: cover; border-radius: 8px 8px 0 0;" alt="Zoom">
                                            <div class="p-3 bg-white text-dark">
                                                <div class="fw-bold small">DM Sent! 🚀</div>
                                                <div class="x-small text-muted">Reply SHOP to get link</div>
                                            </div>
                                        </div>
                                    @elseif($step['type'] == 'inbox')
                                        <!-- Floating Inbox Thread -->
                                        <div class="linkdm-floating-card inbox-card">
                                            <div class="notification-badge-red">1</div>
                                            <div class="p-3 bg-white text-dark">
                                                <div class="fw-bold small mb-2 border-bottom pb-2">Inbox Starters</div>
                                                <div class="d-grid gap-2">
                                                    <div class="bg-light p-2 rounded x-small fw-bold text-primary">Visit website</div>
                                                    <div class="bg-light p-2 rounded x-small fw-bold text-primary">View releases</div>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif($step['type'] == 'ad')
                                        <!-- Floating Ad Card -->
                                        <div class="linkdm-floating-card ad-card">
                                            <div class="notification-badge-red">1</div>
                                            <img src="https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=600&auto=format&fit=crop" style="height: 100px; width: 100%; object-fit: cover; border-radius: 8px 8px 0 0;" alt="Product">
                                            <div class="p-3 bg-white text-center text-dark">
                                                <div class="fw-bold x-small">Sponsored Ad</div>
                                                <div class="x-small text-muted">Auto-reply active</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Vertical Pagination -->
            <div class="why-socialyt-pagination swiper-pagination"></div>
        </div>
    </div>
</section>



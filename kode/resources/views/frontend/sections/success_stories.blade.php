@php
    $row1 = [
        ['category' => 'Realtor', 'name' => 'Chad Carroll', 'handle' => '@chadcarroll', 'date' => 'Dec 2019', 'followers' => '512k', 'growth' => '+63k', 'class' => 'bg-plixi-blue', 'img' => 'https://i.pravatar.cc/150?u=chad'],
        ['category' => 'Retail', 'name' => 'Topman', 'handle' => '@topman', 'date' => 'Nov 2018', 'followers' => '755k', 'growth' => '+213k', 'class' => 'bg-plixi-dark', 'img' => 'https://i.pravatar.cc/150?u=topman'],
        ['category' => 'Influencer', 'name' => 'Nicolette Mason', 'handle' => '@nicolettemason', 'date' => 'Jan 2021', 'followers' => '191k', 'growth' => '+17k', 'class' => 'bg-plixi-yellow', 'img' => 'https://i.pravatar.cc/150?u=nicolette'],
        ['category' => 'Entrepreneur', 'name' => 'Grant Cardone', 'handle' => '@grantcardone', 'date' => 'Jul 2019', 'followers' => '3M', 'growth' => '+122k', 'class' => 'bg-plixi-orange', 'img' => 'https://i.pravatar.cc/150?u=grant'],
    ];

    $row2 = [
        ['category' => 'E-commerce', 'name' => 'AWAY', 'handle' => '@away', 'date' => 'Apr 2020', 'followers' => '563k', 'growth' => '+78k', 'class' => 'bg-plixi-black', 'img' => 'https://i.pravatar.cc/150?u=away'],
        ['category' => 'E-commerce', 'name' => 'Paper Source', 'handle' => '@papersource', 'date' => 'Sept 2019', 'followers' => '258k', 'growth' => '+188k', 'class' => 'bg-plixi-peach', 'img' => 'https://i.pravatar.cc/150?u=paper'],
        ['category' => 'Retail', 'name' => 'Moon Juice', 'handle' => '@moonjuice', 'date' => 'Feb 2019', 'followers' => '310k', 'growth' => '+15k', 'class' => 'bg-plixi-purple', 'img' => 'https://i.pravatar.cc/150?u=moon'],
        ['category' => 'Agency', 'name' => 'Elite Media', 'handle' => '@elitemedia', 'date' => 'May 2021', 'followers' => '120k', 'growth' => '+45k', 'class' => 'bg-plixi-blue-alt', 'img' => 'https://i.pravatar.cc/150?u=elite'],
    ];
@endphp

<section class="section-success-stories py-5">
    <div class="container-fluid px-0">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold" style="font-family: 'Outfit', sans-serif !important; letter-spacing: -2px;">
                Client <span class="plixi-gradient-text-alt">Success</span> Stories
            </h2>
        </div>

        <div class="stories-marquee-container">
            <!-- Row 1: Moves Left -->
            <div class="stories-marquee-row row-left">
                <div class="marquee-content-stories">
                    @foreach(array_merge($row1, $row1) as $story)
                        <div class="success-story-card {{ $story['class'] }}">
                            <div class="pattern-waves"></div>
                            <div class="story-header">
                                <div class="story-info">
                                    <span class="story-cat">{{ $story['category'] }}</span>
                                    <h4 class="story-name">{{ $story['name'] }}</h4>
                                    <span class="story-handle">{{ $story['handle'] }}</span>
                                </div>
                                <div class="story-avatar">
                                    <img src="{{ $story['img'] }}" alt="{{ $story['name'] }}">
                                </div>
                            </div>
                            <div class="story-stats">
                                <div class="stat-item">
                                    <span class="stat-label">Member Since</span>
                                    <span class="stat-val">{{ $story['date'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Followers</span>
                                    <span class="stat-val">{{ $story['followers'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Growth</span>
                                    <span class="stat-val growth-positive">{{ $story['growth'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Row 2: Moves Right -->
            <div class="stories-marquee-row row-right">
                <div class="marquee-content-stories">
                    @foreach(array_merge($row2, $row2) as $story)
                        <div class="success-story-card {{ $story['class'] }}">
                            <div class="pattern-waves"></div>
                            <div class="story-header">
                                <div class="story-info">
                                    <span class="story-cat">{{ $story['category'] }}</span>
                                    <h4 class="story-name">{{ $story['name'] }}</h4>
                                    <span class="story-handle">{{ $story['handle'] }}</span>
                                </div>
                                <div class="story-avatar">
                                    <img src="{{ $story['img'] }}" alt="{{ $story['name'] }}">
                                </div>
                            </div>
                            <div class="story-stats">
                                <div class="stat-item">
                                    <span class="stat-label">Member Since</span>
                                    <span class="stat-val">{{ $story['date'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Followers</span>
                                    <span class="stat-val">{{ $story['followers'] }}</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Growth</span>
                                    <span class="stat-val growth-positive">{{ $story['growth'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <p class="fs-6 fw-bold" style="font-family: 'Outfit', sans-serif !important; color: #111;">
                Review 15,000+ more success stories or <span style="background: linear-gradient(90deg, #ff4d6d, #f59e0b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; cursor: pointer;">🚀 Start Growing Your Instagram</span> Now
            </p>
        </div>
    </div>
</section>

<style nonce="{{ csp_nonce() }}">
    .section-success-stories {
        background-color: #fff;
        overflow: hidden;
        padding: 80px 0;
        font-family: 'Outfit', sans-serif !important;
    }

    .plixi-gradient-text-alt {
        background: linear-gradient(90deg, #FF4D6D, #4D96FF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .stories-marquee-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    .stories-marquee-row {
        display: flex;
        overflow: hidden;
        white-space: nowrap;
    }

    .marquee-content-stories {
        display: flex;
        gap: 25px;
        animation: plixi-marquee-left 60s linear infinite;
        padding: 20px 0;
    }

    .row-right .marquee-content-stories {
        animation: plixi-marquee-right 60s linear infinite;
    }

    .success-story-card {
        flex: 0 0 450px;
        border-radius: 20px;
        padding: 40px;
        color: #ffffff !important; /* Force white text */
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        border: none !important;
    }

    /* Background Classes */
    .bg-plixi-blue { background: linear-gradient(135deg, #4D96FF 0%, #3B82F6 100%) !important; }
    .bg-plixi-dark { background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%) !important; }
    .bg-plixi-yellow { background: linear-gradient(135deg, #FBBF24 0%, #F59E0B 100%) !important; }
    .bg-plixi-orange { background: linear-gradient(135deg, #FB923C 0%, #EA580C 100%) !important; }
    .bg-plixi-black { background: linear-gradient(135deg, #111 0%, #222 100%) !important; }
    .bg-plixi-peach { background: linear-gradient(135deg, #F87171 0%, #EF4444 100%) !important; }
    .bg-plixi-purple { background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%) !important; }
    .bg-plixi-blue-alt { background: linear-gradient(135deg, #38BDF8 0%, #0EA5E9 100%) !important; }

    /* Wavy Pattern Overlay */
    .pattern-waves {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background-image: url("data:image/svg+xml,%3Csvg width='400' height='200' viewBox='0 0 400 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 100 C 50 50, 150 150, 200 100 C 250 50, 350 150, 400 100 L 400 200 L 0 200 Z' fill='rgba(255,255,255,0.08)'/%3E%3C/svg%3E");
        background-size: 100% 100%;
        pointer-events: none;
    }

    .story-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 50px;
        position: relative;
        z-index: 2;
    }

    .story-cat {
        font-size: 0.9rem;
        font-weight: 500;
        opacity: 0.9;
        display: block;
        margin-bottom: 5px;
    }

    .story-name {
        font-weight: 800;
        font-size: 1.8rem;
        margin: 0;
        letter-spacing: -0.5px;
        color: #fff !important;
    }

    .story-handle {
        font-size: 0.9rem;
        opacity: 0.7;
    }

    .story-avatar img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        border: 4px solid rgba(255,255,255,0.2);
        object-fit: cover;
    }

    .story-stats {
        display: flex;
        justify-content: space-between;
        border-top: 1px solid rgba(255,255,255,0.15);
        padding-top: 25px;
        position: relative;
        z-index: 2;
    }

    .stat-label {
        font-size: 0.75rem;
        opacity: 0.8;
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .stat-val {
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff !important;
    }

    @keyframes plixi-marquee-left {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }

    @keyframes plixi-marquee-right {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    .stories-marquee-row:hover .marquee-content-stories {
        animation-play-state: paused;
    }

    @media (max-width: 991px) {
        .success-story-card {
            flex: 0 0 350px;
            padding: 30px;
        }
        .story-name { font-size: 1.5rem; }
        .stat-val { font-size: 1.1rem; }
    }
</style>

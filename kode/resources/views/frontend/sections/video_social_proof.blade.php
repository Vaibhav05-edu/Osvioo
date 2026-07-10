@php
    $reels = [
        [
            'handle' => 'jaiflyy',
            'avatar' => 'https://i.pravatar.cc/150?u=jaiflyy',
            'title' => 'Social Media is Changing',
            'likes' => '128k',
            'id' => '-Nf5QNtFgkA'
        ],
        [
            'handle' => 'letsdodizz',
            'avatar' => 'https://i.pravatar.cc/150?u=letsdodizz',
            'title' => 'How to grow in minutes',
            'likes' => '2,812',
            'id' => 'iYLkM9rNQUo'
        ],
        [
            'handle' => 'eusoutwins',
            'avatar' => 'https://i.pravatar.cc/150?u=eusoutwins',
            'title' => 'Crie Posts com IA',
            'likes' => 'Liked by francesca',
            'id' => 'U-SvBBIr9Zc'
        ],
        [
            'handle' => 'adam.godigital',
            'avatar' => 'https://i.pravatar.cc/150?u=adam',
            'title' => 'Use this AI instead!',
            'likes' => '2,324',
            'id' => '-ND8SlMFYuA'
        ]
    ];
@endphp

<section class="section-video-proof py-5">
    <div class="container py-5">
        <h2 class="text-center fw-bold display-5 mb-5 text-dark" style="font-family: 'Outfit', sans-serif !important; max-width: 800px; margin: 0 auto 60px auto;">
            Loved ❤️ by more than a Million Entrepreneurs, Marketers and Content Creators.
        </h2>

        <div class="row g-4">
            @foreach($reels as $reel)
                <div class="col-lg-3 col-md-6">
                    <div class="insta-post-card">


                        <div class="insta-video-container">
                            <iframe class="insta-video-iframe" 
                                    src="https://www.youtube.com/embed/{{ $reel['id'] }}?autoplay=0&mute=1&loop=1&playlist={{ $reel['id'] }}&controls=0&modestbranding=1&rel=0" 
                                    allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            
                            <div class="insta-video-overlay">
                                <div class="play-btn-glass">
                                    <i class="bi bi-play-fill"></i>
                                </div>
                                <div class="video-caption-bottom">
                                    <div class="fw-bold">{{ $reel['title'] }}</div>
                                    <div class="text-info" style="font-size: 0.7rem;">#OsviooAI #Growth</div>
                                </div>
                            </div>
                        </div>

                        <div class="insta-footer">
                            <div class="insta-actions">
                                <i class="bi bi-heart"></i>
                                <i class="bi bi-chat"></i>
                                <i class="bi bi-send"></i>
                                <i class="bi bi-bookmark ms-auto"></i>
                            </div>
                            <div class="insta-likes">{{ $reel['likes'] }} likes</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style nonce="{{ csp_nonce() }}">
    .section-video-proof {
        background-color: #fff;
    }

    .insta-post-card {
        background: #fff;
        border: 1px solid #efefef;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .insta-post-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .insta-post-header {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        gap: 12px;
    }

    .insta-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #FFD200;
        padding: 2px;
    }

    .insta-username {
        font-weight: 700;
        font-size: 0.9rem;
        color: #262626;
    }

    .insta-video-container {
        position: relative;
        aspect-ratio: 9/12;
        background: #000;
        width: 100%;
    }

    .insta-video-iframe {
        width: 100%;
        height: 100%;
        border: 0;
        position: absolute;
        top: 0;
        left: 0;
    }

    .insta-video-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.1);
        pointer-events: none;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .play-btn-glass {
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        border: 1px solid rgba(255,255,255,0.3);
    }

    .video-caption-bottom {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 20px;
        background: linear-gradient(transparent, rgba(0,0,0,0.7));
        color: white;
        font-size: 0.9rem;
    }

    .insta-footer {
        padding: 12px 15px;
    }

    .insta-actions {
        display: flex;
        gap: 15px;
        margin-bottom: 8px;
        font-size: 1.4rem;
        color: #262626;
    }

    .insta-actions i {
        cursor: pointer;
    }

    .insta-actions i.bi-heart:hover {
        color: #ed4956;
    }

    .insta-likes {
        font-weight: 700;
        font-size: 0.85rem;
        color: #262626;
    }

    @media (max-width: 768px) {
        .insta-post-card {
            max-width: 350px;
            margin: 0 auto;
        }
    }
</style>

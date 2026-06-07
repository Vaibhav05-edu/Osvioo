<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$mediaKit->title}} | Media Kit</title>
    <meta name="description" content="Official Media Kit for {{$mediaKit->user->name ?? 'Creator'}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&family=Outfit:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --pink: #ff1b6b;
            --orange: #ff8e25;
            --yellow: #ffdf00;
            --bg-light: #ffffff;
            --text-dark: #111111;
        }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            font-family: 'Outfit', sans-serif; 
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Vibrant Gradient Backgrounds */
        .bg-gradient-top {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 800px;
            background: radial-gradient(circle at top left, rgba(255,142,37,0.6) 0%, rgba(255,27,107,0.3) 30%, rgba(255,255,255,0) 70%),
                        radial-gradient(circle at top right, rgba(255,223,0,0.5) 0%, rgba(255,255,255,0) 50%);
            z-index: -2;
        }

        .bg-gradient-bottom {
            position: absolute;
            bottom: 0; left: 0; width: 100%; height: 600px;
            background: linear-gradient(to top, rgba(255,27,107,0.8) 0%, rgba(255,142,37,0.5) 50%, rgba(255,255,255,0) 100%);
            z-index: -2;
        }

        /* Grid Pattern */
        .grid-pattern {
            position: absolute;
            top: 5%; left: 10%; right: 10%;
            height: 600px;
            background-image: linear-gradient(#e0e0e0 1px, transparent 1px), linear-gradient(90deg, #e0e0e0 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: -1;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 4rem 2rem;
            position: relative;
        }

        /* Title */
        .main-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: clamp(4rem, 8vw, 6rem);
            text-align: center;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            text-transform: uppercase;
        }
        
        .title-media { color: var(--pink); }
        .title-kit { color: var(--yellow); }

        /* Cover Image & Ribbons */
        .cover-section {
            position: relative;
            display: flex;
            justify-content: center;
            margin: 4rem 0;
        }

        .ribbon {
            position: absolute;
            top: 50%;
            left: -10%;
            width: 120%;
            padding: 15px 0;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            display: flex;
            gap: 2rem;
            z-index: 1;
        }

        .ribbon-orange {
            background: var(--orange);
            color: #fff;
            transform: rotate(-5deg) translateY(-50%);
        }

        .ribbon-pink {
            background: var(--pink);
            color: #fff;
            transform: rotate(3deg) translateY(50%);
        }

        .ribbon span {
            display: inline-block;
            animation: scroll 20s linear infinite;
        }

        @keyframes scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100%); }
        }

        .cover-image-container {
            width: 350px;
            height: 450px;
            background: #ddd;
            z-index: 2;
            position: relative;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            border: 10px solid white;
        }

        .cover-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .name-badge {
            margin: -2rem auto 3rem;
            position: relative;
            z-index: 3;
            background: white;
            border: 2px solid var(--text-dark);
            border-radius: 50px;
            padding: 10px 40px;
            display: inline-block;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            text-transform: uppercase;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Two Column Layout */
        .grid-2-col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            margin-bottom: 4rem;
        }

        @media(max-width: 768px) {
            .grid-2-col { grid-template-columns: 1fr; }
        }

        /* Details Sections */
        .section-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 1.2rem;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--text-dark);
            padding-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title::after {
            content: '✦';
            font-size: 1.5rem;
            color: var(--text-dark);
        }

        .bio-text {
            font-size: 1rem;
            line-height: 1.8;
            color: #444;
            white-space: pre-wrap;
            margin-bottom: 2rem;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-item h3 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 2.5rem;
            margin-bottom: 0.2rem;
            background: linear-gradient(45deg, var(--pink), var(--orange));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-item p {
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #666;
        }

        .stat-large {
            grid-column: 1 / -1;
        }
        .stat-large h3 {
            font-size: 4rem;
            background: linear-gradient(45deg, var(--pink), var(--yellow));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Services / Socials */
        .service-list {
            list-style: none;
        }

        .service-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px dashed #ccc;
        }

        .service-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            border: 1px solid var(--text-dark);
            padding: 5px 15px;
            font-size: 0.9rem;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s;
        }

        .service-name:hover {
            background: var(--text-dark);
            color: white;
        }

        /* Quote / Footer */
        .footer-quote {
            text-align: center;
            margin-top: 6rem;
            position: relative;
            z-index: 2;
        }

        .quote-box {
            border: 1px solid rgba(0,0,0,0.2);
            border-radius: 100px;
            padding: 2rem 4rem;
            display: inline-block;
            max-width: 80%;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(5px);
        }

        .quote-text {
            font-style: italic;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .quote-author {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .bottom-tags {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 3rem;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            border: 2px solid var(--text-dark);
            padding: 15px;
            background: white;
        }

        /* Sparkles */
        .sparkle {
            position: absolute;
            font-size: 2rem;
            color: var(--text-dark);
        }
        .s1 { top: 20%; left: 15%; }
        .s2 { top: 60%; right: 10%; font-size: 3rem; color: var(--pink); }
        .s3 { bottom: 10%; left: 20%; font-size: 4rem; color: white; opacity: 0.5; }
    </style>
</head>
<body>

    <div class="bg-gradient-top"></div>
    <div class="bg-gradient-bottom"></div>
    <div class="grid-pattern"></div>

    <span class="sparkle s1">✦</span>
    <span class="sparkle s2">✦</span>
    <span class="sparkle s3">✦</span>

    <div class="container">
        
        <h1 class="main-title">
            <span class="title-media">MEDIA</span> <span class="title-kit">KIT</span>
        </h1>

        <div class="cover-section">
            <div class="ribbon ribbon-orange">
                @for($i=0; $i<5; $i++)
                    <span>{{ strtoupper($mediaKit->title) }} MEDIA KIT ✦ </span>
                @endfor
            </div>
            <div class="ribbon ribbon-pink">
                @for($i=0; $i<5; $i++)
                    <span>CREATOR ✦ INFLUENCER ✦ </span>
                @endfor
            </div>

            <div class="cover-image-container">
                @if($mediaKit->cover_image)
                    <img src="{{ asset('assets/images/custom/' . $mediaKit->cover_image) }}" alt="{{ $mediaKit->title }}">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:3rem;color:#999;background:#eee;">
                        &#10022;
                    </div>
                @endif
            </div>
        </div>

        <div class="name-badge">
            {{ $mediaKit->user->name ?? 'CREATOR' }}
        </div>

        <div class="grid-2-col">
            <!-- Left Column -->
            <div>
                <h2 class="section-title">ABOUT {{ strtoupper($mediaKit->user->name ?? 'ME') }}</h2>
                <div class="bio-text">{{ $mediaKit->bio }}</div>

                <h2 class="section-title">BUSINESS INQUIRIES</h2>
                <div class="bio-text">
                    Email me for bookings & collabs:<br>
                    <strong>{{ $mediaKit->contact_email }}</strong>
                </div>

                @if(!$mediaKit->watermark_removed)
                    <div style="margin-top: 2rem; font-size: 0.8rem; font-weight: bold;">
                        Powered by <a href="/" style="color:var(--pink); text-decoration:none;">{{ site_settings('site_name', 'Osvioo') }}</a>
                    </div>
                @endif
            </div>

            <!-- Right Column -->
            <div>
                <h2 class="section-title" style="border-radius: 50px; border: 2px solid #111; padding: 10px 20px; display: inline-flex; justify-content: center; margin-bottom: 2rem; width: 100%;">
                    KEY STATISTIC
                </h2>

                <div class="stats-grid">
                    <div class="stat-large">
                        <h3>{{ $mediaKit->total_followers >= 1000 ? number_format($mediaKit->total_followers) : $mediaKit->total_followers }}</h3>
                        <p>Total Reach</p>
                    </div>
                    
                    @if($mediaKit->engagement_rate)
                    <div class="stat-item">
                        <h3>{{ $mediaKit->engagement_rate }}%</h3>
                        <p>Avg Engagement</p>
                    </div>
                    @endif

                    @if($mediaKit->top_platform)
                    <div class="stat-item">
                        <h3 style="font-size: 2rem; line-height: 1.2;">{{ strtoupper($mediaKit->top_platform) }}</h3>
                        <p>Top Platform</p>
                    </div>
                    @endif
                </div>

                @php
                    $socials = $mediaKit->social_links;
                    if(is_string($socials)) { $socials = json_decode($socials, true); }
                    if(!is_array($socials)) { $socials = []; }
                @endphp

                @if(count($socials) > 0)
                <h2 class="section-title" style="border-radius: 50px; border: 2px solid #111; padding: 10px 20px; display: inline-flex; justify-content: center; margin-bottom: 2rem; width: 100%; margin-top: 1rem;">
                    PLATFORMS
                </h2>
                
                <ul class="service-list">
                    @foreach($socials as $pName => $url)
                        @if($url)
                        <li class="service-item">
                            <a href="{{ $url }}" target="_blank" class="service-name">{{ strtoupper($pName) }} POST</a>
                            <span style="font-weight:900; font-family:'Montserrat',sans-serif;">↗</span>
                        </li>
                        @endif
                    @endforeach
                </ul>
                @endif

            </div>
        </div>

        <div class="footer-quote">
            <div class="quote-box">
                <p class="quote-text">"Let's create something beautiful and impactful together."</p>
                <p class="quote-author">- {{ strtoupper($mediaKit->user->name ?? 'CREATOR') }}</p>
            </div>
        </div>

        <div class="bottom-tags">
            @php
                $platforms = array_keys($socials);
                $tags = count($platforms) ? implode(' &nbsp;|&nbsp; ', array_map('strtoupper', $platforms)) : 'CONTENT CREATOR &nbsp;|&nbsp; INFLUENCER';
            @endphp
            <span>{!! $tags !!}</span>
        </div>

    </div>

</body>
</html>

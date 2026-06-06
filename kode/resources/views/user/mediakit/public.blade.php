<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$mediaKit->title}} | Media Kit</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --theme-color: {{$mediaKit->theme_color ?? '#6366f1'}};
            --bg-dark: #0a0a0a;
            --bg-card: rgba(255, 255, 255, 0.03);
            --border-color: rgba(255, 255, 255, 0.08);
            --text-primary: #ffffff;
            --text-secondary: #a1a1aa;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-primary);
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            background-image: 
                radial-gradient(circle at 15% 50%, rgba(255,255,255,0.02) 0%, transparent 50%),
                radial-gradient(circle at 85% 30%, rgba(255,255,255,0.02) 0%, transparent 50%);
        }

        /* Animated Background Orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: -1;
            animation: float 10s ease-in-out infinite alternate;
        }
        .orb-1 {
            width: 400px;
            height: 400px;
            background: var(--theme-color);
            top: -100px;
            left: -100px;
        }
        .orb-2 {
            width: 300px;
            height: 300px;
            background: #8b5cf6;
            bottom: 10%;
            right: -50px;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 50px) scale(1.1); }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Hero Section */
        .hero {
            position: relative;
            border-radius: 32px;
            overflow: hidden;
            margin-bottom: 3rem;
            min-height: 400px;
            display: flex;
            align-items: flex-end;
            padding: 3rem;
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            backdrop-filter: blur(20px);
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 0.6;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, var(--bg-dark) 0%, transparent 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .hero-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #fff, #a1a1aa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-text p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-verified {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 1rem;
            color: #fff;
            backdrop-filter: blur(10px);
        }

        .btn-primary {
            background: var(--theme-color);
            color: #fff;
            text-decoration: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 25px -5px var(--theme-color);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px -5px var(--theme-color);
            filter: brightness(1.1);
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
            .hero-text h1 {
                font-size: 3rem;
            }
            .hero {
                padding: 2rem;
            }
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
            transition: transform 0.3s ease, border-color 0.3s ease;
            height: 100%;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(255,255,255,0.15);
        }

        .card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .card h3 i {
            color: var(--theme-color);
        }

        .bio-text {
            color: var(--text-secondary);
            line-height: 1.8;
            font-size: 1.1rem;
            white-space: pre-wrap;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .stat-item {
            background: rgba(0,0,0,0.3);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: rgba(255,255,255,0.05);
            border-color: var(--theme-color);
        }

        .stat-value {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Social Links */
        .social-links {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .social-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.2rem 1.5rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .social-btn .platform {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.1rem;
            text-transform: capitalize;
        }

        .social-btn i.fa-arrow-right {
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            background: var(--theme-color);
            border-color: var(--theme-color);
            transform: translateX(5px);
        }

        .social-btn:hover i.fa-arrow-right {
            opacity: 1;
            transform: translateX(0);
        }

        .footer {
            text-align: center;
            padding: 3rem 0;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }
        
        .footer a {
            color: var(--theme-color);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>

    <div class="container">
        <!-- Hero Section -->
        <div class="hero">
            @if($mediaKit->cover_image)
                <img src="{{ asset('assets/images/custom/' . $mediaKit->cover_image) }}" class="hero-bg" alt="Cover">
            @else
                <div class="hero-bg" style="background: linear-gradient(45deg, var(--bg-dark), var(--theme-color));"></div>
            @endif
            <div class="hero-overlay"></div>
            
            <div class="hero-content">
                <div class="hero-text">
                    <div class="badge-verified">
                        <i class="fa-solid fa-circle-check" style="color: #3b82f6;"></i> Verified Creator
                    </div>
                    <h1>{{$mediaKit->title}}</h1>
                    <p><i class="fa-solid fa-user"></i> Media Kit by {{$mediaKit->user->name}}</p>
                </div>
                <div class="hero-action">
                    <a href="mailto:{{$mediaKit->contact_email}}" class="btn-primary">
                        <i class="fa-solid fa-envelope"></i> Let's Collaborate
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ number_format($mediaKit->total_followers) }}</div>
                <div class="stat-label">Total Reach</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $mediaKit->engagement_rate }}%</div>
                <div class="stat-label">Avg. Engagement</div>
            </div>
            <div class="stat-item">
                <div class="stat-value" style="color: var(--theme-color);">
                    <i class="fa-brands fa-{{strtolower($mediaKit->top_platform ?? 'instagram')}}"></i>
                </div>
                <div class="stat-label">Top Platform: {{$mediaKit->top_platform ?? 'Various'}}</div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <div class="card">
                <h3><i class="fa-solid fa-address-card"></i> About Me</h3>
                <div class="bio-text">
                    {{$mediaKit->bio}}
                </div>
            </div>
            
            <div class="card">
                <h3><i class="fa-solid fa-hashtag"></i> Social Links</h3>
                <div class="social-links">
                    @php
                        $socials = is_string($mediaKit->social_links) ? json_decode($mediaKit->social_links, true) : $mediaKit->social_links;
                        if(is_string($socials)) $socials = json_decode($socials, true); // Double check decoding
                    @endphp
                    @if($socials && is_array($socials))
                        @foreach($socials as $platform => $url)
                            @if($url)
                            <a href="{{$url}}" target="_blank" class="social-btn">
                                <div class="platform">
                                    <i class="fa-brands fa-{{strtolower($platform)}}"></i>
                                    {{$platform}}
                                </div>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                            @endif
                        @endforeach
                    @else
                        <p class="text-secondary text-center py-4">No linked accounts provided.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{date('Y')}} {{$mediaKit->user->name}}. All rights reserved.</p>
            @if(!$mediaKit->watermark_removed)
                <p class="mt-2">Powered by <a href="/">{{ site_settings('site_name', 'Osvioo') }}</a></p>
            @endif
        </div>
    </div>
</body>
</html>

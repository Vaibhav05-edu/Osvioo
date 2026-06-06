<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$mediaKit->title}} | Media Kit</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS for layout base -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root {
            --theme-color: {{$mediaKit->theme_color}};
            --bg-dark: #0f172a;
            --card-bg: rgba(255, 255, 255, 0.05);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Gradients */
        .bg-glow {
            position: fixed;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, var(--theme-color) 0%, transparent 70%);
            opacity: 0.15;
            top: -20%;
            left: -10%;
            border-radius: 50%;
            filter: blur(100px);
            z-index: -1;
            animation: float 10s ease-in-out infinite;
        }
        .bg-glow.right {
            top: auto;
            bottom: -20%;
            left: auto;
            right: -10%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            50% { transform: translate(30px, -30px); }
            100% { transform: translate(0, 0); }
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
        }

        /* Glassmorphism Card */
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .cover-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 24px;
            margin-bottom: -100px;
            position: relative;
            z-index: 0;
            mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, black 50%, transparent 100%);
        }

        .profile-container {
            position: relative;
            z-index: 10;
        }

        .stat-box {
            text-align: center;
            padding: 1.5rem;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stat-value {
            font-size: 2.5rem;
            color: var(--theme-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.05);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: var(--theme-color);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 10px 20px -5px var(--theme-color);
            border-color: transparent;
        }

        .contact-btn {
            background: var(--theme-color);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px -10px var(--theme-color);
        }

        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px -10px var(--theme-color);
            color: white;
        }
        
        .bio-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #cbd5e1;
            white-space: pre-wrap;
        }
        
        .badge-pro {
            background: linear-gradient(135deg, var(--theme-color), #8b5cf6);
            padding: 5px 12px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>
    <div class="bg-glow right"></div>

    <div class="container py-5">
        
        @if($mediaKit->cover_image)
            <img src="{{ asset('assets/images/mediakits/' . $mediaKit->cover_image) }}" class="cover-img" alt="Cover">
        @endif

        <div class="row justify-content-center profile-container {{$mediaKit->cover_image ? '' : 'mt-5'}}">
            <div class="col-lg-10">
                <div class="glass-card">
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <span class="badge-pro mb-3 d-inline-block">Verified Creator</span>
                            <h1 class="display-4 mb-2">{{$mediaKit->title}}</h1>
                            <p class="text-muted fs-5">Media Kit by {{$mediaKit->user->name}}</p>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <a href="mailto:{{$mediaKit->contact_email}}" class="contact-btn">
                                <i class="bi bi-envelope-fill me-2"></i> Let's Collaborate
                            </a>
                        </div>
                    </div>

                    <div class="row g-4 mt-2 mb-5">
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-value">{{ number_format($mediaKit->total_followers) }}</div>
                                <div class="stat-label">Total Reach</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-value">{{ $mediaKit->engagement_rate }}%</div>
                                <div class="stat-label">Avg. Engagement</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stat-box">
                                <div class="stat-value"><i class="bi bi-star-fill text-warning"></i></div>
                                <div class="stat-label">Top Platform: {{$mediaKit->top_platform ?? 'Various'}}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-8 pe-lg-5">
                            <h3 class="mb-4">About Me</h3>
                            <div class="bio-text">
                                {{$mediaKit->bio}}
                            </div>
                        </div>
                        <div class="col-lg-4 mt-5 mt-lg-0">
                            <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                                <h4 class="mb-4 text-center">Social Links</h4>
                                <div class="d-flex flex-column gap-3">
                                    @if($mediaKit->social_links)
                                        @foreach($mediaKit->social_links as $platform => $url)
                                            <a href="{{$url}}" target="_blank" class="social-link">
                                                <i class="bi bi-{{strtolower($platform)}} fs-5"></i> {{$platform}}
                                            </a>
                                        @endforeach
                                    @else
                                        <p class="text-muted text-center">No linked accounts provided.</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4 d-block d-md-none">
                                <a href="mailto:{{$mediaKit->contact_email}}" class="contact-btn w-100 text-center">
                                    <i class="bi bi-envelope-fill me-2"></i> Let's Collaborate
                                </a>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5 text-muted">
            <small>&copy; {{date('Y')}} {{$mediaKit->user->name}}.</small>
            @if(!$mediaKit->watermark_removed)
                <small class="d-block mt-1">Powered by {{ site_settings('site_name', 'Osvioo') }}</small>
            @endif
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

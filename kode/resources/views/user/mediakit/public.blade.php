<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$mediaKit->title}} | Media Kit</title>
    <meta name="description" content="Media Kit for {{$mediaKit->user->name}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --accent:  {{$mediaKit->theme_color ?? '#c9a97a'}};
            --bg:      #f7f5f2;
            --card:    #ffffff;
            --text:    #1a1a1a;
            --muted:   #6b6b6b;
            --border:  #e5e0d8;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── Page Wrapper ── */
        .page {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1.5rem 4rem;
        }

        /* ── Top Hero ── */
        .hero {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            margin: 2rem 0 1.5rem;
            display: grid;
            grid-template-columns: 260px 1fr;
            min-height: 340px;
        }

        @media (max-width: 640px) {
            .hero { grid-template-columns: 1fr; }
            .hero-photo { height: 240px; }
        }

        .hero-photo {
            position: relative;
            overflow: hidden;
            background: #e8e4dc;
        }

        .hero-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            display: block;
        }

        .hero-photo-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent) 0%, #e8e4dc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: rgba(255,255,255,0.6);
        }

        .hero-info {
            padding: 2.5rem 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 1rem;
        }

        .badge::before {
            content: '';
            display: block;
            width: 20px;
            height: 2px;
            background: var(--accent);
        }

        .hero-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 3.5rem;
            line-height: 1.05;
            font-weight: 600;
            color: var(--text);
        }

        .hero-sub {
            color: var(--muted);
            font-size: 0.95rem;
            margin-top: 0.5rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .divider {
            width: 40px;
            height: 2px;
            background: var(--accent);
            margin: 1.25rem 0;
        }

        .hero-action {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-collab {
            background: var(--accent);
            color: #fff;
            text-decoration: none;
            padding: 0.75rem 1.75rem;
            border-radius: 6px;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            transition: opacity 0.2s;
        }

        .btn-collab:hover { opacity: 0.85; }

        .contact-text {
            color: var(--muted);
            font-size: 0.85rem;
        }

        /* ── Stats Row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 480px) { .stats-row { grid-template-columns: 1fr; } }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.8rem;
            font-weight: 600;
            color: var(--text);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--muted);
            margin-top: 0.35rem;
        }

        .stat-icon {
            font-size: 1.8rem;
            margin-bottom: 0.3rem;
        }

        /* ── Content Grid ── */
        .content-row {
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 1.5rem;
        }

        @media (max-width: 700px) { .content-row { grid-template-columns: 1fr; } }

        .section-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 2rem;
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .bio-text {
            color: var(--muted);
            line-height: 1.9;
            font-size: 1rem;
            white-space: pre-wrap;
        }

        /* Social links */
        .social-list { display: flex; flex-direction: column; gap: 0.75rem; }

        .social-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 1.1rem;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .social-item:hover {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .social-item-left {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-transform: capitalize;
        }

        /* AI Captions Section */
        .captions-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 2rem;
            margin-top: 1.5rem;
        }

        .caption-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .caption-item {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1rem;
            font-size: 0.9rem;
            line-height: 1.7;
            color: var(--text);
            position: relative;
        }

        .caption-num {
            position: absolute;
            top: -10px;
            left: 12px;
            background: var(--accent);
            color: #fff;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2.5rem 0 0;
            color: var(--muted);
            font-size: 0.85rem;
        }

        .footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }

        .powered {
            margin-top: 0.4rem;
            font-size: 0.78rem;
            opacity: 0.6;
        }
    </style>
</head>
<body>
<div class="page">

    {{-- ── Hero Card ── --}}
    <div class="hero">
        <div class="hero-photo">
            @if($mediaKit->cover_image)
                <img src="{{ asset('assets/images/custom/' . $mediaKit->cover_image) }}" alt="{{ $mediaKit->title }}">
            @else
                <div class="hero-photo-placeholder">✦</div>
            @endif
        </div>

        <div class="hero-info">
            <div>
                <div class="badge">Verified Creator</div>
                <h1 class="hero-name">{{ $mediaKit->title }}</h1>
                @php
                    $socials = $mediaKit->social_links;
                    if(is_string($socials)) $socials = json_decode($socials, true);
                    $niche = is_array($socials) ? implode(' | ', array_map('strtoupper', array_keys($socials))) : 'CONTENT CREATOR';
                @endphp
                <div class="hero-sub">{{ $niche }}</div>
                <div class="divider"></div>
                <p class="bio-text" style="font-size:0.9rem;">{{ Str::limit($mediaKit->bio, 160) }}</p>
            </div>
            <div class="hero-action">
                <a href="mailto:{{ $mediaKit->contact_email }}" class="btn-collab">✉ Let's Collaborate</a>
                <span class="contact-text">{{ $mediaKit->contact_email }}</span>
            </div>
        </div>
    </div>

    {{-- ── Stats ── --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-num">{{ number_format($mediaKit->total_followers) }}</div>
            <div class="stat-label">Total Reach</div>
        </div>
        <div class="stat-card">
            <div class="stat-num">{{ $mediaKit->engagement_rate }}%</div>
            <div class="stat-label">Avg. Engagement</div>
        </div>
        <div class="stat-card">
            @php
                $platform = strtolower($mediaKit->top_platform ?? 'instagram');
                $icons = ['instagram'=>'📸','youtube'=>'📺','tiktok'=>'🎵','twitter'=>'🐦','facebook'=>'👥'];
                $icon = $icons[$platform] ?? '🌟';
            @endphp
            <div class="stat-icon">{{ $icon }}</div>
            <div class="stat-num" style="font-size:1.4rem;font-family:'DM Sans',sans-serif;">{{ ucfirst($platform) }}</div>
            <div class="stat-label">Top Platform</div>
        </div>
    </div>

    {{-- ── Content Row ── --}}
    <div class="content-row">
        <div class="section-card">
            <h2 class="section-title">My Mission</h2>
            <div class="bio-text">{{ $mediaKit->ai_generated_bio ?: $mediaKit->bio }}</div>
        </div>

        <div class="section-card">
            <h2 class="section-title">Connect</h2>
            <div class="social-list">
                @if($socials && is_array($socials))
                    @foreach($socials as $pName => $url)
                        @if($url)
                        <a href="{{ $url }}" target="_blank" class="social-item">
                            <div class="social-item-left">
                                @php
                                    $si = ['instagram'=>'📸','youtube'=>'📺','tiktok'=>'🎵','twitter'=>'🐦','facebook'=>'👥','linkedin'=>'💼'];
                                    echo ($si[strtolower($pName)] ?? '🔗') . ' ' . $pName;
                                @endphp
                            </div>
                            <span>→</span>
                        </a>
                        @endif
                    @endforeach
                @else
                    <p style="color:var(--muted);font-size:0.9rem;">No accounts linked.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ── AI Captions ── --}}
    @if($mediaKit->ai_generated_captions)
        @php
            $captions = is_string($mediaKit->ai_generated_captions)
                ? json_decode($mediaKit->ai_generated_captions, true)
                : $mediaKit->ai_generated_captions;
        @endphp
        @if(is_array($captions) && count($captions) > 0)
        <div class="captions-section">
            <h2 class="section-title">AI-Powered Captions</h2>
            <div class="caption-grid">
                @foreach($captions as $i => $caption)
                <div class="caption-item">
                    <div class="caption-num">{{ $i + 1 }}</div>
                    {{ $caption }}
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif

    {{-- ── Footer ── --}}
    <div class="footer">
        <p>© {{ date('Y') }} {{ $mediaKit->user->name }}. All rights reserved.</p>
        @if(!$mediaKit->watermark_removed)
            <p class="powered">Powered by <a href="/">{{ site_settings('site_name', 'Osvioo') }}</a></p>
        @endif
    </div>

</div>
</body>
</html>

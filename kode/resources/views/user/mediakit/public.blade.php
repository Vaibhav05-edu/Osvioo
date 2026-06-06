<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$mediaKit->title}} | Media Kit</title>
    <meta name="description" content="Official Media Kit for {{$mediaKit->user->name}}">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:#f5f0ea; color:#1a1a1a; font-family:Georgia,'Times New Roman',Times,serif; min-height:100vh; }
        .wrapper { max-width:780px; margin:2rem auto; background:#fdfbf8; border:1px solid #e8e0d5; border-radius:4px; overflow:hidden; box-shadow:0 4px 30px rgba(0,0,0,0.08); }

        /* TOP CARD */
        .top-card { display:grid; grid-template-columns:260px 1fr; min-height:340px; border-bottom:1px solid #e8e0d5; }
        @media(max-width:600px){ .top-card{grid-template-columns:1fr;} .photo-col{height:260px;} }
        .photo-col { background:#e8e2d9; overflow:hidden; position:relative; }
        .photo-col img { width:100%; height:100%; object-fit:cover; object-position:top center; display:block; }
        .photo-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:linear-gradient(160deg,#e8ddd0 0%,#d4c9b8 100%); font-size:5rem; color:rgba(150,130,110,0.4); }
        .info-col { padding:2.5rem 2.5rem 2rem; display:flex; flex-direction:column; justify-content:center; text-align:center; background:#fdfbf8; }
        .creator-name { font-size:2.8rem; font-weight:400; letter-spacing:1px; color:#1a1a1a; line-height:1.1; margin-bottom:0.6rem; }
        .creator-niche { font-family:Arial,sans-serif; font-size:0.78rem; font-weight:400; letter-spacing:3px; color:#7a7060; text-transform:uppercase; margin-bottom:1rem; }
        .divider-line { width:120px; height:1px; background:#c9b89a; margin:0 auto 1.25rem; }
        .followers-num { font-size:3rem; font-weight:400; color:#1a1a1a; letter-spacing:3px; line-height:1; margin-bottom:0.2rem; }
        .followers-label { font-family:Arial,sans-serif; font-size:0.78rem; letter-spacing:2px; text-transform:uppercase; color:#7a7060; margin-bottom:1rem; }
        .handle { font-family:Arial,sans-serif; font-size:0.7rem; letter-spacing:3px; text-transform:uppercase; color:#9a8e7f; margin-bottom:1.4rem; }

        /* STAT CIRCLES */
        .stat-circles { display:flex; justify-content:center; gap:1.2rem; flex-wrap:wrap; }
        .stat-circle-item { text-align:center; }
        .stat-circle { width:60px; height:60px; border-radius:50%; border:1.5px solid #1a1a1a; display:flex; align-items:center; justify-content:center; margin:0 auto 0.35rem; font-size:0.85rem; font-weight:400; color:#1a1a1a; font-family:Georgia,serif; }
        .stat-circle-label { font-family:Arial,sans-serif; font-size:0.65rem; letter-spacing:1px; text-transform:uppercase; color:#7a7060; }

        /* SECTIONS */
        .section { padding:2.5rem 3rem; border-bottom:1px solid #e8e0d5; }
        .section-alt { padding:2rem 3rem; border-bottom:1px solid #e8e0d5; background:#faf7f3; }
        .section-title { font-family:Arial,Helvetica,sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#1a1a1a; margin-bottom:1.2rem; }
        .section-title-sm { font-family:Arial,Helvetica,sans-serif; font-size:0.75rem; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#7a7060; margin-bottom:1rem; }
        .bio-text { font-size:0.95rem; line-height:1.9; color:#4a4540; white-space:pre-wrap; }

        /* SOCIAL PILLS */
        .social-pills { display:flex; flex-wrap:wrap; gap:0.6rem; }
        .social-pill { display:inline-flex; align-items:center; gap:0.4rem; padding:0.5rem 1rem; border:1px solid #c9b89a; border-radius:50px; font-family:Arial,sans-serif; font-size:0.8rem; color:#4a4540; text-decoration:none; letter-spacing:0.5px; transition:background 0.2s,color 0.2s; }
        .social-pill:hover { background:#1a1a1a; color:#fff; border-color:#1a1a1a; }

        /* CAPTIONS */
        .caption-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:0.75rem; margin-top:0.75rem; }
        .caption-card { background:#fff; border:1px solid #e8e0d5; border-radius:6px; padding:1rem; padding-top:1.4rem; font-family:Arial,sans-serif; font-size:0.8rem; line-height:1.7; color:#4a4540; position:relative; }
        .caption-num { position:absolute; top:-1px; left:12px; background:#1a1a1a; color:#fff; width:20px; height:20px; border-radius:0 0 4px 4px; display:flex; align-items:center; justify-content:center; font-size:0.65rem; font-weight:700; }

        /* CTA */
        .cta-section { padding:2rem 3rem; text-align:center; border-bottom:1px solid #e8e0d5; }
        .cta-btn { display:inline-block; background:#1a1a1a; color:#fff; text-decoration:none; padding:0.85rem 2.5rem; font-family:Arial,sans-serif; font-size:0.8rem; font-weight:700; letter-spacing:3px; text-transform:uppercase; transition:opacity 0.2s; }
        .cta-btn:hover { opacity:0.75; }

        /* FOOTER */
        .kit-footer { padding:1.25rem 2rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem; background:#f5f0ea; }
        .footer-item { font-family:Arial,sans-serif; font-size:0.72rem; color:#7a7060; letter-spacing:0.5px; }
        .footer-item a { color:#7a7060; text-decoration:none; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- TOP CARD --}}
    <div class="top-card">
        <div class="photo-col">
            @if($mediaKit->cover_image)
                <img src="{{ asset('assets/images/custom/' . $mediaKit->cover_image) }}" alt="{{ $mediaKit->title }}">
            @else
                <div class="photo-placeholder">&#10022;</div>
            @endif
        </div>

        <div class="info-col">
            <div class="creator-name">{{ $mediaKit->title }}</div>

            @php
                $socials = $mediaKit->social_links;
                if(is_string($socials)) { $socials = json_decode($socials, true); }
                if(!is_array($socials)) { $socials = []; }
                $platforms = array_keys($socials);
                $niche = count($platforms) ? implode(' | ', array_map('strtoupper', $platforms)) : 'CONTENT CREATOR';
            @endphp

            <div class="creator-niche">{{ $niche }}</div>
            <div class="divider-line"></div>

            @if($mediaKit->total_followers > 0)
                <div class="followers-num">{{ number_format($mediaKit->total_followers) }}</div>
                <div class="followers-label">{{ $mediaKit->top_platform ?? 'Social' }} Followers</div>
            @endif

            @if(count($socials) > 0)
                @php
                    $firstUrl = array_values($socials)[0] ?? '';
                    $parsedPath = $firstUrl ? ltrim(parse_url($firstUrl, PHP_URL_PATH) ?? '', '/') : '';
                    $handleText = $parsedPath ?: $mediaKit->user->name;
                @endphp
                <div class="handle">@{{ $handleText }}</div>
            @endif

            {{-- STAT CIRCLES --}}
            <div class="stat-circles">
                @if($mediaKit->engagement_rate)
                    <div class="stat-circle-item">
                        <div class="stat-circle">{{ $mediaKit->engagement_rate }}%</div>
                        <div class="stat-circle-label">Engagement</div>
                    </div>
                @endif
                @if($mediaKit->total_followers > 0)
                    <div class="stat-circle-item">
                        <div class="stat-circle">{{ $mediaKit->total_followers >= 1000 ? round($mediaKit->total_followers/1000).'K' : $mediaKit->total_followers }}</div>
                        <div class="stat-circle-label">Reach</div>
                    </div>
                @endif
                @if($mediaKit->top_platform)
                    <div class="stat-circle-item">
                        <div class="stat-circle" style="font-size:0.68rem;">{{ strtoupper(substr($mediaKit->top_platform,0,3)) }}</div>
                        <div class="stat-circle-label">Top Platform</div>
                    </div>
                @endif
                @if(count($socials) > 0)
                    <div class="stat-circle-item">
                        <div class="stat-circle">{{ count($socials) }}</div>
                        <div class="stat-circle-label">Platforms</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MISSION / BIO --}}
    <div class="section">
        <div class="section-title">My Mission</div>
        <div class="bio-text">{{ $mediaKit->ai_generated_bio ?: $mediaKit->bio }}</div>
    </div>

    {{-- SOCIAL LINKS --}}
    @if(count($socials) > 0)
    <div class="section" style="padding:2rem 3rem;">
        <div class="section-title-sm">Connect With Me</div>
        <div class="social-pills">
            @foreach($socials as $pName => $url)
                @if($url)
                    <a href="{{ $url }}" target="_blank" class="social-pill">{{ $pName }} &#8599;</a>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- AI CAPTIONS --}}
    @if($mediaKit->ai_generated_captions)
        @php
            $captions = is_string($mediaKit->ai_generated_captions)
                ? json_decode($mediaKit->ai_generated_captions, true)
                : $mediaKit->ai_generated_captions;
        @endphp
        @if(is_array($captions) && count($captions) > 0)
        <div class="section-alt">
            <div class="section-title-sm">Content Captions</div>
            <div class="caption-grid">
                @foreach($captions as $i => $cap)
                    <div class="caption-card">
                        <div class="caption-num">{{ $i + 1 }}</div>
                        {{ $cap }}
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    @endif

    {{-- CTA --}}
    <div class="cta-section">
        <a href="mailto:{{ $mediaKit->contact_email }}" class="cta-btn">Let's Collaborate</a>
        <p style="margin-top:0.75rem;font-family:Arial,sans-serif;font-size:0.78rem;color:#7a7060;letter-spacing:1px;">
            {{ $mediaKit->contact_email }}
        </p>
    </div>

    {{-- FOOTER --}}
    <div class="kit-footer">
        <span class="footer-item">{{ $mediaKit->contact_email }}</span>
        <span class="footer-item">&copy; {{ date('Y') }} {{ $mediaKit->user->name }}</span>
        @if(!$mediaKit->watermark_removed)
            <span class="footer-item">Powered by <a href="/">{{ site_settings('site_name', 'Osvioo') }}</a></span>
        @endif
    </div>

</div>
</body>
</html>

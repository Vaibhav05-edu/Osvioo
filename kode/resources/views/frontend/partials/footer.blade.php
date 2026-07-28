@php
    $icons = get_content("element_social_icon");
@endphp

<footer class="footer-master-clone">
    <div class="container-fluid px-lg-5">
        <div class="wishlink-footer-card">
            <!-- PREMIUM GLOW -->
            <div class="wishlink-glow"></div>

            <div class="footer-grid-master">
                <!-- Column 1: Branding -->
                <div class="footer-col branding-col">
                    <span class="osvioo-logo-script" style="font-size: 2.8rem !important;">Osvioo</span>
                    <p class="copyright-text mt-3">Copyright © 2026, All Rights Reserved</p>
                    
                    <div class="legal-info-box mt-4">
                        <h6 class="fw-bold mb-1">Osvioo Private Limited</h6>
                        <p class="small-grey mb-3">CIN - U74994HR2022PTC100843</p>
                        <p class="address-text">
                            4th Floor, Plot No 48, AIHP Executive Centre,<br>
                            Sector 32, Gurugram, Haryana, 122001
                        </p>
                    </div>
                </div>

                <!-- Company -->
                <div class="footer-section">
                    <h5 class="master-col-title">Company</h5>
                    <ul class="master-links">
                        @foreach($menus as $menu)
                            <li><a href="{{ $menu->url }}">{{ $menu->name }}</a></li>
                        @endforeach
                        @foreach($pages as $page)
                            <li><a href="{{ route('page', $page->slug) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>

                    <div class="query-box mt-5">
                        <h5 class="master-col-title compact">For Brands<br>Related Queries</h5>
                        <a href="mailto:info@osvioo.com" class="master-email">info@osvioo.com</a>
                    </div>
                </div>

                <!-- Resources -->
                <div class="footer-section">
                    <h5 class="master-col-title">Resources</h5>
                    <ul class="master-links">
                        <li><a href="{{ route('blog') }}" class="pink-link">Blogs</a></li>
                        <li><a href="{{ route('blog') }}">Tech Blogs</a></li>
                        <li><a href="{{ route('blog') }}">Case Studies</a></li>
                        <li><a href="{{ route('about') }}">Career</a></li>
                    </ul>

                    <div class="query-box mt-5">
                        <h5 class="master-col-title compact">For Creators<br>Related Queries</h5>
                        <a href="mailto:support@osvioo.com" class="master-email">support@osvioo.com</a>
                    </div>
                </div>

                <!-- Meta & Social -->
                <div class="footer-section text-end">
                    <div class="meta-badge-container-master">
                        <div class="meta-row-master">
                            <!-- Meta Loop Icon -->
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.5 7C15.8 7 14.3 7.8 13.3 9.1C12.3 10.4 11.7 12 11.7 13.7C11.7 15.4 12.3 17 13.3 18.3C14.3 19.6 15.8 20.4 17.5 20.4C20.8 20.4 23.5 17.7 23.5 14.4C23.5 11.1 20.8 8.4 17.5 8.4V7ZM6.5 7C3.2 7 0.5 9.7 0.5 13C0.5 16.3 3.2 19 6.5 19C8.2 19 9.7 18.2 10.7 16.9C11.7 15.6 12.3 14 12.3 12.3C12.3 10.6 11.7 9 10.7 7.7C9.7 6.4 8.2 5.6 6.5 5.6V7ZM17.5 18.4C16.3 18.4 15.3 17.8 14.6 16.9C13.9 16 13.5 14.9 13.5 13.7C13.5 12.5 13.9 11.4 14.6 10.5C15.3 9.6 16.3 9 17.5 9C19.9 9 21.8 10.9 21.8 13.3C21.8 15.7 19.9 17.6 17.5 17.6V18.4ZM6.5 17.4C4.1 17.4 2.2 15.5 2.2 13.1C2.2 10.7 4.1 8.8 6.5 8.8C7.7 8.8 8.7 9.4 9.4 10.3C10.1 11.2 10.5 12.3 10.5 13.5C10.5 14.7 10.1 15.8 9.4 16.7C8.7 17.6 7.7 18.2 6.5 18.2V17.4Z" fill="#0668E1"/>
                            </svg>
                            <span class="meta-label-master">Meta</span>
                        </div>
                        <p class="meta-partner-label">Business Partner</p>
                    </div>

                    <div class="social-box-master mt-5">
                        <h5 class="master-col-title mb-3">Follow us</h5>
                        <div class="social-icons-row">
                            @foreach ($icons as $icon)
                                @if(!empty($icon->value->icon) && $icon->value->button_url != '@@')
                                    <a target="_blank" href="{{$icon->value->button_url}}" class="master-social-btn">
                                        <i class="{{ $icon->value->icon }}"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom-master">
                <a href="{{ route('page', 'privacy-policy') }}">Privacy Policy</a>
                <a href="{{ route('page', 'data-deletion') }}">Data Deletion</a>
                <a href="{{ route('page', 'terms-and-conditions') }}">Terms Of Service</a>
            </div>
        </div>
    </div>
</footer>

<style nonce="{{ csp_nonce() }}">
    .footer-master-clone {
        background-color: #f8f2e9;
        padding: 60px 0;
        font-family: 'Outfit', sans-serif !important;
    }

    .wishlink-footer-card {
        background: #fff;
        border-radius: 80px;
        padding: 80px 100px 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0,0,0,0.02);
    }

    .wishlink-glow {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: radial-gradient(circle at 20% 30%, rgba(139, 92, 246, 0.18) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 50% 50%, rgba(255, 210, 0, 0.08) 0%, transparent 60%);
        filter: blur(80px);
        z-index: 1;
    }

    .footer-grid-master {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
        gap: 30px;
        position: relative;
        z-index: 5;
    }

    .signature-logo {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800;
        font-size: 2.8rem;
        letter-spacing: -2px;
        color: #111;
        line-height: 1;
    }

    .copyright-text { font-size: 0.9rem; font-weight: 700; color: #111; }
    .small-grey { font-size: 0.75rem; color: #777; font-weight: 500; }
    .address-text { font-size: 0.85rem; color: #444; line-height: 1.6; font-weight: 500; }

    .master-col-title { font-size: 1.2rem; font-weight: 800; color: #111; margin-bottom: 25px; line-height: 1.2; }
    .master-col-title.compact { font-size: 1.1rem; margin-bottom: 10px; }

    .master-links { list-style: none; padding: 0; margin: 0; }
    .master-links li { margin-bottom: 12px; }
    .master-links a { text-decoration: none; color: #111; font-weight: 600; font-size: 0.95rem; opacity: 0.8; transition: opacity 0.3s; }
    .master-links a:hover { opacity: 0.5; }
    .pink-link { color: #FF4D6D !important; }

    .master-email { text-decoration: none; color: #111; font-weight: 700; font-size: 1rem; }

    .meta-badge-container-master { display: inline-block; text-align: left; }
    .meta-row-master { display: flex; align-items: center; gap: 8px; }
    .meta-label-master { font-weight: 800; font-size: 1.6rem; color: #0668E1; letter-spacing: -0.5px; line-height: 1; }
    .meta-partner-label { font-size: 0.7rem; font-weight: 700; color: #333; margin-top: -3px; margin-left: 2px; }

    .social-icons-row { display: flex; gap: 10px; justify-content: flex-end; flex-wrap: wrap; }
    .master-social-btn { width: 38px; height: 38px; background: #000; color: #fff !important; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.15rem; text-decoration: none; transition: transform 0.3s; }
    .master-social-btn i { font-family: "bootstrap-icons" !important; font-style: normal; }
    .master-social-btn:hover { transform: translateY(-5px); }

    .footer-bottom-master {
        margin-top: 80px;
        padding-top: 35px;
        border-top: 1px solid rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-around;
        position: relative;
        z-index: 5;
    }

    .footer-bottom-master a { text-decoration: none; color: #111; font-weight: 800; font-size: 0.95rem; opacity: 0.9; }

    @media (max-width: 991px) {
        .footer-grid-master { grid-template-columns: 1fr; text-align: center; }
        .footer-section.text-end { text-align: center !important; }
        .social-icons-row { justify-content: center !important; }
        .meta-badge-container-master { text-align: center; }
        .meta-row-master { justify-content: center; }
        .footer-bottom-master { flex-direction: column; align-items: center !important; gap: 20px; text-align: center; }
        .wishlink-footer-card { border-radius: 40px; padding: 60px 20px; }
    }
</style>

@php
   $footer        = get_content("content_footer")->first();
   $footerbg      = $footer->file->where("type",'footer_background')->first();
   $footerbgSize  = get_appearance_img_size('footer','content','footer_background');
   $paymentImg      = $footer->file->where("type",'payment_image')->first();
   $paymentImgSize  = get_appearance_img_size('footer','content','payment_image');
   $icons         = get_content("element_social_icon");
   $buttons       = get_content("element_footer");
   $blogs        =get_feature_blogs()->take(2);
   $services = get_content("element_service")->take(4);
@endphp

<footer class="footer-wishlink">
    <div class="container footer-card-container">
        <div class="footer-wishlink-card animate__animated animate__fadeInUp">
            <!-- THE MULTI-COLORED HALO GLOW -->
            <div class="footer-halo-glow"></div>

            <div class="row g-5 position-relative" style="z-index: 2;">
                <!-- Left Side: Branding -->
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <img src="{{imageUrl(@site_logo('user_site_logo')->file,'user_site_logo',true)}}" alt="Logo" class="footer-logo mb-4">
                        <div class="company-info mt-4">
                            <h5 class="fw-bold mb-2">Socialyt</h5>
                            <p class="fs-5 opacity-80 mb-4">Turn DMs into Sales</p>
                            
                            <div class="social-links d-flex gap-3 mt-4">
                                @foreach ($icons as $icon)
                                    <a target="_blank" href="{{$icon->value->button_url}}" class="footer-social-circle">
                                        <i class="{{ $icon->value->icon }}"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Links Grid -->
                <div class="col-lg-8">
                    <div class="row row-cols-2 row-cols-md-3 g-4">
                        <div class="col">
                            <h5 class="footer-section-title mb-4">Breakdown</h5>
                            <ul class="list-unstyled footer-links-grid">
                                <li><a href="#">Vs. Manychat</a></li>
                                <li><a href="#">Vs. InstaChamp</a></li>
                                <li><a href="#">Vs. Mobile Monkey</a></li>
                                <li><a href="#">Vs. Stan AutoDM</a></li>
                                <li><a href="#">Vs. LTK DM</a></li>
                                <li><a href="#">Vs. Inro.Social</a></li>
                            </ul>
                        </div>
                        <div class="col">
                            <h5 class="footer-section-title mb-4" style="visibility: hidden;">More Vs.</h5>
                            <ul class="list-unstyled footer-links-grid">
                                <li><a href="#">Vs. InstantDM</a></li>
                                <li><a href="#">Vs. SuperProfile.Bio</a></li>
                                <li><a href="#">Vs. Wishlink</a></li>
                                <li><a href="#">Vs. LinktoDM</a></li>
                                <li><a href="#">Vs. SendPulse</a></li>
                                <li><a href="#">Vs. DelightChat</a></li>
                            </ul>
                        </div>
                        <div class="col">
                            <h5 class="footer-section-title mb-4">Support & Legal</h5>
                            <ul class="list-unstyled footer-links-grid">
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Help Center</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                            </ul>
                            
                            <h5 class="footer-section-title mt-5 mb-4">Follow us</h5>
                            <div class="meta-partner-footer">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg" alt="Meta Partner" style="height: 25px; opacity: 0.8;">
                                <p class="x-small mt-2 opacity-60">Business Partner</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="footer-bottom-line mt-5 pt-5 border-top border-dark border-opacity-10 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <p class="mb-0 small opacity-60">{{site_settings("copy_right_text")}}</p>
                <div class="d-flex gap-4">
                    <a href="#" class="small opacity-60 text-decoration-none">Privacy Policy</a>
                    <a href="#" class="small opacity-60 text-decoration-none">Terms Of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style nonce="{{ csp_nonce() }}">
    .footer-wishlink {
        padding: 80px 0 50px;
    }

    .footer-card-container {
        max-width: 1350px !important;
    }

    .footer-wishlink-card {
        background-color: var(--wishlink-cream) !important;
        border-radius: 80px; /* Big rounded card */
        padding: 100px 80px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 40px 100px rgba(0,0,0,0.06);
        border: 1px solid rgba(255, 138, 0, 0.1);
    }

    /* REFINED HALO GLOW EFFECT - MISTY & SPREAD OUT */
    .footer-halo-glow {
        position: absolute;
        bottom: -300px;
        left: -10%;
        width: 120%;
        height: 800px;
        background: 
            radial-gradient(circle at 15% 75%, rgba(255, 210, 0, 0.35) 0%, transparent 55%),
            radial-gradient(circle at 45% 85%, rgba(255, 138, 0, 0.3) 0%, transparent 60%),
            radial-gradient(circle at 75% 70%, rgba(255, 135, 179, 0.25) 0%, transparent 55%);
        filter: blur(120px);
        pointer-events: none;
        z-index: 1;
        opacity: 0.9;
    }

    .footer-logo {
        height: 45px;
    }

    .footer-section-title {
        font-family: 'Outfit', sans-serif !important;
        font-weight: 800;
        font-size: 1.3rem;
        color: #1A1A1A;
        letter-spacing: -0.5px;
    }

    .footer-links-grid li {
        margin-bottom: 14px;
    }

    .footer-links-grid a {
        color: #1A1A1A;
        text-decoration: none;
        opacity: 0.6;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .footer-links-grid a:hover {
        opacity: 1;
        color: var(--wishlink-orange);
        padding-left: 5px;
    }

    .footer-social-circle {
        width: 45px;
        height: 45px;
        background: #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff !important;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-social-circle:hover {
        background: var(--wishlink-orange);
        transform: translateY(-5px) scale(1.1);
    }

    @media (max-width: 991px) {
        .footer-wishlink-card {
            padding: 60px 30px;
            border-radius: 50px;
            text-align: center;
        }
        .footer-brand {
            margin-bottom: 50px;
        }
        .social-links {
            justify-content: center;
        }
        .footer-halo-glow {
            width: 400px;
            height: 400px;
            left: 50%;
            transform: translateX(-50%);
        }
        .footer-links-grid {
            text-align: center;
        }
    }
</style>

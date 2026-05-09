@php
    // Fetch banner and ensure it's a single object, not a collection
    $bannerData = get_content('content_banner');
    if ($bannerData instanceof \Illuminate\Support\Collection) {
        $banner = $bannerData->first();
    } else {
        $banner = $bannerData;
    }
    
    // Use data_get for ultra-safe property access. 'file' is MorphMany so we need first()
    $bannerFileColl = data_get($banner, 'file');
    $bannerFile = ($bannerFileColl instanceof \Illuminate\Support\Collection) ? $bannerFileColl->first() : $bannerFileColl;
    
    $bannerImage = asset('assets/images/custom/hero_influencer.png');
    if ($bannerFile) {
        $dynamicUrl = imageURL($bannerFile, 'banner', false);
        // Only use the dynamic URL if it's NOT a default placeholder
        if (strpos($dynamicUrl, 'default.jpg') === false && strpos($dynamicUrl, '100x100') === false) {
            $bannerImage = $dynamicUrl;
        }
    }
    
    $heroTitle = $settings->headline_1 ?? 'Automate your social media';
    $heroSubTitle = $settings->headline_2 ?? '10x faster';
    $heroDescription = $settings->description ?? 'Our all-in-one social media management platform unlocks the full potential of social to transform not just your marketing strategy—but every area of your organization.';
    
    $typingTexts = $settings->typing_texts ?? ['AI helps you grow', 'AI creates media kit', 'AI auto DM'];
    $typingTextsJson = json_encode(array_map('trim', (array)$typingTexts));
    
    // Ensure these are collections for the loops
    $features = get_content('element_feature', false);
    if (!($features instanceof \Illuminate\Support\Collection)) {
        $features = collect($features ? [$features] : []);
    }
    $features = $features->take(3);
    
    $testimonials = get_content('element_testimonial', false);
    if (!($testimonials instanceof \Illuminate\Support\Collection)) {
        $testimonials = collect($testimonials ? [$testimonials] : []);
    }
@endphp
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Socialyt - Instagram & Facebook DM Automation</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&family=Dancing+Script:wght@700&family=Playball&family=Syne:wght@700;800&family=Montserrat:wght@700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}" />
    <style nonce="{{ csp_nonce() }}">
      :root {
          --font-heading: 'Syne', sans-serif;
          --font-body: 'Inter', sans-serif;
          --font-nav: 'Outfit', sans-serif;
      }

      body {
          font-family: var(--font-body);
          -webkit-font-smoothing: antialiased;
      }

      h1, h2, h3, .hero-title {
          font-family: var(--font-heading);
          letter-spacing: -0.02em;
      }

      h4, h5, h6, .nav-link, .btn, .navbar-brand {
          font-family: var(--font-nav);
          font-weight: 600;
      }

      .navbar-custom.sticky-top { top: 0; z-index: 1020; }
      
      .social-proof {
          position: fixed;
          bottom: 20px;
          left: 20px;
          background: white;
          padding: 8px 12px;
          border-radius: 10px;
          box-shadow: 0 10px 30px rgba(0,0,0,0.1);
          display: flex;
          align-items: center;
          gap: 10px;
          z-index: 9999;
          max-width: 250px;
          animation: slideUp 0.5s ease-out;
      }
      .social-proof img { width: 40px !important; height: 40px !important; border-radius: 8px; }
      .social-proof .text-content { font-size: 0.75rem; line-height: 1.2; }
      .social-proof .fw-bold { font-size: 0.8rem; }
      
      @keyframes slideUp {
          from { transform: translateY(100px); opacity: 0; }
          to { transform: translateY(0); opacity: 1; }
      }

      /* Mobile Optimizations */
      @media (max-width: 767.98px) {
          .display-3 { font-size: 2.2rem !important; line-height: 1.1 !important; }
          .display-4 { font-size: 1.8rem !important; }
          .display-6 { font-size: 1.3rem !important; }
          .hero-title { font-size: 2.2rem !important; margin-bottom: 1rem !important; }
          .premium-typing-text { font-size: 1.5rem !important; }
          .btn-premium, .btn-outline-premium { 
              padding: 12px 20px !important; 
              font-size: 0.9rem !important; 
              width: 100%; 
              margin-bottom: 10px;
          }
          .creator-card {
              padding: 10px 15px !important;
              border-radius: 50px !important;
          }
          .creator-card img {
              width: 60px !important;
              height: 60px !important;
          }
          .creator-card .fw-bold {
              font-size: 0.9rem !important;
          }
          .section-hero {
              padding-top: 2rem !important;
              padding-bottom: 2rem !important;
          }
          .social-proof {
              bottom: 10px;
              left: 10px;
              right: 10px;
              max-width: calc(100% - 20px);
          }
          
          /* Global Section Tweaks */
          h2 { font-size: 1.8rem !important; }
          h3 { font-size: 1.5rem !important; }
          .section-feature, .py-5 { padding-top: 3rem !important; padding-bottom: 3rem !important; }
          .container { padding-left: 20px !important; padding-right: 20px !important; }
          
          /* Feature Cards */
          .transition-transform { transform: none !important; }
          .shadow-sm { box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important; }
          
          /* Pricing Cards */
          .pricing-card { margin-bottom: 20px; }
          
          /* Images */
          img { max-width: 100%; height: auto; }
      }
    </style>
  </head>
  <body>
    @include('frontend.partials.header')

    <!-- Hero Section -->
    @include('frontend.sections.banner')

    <!-- Brand Marquee Section -->
    @include('frontend.sections.brand_marquee')

    <!-- Feature Slider Section -->
    @include('frontend.sections.feature_slider')

    <!-- Alternating Features (Stats & Stories) -->
    <!-- Why Socialyt Section (Vertical Carousel) -->
    @include('frontend.sections.why_us')

    <!-- Are you one of them? (Categories) Section -->
    @include('frontend.sections.creator_categories')



    <!-- Videos Grid -->
    <!-- Engagement in Action -->
    <section class="py-5 section-engagement-action" id="engagement">
        <div class="container py-5">
            <h2 class="text-center fw-bold mb-5 fs-1" style="font-family: 'Outfit', sans-serif !important;">Engagement in Action</h2>
            
            <style nonce="{{ csp_nonce() }}">
                .reels-grid {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 1.5rem;
                    padding: 0 1rem;
                }
                .reel-card {
                    position: relative;
                    width: 100%;
                    max-width: 280px;
                    aspect-ratio: 9/16;
                    background: #000;
                    border-radius: 2rem;
                    overflow: hidden;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
                    transition: transform 0.3s ease;
                }
                .reel-card:hover { transform: translateY(-5px); }
                .reel-iframe {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    border: 0;
                    object-fit: cover;
                }
                .reel-overlay {
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    padding: 1.5rem;
                    background: linear-gradient(transparent, rgba(0,0,0,0.8));
                    pointer-events: none;
                }
                @media (max-width: 768px) {
                    .reel-card { max-width: 45%; }
                }
                .section-engagement-action {
                    background-color: var(--royal-yellow) !important; 
                }
            </style>

            @php
                $automationVideos = [
                    ['id' => '-Nf5QNtFgkA', 'title' => 'DM Automation'],
                    ['id' => 'iYLkM9rNQUo', 'title' => 'Growth Strategy'],
                    ['id' => 'U-SvBBIr9Zc', 'title' => 'Comment Bot'],
                    ['id' => '-ND8SlMFYuA', 'title' => 'Automation Pro']
                ];
            @endphp

            <div class="reels-grid">
                @foreach($automationVideos as $video)
                    <div class="reel-card animate__animated animate__fadeInUp">
                        <iframe class="reel-iframe" 
                                src="https://www.youtube.com/embed/{{ $video['id'] }}?autoplay=1&mute=1&loop=1&playlist={{ $video['id'] }}&controls=0&modestbranding=1&rel=0" 
                                allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <div class="reel-overlay">
                            <div class="text-white fw-bold small">{{ $video['title'] }}</div>
                            <div class="text-primary small fw-bold" style="font-size: 0.6rem;">Socialyt AI</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Redesigned Pricing Section (Premium Aesthetic) -->
    <section class="py-5 section-pricing" id="pricing">
        <div class="container py-5">
            <div class="text-center mb-5 pb-4">
                <h2 class="display-3 fw-bold mb-3" style="font-family: 'Outfit', sans-serif !important;">Simple, Transparent Pricing</h2>
                <p class="fs-4 text-muted mx-auto" style="max-width: 600px; font-family: 'Outfit', sans-serif !important;">Choose the plan that fits your growth stage.</p>
            </div>
            
            <div class="row g-4 align-items-stretch justify-content-center">
                <!-- Free Plan -->
                <div class="col-lg-4">
                    <div class="pricing-card-premium">
                        <div class="plan-header">
                            <span class="plan-badge">STARTER</span>
                            <h4 class="plan-title">Free</h4>
                            <div class="plan-price">
                                <span class="currency">$</span>0
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><i class="fas fa-check-circle"></i> 100 Automated DMs/mo</li>
                                <li><i class="fas fa-check-circle"></i> Basic Comment Reply</li>
                                <li><i class="fas fa-check-circle"></i> Standard Support</li>
                                <li class="disabled"><i class="fas fa-times-circle"></i> Custom Inbox Starters</li>
                            </ul>
                        </div>
                        <div class="plan-footer">
                            <a href="#" class="btn-pricing-outline">Get Started Free</a>
                        </div>
                    </div>
                </div>

                <!-- Pro Plan (Most Popular) -->
                <div class="col-lg-4">
                    <div class="pricing-card-premium featured">
                        <div class="popular-tag">MOST POPULAR</div>
                        <div class="plan-header text-white">
                            <span class="plan-badge bg-white text-primary">GROWTH</span>
                            <h4 class="plan-title">Pro</h4>
                            <div class="plan-price">
                                <span class="currency">$</span>29
                            </div>
                        </div>
                        <div class="plan-features text-white">
                            <ul>
                                <li><i class="fas fa-check-circle text-white"></i> 5,000 Automated DMs/mo</li>
                                <li><i class="fas fa-check-circle text-white"></i> Advanced Keyword Triggers</li>
                                <li><i class="fas fa-check-circle text-white"></i> Priority Support</li>
                                <li><i class="fas fa-check-circle text-white"></i> Custom Inbox Starters</li>
                            </ul>
                        </div>
                        <div class="plan-footer">
                            <a href="#" class="btn-pricing-white">Try Pro Free</a>
                        </div>
                    </div>
                </div>

                <!-- Agency Plan -->
                <div class="col-lg-4">
                    <div class="pricing-card-premium">
                        <div class="plan-header">
                            <span class="plan-badge">ENTERPRISE</span>
                            <h4 class="plan-title">Agency</h4>
                            <div class="plan-price">
                                <span class="currency">$</span>99
                            </div>
                        </div>
                        <div class="plan-features">
                            <ul>
                                <li><i class="fas fa-check-circle"></i> Unlimited DMs</li>
                                <li><i class="fas fa-check-circle"></i> 10 Account Slots</li>
                                <li><i class="fas fa-check-circle"></i> Dedicated Manager</li>
                                <li><i class="fas fa-check-circle"></i> White Label Reporting</li>
                            </ul>
                        </div>
                        <div class="plan-footer">
                            <a href="#" class="btn-pricing-outline">Contact Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style nonce="{{ csp_nonce() }}">
            .section-pricing {
                background: #fff;
            }
            .pricing-card-premium {
                background: #fff;
                border-radius: 50px;
                padding: 50px 40px;
                height: 100%;
                display: flex;
                flex-direction: column;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                border: 2px solid #f0f0f0;
                position: relative;
            }
            .pricing-card-premium.featured {
                background: linear-gradient(135deg, var(--royal-blue) 0%, var(--royal-blue-dark) 100%);
                border: none;
                transform: scale(1.05);
                box-shadow: 0 30px 60px rgba(0, 82, 255, 0.2);
                z-index: 2;
            }
            .pricing-card-premium:not(.featured):hover {
                transform: translateY(-10px);
                border-color: var(--royal-blue);
                box-shadow: 0 20px 40px rgba(0,0,0,0.05);
            }

            .plan-badge {
                font-size: 0.75rem;
                font-weight: 800;
                padding: 6px 15px;
                background: var(--royal-blue-accent);
                color: var(--royal-blue);
                border-radius: 50px;
                letter-spacing: 1px;
                display: inline-block;
                margin-bottom: 20px;
            }
            .plan-title {
                font-family: 'Outfit', sans-serif !important;
                font-weight: 800;
                font-size: 2rem;
                margin-bottom: 10px;
            }
            .plan-price {
                font-family: 'Outfit', sans-serif !important;
                font-size: 4rem;
                font-weight: 800;
                margin-bottom: 30px;
            }
            .plan-price .currency {
                font-size: 1.5rem;
                vertical-align: super;
                margin-right: 5px;
            }

            .plan-features ul {
                list-style: none;
                padding: 0;
                margin-bottom: 40px;
                flex-grow: 1;
            }
            .plan-features li {
                margin-bottom: 15px;
                font-family: 'Outfit', sans-serif !important;
                font-weight: 500;
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .plan-features i {
                color: var(--royal-blue);
                font-size: 1.1rem;
            }
            .plan-features .disabled {
                opacity: 0.4;
                text-decoration: line-through;
            }

            .btn-pricing-outline {
                display: block;
                width: 100%;
                padding: 18px;
                border: 2px solid var(--royal-blue);
                color: var(--royal-blue) !important;
                text-align: center;
                border-radius: 50px;
                text-decoration: none !important;
                font-weight: 800;
                font-family: 'Outfit', sans-serif !important;
                transition: all 0.3s ease;
            }
            .btn-pricing-outline:hover {
                background: var(--royal-blue);
                color: white !important;
            }

            .btn-pricing-white {
                display: block;
                width: 100%;
                padding: 18px;
                background: white;
                color: var(--royal-blue) !important;
                text-align: center;
                border-radius: 50px;
                text-decoration: none !important;
                font-weight: 800;
                font-family: 'Outfit', sans-serif !important;
                transition: all 0.3s ease;
            }
            .btn-pricing-white:hover {
                transform: scale(1.05);
                box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            }

            .popular-tag {
                position: absolute;
                top: -15px;
                left: 50%;
                transform: translateX(-50%);
                background: #000;
                color: #fff;
                padding: 6px 20px;
                border-radius: 50px;
                font-size: 0.75rem;
                font-weight: 800;
                letter-spacing: 1px;
            }

            @media (max-width: 991px) {
                .pricing-card-premium.featured {
                    transform: scale(1);
                    margin: 30px 0;
                }
            }
        </style>
    </section>

    <!-- Combined Support & FAQ Section (Wishlink Style) -->
    <section class="py-5 section-support-faq" id="support">
        <div class="container py-5">
            <!-- Launchpad Header -->
            <div class="text-center mb-5 pb-4">
                <h2 class="display-3 fw-bold mb-4" style="font-family: 'Outfit', sans-serif !important;">Your launchpad to success!!</h2>
                <p class="fs-4 text-muted mx-auto lh-base" style="max-width: 900px; font-family: 'Outfit', sans-serif !important;">
                    Help your followers shop smarter with great product recommendations and 
                    <span class="text-dark fw-bold px-2" style="background-color: var(--royal-yellow) !important; display: inline-block !important; border-radius: 4px;">earn when they shop from your content.</span> 
                    With Socialyt, you can expand your reach, engage a wider audience, and effortlessly manage everything from a single app.
                </p>
            </div>

            <!-- FAQ Header -->
            <div class="mt-5 pt-5">
                <h3 class="display-3 fw-bold mb-2" style="font-family: 'Outfit', sans-serif !important;">FAQs</h3>
                <p class="fs-4 mb-5" style="font-family: 'Outfit', sans-serif !important;">Got questions? We've got answers!</p>

                <div class="accordion accordion-flush d-grid gap-3" id="faqAccordion">
                    @php
                        $faqs_list = [
                            ['q' => 'How does the Socialyt Creator payout process work?', 'a' => 'Payouts are processed automatically every month. Once you hit the minimum threshold, your earnings are transferred directly to your linked bank account or PayPal.'],
                            ['q' => 'How does Socialyt help Creators grow?', 'a' => 'Socialyt automates your engagement, allowing you to respond to 100% of comments and DMs instantly. This boosts your ranking in the algorithm and keeps your audience active.'],
                            ['q' => 'Will Brands control my content?', 'a' => 'Absolutely not. You maintain 100% creative control over your content. Socialyt just provides the tools to manage your audience and monetization.'],
                            ['q' => 'Is my account safe with Socialyt?', 'a' => 'Yes, Socialyt is an official Meta Business Partner. We use only official APIs and never ask for your password. Your account remains 100% secure.'],
                            ['q' => 'Can I use Socialyt for multiple accounts?', 'a' => 'Yes! Depending on your plan, you can manage multiple Instagram and Facebook pages from a single unified dashboard.'],
                        ];
                    @endphp

                    @foreach($faqs_list as $index => $item)
                        <div class="accordion-item border-0 bg-transparent">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed faq-btn-premium" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}">
                                    {{ $item['q'] }}
                                    <i class="fas fa-arrow-down ms-auto faq-icon-custom"></i>
                                </button>
                            </h2>
                            <div id="faq-{{ $index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body faq-body-premium">
                                    {{ $item['a'] }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <style nonce="{{ csp_nonce() }}">
            .section-support-faq {
                background: var(--royal-white);
            }
            .faq-btn-premium {
                background: linear-gradient(90deg, var(--royal-blue) 0%, var(--royal-blue-dark) 100%) !important;
                color: white !important;
                border-radius: 15px !important;
                padding: 25px 30px !important;
                font-family: 'Outfit', sans-serif !important;
                font-weight: 700 !important;
                font-size: 1.3rem !important;
                box-shadow: 0 10px 25px rgba(0, 82, 255, 0.2) !important;
                position: relative;
                border: none !important;
                display: flex;
                align-items: center;
                width: 100%;
            }
            .faq-btn-premium::after { display: none !important; }
            
            .faq-icon-custom {
                transition: transform 0.3s ease;
                font-size: 1.2rem;
            }
            .faq-btn-premium:not(.collapsed) .faq-icon-custom {
                transform: rotate(180deg);
            }

            .faq-body-premium {
                background: white !important;
                margin-top: 5px;
                border-radius: 15px !important;
                padding: 30px !important;
                font-family: 'Outfit', sans-serif !important;
                font-size: 1.1rem;
                line-height: 1.6;
                color: #555;
                box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            }

            @media (max-width: 768px) {
                .faq-btn-premium {
                    font-size: 1.1rem !important;
                    padding: 20px !important;
                }
            }
        </style>
    </section>n>

    <!-- Meta Partner -->
    <section class="py-5">
        <div class="container">
            <div class="bg-white border rounded-5 p-5 text-center shadow-sm">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg" 
                     height="60" class="mb-4" alt="Meta Partner">
                <h3 class="fw-bold mb-3">Official Meta Business Partner</h3>
                <p class="text-muted mx-auto mb-4" style="max-width: 700px">
                    Socialyt is officially certified by Meta. Your accounts are 100% safe, and your automation is built on official APIs.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-dark rounded-pill px-4 py-2"><i class="fab fa-apple me-2"></i> iOS</a>
                    <a href="#" class="btn btn-success rounded-pill px-4 py-2" style="background-color: #34d399; border:none;"><i class="fab fa-android me-2"></i> Android</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Minimalist Footer Section -->
    <footer class="footer-banner-grey">
        <div class="container">
            <div class="row g-5">
                <!-- Brand Column -->
                <div class="col-lg-4">
                    <div class="footer-brand-title">Socialyt</div>
                    <div class="footer-brand-tagline">Turn DMs into Sales</div>
                    <p class="text-muted mb-4 pe-lg-5">
                        Enhance engagement with your followers by automatically sending personalized DMs in response to comments.
                        <br><br>
                        Save time, drive sales, and strengthen connections!
                    </p>
                    <a href="#" class="btn btn-dark rounded-pill px-4 py-2 mb-4">
                        Contact Us <i class="fas fa-paper-plane ms-2"></i>
                    </a>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon-circle"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon-circle"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon-circle"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon-circle"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Breakdown Column -->
                <div class="col-lg-3 footer-link-col">
                    <h5>Breakdown</h5>
                    <div class="row row-cols-2">
                        <div class="col">
                            <ul class="list-unstyled">
                                <li><a href="#">Vs. Manychat</a></li>
                                <li><a href="#">Vs. InstaChamp</a></li>
                                <li><a href="#">Vs. Mobile Monkey</a></li>
                                <li><a href="#">Vs. Stan AutoDM</a></li>
                                <li><a href="#">Vs. LTK DM</a></li>
                                <li><a href="#">Vs. Inro.Social</a></li>
                            </ul>
                        </div>
                        <div class="col">
                            <ul class="list-unstyled">
                                <li><a href="#">Vs. InstantDM</a></li>
                                <li><a href="#">Vs. SuperProfile.Bio</a></li>
                                <li><a href="#">Vs. Wishlink</a></li>
                                <li><a href="#">Vs. LinktoDM</a></li>
                                <li><a href="#">Vs. SendPulse</a></li>
                                <li><a href="#">Vs. DelightChat</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Support & Legal -->
                <div class="col-lg-2 footer-link-col">
                    <h5>Support & Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Contact Us</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Return and Refund Policy</a></li>
                    </ul>
                    
                    <h5 class="mt-4">Review Us</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Trustpilot</a></li>
                        <li><a href="#">G2</a></li>
                        <li><a href="#">Capterra</a></li>
                    </ul>
                </div>

                <!-- Info & Solutions -->
                <div class="col-lg-2 footer-link-col">
                    <h5>Info</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Create Account</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Meta Verified</a></li>
                    </ul>

                    <h5 class="mt-4">Solutions</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Creators</a></li>
                        <li><a href="#">E-Commerce</a></li>
                    </ul>
                </div>
            </div>

            <!-- Large Watermark -->
            <div class="footer-watermark">Socialyt</div>

            <div class="text-center mt-5 pt-4 border-top">
                <p class="text-muted small">&copy; Copyrights 2026. All rights reserved by Hexotix Private Limited.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <style nonce="{{ csp_nonce() }}">
        .premium-social-proof {
            position: fixed;
            bottom: 25px;
            left: 25px;
            background: #fff !important;
            padding: 8px 15px !important;
            border-radius: 50px !important;
            box-shadow: 0 10px 40px rgba(0,0,0,0.12) !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 12px !important;
            z-index: 99999 !important;
            border: 1px solid rgba(0,0,0,0.05) !important;
            width: auto !important;
            max-width: 500px !important;
        }
        .premium-social-proof span {
            white-space: nowrap !important;
            display: inline-block !important;
        }
        .sp-img-box {
            width: 32px !important;
            height: 32px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            flex-shrink: 0 !important;
        }
    </style>

    <!-- Dynamic Social Proof Popup -->
    <div id="dynamic-social-proof" class="premium-social-proof d-none animate__animated">
        <img id="sp-img" src="https://i.pravatar.cc/150?u=1" alt="User" class="sp-img-box">
        <div class="d-flex align-items-center gap-2">
            <span id="sp-name" class="fw-bold text-dark" style="font-size: 0.8rem;">Manas 🇺🇸</span>
            <span id="sp-action" class="text-muted" style="font-size: 0.8rem;">Just signed up to Socialyt</span>
            <span id="sp-time" class="text-muted" style="font-size: 0.7rem; opacity: 0.7;">• Just now</span>
        </div>
        <button onclick="document.getElementById('dynamic-social-proof').classList.add('d-none')" class="btn-close ms-2" style="font-size: 0.5rem; opacity: 0.4; flex-shrink: 0;" aria-label="Close"></button>
    </div>

    <script nonce="{{ csp_nonce() }}">
        const notifications = [
            { name: 'Manas 🇺🇸', action: 'Just signed up to Socialyt', time: 'Just now', img: 'https://i.pravatar.cc/150?u=1' },
            { name: 'Sarah 🇬🇧', action: 'Upgraded to Pro', time: '2 mins ago', img: 'https://i.pravatar.cc/150?u=2' },
            { name: 'Alex 🇨🇦', action: 'Started automating comments', time: '5 mins ago', img: 'https://i.pravatar.cc/150?u=3' },
            { name: 'Priya 🇮🇳', action: 'Just signed up to Socialyt', time: '12 mins ago', img: 'https://i.pravatar.cc/150?u=4' },
            { name: 'Mike 🇦🇺', action: 'Upgraded to Agency', time: '1 hour ago', img: 'https://i.pravatar.cc/150?u=5' },
            { name: 'Elena 🇪🇸', action: 'Hit 10k DMs sent!', time: '3 hours ago', img: 'https://i.pravatar.cc/150?u=6' }
        ];

        function showNotification() {
            const popup = document.getElementById('dynamic-social-proof');
            if (!popup) return;
            const data = notifications[Math.floor(Math.random() * notifications.length)];
            document.getElementById('sp-img').src = data.img;
            document.getElementById('sp-name').textContent = data.name;
            document.getElementById('sp-action').textContent = data.action;
            document.getElementById('sp-time').textContent = data.time;
            popup.classList.remove('d-none', 'animate__fadeOutDown');
            popup.classList.add('animate__animated', 'animate__fadeInUp');
            setTimeout(() => {
                popup.classList.remove('animate__fadeInUp');
                popup.classList.add('animate__fadeOutDown');
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            console.log('Initializing Swiper sliders...');
            
            // Feature Slider
            const featureSwiper = new Swiper('.feature-swiper', {
                loop: true,
                slidesPerView: 1,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                speed: 800,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.feature-next',
                    prevEl: '.feature-prev',
                }
            });

            // Why Socialyt (Orange Section)
            const whySwiper = new Swiper('.why-socialyt-swiper-container', {
                direction: 'vertical',
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                speed: 800,
                pagination: {
                    el: '.why-socialyt-pagination',
                    clickable: true,
                },
                height: 600
            });

            // Creator Love (Stacked Cards)
            const creatorSwiper = new Swiper('.creator-swiper', {
                effect: 'cards',
                grabCursor: true,
                loop: true,
                cardsEffect: {
                    slideShadows: false, // Clean look
                    perSlideOffset: 12,  // Controlled stack depth
                    perSlideRotate: 0,   // No rotation for a "neat" look
                },
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                }
            });

            // Force start as a fail-safe
            if (featureSwiper && featureSwiper.autoplay) {
                featureSwiper.autoplay.start();
                console.log('Feature Slider autoplay started');
            }
            if (whySwiper && whySwiper.autoplay) {
                whySwiper.autoplay.start();
                console.log('Why Socialyt autoplay started');
            }

            setTimeout(() => {
                showNotification();
                setInterval(showNotification, 6000);
            }, 2000);
        });
    </script>
  </body>
</html>
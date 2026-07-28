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
    <title>Osvioo - Instagram & Facebook DM Automation</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/logo.jpeg') }}" />
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" />
    <link nonce="{{ csp_nonce() }}" href="{{ asset('assets/global/css/bootstrap-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&family=Caveat:wght@400..700&family=Dancing+Script:wght@700&family=Playball&family=Syne:wght@700;800&family=Montserrat:wght@700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}?v={{ time() }}" />
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/mobile.css') }}?v={{ time() }}" />
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
          h2 { font-size: 1.5rem !important; }
          h3 { font-size: 1.3rem !important; }
          .section-feature, .py-5 { padding-top: 2rem !important; padding-bottom: 2rem !important; }
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

    <!-- Video Social Proof Section -->
    @include('frontend.sections.video_social_proof')

    <!-- Feature Slider Section -->
    @include('frontend.sections.feature_slider')

    <!-- Alternating Features (Stats & Stories) -->
    <!-- Why Osvioo Section (Vertical Carousel) -->
    @include('frontend.sections.why_us')

    <!-- Are you one of them? (Categories) Section -->
    @include('frontend.sections.creator_categories')



    <!-- Removed old Engagement in Action section -->

    <!-- Client Success Stories Section -->
    @include('frontend.sections.success_stories')

    <!-- Combined Support & FAQ Section (Wishlink Style) -->
    <section class="py-5 section-support-faq" id="support">
        <div class="container py-5">
            <!-- FAQ Header -->
            <div class="mt-5 pt-5">
                <h3 class="display-5 fw-bold mb-2" style="font-family: 'Outfit', sans-serif !important;">FAQs</h3>
                <p class="fs-6 mb-5" style="font-family: 'Outfit', sans-serif !important;">Got questions? We've got answers!</p>

                <div class="accordion accordion-flush d-grid gap-3" id="faqAccordion">
                    @php
                        $faqs_list = [
                            ['q' => 'How does the <span class="osvioo-logo-script" style="font-size: 1.1rem !important; margin: 0 6px; display: inline-block; vertical-align: middle;">Osvioo</span> Creator payout process work?', 'a' => 'Payouts are processed automatically every month. Once you hit the minimum threshold, your earnings are transferred directly to your linked bank account or PayPal.'],
                            ['q' => 'How does <span class="osvioo-logo-script" style="font-size: 1.1rem !important; margin: 0 6px; display: inline-block; vertical-align: middle;">Osvioo</span> help Creators grow?', 'a' => 'Osvioo automates your engagement, allowing you to respond to 100% of comments and DMs instantly. This boosts your ranking in the algorithm and keeps your audience active.'],
                            ['q' => 'Will Brands control my content?', 'a' => 'Absolutely not. You maintain 100% creative control over your content. Osvioo just provides the tools to manage your audience and monetization.'],
                            ['q' => 'Is my account safe with <span class="osvioo-logo-script" style="font-size: 1.1rem !important; margin: 0 6px; display: inline-block; vertical-align: middle;">Osvioo</span>?', 'a' => 'Yes, Osvioo is an official Meta Business Partner. We use only official APIs and never ask for your password. Your account remains 100% secure.'],
                            ['q' => 'Can I use <span class="osvioo-logo-script" style="font-size: 1.1rem !important; margin: 0 6px; display: inline-block; vertical-align: middle;">Osvioo</span> for multiple accounts?', 'a' => 'Yes! Depending on your plan, you can manage multiple Instagram and Facebook pages from a single unified dashboard.'],
                        ];
                    @endphp

                    @foreach($faqs_list as $index => $item)
                        <div class="accordion-item border-0 bg-transparent">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed faq-btn-premium" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $index }}">
                                    <span class="faq-question-text" style="flex: 1; padding-right: 15px;">{!! $item['q'] !!}</span>
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
                background: linear-gradient(90deg, #8B5CF6 0%, #6366F1 100%) !important; /* Purple-dominant gradient */
                color: white !important;
                border-radius: 15px !important;
                padding: 25px 30px !important;
                font-family: 'Outfit', sans-serif !important;
                font-weight: 700 !important;
                font-size: 1.1rem !important;
                box-shadow: 0 10px 25px rgba(139, 92, 246, 0.2) !important;
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
                font-size: 0.95rem;
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
    </section>


    <!-- Meta Partner & Footer Integrated in Partial -->
    @include('frontend.partials.footer')

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

    @include('frontend.partials.footer')
    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('DOMContentLoaded', function() {
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

            // Why Osvioo (Orange Section)
            const whySwiper = new Swiper('.why-socialyt-swiper-container', {
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                },
                speed: 800,
                pagination: {
                    el: '.why-socialyt-pagination',
                    clickable: true,
                },
                breakpoints: {
                    992: {
                        direction: 'vertical',
                        height: 600
                    },
                    0: {
                        direction: 'horizontal',
                        height: 800
                    }
                }
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
                console.log('Why Osvioo autoplay started');
            }



        });
    </script>
  </body>
</html>
@extends('layouts.master')
@section('content')

<style nonce="{{ csp_nonce() }}">
    /* PREDIS.AI MASTER CLONE DESIGN SYSTEM */
    :root {
        --predis-blue: #0052FF !important;
        --predis-dark: #031B33 !important;
        --predis-green: #10B981 !important;
        --predis-pink: #EC4899 !important;
        --predis-light-blue: #EFF6FF !important;
        --predis-border: #E2E8F0 !important;
        --predis-text-muted: #64748B !important;
        --hero-dark: #031B33 !important;
        --credit-gradient: linear-gradient(90deg, #3B82F6 0%, #EC4899 100%) !important;
        --primary-gradient: linear-gradient(90deg, #3B82F6 0%, #D946EF 100%) !important;
        --faq-gradient: linear-gradient(90deg, #8B5CF6 0%, #D946EF 100%) !important;
    }

    .nav-link-wishlink {
        font-weight: 700 !important;
        font-size: 0.9rem !important;
    }

    .pricing-page-wrapper { background-color: #fff !important; padding-bottom: 100px !important; font-family: 'Inter', sans-serif !important; overflow-x: hidden; }
    
    .pricing-hero-predis { text-align: center !important; padding: 60px 0 30px !important; }
    .pricing-hero-predis h1 { font-size: 2.8rem !important; font-weight: 900 !important; color: var(--hero-dark) !important; margin-bottom: 12px !important; letter-spacing: -1.5px !important; line-height: 1.1 !important; }
    .gradient-text-hero { background: var(--primary-gradient) !important; -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important; display: inline-block !important; }
    .pricing-hero-predis p { font-size: 0.95rem !important; color: #031B33 !important; font-weight: 600 !important; max-width: 750px !important; margin: 0 auto 35px !important; opacity: 0.9 !important; }
    .trusted-badge-pill { display: inline-block !important; background: #FFFFFF !important; border: 1px solid #F1F5F9 !important; padding: 12px 30px !important; border-radius: 100px !important; box-shadow: 0 10px 40px rgba(0,0,0,0.06) !important; color: #475569 !important; font-weight: 700 !important; font-size: 0.85rem !important; }

    .duration-toggle-container { margin: 50px 0 !important; }
    .predis-tab-nav { background: #F1F5F9 !important; padding: 5px !important; border-radius: 100px !important; display: inline-flex !important; border: 1px solid #E2E8F0 !important; }
    .predis-tab-nav .nav-link { border-radius: 100px !important; padding: 10px 45px !important; font-weight: 800 !important; font-size: 0.95rem !important; color: #64748B !important; border: none !important; transition: all 0.3s ease !important; }
    .predis-tab-nav .nav-link.active { background: #FFFFFF !important; color: var(--predis-dark) !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; }

    /* PRICING CARDS */
    .predis-pricing-card { background: #FFFFFF !important; border: 1px solid var(--predis-border) !important; border-radius: 24px !important; padding: 30px 25px !important; height: 100% !important; position: relative !important; display: flex !important; flex-direction: column !important; }
    .predis-pricing-card.featured { border: 2px solid #8B5CF6 !important; box-shadow: 0 25px 60px rgba(139, 92, 246, 0.1) !important; }
    .popular-badge { position: absolute !important; top: 15px !important; right: 15px !important; background: #3B82F6 !important; color: white !important; padding: 4px 12px !important; border-radius: 8px !important; font-size: 0.7rem !important; font-weight: 800 !important; }
    .plan-name { font-size: 1.4rem !important; font-weight: 900 !important; color: var(--predis-dark) !important; margin-bottom: 15px !important; }

    .price-container { margin-bottom: 30px !important; }
    .current-price { display: flex !important; align-items: flex-start !important; color: var(--predis-blue) !important; font-weight: 900 !important; line-height: 1 !important; }
    .price-currency { font-size: 1.2rem !important; margin-top: 4px !important; margin-right: 4px !important; }
    .price-amount { font-size: 3rem !important; letter-spacing: -1.5px !important; }
    .price-period { font-size: 1rem !important; color: var(--predis-text-muted) !important; margin-left: 5px !important; align-self: center !important; font-weight: 700 !important; }
    .billed-text { font-size: 0.9rem !important; color: var(--predis-dark) !important; font-weight: 700 !important; margin-top: 8px; }

    .predis-btn-split { display: flex !important; width: 100% !important; margin: 30px 0 12px !important; border-radius: 12px !important; overflow: hidden !important; text-decoration: none !important; }
    .predis-btn-main { flex-grow: 1 !important; padding: 18px !important; font-weight: 900 !important; font-size: 1rem !important; text-align: center !important; }
    .btn-main-light { background: #EFF6FF !important; color: #0052FF !important; }
    .btn-main-dark { background: #031B33 !important; color: #FFFFFF !important; }
    .predis-btn-discount { background: #0052FF !important; color: white !important; padding: 18px 20px !important; font-weight: 900 !important; font-size: 0.9rem !important; }
    .trial-caption { font-size: 0.9rem !important; color: var(--predis-text-muted) !important; font-weight: 800 !important; margin-bottom: 40px !important; text-align: center; }

    .credits-total { font-size: 1.7rem !important; font-weight: 900 !important; color: var(--predis-dark) !important; text-align: center !important; }
    .credits-breakdown { font-size: 0.9rem !important; color: var(--predis-text-muted) !important; text-align: center !important; font-weight: 700 !important; margin-bottom: 12px !important; }
    .predis-bar-wrapper { height: 8px !important; background: #F1F5F9 !important; border-radius: 100px !important; overflow: hidden !important; }
    .predis-bar-fill { height: 100% !important; background: var(--credit-gradient) !important; }
    .extra-output-link { text-align: right !important; color: #0052FF !important; font-size: 0.85rem !important; font-weight: 900 !important; margin-top: 8px; margin-bottom: 30px; }

    .feature-row { display: flex !important; gap: 12px !important; margin-bottom: 20px !important; }
    .tick-icon { color: var(--predis-green) !important; font-size: 1.2rem !important; margin-top: 2px !important; }
    .feature-main-text { font-weight: 800 !important; color: #1E293B !important; font-size: 1.05rem !important; display: flex !important; align-items: center; }
    .feature-sub-text { font-size: 0.9rem !important; color: var(--predis-text-muted) !important; margin-top: 4px !important; font-weight: 600 !important; padding-left: 30px; }

    .addons-block { margin-top: 30px !important; padding-top: 30px !important; border-top: 1px solid #F1F5F9 !important; }
    .addon-item-row { display: flex !important; justify-content: space-between !important; align-items: center !important; margin-bottom: 15px !important; }
    .addon-info-text { font-size: 0.95rem !important; font-weight: 800 !important; color: #334155 !important; }
    .addon-stepper { display: flex !important; align-items: center !important; border: 2px solid #E2E8F0 !important; border-radius: 100px !important; padding: 4px 12px !important; background: #fff !important; }
    .stepper-btn { background: none !important; border: none !important; color: #64748B !important; font-size: 1.4rem !important; cursor: pointer !important; min-width: 40px; user-select: none; }
    .stepper-val { font-weight: 900 !important; min-width: 25px !important; text-align: center !important; font-size: 1.1rem; color: var(--predis-dark); }

    /* COMPARISON TABLE - ULTRA DETAILED MASTER RESTORE */
    .comparison-section-wrapper { padding: 120px 0; background: #FCFDFF; border-top: 1px solid #F1F5F9; }
    .comparison-table-container { background: #FFFFFF; border-radius: 40px; box-shadow: 0 40px 100px rgba(0,0,0,0.05); padding: 60px; overflow: hidden; border: 1px solid #F1F5F9; }
    .comparison-table thead th { border: none !important; padding: 40px 20px !important; vertical-align: bottom !important; }
    .comparison-table tbody td { border-top: 1px solid #F1F5F9 !important; padding: 22px 25px !important; font-size: 1.1rem !important; color: #475569 !important; }
    .feature-category-row td { background: #F8FAFC !important; font-weight: 900 !important; color: #031B33 !important; font-size: 1.2rem !important; text-transform: uppercase; letter-spacing: 1.5px; padding: 25px 35px !important; border-top: 2px solid #E2E8F0 !important; }
    .comp-feature-name { font-weight: 700; color: #1E293B; }
    .comp-check { color: var(--predis-green); font-size: 1.4rem; }
    .comp-cross { color: #CBD5E1; font-size: 1.4rem; }
    .comp-val { font-weight: 900; color: #031B33; font-size: 1.1rem; }
    .rise-column-highlight { background: #F5F3FF !important; border-left: 2px solid #DDD6FE !important; border-right: 2px solid #DDD6FE !important; }

    /* FAQ - EXACT PREVIOUS RESTORE */
    .faq-section-wrapper { padding: 100px 0; background: #F8F5F0 !important; }
    .faq-header { margin-bottom: 50px; text-align: left; max-width: 1000px; margin-left: auto; margin-right: auto; }
    .faq-header h2 { font-size: 3rem; font-weight: 900; color: #1E293B; margin-bottom: 10px; letter-spacing: -1.5px; }
    .faq-header p { font-size: 1rem; color: #475569; font-weight: 600; }
    
    .faq-accordion-custom { max-width: 1000px; margin: 0 auto; }
    .faq-item-custom { margin-bottom: 15px; border: none !important; }
    .faq-trigger-custom { 
        width: 100%; padding: 22px 30px; 
        background: linear-gradient(90deg, #8B5CF6 0%, #D946EF 100%) !important; 
        border: none !important; text-align: left; display: flex; justify-content: space-between; align-items: center; 
        font-size: 1.25rem; font-weight: 800; color: #FFFFFF !important; border-radius: 14px !important; 
        transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.2);
    }
    .faq-trigger-custom:not(.collapsed) { border-radius: 14px 14px 0 0 !important; }
    .faq-trigger-custom::after { content: '\F282'; font-family: "bootstrap-icons" !important; font-size: 1.2rem; transition: transform 0.3s; color: #FFFFFF; }
    .faq-trigger-custom:not(.collapsed)::after { transform: rotate(180deg); }
    .faq-answer-wrapper { background: #FFFFFF; border-radius: 0 0 14px 14px; border: 1px solid #F1F5F9; border-top: none; }
    .faq-answer-inner { padding: 30px; font-size: 1.15rem; color: #475569; line-height: 1.8; font-weight: 500; }
</style>

<div class="pricing-page-wrapper">
    <div class="container">
        <!-- HERO -->
        <div class="pricing-hero-predis">
            <h1>High-Performing Content That <br><span class="gradient-text-hero">Drives Real Results</span></h1>
            <p>Generate, design, and optimise social media content with AI. Faster, easier, and built for growth</p>
            <div class="text-center"><div class="trusted-badge-pill">Trusted by 6.5M+ creators worldwide</div></div>
        </div>

        <!-- TABS -->
        <div class="duration-toggle-container text-center">
            <ul class="nav predis-tab-nav" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="tab-monthly" data-bs-toggle="tab" data-bs-target="#pane-monthly">Pay Monthly</button></li>
                <li class="nav-item"><button class="nav-link" id="tab-yearly" data-bs-toggle="tab" data-bs-target="#pane-yearly">Pay Annually</button></li>
            </ul>
        </div>

        <div class="tab-content">
            @php 
                $types = [
                    'monthly' => $plans->where('duration', 1),
                    'yearly' => $plans->where('duration', 2)
                ];
            @endphp
            @foreach ($types as $key => $cards)
                <div class="tab-pane fade {{ $key == 'monthly' ? 'show active' : '' }}" id="pane-{{$key}}">
                    <div class="row g-4 justify-content-center">
                        @foreach ($cards as $plan)
                            @php
                                $aiConfig = (array) $plan->ai_configuration;
                                $socialAccess = (array) $plan->social_access;
                                $credits = $aiConfig['word_limit'] ?? 0;
                                $bonus = $credits > 0 ? (int)($credits * 0.4) : 0;
                                $profiles = $socialAccess['profile'] ?? 1;
                            @endphp
                            <div class="col-lg-4 col-md-6">
                                <div class="predis-pricing-card {{ $plan->is_recommended ? 'featured' : '' }}" data-base-price="{{$plan->price}}" data-base-credits="{{$credits}}" data-bonus-credits="{{$bonus}}" data-base-channels="{{$profiles}}">
                                    @if($plan->is_recommended) <div class="popular-badge">Most Popular</div> @endif
                                    <div class="plan-name">{{$plan->title}}</div>
                                    <div class="price-container">
                                        <div class="current-price"><span class="price-currency">$</span><span class="price-amount dynamic-price">{{ num_format(number: $plan->price, calC:true) }}</span><span class="price-period">/ {{ $key == 'monthly' ? 'month' : 'year' }}</span></div>
                                        <div class="billed-text dynamic-billed-text">Billed {{ ucfirst($key) }}</div>
                                    </div>
                                    <a href="{{ route('register') }}" class="predis-btn-split text-decoration-none">
                                        <div class="predis-btn-main {{ $plan->title == 'Rise' ? 'btn-main-dark' : 'btn-main-light' }}">Start for free</div>
                                        @if($plan->discount_price > 0 && $plan->price > 0)
                                            <div class="predis-btn-discount">{{ round((($plan->price - $plan->discount_price) / $plan->price) * 100) }}% off</div>
                                        @endif
                                    </a>
                                    <div class="trial-caption">$0 for 7 Days</div>
                                    <div class="credits-total"><span class="dynamic-total-credits">{{ number_format($credits + $bonus) }}</span> Total Credits</div>
                                    <div class="credits-breakdown">(<span class="dynamic-base-credits">{{ number_format($credits) }}</span> + <span class="dynamic-bonus-credits">{{ number_format($bonus) }}</span> Bonus)</div>
                                    <div class="predis-bar-wrapper"><div class="predis-bar-fill" style="width: 75%;"></div></div>
                                    <div class="extra-output-link">40% extra output</div>
                                    <div class="feature-list-box flex-grow-1">
                                        <div class="feature-row" style="margin-bottom: 5px;"><i class="bi bi-check-circle-fill tick-icon"></i><div class="feature-main-text"><span class="dynamic-feat-credits">{{ number_format($credits) }}</span> Credits/mo</div></div>
                                        <div class="feature-sub-text mb-4">Enough for <span class="dynamic-feat-images">{{ number_format(max(1, $credits / 20)) }}</span> AI Images</div>
                                        <div class="feature-row"><i class="bi bi-check-circle-fill tick-icon"></i><div class="feature-main-text"><strong>{{$profiles}}</strong> Brand</div></div>
                                        <div class="feature-row"><i class="bi bi-check-circle-fill tick-icon"></i><div class="feature-main-text">Publish to <span class="dynamic-feat-channels"><strong>{{$profiles}}</strong></span> Channels</div></div>
                                    </div>
                                    <div class="addons-block">
                                        <div class="addon-item-row" data-type="channel">
                                            <div class="addon-info-text">1 Social Channel ($5/mo)</div>
                                            <div class="addon-stepper"><button type="button" class="stepper-btn btn-minus">-</button><span class="stepper-val addon-count">0</span><button type="button" class="stepper-btn btn-plus">+</button></div>
                                        </div>
                                        <div class="addon-item-row" data-type="credit">
                                            <div class="addon-info-text">Extra Credits ($29/mo)</div>
                                            <div class="addon-stepper"><button type="button" class="stepper-btn btn-minus">-</button><span class="stepper-val addon-count">0</span><button type="button" class="stepper-btn btn-plus">+</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="comparison-section-wrapper">
    <div class="container">
        <h2 class="text-center fw-900 mb-5" style="font-size: 3.5rem;">Detailed Plan Comparison</h2>
        <div class="comparison-table-container">
            <div class="table-responsive">
                <table class="table comparison-table align-middle">
                    <thead>
                        <tr><th style="width: 34%;"></th><th class="text-center" style="width: 22%;"><div class="fw-900 text-dark" style="font-size: 1.8rem;">Free</div><div class="text-muted mt-1">$0 /mo</div></th><th class="text-center rise-column-highlight" style="width: 22%; border-radius: 20px 20px 0 0;"><div class="fw-900 text-primary" style="font-size: 1.8rem;">Rise</div><div class="text-muted mt-1">$40 /mo</div></th><th class="text-center" style="width: 22%;"><div class="fw-900 text-dark" style="font-size: 1.8rem;">Enterprise</div><div class="text-muted mt-1">$212 /mo</div></th></tr>
                    </thead>
                    <tbody>
                        <tr class="feature-category-row"><td colspan="4">Content Generation</td></tr>
                        <tr><td class="comp-feature-name">Monthly AI Credits</td><td class="text-center comp-val">100</td><td class="text-center comp-val rise-column-highlight">3,200</td><td class="text-center comp-val">10,000</td></tr>
                        <tr><td class="comp-feature-name">Bonus Credits</td><td class="text-center comp-val">0</td><td class="text-center comp-val rise-column-highlight">1,280</td><td class="text-center comp-val">4,000</td></tr>
                        <tr><td class="comp-feature-name">AI Image Generation</td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check rise-column-highlight"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                        <tr><td class="comp-feature-name">AI Video Generation</td><td class="text-center comp-cross"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-check rise-column-highlight"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                        
                        <tr class="feature-category-row"><td colspan="4">Social Management</td></tr>
                        <tr><td class="comp-feature-name">Social Channels</td><td class="text-center comp-val">1</td><td class="text-center comp-val rise-column-highlight">20</td><td class="text-center comp-val">60</td></tr>
                        <tr><td class="comp-feature-name">Post Scheduling</td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check rise-column-highlight"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                        <tr><td class="comp-feature-name">Calendar View</td><td class="text-center comp-cross"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-check rise-column-highlight"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                        
                        <tr class="feature-category-row"><td colspan="4">Analytics & Support</td></tr>
                        <tr><td class="comp-feature-name">Weekly Performance Reports</td><td class="text-center comp-cross"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-check rise-column-highlight"><i class="bi bi-check-circle-fill text-success"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                        <tr><td class="comp-feature-name">Priority Chat Support</td><td class="text-center comp-cross"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-cross rise-column-highlight"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                        <tr><td class="comp-feature-name">Dedicated Account Manager</td><td class="text-center comp-cross"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-cross rise-column-highlight"><i class="bi bi-x-circle-fill text-muted opacity-25"></i></td><td class="text-center comp-check"><i class="bi bi-check-circle-fill text-success"></i></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="faq-section-wrapper">
    <div class="container">
        <div class="faq-header"><h2>FAQs</h2><p>Got questions? We've got answers!</p></div>
        <div class="faq-accordion-custom" id="pricingAccordion">
            @php
                $faqs = [
                    ['q' => 'How does the Osvioo Creator payout process work?', 'a' => 'Creators are paid out automatically through our secure payment gateway once they reach the minimum threshold.'],
                    ['q' => 'How does Osvioo help Creators grow?', 'a' => 'We provide AI-driven insights, content automation, and direct brand connection tools to amplify your reach.'],
                    ['q' => 'Will Brands control my content?', 'a' => 'No, you maintain full creative control. Brands only provide guidelines and approve final deliverables.'],
                    ['q' => 'Is my account safe with Osvioo?', 'a' => 'Yes, we use industry-standard encryption and official APIs to ensure your accounts are always secure.'],
                    ['q' => 'Can I use Osvioo for multiple accounts?', 'a' => 'Yes, depending on your plan, you can manage multiple social profiles from a single dashboard.']
                ];
            @endphp
            @foreach($faqs as $i => $f)
                <div class="faq-item-custom">
                    <button class="faq-trigger-custom collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{$i}}">
                        <span>{{$f['q']}}</span>
                    </button>
                    <div id="faq-{{$i}}" class="accordion-collapse collapse" data-bs-parent="#pricingAccordion">
                        <div class="faq-answer-wrapper"><div class="faq-answer-inner">{{$f['a']}}</div></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script nonce="{{ csp_nonce() }}">
document.addEventListener('DOMContentLoaded', function() {
    // Exact match for the reference screenshot nav states
    const navLinks = document.querySelectorAll('.nav-link-wishlink');
    navLinks.forEach(link => {
        const text = link.innerText.trim();
        if (text === 'Creators') {
            link.classList.add('active-pill');
        } else if (text === 'Pricing') {
            link.classList.remove('active-pill');
            link.classList.add('blue-text');
        } else {
            link.classList.remove('active-pill');
            link.classList.remove('blue-text');
        }
    });

    function update(card) {
        let extraCost = 0, extraCr = 0, extraCh = 0;
        card.querySelectorAll('.addon-item-row').forEach(row => {
            const count = parseInt(row.querySelector('.addon-count').innerText) || 0;
            if (row.dataset.type === 'channel') { extraCost += count * 5; extraCh += count; }
            else { extraCost += count * 29; extraCr += count * 1200; }
        });
        const bP = parseInt(card.dataset.basePrice), bCr = parseInt(card.dataset.baseCredits), boCr = parseInt(card.dataset.bonusCredits), bCh = parseInt(card.dataset.baseChannels);
        card.querySelector('.dynamic-price').innerText = (bP + extraCost);
        card.querySelector('.dynamic-total-credits').innerText = (bCr + extraCr + boCr).toLocaleString();
        card.querySelector('.dynamic-base-credits').innerText = (bCr + extraCr).toLocaleString();
        card.querySelector('.dynamic-feat-credits').innerText = (bCr + extraCr).toLocaleString();
    }
    document.querySelectorAll('.btn-plus, .btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const countSpan = this.parentElement.querySelector('.addon-count');
            let count = parseInt(countSpan.innerText) || 0;
            count = Math.max(0, count + (this.classList.contains('btn-plus') ? 1 : -1));
            countSpan.innerText = count;
            update(this.closest('.predis-pricing-card'));
        });
    });
});
</script>
@endsection
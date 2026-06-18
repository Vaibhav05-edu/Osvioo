@extends('layouts.master')
@section('content')

@php
    $user = auth_user('web')->load(['runningSubscription','runningSubscription.package']);
    $subscription = $user->runningSubscription;
    $currentPlan = $subscription && $subscription->package ? $subscription->package: null;
@endphp

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

    .pricing-page-wrapper { background-color: transparent !important; padding-bottom: 100px !important; font-family: 'Inter', sans-serif !important; overflow-x: hidden; }
    
    .duration-toggle-container { margin: 20px 0 50px !important; }
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

    .predis-btn-split { display: flex !important; width: 100% !important; margin: 30px 0 12px !important; border-radius: 12px !important; overflow: hidden !important; text-decoration: none !important; cursor: pointer; border: none; padding: 0; background: transparent; }
    .predis-btn-main { flex-grow: 1 !important; padding: 18px !important; font-weight: 900 !important; font-size: 1rem !important; text-align: center !important; transition: opacity 0.2s; }
    .predis-btn-split:hover .predis-btn-main { opacity: 0.9; }
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
    .cross-icon { color: #ef4444 !important; font-size: 1.2rem !important; margin-top: 2px !important; }
    .feature-main-text { font-weight: 800 !important; color: #1E293B !important; font-size: 1.05rem !important; display: flex !important; align-items: center; }
    .feature-sub-text { font-size: 0.9rem !important; color: var(--predis-text-muted) !important; margin-top: 4px !important; font-weight: 600 !important; padding-left: 30px; }
</style>

<div class="pricing-page-wrapper">

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
                                
                                <button type="button" @if(@$currentPlan->id == $plan->id) data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="{{translate('Current running plan')}}" data-plan="{{$plan}}" @endif data-href="{{route('user.plan.purchase', $plan->slug)}}" class="predis-btn-split text-decoration-none subscribe-plan">
                                    <div class="predis-btn-main {{ $plan->title == 'Rise' ? 'btn-main-dark' : 'btn-main-light' }}">
                                        {{ @$currentPlan->id == $plan->id ? translate("Running") : translate("Subscribe") }}
                                    </div>
                                    @if($plan->discount_price > 0 && $plan->price > 0)
                                        <div class="predis-btn-discount">{{ round((($plan->price - $plan->discount_price) / $plan->price) * 100) }}% off</div>
                                    @endif
                                </button>

                                @if(!$hasUsedTrial && @$currentPlan->id != $plan->id && $plan->price > 0)
                                    <div class="trial-caption">
                                        <a href="{{ route('user.plan.trial', $plan->slug) }}" style="color: inherit; text-decoration: underline;">
                                            {{ translate('Start 7-Day Free Trial') }}
                                        </a>
                                    </div>
                                @else
                                    <div class="trial-caption" style="opacity: 0;">-</div>
                                @endif

                                <div class="credits-total"><span class="dynamic-total-credits">{{ number_format($credits + $bonus) }}</span> Total Credits</div>
                                <div class="credits-breakdown">(<span class="dynamic-base-credits">{{ number_format($credits) }}</span> + <span class="dynamic-bonus-credits">{{ number_format($bonus) }}</span> Bonus)</div>
                                <div class="predis-bar-wrapper"><div class="predis-bar-fill" style="width: 75%;"></div></div>
                                <div class="extra-output-link">40% extra output</div>
                                
                                <div class="feature-list-box flex-grow-1">
                                    <div class="feature-row" style="margin-bottom: 5px;"><i class="bi bi-check-circle-fill tick-icon"></i><div class="feature-main-text"><span class="dynamic-feat-credits">{{ number_format($credits) }}</span> Credits/mo</div></div>
                                    <div class="feature-sub-text mb-4">Enough for <span class="dynamic-feat-images">{{ number_format(max(1, $credits / 20)) }}</span> AI Images</div>
                                    <div class="feature-row"><i class="bi bi-check-circle-fill tick-icon"></i><div class="feature-main-text"><strong>{{$profiles}}</strong> Brand</div></div>
                                    <div class="feature-row"><i class="bi bi-check-circle-fill tick-icon"></i><div class="feature-main-text">Publish to <span class="dynamic-feat-channels"><strong>{{$profiles}}</strong></span> Channels</div></div>
                                    
                                    <div class="mt-4 pt-3" style="border-top: 1px solid #F1F5F9;">
                                        @foreach (plan_configuration($plan) as $configKey => $configVal)
                                            <div class="feature-row" style="margin-bottom: 12px; align-items: center;">
                                                @if(is_bool($configVal) && !$configVal)
                                                    <i class="bi bi-x-circle-fill cross-icon"></i>
                                                @else
                                                    <i class="bi bi-check-circle-fill tick-icon"></i>
                                                @endif
                                                <div class="feature-main-text" style="font-size: 0.95rem; font-weight: 600; color: #475569;">
                                                    {{ !is_bool($configVal) ? $configVal : "" }} {{ k2t($configKey) }}
                                                </div>
                                            </div>
                                        @endforeach
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

@endsection

@section('modal')
    @include('modal.plan_subscribe')
@endsection

@push('script-push')
<script nonce="{{ csp_nonce() }}">
document.addEventListener('DOMContentLoaded', function() {
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
@endpush

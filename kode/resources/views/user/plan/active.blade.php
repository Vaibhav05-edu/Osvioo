@extends('layouts.master')
@section('content')
<div class="row g-4">
    {{-- LEFT SIDE: CURRENT PLAN INFO --}}
    <div class="col-xl-8">
        <div class="i-card h-100 p-0 overflow-hidden" style="border-radius: 20px; border: 1px solid #eef0f2;">
            @php
                $user = auth_user('web')->load(['runningSubscription','runningSubscription.package']);
                $subscription = $user->runningSubscription;
            @endphp

            <div class="p-4 @if($subscription) bg--primary @else bg-secondary @endif text-white">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <span class="badge bg-white text-dark capsuled mb-2 fw-bold text-uppercase fs-10" style="letter-spacing: 1px;">{{translate('Current Active Plan')}}</span>
                        <h1 class="mb-0 fw-bold" style="font-size: 2.5rem; letter-spacing: -1px;">{{$subscription ? $subscription->package->title : translate('No Active Plan')}}</h1>
                    </div>
                    <div class="text-end">
                        <p class="mb-0 opacity-75 fs-12">{{translate('Next Renewal')}}</p>
                        <h4 class="mb-0 fw-bold">{{$subscription && $subscription->expired_at ? get_date_time($subscription->expired_at, 'd M, Y') : '--'}}</h4>
                    </div>
                </div>
                
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);">
                            <p class="fs-12 mb-1 opacity-75">{{translate('Social Profiles')}}</p>
                            <h4 class="mb-0 fw-bold">{{$subscription ? $subscription->total_profile : 0}}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 position-relative" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                            <p class="fs-12 mb-1 opacity-75">{{translate('AI Word Limit')}}</p>
                            <div class="d-flex align-items-center gap-2">
                                <h4 class="mb-0 fw-bold">1,000 / 1,000</h4>
                                <span class="badge bg-danger text-white border-0 fs-10" style="padding: 2px 8px;">{{translate('LIMIT REACHED')}}</span>
                            </div>
                            <a href="#custom-boost" class="text-white fs-10 fw-bold text-decoration-underline mt-1 d-block">{{translate('Click here to buy more credits')}}</a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);">
                            <p class="fs-12 mb-1 opacity-75">{{translate('Monthly Posts')}}</p>
                            <h4 class="mb-0 fw-bold">{{$subscription ? ($subscription->post_balance == -1 ? 'Unlimited' : $subscription->post_balance) : 0}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white">
                <div class="row g-4">
                    {{-- PLAN FEATURES --}}
                    <div class="col-md-6">
                        <h5 class="card--title-sm mb-3 fw-bold">{{translate('What\'s included in your plan')}}</h5>
                        <ul class="list-group list-group-flush border-0">
                            <li class="list-group-item px-0 py-2 border-0 d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text--success"></i> {{translate('Multi-platform Scheduling')}}
                            </li>
                            <li class="list-group-item px-0 py-2 border-0 d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text--success"></i> {{translate('Basic Analytics Dashboard')}}
                            </li>
                            <li class="list-group-item px-0 py-2 border-0 d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text--success"></i> {{translate('Instagram Auto DM Access')}}
                            </li>
                            <li class="list-group-item px-0 py-2 border-0 d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text--success"></i> {{translate('AI Media Kit Maker')}}
                            </li>
                        </ul>
                    </div>

                    {{-- ACTIVE ADD-ONS --}}
                    <div class="col-md-6 border-start ps-md-4">
                        <h5 class="card--title-sm mb-3 fw-bold">{{translate('Active Add-ons')}}</h5>
                        <div class="d-flex flex-column gap-2">
                            <div class="p-3 border rounded-4 d-flex align-items-center justify-content-between" style="background: #f8f9fa;">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check text--primary fs-20"></i>
                                    <div>
                                        <h6 class="mb-0 fw-bold fs-14">{{translate('Priority Support')}}</h6>
                                        <p class="mb-0 text-muted fs-11">24/7 Influencer Help</p>
                                    </div>
                                </div>
                                <span class="badge bg-white text-dark border fs-10">INCLUDED</span>
                            </div>
                            <div class="text-center py-4 border border-dashed rounded-4">
                                <p class="text-muted fs-13 mb-0">{{translate('No extra add-ons purchased yet.')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT SIDE: ADD-ON MARKETPLACE --}}
    <div class="col-xl-4">
        <div class="i-card h-100 p-4" style="border-radius: 20px; background: #fff; border: 1px solid #eef0f2;">
            <h4 class="card--title mb-1 fw-bold text--primary">{{translate('Boost Your Plan')}}</h4>
            <p class="text-muted fs-13 mb-4">{{translate('Upgrade specific limits without changing your entire plan.')}}</p>

            <div class="addon-list d-flex flex-column gap-3">
                {{-- ADD-ON: +3 SOCIAL ACCOUNTS --}}
                <div class="p-3 border rounded-4 position-relative overflow-hidden" style="background: #fcfcff; border-color: #5D5AF130 !important;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-sm bg--primary-soft text--primary">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <h6 class="mb-0 fw-bold fs-15">{{translate('+3 Social Profiles')}}</h6>
                        </div>
                        <span class="fw-bold text--primary">$9.99</span>
                    </div>
                    <p class="text-muted fs-12 mb-3">{{translate('Connect 3 additional Instagram, TikTok or Twitter accounts.')}}</p>
                    <button class="i-btn btn--primary btn--sm w-100 capsuled">{{translate('Add Now')}}</button>
                </div>

                {{-- ADD-ON: +5 SOCIAL ACCOUNTS --}}
                <div class="p-3 border rounded-4" style="background: #fafafa;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-sm bg-dark text-white">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <h6 class="mb-0 fw-bold fs-15">{{translate('+5 Social Profiles')}}</h6>
                        </div>
                        <span class="fw-bold">$14.99</span>
                    </div>
                    <p class="text-muted fs-12 mb-3">{{translate('Best value for growing influencer agencies.')}}</p>
                    <button class="i-btn btn--outline btn--sm w-100 capsuled">{{translate('Add Now')}}</button>
                </div>

                {{-- ADD-ON: AI IMAGE MAKER PRO --}}
                <div class="p-3 border rounded-4" style="background: #fafafa;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-sm" style="background: #E4405F15; color: #E4405F;">
                                <i class="bi bi-brush"></i>
                            </div>
                            <h6 class="mb-0 fw-bold fs-15">{{translate('AI Image Pro')}}</h6>
                        </div>
                        <span class="fw-bold">$19.99</span>
                    </div>
                    <p class="text-muted fs-12 mb-3">{{translate('Generate high-quality visuals for your posts automatically.')}}</p>
                    <button class="i-btn btn--outline btn--sm w-100 capsuled">{{translate('Add Now')}}</button>
                </div>

                {{-- ADD-ON: EXTRA WORDS --}}
                <div class="p-3 border rounded-4" style="background: #fafafa;">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-sm" style="background: #FF950015; color: #FF9500;">
                                <i class="bi bi-card-text"></i>
                            </div>
                            <h6 class="mb-0 fw-bold fs-15">{{translate('+100K AI Words')}}</h6>
                        </div>
                        <span class="fw-bold">$7.99</span>
                    </div>
                    <p class="text-muted fs-12 mb-3">{{translate('Never run out of AI content suggestions.')}}</p>
                    <button class="i-btn btn--outline btn--sm w-100 capsuled">{{translate('Add Now')}}</button>
                </div>

                <hr class="my-4">

                {{-- CUSTOM BOOST CONFIGURATOR --}}
                <div class="p-4 border rounded-4" style="background: linear-gradient(135deg, #ffffff 0%, #f0f4ff 100%); border-style: dashed !important; border-color: #5D5AF1 !important;">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-sliders text--primary"></i>
                        {{translate('Custom Plan Boost')}}
                    </h6>
                    <p class="text-muted fs-12 mb-3">{{translate('Need something specific? Configure your own limit.')}}</p>
                    
                    <div class="mb-3">
                        <label class="form-label fs-12 fw-bold text-uppercase">{{translate('I want more...')}}</label>
                        <select class="form-select form-control capsuled fs-14">
                            <option value="profiles">{{translate('Social Profiles')}}</option>
                            <option value="words">{{translate('AI Words')}}</option>
                            <option value="images">{{translate('AI Images')}}</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-12 fw-bold text-uppercase">{{translate('How many?')}}</label>
                        <div class="input-group">
                            <input type="number" class="form-control capsuled fs-14" placeholder="Enter quantity" value="1">
                            <span class="input-group-text bg-white border-start-0" style="border-radius: 0 50px 50px 0;">+</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3 p-2 bg-white rounded-3 border">
                        <span class="fs-12 text-muted">{{translate('Estimated Price')}}</span>
                        <span class="fw-bold text--primary fs-16" id="customPrice">$0.00</span>
                    </div>

                    <button class="i-btn btn--primary btn--md w-100 capsuled shadow-sm">{{translate('Request Custom Add-on')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

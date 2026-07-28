@extends('layouts.master')
@section('content')
<div class="row g-4">
    {{-- LEFT SIDE: CURRENT PLAN INFO --}}
    <div class="col-xl-8">
        <div class="glass-card h-100 p-0 overflow-hidden">
            @php
                $user = auth_user('web')->load(['runningSubscription','runningSubscription.package']);
                $subscription = $user->runningSubscription;
            @endphp

            <div class="p-4 @if($subscription) frosted-btn @else bg-secondary @endif text-white" style="border-radius: 0; width: 100%;">
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
                            @php
                                $wordLimit = $subscription ? $subscription->word_balance : 0;
                                $wordsRemaining = $subscription ? $subscription->remaining_word_balance : 0;
                                if ($wordLimit == -1) {
                                    $wordLimitText = 'Unlimited';
                                    $wordsUsed = 0;
                                    $limitReached = false;
                                } else {
                                    $wordsUsed = max(0, $wordLimit - $wordsRemaining);
                                    $wordLimitText = number_format($wordLimit);
                                    $limitReached = $wordLimit > 0 && $wordsRemaining <= 0;
                                }
                            @endphp
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <h4 class="mb-0 fw-bold">
                                    @if($wordLimit == -1)
                                        {{translate('Unlimited')}}
                                    @else
                                        {{ number_format($wordsUsed) }} / {{ $wordLimitText }}
                                    @endif
                                </h4>
                                @if($limitReached)
                                    <span class="badge bg-danger text-white border-0 fs-10" style="padding: 2px 8px;">{{translate('LIMIT REACHED')}}</span>
                                @endif
                            </div>
                            @if($limitReached)
                                <a href="{{ route('user.addon.marketplace') }}" class="text-white fs-10 fw-bold text-decoration-underline mt-1 d-block">{{translate('Click here to buy more credits')}}</a>
                            @endif
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

            <div class="p-4">
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
                            <div class="p-3 border rounded-4 d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-shield-check text--primary fs-20"></i>
                                    <div>
                                        <h6 class="mb-0 fw-bold fs-14">{{translate('Priority Support')}}</h6>
                                        <p class="mb-0 text-muted fs-11">24/7 Influencer Help</p>
                                    </div>
                                </div>
                                <span class="badge bg--primary-soft text--primary border border-primary-subtle fs-10">INCLUDED</span>
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
        <div class="glass-card h-100 p-4">
            <h4 class="card--title mb-1 fw-bold text--primary">{{translate('Boost Your Plan')}}</h4>
            <p class="text-muted fs-13 mb-4">{{translate('Upgrade specific limits without changing your entire plan.')}}</p>

            <div class="addon-list d-flex flex-column gap-3">
                @php
                    $availableAddons = \Illuminate\Support\Facades\Schema::hasTable('addons') ? \App\Models\Addon::where('status', 1)->get() : collect();
                @endphp

                @forelse($availableAddons as $addon)
                <div class="p-3 border rounded-4 position-relative overflow-hidden bg-light-soft">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="icon-box-sm bg--primary-soft text--primary">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <h6 class="mb-0 fw-bold fs-15">{{ $addon->title }}</h6>
                        </div>
                        <span class="fw-bold text--primary">{{ num_format($addon->price, base_currency()) }}</span>
                    </div>
                    <p class="text-muted fs-12 mb-3">
                        {{translate('Type')}}: {{ ucwords(str_replace('_', ' ', $addon->type)) }} (+{{ $addon->value }})
                    </p>
                    <a href="{{ route('user.addon.marketplace') }}" class="i-btn btn--primary btn--sm w-100 capsuled">{{translate('Add Now in Marketplace')}}</a>
                </div>
                @empty
                <div class="text-center py-4 border border-dashed rounded-4">
                    <p class="text-muted fs-13 mb-0">{{translate('No add-ons available right now.')}}</p>
                </div>
                @endforelse

                <hr class="my-4">

                {{-- CUSTOM BOOST CONFIGURATOR --}}
                <div class="p-4 border rounded-4 custom-boost-card" style="border-style: dashed !important; border-color: #5D5AF1 !important;">
                    <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i class="bi bi-sliders text--primary"></i>
                        {{translate('Custom Plan Boost')}}
                    </h6>
                    <p class="text-muted fs-12 mb-3">{{translate('Need something specific? Contact our support team to create a custom add-on for you.')}}</p>
                    
                    <a href="{{ route('user.ticket.create') }}" class="i-btn btn--primary btn--md w-100 capsuled shadow-sm">{{translate('Contact Support')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

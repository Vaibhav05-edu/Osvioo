@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-9">
        <div class="i-card h-100 p-0 overflow-hidden" style="border-radius: 24px;">
            <div class="p-5 text-center bg--primary-soft" style="border-bottom: 2px dashed #eef0f2;">
                <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: #fff; border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                    <i class="bi bi-calendar-check text--primary fs-40"></i>
                </div>
                <h3 class="fw-bold mb-1">{{translate('Upcoming Billing Details')}}</h3>
                <p class="text-muted">{{translate('Scheduled for next billing cycle')}}</p>
                
                @if($subscription && $subscription->status == \App\Enums\SubscriptionStatus::value('RUNNING', true))
                    <div class="badge bg--info-soft text--info capsuled px-3 py-2 mt-2">
                        <i class="bi bi-arrow-repeat"></i> {{translate('Recurring Payment Active')}}
                    </div>
                @elseif($subscription && $subscription->status == \App\Enums\SubscriptionStatus::value('INACTIVE', true))
                    <div class="badge bg--warning-soft text--warning capsuled px-3 py-2 mt-2">
                        <i class="bi bi-pause-circle"></i> {{translate('Subscription Paused')}}
                    </div>
                @else
                    <div class="badge bg--danger-soft text--danger capsuled px-3 py-2 mt-2">
                        <i class="bi bi-exclamation-triangle"></i> {{translate('No Active Subscription')}}
                    </div>
                @endif
            </div>

            <div class="p-5">
                @if($subscription && $package)
                    @php
                        $price = round($package->discount_price) > 0 ? $package->discount_price : $package->price;
                        $formattedPrice = num_format($price);
                        $currency = site_settings('site_currency_symbol', '$');
                        $nextBillingDate = $subscription->expired_at ? \Carbon\Carbon::parse($subscription->expired_at)->format('d M, Y') : translate('N/A');
                    @endphp

                    <div class="billing-details mb-5">
                        <h5 class="card--title-sm mb-4 border-bottom pb-2">{{translate('Breakdown')}}</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-sm bg--light circle"><i class="bi bi-box"></i></div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $package->title }}</h6>
                                    <p class="mb-0 text-muted fs-12">{{ translate('Subscription Plan') }}</p>
                                </div>
                            </div>
                            <span class="fw-bold fs-16">{{ $currency }}{{ $formattedPrice }}</span>
                        </div>

                        <div class="mt-4 p-4 rounded-4 bg--light">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 fw-bold text-uppercase fs-14">{{translate('Total Due on')}} {{ $nextBillingDate }}</h5>
                                <h4 class="mb-0 fw-bold text--primary">{{ $currency }}{{ $formattedPrice }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="payment-method-card p-4 border rounded-4 mb-5">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0 fw-bold">{{translate('Payment Method')}}</h6>
                            <a href="{{route('user.profile')}}" class="text--primary fs-14 fw-bold">{{translate('Update Wallet / Profile')}}</a>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 50px; height: 32px; background: #4f46e5; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; font-weight: bold;">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">{{translate('Account Balance / Gateway Payment')}}</p>
                                <p class="mb-0 text-muted fs-12">{{translate('Available Balance')}}: {{ $currency }}{{ num_format(auth_user('web')->balance) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <form action="{{ route('user.plan.pay_early') }}" method="POST" class="w-100" onsubmit="return confirm('{{ translate('Are you sure you want to recharge and start your next billing cycle immediately?') }}');">
                            @csrf
                            <button type="submit" class="i-btn btn--primary btn--lg w-100 capsuled">{{translate('Pay Early')}}</button>
                        </form>

                        <form action="{{ route('user.plan.pause_subscription') }}" method="POST" class="w-100">
                            @csrf
                            @if($subscription->status == \App\Enums\SubscriptionStatus::value('RUNNING', true))
                                <button type="submit" class="i-btn btn--light btn--lg w-100 capsuled">{{translate('Pause Subscription')}}</button>
                            @else
                                <button type="submit" class="i-btn btn--success btn--lg w-100 capsuled">{{translate('Resume Subscription')}}</button>
                            @endif
                        </form>
                    </div>
                    <p class="text-center mt-4 text-muted fs-12">
                        {{translate('By clicking Pay Early, your next subscription cycle will start immediately.')}}
                    </p>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-exclamation-circle text-muted fs-40 mb-3 d-block"></i>
                        <h5>{{ translate('No Active Subscription Found') }}</h5>
                        <p class="text-muted mb-4">{{ translate('You currently do not have any active subscription plan to manage billing for.') }}</p>
                        <a href="{{ route('home') }}#pricing" class="i-btn btn--primary btn--md capsuled">
                            {{ translate('Explore Subscription Plans') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@php use Illuminate\Support\Arr; @endphp
@extends('layouts.master')
@push('style-include')
    <link nonce="{{ csp_nonce() }}" href="{{asset('assets/global/css/datepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')

@php

        $user             = auth_user('web')->load(['runningSubscription','runningSubscription.package']);
        $subscription     = $user->runningSubscription;
        $remainingToken   = $subscription ? $subscription->remaining_word_balance : 0;
        $remainingProfile = $subscription ? $subscription->total_profile : 0;
        $remainingPost    = $subscription ? $subscription->remaining_post_balance : 0;
        $accessPlatforms         = (array) ($subscription ? @$subscription->package->social_access->platform_access : []);
        $platforms = get_platform()
                        ->whereIn('id', $accessPlatforms )
                        ->where("status",App\Enums\StatusEnum::true->status())
                        ->where("is_integrated",App\Enums\StatusEnum::true->status());

        $subscriptionDetails = collect([
            'remaining_word'    => $remainingToken,
            'remaining_profile' => $remainingProfile,
            'remaining_post'    => $remainingPost,
            'total_patforms'   => count($accessPlatforms)])->mapWithKeys(fn($value,$key) :array =>  [k2t($key) => $value])->toArray();
        if( $remainingToken == App\Enums\PlanDuration::value('UNLIMITED')) unset($subscriptionDetails['remaining_word']);
        if( $remainingPost == App\Enums\PlanDuration::value('UNLIMITED')) unset($subscriptionDetails['remaining_profile']);
@endphp




<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="row g-4">
            <div class="col-xl-6">
                <div class="i-card h-550">
                    <h4 class="card--title mb-4">
                         {{translate('Connected Social Accounts')}}
                    </h4>
                    <div class="row g-3">
                       @forelse(Arr::get($data['account_report'] ,'accounts_by_platform',[]) as $platform)
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="i-card no-border p-0 border position-relative bg--light">
                                    <div class="shape-one">
                                        <svg width="65" height="65" viewBox="0 0 65 65" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M52.3006 64.8958L64.4805 64.9922L64.9908 0.510364L0.508992 1.7845e-05L0.412593 12.1799L35.5193 12.4578C45.016 12.533 52.6536 20.2924 52.5784 29.789L52.3006 64.8958Z"
                                                fill="none" />
                                        </svg>
                                    </div>
                                    <div class="shape-two">
                                        <svg width="65" height="65" viewBox="0 0 65 65" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M52.3006 64.8958L64.4805 64.9922L64.9908 0.510364L0.508992 1.7845e-05L0.412593 12.1799L35.5193 12.4578C45.016 12.533 52.6536 20.2924 52.5784 29.789L52.3006 64.8958Z"
                                                fill="none" />
                                        </svg>
                                    </div>
                                    @php
                                        $platformIcons = [
                                            'facebook'  => ['icon' => 'bi-facebook', 'color' => '#1877F2'],
                                            'instagram' => ['icon' => 'bi-instagram', 'color' => '#E4405F'],
                                            'twitter'   => ['icon' => 'bi-twitter-x', 'color' => '#000000'],
                                            'linkedin'  => ['icon' => 'bi-linkedin', 'color' => '#0A66C2'],
                                            'tiktok'    => ['icon' => 'bi-tiktok', 'color' => '#000000'],
                                            'youtube'   => ['icon' => 'bi-youtube', 'color' => '#FF0000'],
                                            'pinterest' => ['icon' => 'bi-pinterest', 'color' => '#BD081C'],
                                            'reddit'    => ['icon' => 'bi-reddit', 'color' => '#FF4500'],
                                        ];
                                        $pSlug = strtolower($platform->slug);
                                        $pInfo = $platformIcons[$pSlug] ?? ['icon' => 'bi-share', 'color' => '#5D5AF1'];
                                    @endphp
                                    <span class="icon-image d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: {{ $pInfo['color'] }}15; border-radius: 12px;">
                                        <i class="bi {{ $pInfo['icon'] }}" style="font-size: 24px; color: {{ $pInfo['color'] }};"></i>
                                    </span>
                                    <div class="p-3">
                                        <h5 class="card--title-sm">
                                            {{$platform->name}}
                                        </h5>
                                    </div>
                                    <div class="p-3 border-top">
                                        <p class="card--title-sm mb-1">
                                            {{$platform->accounts_count}}
                                        </p>
                                        <p class="mb-3 fs-14">
                                              {{translate('Total Posts')}}
                                        </p>
                                        <a href="{{route('user.social.account.create',['platform' => $platform->slug])}}" class="i-btn btn--sm btn--outline capsuled w-100">
                                             <i class="bi bi-plus-lg"></i>
                                              {{translate('Create Account')}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty

                             <div class="col-12">
                                  @include('admin.partials.not_found')
                             </div>

                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="i-card h-100 p-0 overflow-hidden" style="border-radius: 16px; border: 1px solid #eef0f2;">
                    <div class="p-4 bg--primary-soft" style="border-bottom: 1px solid #eef0f2;">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="icon-box" style="width: 40px; height: 40px; background: #fff; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                    <i class="bi bi-gem text--primary fs-20"></i>
                                </div>
                                <div>
                                    <h5 class="mb-0" style="font-weight: 700;">{{$subscription ? $subscription->package->title : 'No Active Plan'}}</h5>
                                    <p class="text-muted fs-12 mb-0">{{translate('Current Subscription')}}</p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="text-muted fs-12 mb-0">{{translate('Next Billing Date')}}</p>
                                <h6 class="mb-0" style="font-weight: 700;">
                                    {{$subscription && $subscription->expired_at ? get_date_time($subscription->expired_at, 'd M, Y') : '--'}}
                                </h6>
                            </div>
                        </div>

                        <div class="progress mb-3" style="height: 8px; background: #fff; border-radius: 10px;">
                            @php
                                $percent = 0;
                                if($subscription && $subscription->package->social_access) {
                                    $total = $subscription->total_profile;
                                    $used = $subscription->total_profile - $remainingProfile;
                                    $percent = $total > 0 ? ($used / $total) * 100 : 0;
                                }
                            @endphp
                            <div class="progress-bar" role="progressbar" style="width: {{$percent}}%; background: #5D5AF1; border-radius: 10px;" aria-valuenow="{{$percent}}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between fs-12 text-muted">
                            <span>{{$remainingProfile}} {{translate('Profiles remaining')}}</span>
                            <span>{{translate('Plan usage')}}: {{round($percent)}}%</span>
                        </div>
                    </div>

                    <div class="p-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <a href="{{route('user.plan')}}" class="i-btn btn--primary w-100 d-flex align-items-center justify-content-center gap-2" style="padding: 10px; border-radius: 12px;">
                                    <i class="bi bi-arrow-up-circle"></i>
                                    {{translate('Upgrade Plan')}}
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{route('user.plan')}}" class="i-btn btn--outline w-100 d-flex align-items-center justify-content-center gap-2" style="padding: 10px; border-radius: 12px; border-color: #eef0f2; color: #444;">
                                    <i class="bi bi-plus-square"></i>
                                    {{translate('Add-ons')}}
                                </a>
                            </div>
                            <div class="col-12">
                                <a href="{{route('user.transaction.report.list')}}" class="d-flex align-items-center justify-content-between p-3 border" style="border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width: 32px; height: 32px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-receipt text-muted"></i>
                                        </div>
                                        <span class="text-dark fw-bold fs-14">{{translate('Billing History & Invoices')}}</span>
                                    </div>
                                    <i class="bi bi-chevron-right text-muted fs-12"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="i-card h-100">
                    <div class="row align-items-center g-2 mb-4">
                        <div class="col-md-9">
                            <h4 class="card--title">
                               {{translate('Main Performance')}}
                            </h4>
                        </div>
                    </div>
                    <div class="row g-4">
                        {{-- TOTAL ACCOUNTS --}}
                        <div class="col-xl-4 col-md-6">
                            <div class="i-card border shadow-sm p-0 overflow-hidden" style="border-radius: 16px; background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);">
                                <div class="p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box" style="width: 48px; height: 48px; background: #5D5AF115; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-people-fill fs-24 text--primary"></i>
                                        </div>
                                        <span class="badge bg--success-soft text--success capsuled">+4 this week</span>
                                    </div>
                                    <h2 class="mb-1" style="font-weight: 800; font-family: 'Outfit', sans-serif;">{{Arr::get($data['account_report'],'total_account',0)}}</h2>
                                    <p class="text-muted mb-0" style="font-size: 14px; font-weight: 500;">{{translate('Total Accounts Connected')}}</p>
                                </div>
                                <div class="footer px-4 py-2 border-top bg--light d-flex justify-content-between">
                                     <a class="text--primary fw-bold fs-13" href="{{route('user.social.account.list')}}">{{translate('View All')}}</a>
                                     <i class="bi bi-chevron-right fs-12"></i>
                                </div>
                            </div>
                        </div>

                        {{-- TOTAL POSTS --}}
                        <div class="col-xl-4 col-md-6">
                            <div class="i-card border shadow-sm p-0 overflow-hidden" style="border-radius: 16px; background: linear-gradient(135deg, #fffcf5 0%, #ffffff 100%);">
                                <div class="p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box" style="width: 48px; height: 48px; background: #FF950015; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-send-check-fill fs-24" style="color: #FF9500;"></i>
                                        </div>
                                        <span class="badge bg--info-soft text--info capsuled">{{Arr::get($data,'schedule_post',0)}} Scheduled</span>
                                    </div>
                                    <h2 class="mb-1" style="font-weight: 800; font-family: 'Outfit', sans-serif;">{{Arr::get($data,'total_post',0)}}</h2>
                                    <p class="text-muted mb-0" style="font-size: 14px; font-weight: 500;">{{translate('Total Posts Published')}}</p>
                                </div>
                                <div class="footer px-4 py-2 border-top bg--light d-flex justify-content-between">
                                     <a class="text--primary fw-bold fs-13" href="{{route('user.social.post.list')}}">{{translate('Post History')}}</a>
                                     <i class="bi bi-chevron-right fs-12"></i>
                                </div>
                            </div>
                        </div>

                        {{-- TOTAL MEDIA KITS --}}
                        <div class="col-xl-4 col-md-6">
                            <div class="i-card border shadow-sm p-0 overflow-hidden" style="border-radius: 16px; background: linear-gradient(135deg, #f5fff8 0%, #ffffff 100%);">
                                <div class="p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="icon-box" style="width: 48px; height: 48px; background: #22c55e15; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-person-badge-fill fs-24 text--success"></i>
                                        </div>
                                        <span class="badge bg--success-soft text--success capsuled">AI Optimized</span>
                                    </div>
                                    <h2 class="mb-1" style="font-weight: 800; font-family: 'Outfit', sans-serif;">12</h2>
                                    <p class="text-muted mb-0" style="font-size: 14px; font-weight: 500;">{{translate('Total Media Kits')}}</p>
                                </div>
                                <div class="footer px-4 py-2 border-top bg--light d-flex justify-content-between">
                                     <a class="text--primary fw-bold fs-13" href="#">{{translate('Manage Kits')}}</a>
                                     <i class="bi bi-chevron-right fs-12"></i>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- INSIGHTS SECTION --}}
    <div class="col-12 mt-2">
        <div class="row g-4">
                    {{-- INSTAGRAM INSIGHTS --}}
                    <div class="col-xl-6">
                        <div class="i-card h-100 p-4 shadow-sm" style="border-radius: 24px; border: 1px solid #eef0f2; background: #fff; transition: all 0.3s ease;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box" style="background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); color: white; width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(228, 64, 95, 0.3);">
                                        <i class="bi bi-instagram fs-20"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold fs-18 text-dark">{{translate('Instagram Insights')}}</h5>
                                        <p class="text-muted fs-11 mb-0">{{translate('Real-time performance')}}</p>
                                    </div>
                                </div>
                                <span class="badge bg-danger text-white fs-10 capsuled px-3 py-1" style="letter-spacing: 1px;">● LIVE</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="p-4 border-0 rounded-4 text-center" style="background: #f8f9fa;">
                                        <p class="text-muted fs-12 mb-2 text-uppercase fw-bold" style="letter-spacing: 0.5px;">{{translate('Followers')}}</p>
                                        <h2 class="mb-0 fw-bold" style="font-size: 32px; color: #1a1a1a;">12.5K</h2>
                                        <div class="mt-2">
                                            <span class="badge bg--success-soft text--success fs-12 fw-bold"><i class="bi bi-arrow-up-short"></i> 12.4%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-4 border-0 rounded-4 text-center" style="background: #f8f9fa;">
                                        <p class="text-muted fs-12 mb-2 text-uppercase fw-bold" style="letter-spacing: 0.5px;">{{translate('Engagement')}}</p>
                                        <h2 class="mb-0 fw-bold" style="font-size: 32px; color: #1a1a1a;">4.82%</h2>
                                        <div class="mt-2">
                                            <span class="badge bg--success-soft text--success fs-12 fw-bold"><i class="bi bi-arrow-up-short"></i> 5.2%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fs-12 fw-bold mb-3 text-muted text-uppercase d-flex align-items-center gap-2">
                                <i class="bi bi-lightning-fill text-warning"></i>
                                {{translate('Top Keywords')}}
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-white text-dark border-0 shadow-sm capsuled px-3 py-2 fs-12">#vlog</span>
                                <span class="badge bg-white text-dark border-0 shadow-sm capsuled px-3 py-2 fs-12">#lifestyle</span>
                                <span class="badge bg-white text-dark border-0 shadow-sm capsuled px-3 py-2 fs-12">#influencerOS</span>
                            </div>
                        </div>
                    </div>

                    {{-- AI PROFILE ANALYSIS --}}
                    <div class="col-xl-6">
                        <div class="i-card h-100 p-4 shadow-sm overflow-hidden position-relative" style="border-radius: 24px; border: 1px solid rgba(93, 90, 241, 0.2); background: linear-gradient(145deg, #ffffff 0%, #f8faff 100%); transition: all 0.3s ease;">
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-box bg--primary text-white" style="width: 45px; height: 45px; border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(93, 90, 241, 0.3);">
                                        <i class="bi bi-robot fs-20"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 fw-bold fs-18 text-dark">{{translate('AI Creator Analysis')}}</h5>
                                        <p class="text-muted fs-11 mb-0">{{translate('Deep learning insights')}}</p>
                                    </div>
                                </div>
                                <span class="badge bg--primary text-white capsuled fs-10 px-3 py-1 shadow-sm">{{translate('PREMIUM AI')}}</span>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-5">
                                    <div class="p-3 border-0 rounded-4 bg-white shadow-sm h-100 d-flex flex-column align-items-center justify-content-center">
                                        <p class="text-muted fs-11 mb-2 text-uppercase fw-bold text-center">{{translate('Profile Health')}}</p>
                                        <div class="position-relative d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <svg viewBox="0 0 36 36" style="width: 100%; height: 100%; transform: rotate(-90deg);">
                                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#eee" stroke-width="3" />
                                                <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#5D5AF1" stroke-width="3" stroke-dasharray="85, 100" stroke-linecap="round" />
                                            </svg>
                                            <div class="position-absolute fs-18 fw-bold" style="color: #5D5AF1;">85%</div>
                                        </div>
                                        <span class="text--success fs-11 fw-bold mt-2">{{translate('Strong Growth')}}</span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="p-3 border-0 rounded-4 text-white shadow-lg h-100 d-flex flex-column justify-content-center" style="background: linear-gradient(135deg, #5D5AF1 0%, #3f3cbd 100%);">
                                        <p class="opacity-75 fs-11 mb-2 text-uppercase fw-bold">{{translate('Suggested Rate')}}</p>
                                        <div class="mb-1">
                                            <h3 class="mb-0 fw-bold" style="font-size: 26px;">$250 - $400</h3>
                                            <h5 class="mb-0 opacity-90 fw-bold" style="font-size: 18px;">₹20,500 - ₹33,000</h5>
                                        </div>
                                        <p class="mb-0 fs-10 opacity-75 mt-2">* {{translate('Based on current reach')}}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-3 rounded-4" style="background: rgba(93, 90, 241, 0.05); border: 1px dashed rgba(93, 90, 241, 0.3);">
                                <h6 class="fs-12 fw-bold mb-2 text-dark d-flex align-items-center gap-2">
                                    <i class="bi bi-stars text-warning"></i>
                                    {{translate('Next Strategy')}}
                                </h6>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="icon-sm bg-white shadow-sm rounded-circle text--primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;"><i class="bi bi-camera-reels fs-14"></i></div>
                                    <p class="mb-0 fs-12 text-dark fw-bold">{{translate('Post a "BTS" Reel today at 7:30 PM')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AI OPTIMIZATION ROADMAP --}}
            <div class="col-12 mt-4 mb-2">
                <div class="i-card p-4 shadow-sm border-0 position-relative overflow-hidden" style="border-radius: 24px; background: #fff;">
                    <div class="position-absolute top-0 end-0 p-4 opacity-10">
                        <i class="bi bi-rocket-takeoff" style="font-size: 80px; color: #5D5AF1;"></i>
                    </div>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="icon-box bg--success-soft text--success" style="width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-check2-circle fs-20"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold fs-18 text-dark">{{translate('AI Profile Optimization Roadmap')}}</h5>
                            <p class="text-muted fs-12 mb-0">{{translate('Actionable tasks to skyrocket your reach')}}</p>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-xl-4">
                            <div class="p-3 rounded-4 h-100 d-flex flex-column" style="background: rgba(220, 53, 69, 0.03); border: 1px solid rgba(220, 53, 69, 0.1);">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-danger text-white capsuled fs-10 px-3 py-1">{{translate('High Priority')}}</span>
                                    <i class="bi bi-exclamation-triangle text-danger"></i>
                                </div>
                                <h6 class="fw-bold mb-2 fs-14">{{translate('Optimize Bio Keywords')}}</h6>
                                <p class="text-muted fs-12 mb-3">{{translate('Your bio lacks niche keywords. Add "Influencer" and "Lifestyle" to improve visibility.')}}</p>
                                <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-danger-subtle">
                                    <span class="text-danger fw-bold fs-11"><i class="bi bi-clock-history me-1"></i> {{translate('Fix Today')}}</span>
                                    <a href="#" class="btn btn-sm text-danger fw-bold fs-11 p-0">{{translate('Fix Now')}} <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="p-3 rounded-4 h-100 d-flex flex-column" style="background: rgba(93, 90, 241, 0.03); border: 1px solid rgba(93, 90, 241, 0.1);">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg--primary text-white capsuled fs-10 px-3 py-1">{{translate('Medium Priority')}}</span>
                                    <i class="bi bi-chat-dots text--primary"></i>
                                </div>
                                <h6 class="fw-bold mb-2 fs-14">{{translate('Engagement Window')}}</h6>
                                <p class="text-muted fs-12 mb-3">{{translate('Reply to top 5 comments within 60 mins of posting for a 15% reach boost.')}}</p>
                                <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-primary-subtle">
                                    <span class="text--primary fw-bold fs-11"><i class="bi bi-graph-up-arrow me-1"></i> {{translate('+15% Potential')}}</span>
                                    <a href="#" class="btn btn-sm text--primary fw-bold fs-11 p-0">{{translate('View Guide')}} <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="p-3 rounded-4 h-100 d-flex flex-column" style="background: rgba(25, 135, 84, 0.03); border: 1px solid rgba(25, 135, 84, 0.1);">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <span class="badge bg-success text-white capsuled fs-10 px-3 py-1">{{translate('Growth Hack')}}</span>
                                    <i class="bi bi-palette text-success"></i>
                                </div>
                                <h6 class="fw-bold mb-2 fs-14">{{translate('Consistent Branding')}}</h6>
                                <p class="text-muted fs-12 mb-3">{{translate('Use a consistent font style for your Reel thumbnails to build better brand recognition.')}}</p>
                                <div class="d-flex align-items-center justify-content-between mt-auto pt-2 border-top border-success-subtle">
                                    <span class="text-success fw-bold fs-11"><i class="bi bi-check-circle-fill me-1"></i> {{translate('Branding')}}</span>
                                    <a href="#" class="btn btn-sm text-success fw-bold fs-11 p-0">{{translate('See Examples')}} <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="i-card-md card-height-100">
                    <div class="card-header">
                        <h4 class="card--title">
                            {{translate("Latest Transaction Log")}}
                        </h4>
                    </div>

                    <div class="card-body px-0">
                        <div class="table-accordion">
                            @php
                            $reports = Arr::get($data,'latest_transactiions',null);
                            @endphp
                            @if($reports && $reports->count() > 0)
                            <div class="accordion" id="wordReports">
                                @forelse(Arr::get($data,'latest_transactiions',[]) as $report)
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$report->id}}" aria-expanded="false"
                                            aria-controls="collapse{{$report->id}}">
                                            <div class="row align-items-center w-100 gy-4 gx-sm-3 gx-0">
                                                <div class="col-lg-3 col-sm-4 col-12">
                                                    <div class="table-accordion-header transfer-by">
                                                        <span class="icon-btn icon-btn-sm primary circle">
                                                            <i class="bi bi-file-text"></i>
                                                        </span>
                                                        <div>
                                                            <h6>
                                                                {{translate("Trx Code")}}
                                                            </h6>
                                                            <p> {{$report->trx_code}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3 col-sm-4 col-6 text-lg-center text-sm-center text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Date")}}
                                                        </h6>
                                                        <p>
                                                            {{ get_date_time($report->created_at) }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-end text-end">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Balance")}}
                                                        </h6>

                                                        <p
                                                            class='text--{{$report->trx_type == App\Models\Transaction::$PLUS ? "success" :"danger" }}'>
                                                            <i class='bi bi-{{$report->trx_type == App\Models\Transaction::$PLUS ? "plus" :"dash" }}'></i>
                                                            {{num_format($report->amount,$report->currency)}}
                                                        </p>

                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>{{translate("Post Balance")}}</h6>
                                                        <p>
                                                            {{@num_format(
                                                                number : $report->post_balance??0,
                                                                calC   : true
                                                            )}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-end text-md-center text-end">
                                                    <div class="table-accordion-header">
                                                        <h6>{{translate("Remark")}}</h6>
                                                        <p>
                                                            {{k2t($report->remarks)}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapse{{$report->id}}" class="accordion-collapse collapse"
                                        data-bs-parent="#wordReports">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">
                                                    <h6 class="title">
                                                        {{translate("Report Information")}}
                                                    </h6>
                                                    <p class="value">
                                                        {{$report->details}}
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            @else
                                @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
                            @endif

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="i-card-md card-height-100">
                    <div class="card-header">
                        <h4 class="card--title">
                            {{translate("Latest Subscription Log")}}
                        </h4>

                    </div>

                    <div class="card-body px-0">
                        <div class="table-accordion">
                            @php
                            $reports = Arr::get($data,'subscription_log',null);
                            @endphp

                            @if($reports && $reports->count() > 0)
                            <div class="accordion" id="wordReports-2">
                                @forelse($reports as $report)
                                <div class="accordion-item">
                                    <div class="accordion-header">
                                        <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{$report->id}}" aria-expanded="false"
                                            aria-controls="collapse{{$report->id}}">
                                            <div class="row align-items-center w-100 gy-4 gx-sm-3 gx-0">
                                                <div class="col-lg-2 col-sm-4 col-12">
                                                    <div class="table-accordion-header transfer-by">
                                                        <span class="icon-btn icon-btn-sm primary circle">
                                                            <i class="bi bi-file-text"></i>
                                                        </span>
                                                        <div>
                                                            <h6>
                                                                {{translate("TRX Code")}}
                                                            </h6>
                                                            <p> {{$report->trx_code}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-center text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Expired In")}}
                                                        </h6>
                                                        <p>
                                                            @if($report->expired_at)
                                                            {{ get_date_time($report->expired_at,'d M, Y') }}
                                                            @else
                                                            --
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-sm-end text-end">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Package")}}
                                                        </h6>
                                                        <p>
                                                            {{@$report->package->title}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-lg-center text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>
                                                            {{translate("Status")}}
                                                        </h6>
                                                        @php echo (subscription_status($report->status)) @endphp
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-sm-center text-end">
                                                    <div class="table-accordion-header">
                                                        <h6>{{translate("Payment Amount")}}</h6>
                                                        <p>
                                                            {{@num_format(
                                                        number : $report->payment_amount??0,
                                                        calC   : true
                                                    )}}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2 col-sm-4 col-6 text-sm-end text-start">
                                                    <div class="table-accordion-header">
                                                        <h6>{{translate("Date")}}</h6>
                                                        <p>
                                                            @if($report->created_at)
                                                            {{ get_date_time($report->created_at) }}
                                                            @else
                                                            --
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapse{{$report->id}}" class="accordion-collapse collapse"
                                        data-bs-parent="#wordReports-2">
                                        <div class="accordion-body">
                                            <ul class="list-group list-group-flush">
                                                @php
                                                $informations = [
                                                    "AI_word_balance"          => $report->word_balance,
                                                    "remaining_word_balance"   => $report->remaining_word_balance,
                                                    "carried_word_balance"     => $report->carried_word_balance,
                                                    "total_social_profile"     => $report->total_profile,
                                                    "carried_profile_balance"  => $report->carried_profile,
                                                    "social_post_balance"      => $report->post_balance,
                                                    "remaining_post_balance"   => $report->remaining_post_balance,
                                                    "carried_post_balance"     => $report->carried_post_balance,
                                                ];
                                                @endphp

                                                @foreach ($informations as $key => $val)
                                                    <li class="list-group-item">
                                                        <h6 class="title">
                                                            {{k2t($key)}}
                                                        </h6>
                                                        <p class="value">
                                                            {{$val == App\Enums\PlanDuration::UNLIMITED->value ? App\Enums\PlanDuration::UNLIMITED->name : $val }}
                                                        </p>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                            </div>
                            @else
                            @include('admin.partials.not_found',['custom_message' => "No Reports found!!"])
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script-include')
    <script src="{{asset('assets/global/js/apexcharts.js')}}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{asset('assets/global/js/datepicker/moment.min.js')}}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{asset('assets/global/js/datepicker/daterangepicker.min.js')}}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{asset('assets/global/js/datepicker/init.js')}}"></script>
@endpush

@push('script-push')

<script nonce="{{ csp_nonce() }}">
  "use strict";

    // Get current theme and direction
    function getCurrentTheme() {
        return document.documentElement.getAttribute('data-bs-theme') || 'light';
    }

    function getCurrentDirection() {
        return document.documentElement.getAttribute('dir') || 'ltr';
    }

    function isRTL() {
        return getCurrentDirection() === 'rtl';
    }

    function isDarkMode() {
        return getCurrentTheme() === 'dark';
    }

    // Get theme-aware colors
    function getThemeColors() {
        const isDark = isDarkMode();
        
        if (isDark) {
            return [
                "var(--bs-primary)",
                "var(--bs-secondary)", 
                "var(--bs-warning)",
                "var(--bs-info)",
                "var(--bs-danger)"
            ];
        } else {
            return [
                "var(--color-primary)",
                "var(--color-secondary)",
                "var(--color-warning)",
                "var(--color-info)",
                "var(--color-danger)"
            ];
        }
    }

    // Get text color based on theme
    function getTextColor() {
        return isDarkMode() ? '#ffffff' : '#373d3f';
    }

    // Get grid color based on theme
    function getGridColor() {
        return isDarkMode() ? '#404040' : '#f1f1f1';
    }


    var subscriptionValues = @json(array_values($subscriptionDetails));
    var subscriptionLabel = @json(array_keys($subscriptionDetails));

    var options = {
        series: subscriptionValues,
        chart: {
            type: "donut",
            width: "100%",
            nonce:"{{ csp_nonce() }}",
        },
        colors: getThemeColors(),
        labels: subscriptionLabel,
        plotOptions: {
             pie: {
                startAngle: isRTL() ? 270 : -90,
                endAngle: isRTL() ? -90 : 270
            }
        },
        dataLabels: {
            enabled: false
        },

        legend: {
             fontSize: '12px',
             position: 'bottom',
            labels: {
                colors: getTextColor()
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#subscriptionChart"), options);
    chart.render();


    var monthlyLabel = @json(array_keys($data['monthly_post_graph']));
    var accountValues = [];
    var totalPost     = @json(array_values($data['monthly_post_graph']));
    var pendigPost    = @json(array_values($data['monthly_pending_post']));
    var schedulePost  = @json(array_values($data['monthly_schedule_post']));
    var successPost   = @json(array_values($data['monthly_success_post']));
    var failedPost    = @json(array_values($data['monthly_failed_post']));

    var monthlyLabel = @json(array_keys($data['monthly_post_graph']));

    var options = {
        chart: {
            height: 410,
            type: "line",
            nonce:"{{ csp_nonce() }}",
            toolbar: {
                       show: false
                    }
        },
        dataLabels: {
            enabled: false,
        },
        colors: getThemeColors(),
        series: [{
                name: "{{ translate('Total Post') }}",
                data: totalPost,
            },
            {
                name: "{{ translate('Pending Post') }}",
                data: pendigPost,
            },
            {
                name: "{{ translate('Success Post') }}",
                data: successPost,
            },
            {
                name: "{{ translate('Schedule Post') }}",
                data: schedulePost,
            },
            {
                name: "{{ translate('Failed Post') }}",
                data: failedPost,
            },
        ],
        xaxis: {
            categories: monthlyLabel,
            labels: {
                style: {
                    colors: getTextColor(),
                    fontSize: '12px'
                }
            },
            axisBorder: {
                color: getGridColor()
            },
            axisTicks: {
                color: getGridColor()
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: getTextColor(),
                    fontSize: '12px'
                }
            }
        },
        grid: {
            borderColor: getGridColor(),
            strokeDashArray: 3
        },

        tooltip: {
            shared: false,
            intersect: true,
            theme: getCurrentTheme(),
            y: {
                formatter: function(value, {
                    series,
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    return parseInt(value);
                }
            }

        },
        markers: {
            size: 6,
        },
        stroke: {
            width: [4, 4],
            curve: 'smooth'
        },
        legend: {
            horizontalAlign: "center",
            offsetY: 5,
            labels: {
                colors: getTextColor()
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#postReport"), options);
    chart.render();

    var swiper = new Swiper(".latest-post-slider", {
        pagination: {
            el: ".latest-post-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        rtl: isRTL(),
        observer: true,
        observeParents: true,
    });

    $(".select2").select2({
         dir: getCurrentDirection(),
        theme: isDarkMode() ? 'default' : 'default', // You might want to add custom dark theme
        // Additional Select2 options for better RTL support
        language: {
            dir: getCurrentDirection()
        }
    });
</script>
@endpush

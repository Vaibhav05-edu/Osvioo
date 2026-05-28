@extends('layouts.master')
@section('content')
@php $user = auth_user('web'); @endphp

<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">

        @if(isset($rejected) && $rejected)
        <div class="alert d-flex align-items-center gap-3 mb-4" style="background: linear-gradient(135deg, #fff1f0, #fff); border: 1px solid #fca5a5; border-radius: 16px; padding: 18px 24px;">
            <i class="bi bi-x-circle-fill fs-4" style="color: #ef4444;"></i>
            <div>
                <strong style="color: #ef4444;">{{translate('Application Rejected')}}</strong>
                <p class="mb-0 text-muted" style="font-size: 0.88rem;">{{translate('Your previous application was rejected. You may re-apply below with updated information.')}}</p>
            </div>
        </div>
        @endif

        {{-- HERO BANNER --}}
        <div class="text-center mb-5" style="padding: 48px 24px; background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%); border-radius: 24px; color: white; position: relative; overflow: hidden;">
            <div style="position: absolute; top: -40px; right: -40px; width: 200px; height: 200px; background: rgba(255,255,255,0.06); border-radius: 50%;"></div>
            <div style="position: absolute; bottom: -60px; left: -30px; width: 250px; height: 250px; background: rgba(255,255,255,0.04); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 1;">
                <div class="mb-3" style="display: inline-flex; align-items: center; justify-content: center; width: 72px; height: 72px; background: rgba(255,255,255,0.2); border-radius: 20px; backdrop-filter: blur(10px);">
                    <i class="bi bi-people-fill fs-2"></i>
                </div>
                <h2 class="mb-2" style="font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 2rem;">{{translate('Join Our Affiliate Program')}}</h2>
                <p class="mb-0" style="font-size: 1rem; opacity: 0.88;">{{translate('Earn commissions by referring new users to our platform. Get rewarded every time someone signs up through your link.')}}</p>
            </div>
        </div>

        {{-- BENEFITS ROW --}}
        <div class="row g-3 mb-5">
            <div class="col-md-4">
                <div class="text-center p-4" style="background: #f8f9ff; border-radius: 16px; border: 1px solid #e8e9ff;">
                    <div class="mb-2" style="font-size: 2rem;">💰</div>
                    <h6 class="fw-bold mb-1">{{translate('Earn Commissions')}}</h6>
                    <p class="text-muted mb-0" style="font-size: 0.83rem;">{{translate('Get rewarded for every successful referral you bring in.')}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4" style="background: #f0fdf4; border-radius: 16px; border: 1px solid #bbf7d0;">
                    <div class="mb-2" style="font-size: 2rem;">📊</div>
                    <h6 class="fw-bold mb-1">{{translate('Real-time Tracking')}}</h6>
                    <p class="text-muted mb-0" style="font-size: 0.83rem;">{{translate('Track your clicks, signups, and earnings in real-time.')}}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center p-4" style="background: #fff7ed; border-radius: 16px; border: 1px solid #fed7aa;">
                    <div class="mb-2" style="font-size: 2rem;">🔗</div>
                    <h6 class="fw-bold mb-1">{{translate('Unique Link')}}</h6>
                    <p class="text-muted mb-0" style="font-size: 0.83rem;">{{translate('Get your own shareable referral link instantly upon approval.')}}</p>
                </div>
            </div>
        </div>

        {{-- APPLICATION FORM --}}
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-4 p-md-5">
                <h4 class="fw-bold mb-1" style="font-family: 'Outfit', sans-serif;">{{translate('Apply to Become an Affiliate')}}</h4>
                <p class="text-muted mb-4" style="font-size: 0.9rem;">{{translate('Tell us a bit about yourself and how you plan to promote.')}}</p>

                @if(session('success'))
                    <div class="alert alert-success rounded-3">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger rounded-3">
                        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{$e}}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('user.affiliate.apply') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{translate('How do you plan to promote?')}} <span class="text-danger">*</span></label>
                        <textarea name="how_to_promote" rows="5" class="form-control" style="border-radius: 12px; resize: none;" placeholder="{{translate('Describe your promotion strategy — e.g., Instagram page with 20k followers, YouTube channel, blog, etc.')}}" required>{{ old('how_to_promote') }}</textarea>
                        <small class="text-muted">{{translate('Be specific. This helps us review your application faster.')}}</small>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">{{translate('Your Website or Social Media URL')}} <span class="text-muted fw-normal">({{translate('Optional')}})</span></label>
                        <input type="url" name="website_url" class="form-control" style="border-radius: 12px;" placeholder="https://instagram.com/yourhandle" value="{{ old('website_url') }}">
                    </div>
                    <button type="submit" class="i-btn btn--primary btn--lg w-100" style="border-radius: 12px; font-weight: 700;">
                        <i class="bi bi-send me-2"></i>{{translate('Submit Application')}}
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

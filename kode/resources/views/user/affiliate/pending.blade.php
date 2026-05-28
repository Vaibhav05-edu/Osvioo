@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6 col-md-8 text-center" style="margin-top: 10vh;">
        
        <div class="mb-4">
            <div style="display: inline-flex; justify-content: center; align-items: center; width: 100px; height: 100px; background: #fffbeb; border-radius: 50%; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.15);">
                <i class="bi bi-hourglass-split text-warning" style="font-size: 3rem;"></i>
            </div>
        </div>
        
        <h2 class="fw-bold mb-3" style="font-family: 'Outfit', sans-serif;">{{translate('Application Pending')}}</h2>
        <p class="text-muted mb-4" style="font-size: 1.1rem; line-height: 1.6;">
            {{translate('Thank you for applying to our Affiliate Program! Your application is currently under review by our team. We will notify you once a decision has been made.')}}
        </p>
        
        <div class="p-4 rounded-4" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
            <p class="mb-0 text-secondary" style="font-size: 0.95rem;">
                <i class="bi bi-info-circle me-2"></i>{{translate('Reviews typically take 1-2 business days.')}}
            </p>
        </div>

        <div class="mt-5">
            <a href="{{route('user.home')}}" class="i-btn btn--primary btn--lg" style="border-radius: 12px;">
                <i class="bi bi-house-door me-2"></i>{{translate('Back to Dashboard')}}
            </a>
        </div>

    </div>
</div>
@endsection

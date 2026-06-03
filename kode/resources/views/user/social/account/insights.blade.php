@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg--primary-soft text--primary" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-bar-chart-line fs-24"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">{{translate('Instagram Insights')}}</h4>
                        <p class="mb-0 text-muted">{{translate('Deep dive into your account analytics and audience demographics.')}}</p>
                    </div>
                </div>
                <button class="btn btn--primary capsuled px-4 fw-bold" onclick="alert('{{translate('Connecting to Instagram Graph API to fetch latest insights...')}}')">
                    <i class="bi bi-arrow-repeat me-2"></i> {{translate('Sync Data')}}
                </button>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold">{{translate('Select Account')}}</label>
                    <select class="form-select capsuled">
                        @if($accounts->count() > 0)
                            @foreach($accounts as $acc)
                                @if($acc->platform->slug == 'instagram')
                                    <option value="{{$acc->id}}">{{$acc->name}} ({{$acc->username}})</option>
                                @endif
                            @endforeach
                        @else
                            <option value="">{{translate('No Instagram accounts connected')}}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{translate('Date Range')}}</label>
                    <select class="form-select capsuled">
                        <option value="7">Last 7 Days</option>
                        <option value="30">Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Accounts Reached')}}</h6>
                        <h3 class="fw-bold mb-1">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Accounts Engaged')}}</h6>
                        <h3 class="fw-bold mb-1">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Total Followers')}}</h6>
                        <h3 class="fw-bold mb-1">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Content Interactions')}}</h6>
                        <h3 class="fw-bold mb-1">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-5 text-center bg-light-soft border rounded-3">
                <i class="bi bi-graph-up text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                <h5 class="fw-bold text-dark">{{translate('No Data Available')}}</h5>
                <p class="text-muted mb-4">{{translate('Please connect your Instagram Business account and sync data to view charts and demographics.')}}</p>
                <a href="{{route('user.social.account.platform')}}" class="btn btn-outline-dark capsuled px-4 fw-bold">
                    <i class="bi bi-link-45deg me-2"></i> {{translate('Connect Account')}}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

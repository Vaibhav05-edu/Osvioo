@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="icon-box bg--info-soft text--info" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock fs-24"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">{{translate('AI Optimal Posting Times')}}</h4>
                    <p class="mb-0 text-muted">{{translate('Discover the best times to post based on your audience\'s historical activity and AI predictions.')}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <div class="p-4 bg-light-soft rounded-3 border">
                        <h6 class="fw-bold mb-3">{{translate('Analyze Account Timing')}}</h6>
                        <form action="#" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">{{translate('Select Connected Account')}}</label>
                                <select class="form-select capsuled" name="account_id">
                                    <option value="">{{translate('Choose Account...')}}</option>
                                    {{-- Account loop can be added here in future --}}
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold">{{translate('Timeframe')}}</label>
                                <select class="form-select capsuled" name="timeframe">
                                    <option value="7">Last 7 Days</option>
                                    <option value="30">Last 30 Days</option>
                                    <option value="90">Last 90 Days</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn--primary capsuled px-4 fw-bold w-100" onclick="alert('{{translate('API integration required. Please configure Insight Analytics API keys first.')}}')">
                                <i class="bi bi-search me-2"></i> {{translate('Analyze Audience')}}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="bg-white border p-4 h-100" style="border-radius: 16px;">
                        <h6 class="fw-bold mb-3"><i class="bi bi-graph-up text-primary me-2"></i>{{translate('Predicted Best Times')}}</h6>
                        
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 text-center bg-light-soft">
                                    <span class="badge bg-success-soft text-success mb-2 capsuled">{{translate('Top Choice')}}</span>
                                    <h4 class="fw-bold text-dark mb-1">06:00 PM</h4>
                                    <p class="fs-12 text-muted mb-0">{{translate('Wednesday')}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 text-center bg-light-soft">
                                    <span class="badge bg-info-soft text-info mb-2 capsuled">{{translate('High Engagement')}}</span>
                                    <h4 class="fw-bold text-dark mb-1">11:30 AM</h4>
                                    <p class="fs-12 text-muted mb-0">{{translate('Friday')}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border rounded-3 p-3 text-center bg-light-soft">
                                    <span class="badge bg-warning-soft text-warning mb-2 capsuled">{{translate('Good Choice')}}</span>
                                    <h4 class="fw-bold text-dark mb-1">08:00 AM</h4>
                                    <p class="fs-12 text-muted mb-0">{{translate('Monday')}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-light-soft rounded-3 border">
                            <p class="fs-13 text-muted mb-0 text-center">
                                <i class="bi bi-info-circle me-1"></i> {{translate('These are placeholder predictions. Connect your account and run the analysis to fetch real AI-driven optimal timing.')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

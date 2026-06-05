@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="icon-box bg--warning-soft text--warning" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-graph-up-arrow fs-24"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">{{translate('AI Current Trends')}}</h4>
                    <p class="mb-0 text-muted">{{translate('Stay ahead of the curve. Discover trending audios, topics, and formats in your niche.')}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <form action="#" method="POST" class="bg-light-soft p-4 border rounded-3 h-100">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('Select Niche')}}</label>
                            <select class="form-select capsuled" name="niche">
                                <option value="fashion">Fashion & Style</option>
                                <option value="tech">Technology</option>
                                <option value="fitness">Health & Fitness</option>
                                <option value="travel">Travel</option>
                                <option value="food">Food & Cooking</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{translate('Platform Focus')}}</label>
                            <select class="form-select capsuled" name="platform">
                                <option value="instagram_reels">Instagram Reels</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn--warning capsuled px-4 fw-bold w-100 text-dark" onclick="alert('{{translate('API integration required. Please connect the Trend API keys first.')}}')">
                            <i class="bi bi-fire me-2"></i> {{translate('Scan Trends')}}
                        </button>
                    </form>
                </div>
                <div class="col-lg-8">
                    <div class="bg-white border p-4 h-100" style="border-radius: 16px;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-bold mb-0"><i class="bi bi-stars text-warning me-2"></i>{{translate('Trending Now (Preview)')}}</h6>
                            <span class="badge bg-danger-soft text-danger capsuled">{{translate('Live Data')}}</span>
                        </div>
                        
                        <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                            <div class="list-group-item p-3 d-flex justify-content-between align-items-center bg-light-soft">
                                <div>
                                    <h6 class="mb-1 fw-bold">"Pedro Pedro Pedro" <span class="badge bg-secondary ms-2" style="font-size: 10px;">Audio</span></h6>
                                    <p class="fs-12 text-muted mb-0">{{translate('Currently viral across Reels. Great for transitions.')}}</p>
                                </div>
                                <span class="fs-12 fw-bold text-success"><i class="bi bi-arrow-up-right me-1"></i>450%</span>
                            </div>
                            <div class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 fw-bold">POV: Office Life <span class="badge bg-secondary ms-2" style="font-size: 10px;">Format</span></h6>
                                    <p class="fs-12 text-muted mb-0">{{translate('Text-on-screen relatable POV videos are seeing high engagement.')}}</p>
                                </div>
                                <span class="fs-12 fw-bold text-success"><i class="bi bi-arrow-up-right me-1"></i>210%</span>
                            </div>
                            <div class="list-group-item p-3 d-flex justify-content-between align-items-center bg-light-soft">
                                <div>
                                    <h6 class="mb-1 fw-bold">#GRWM (Get Ready With Me) <span class="badge bg-secondary ms-2" style="font-size: 10px;">Topic</span></h6>
                                    <p class="fs-12 text-muted mb-0">{{translate('Still dominating the fashion and beauty space.')}}</p>
                                </div>
                                <span class="fs-12 fw-bold text-success"><i class="bi bi-arrow-up-right me-1"></i>120%</span>
                            </div>
                        </div>

                        <div class="mt-4 p-3 bg-light-soft rounded-3 border text-center">
                            <p class="fs-13 text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i> {{translate('Connect your API to see real-time, localized trending data for your specific niche.')}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

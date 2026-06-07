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
                    <div class="bg-light-soft p-4 border rounded-3">
                        <h6 class="fw-bold mb-3">{{translate('Scan Your Niche')}}</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('Select Niche')}}</label>
                            <select class="form-select capsuled" id="trendNiche">
                                <option value="fashion">{{translate('Fashion & Style')}}</option>
                                <option value="tech">{{translate('Technology')}}</option>
                                <option value="fitness">{{translate('Health & Fitness')}}</option>
                                <option value="travel">{{translate('Travel')}}</option>
                                <option value="food">{{translate('Food & Cooking')}}</option>
                                <option value="beauty">{{translate('Beauty & Skincare')}}</option>
                                <option value="business">{{translate('Business & Finance')}}</option>
                                <option value="education">{{translate('Education')}}</option>
                                <option value="entertainment">{{translate('Entertainment')}}</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{translate('Platform Focus')}}</label>
                            <select class="form-select capsuled" id="trendPlatform">
                                <option value="instagram_reels">{{translate('Instagram Reels')}}</option>
                                <option value="tiktok">{{translate('TikTok')}}</option>
                                <option value="youtube_shorts">{{translate('YouTube Shorts')}}</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn--warning capsuled px-4 fw-bold w-100 text-dark" id="scanTrendsBtn">
                            <i class="bi bi-fire me-2"></i> {{translate('Scan Trends')}}
                        </button>
                    </div>
                </div>
                <div class="col-lg-8 mt-4 mt-lg-0">
                    <div class="bg-white border p-4 h-100" style="border-radius: 16px;">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h6 class="fw-bold mb-0"><i class="bi bi-stars text-warning me-2"></i>{{translate('AI Trend Analysis')}}</h6>
                            <span class="badge bg-danger-soft text-danger capsuled" id="trendBadge">{{translate('AI Powered')}}</span>
                        </div>
                        <div id="trendOutput">
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
                            <div class="mt-3 p-3 bg-light-soft rounded-3 border text-center">
                                <p class="fs-13 text-muted mb-0">
                                    <i class="bi bi-info-circle me-1"></i> {{translate('Click "Scan Trends" to get real-time AI trend analysis for your niche.')}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-push')
<script nonce="{{ csp_nonce() }}">
document.getElementById('scanTrendsBtn').addEventListener('click', function() {
    const niche    = document.getElementById('trendNiche').value;
    const platform = document.getElementById('trendPlatform').value;
    const btn      = this;
    const output   = document.getElementById('trendOutput');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> {{ translate("Scanning...") }}';
    output.innerHTML = '<div class="text-center py-4"><span class="spinner-border text-warning"></span><p class="mt-2 text-muted">{{ translate("AI is scanning current trends...") }}</p></div>';

    fetch('{{ route("user.ai_suggestions.scan.trends") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ niche, platform })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status && Array.isArray(data.result)) {
            const typeBadgeColor = {
                'Audio': 'bg-primary', 'Format': 'bg-info', 'Topic': 'bg-success',
                'Hashtag': 'bg-warning text-dark', 'Video': 'bg-danger'
            };
            const rows = data.result.map((item, i) => `
                <div class="list-group-item p-3 d-flex justify-content-between align-items-center ${i % 2 === 0 ? 'bg-light-soft' : ''}">
                    <div>
                        <h6 class="mb-1 fw-bold">${item.title || ''}
                            <span class="badge ${typeBadgeColor[item.type] || 'bg-secondary'} ms-2" style="font-size:10px;">${item.type || ''}</span>
                        </h6>
                        <p class="fs-12 text-muted mb-0">${item.description || ''}</p>
                    </div>
                    <span class="fs-12 fw-bold text-success ms-3 text-nowrap"><i class="bi bi-arrow-up-right me-1"></i>${item.growth || ''}</span>
                </div>
            `).join('');
            output.innerHTML = `<div class="list-group list-group-flush border rounded-3 overflow-hidden">${rows}</div>`;
            document.getElementById('trendBadge').textContent = '{{ translate("Live AI Data") }}';
        } else {
            output.innerHTML = `<div class="alert alert-danger">${data.message || '{{ translate("Failed to get trends.") }}'}</div>`;
        }
    })
    .catch(() => {
        output.innerHTML = '<div class="alert alert-danger">{{ translate("Something went wrong. Please try again.") }}</div>';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-fire me-2"></i> {{ translate("Scan Trends") }}';
    });
});
</script>
@endpush
@endsection

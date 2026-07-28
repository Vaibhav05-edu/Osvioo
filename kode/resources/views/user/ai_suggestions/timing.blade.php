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
                    <p class="mb-0 text-muted">{{translate("Discover the best times to post based on AI predictions and global engagement data.")}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-5">
                    <div class="p-4 rounded-3 border" style="background: var(--bs-body-bg); color: var(--bs-body-color);">
                        <h6 class="fw-bold mb-3">{{translate('Analyze Timing')}}</h6>
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('Timeframe')}}</label>
                            <select class="form-select capsuled" id="timingTimeframe">
                                <option value="7">{{translate('Last 7 Days')}}</option>
                                <option value="30" selected>{{translate('Last 30 Days')}}</option>
                                <option value="90">{{translate('Last 90 Days')}}</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn--primary capsuled px-4 fw-bold w-100" id="analyzeTimingBtn">
                            <i class="bi bi-search me-2"></i> {{translate('Analyze Best Times')}}
                        </button>
                    </div>
                </div>
                <div class="col-lg-7 mt-4 mt-lg-0">
                    <div class="border p-4 h-100" style="border-radius: 16px; background: var(--bs-body-bg); color: var(--bs-body-color);">
                        <h6 class="fw-bold mb-3"><i class="bi bi-graph-up text-primary me-2"></i>{{translate('AI Predicted Best Times')}}</h6>
                        <div id="timingOutput">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 text-center" style="background: var(--bs-tertiary-bg, rgba(0,0,0,0.02));">
                                        <span class="badge bg-success-soft text-success mb-2 capsuled">{{translate('Top Choice')}}</span>
                                        <h4 class="fw-bold mb-1" style="color: var(--text-primary, #1b1c1e);">06:00 PM</h4>
                                        <p class="fs-13 fw-semibold mb-1" style="color: var(--text-primary, #1b1c1e);">{{translate('Wednesday')}}</p>
                                        <p class="fs-12 mb-0" style="color: var(--text-secondary, #4c4b4b);">{{translate('Midweek posts in the morning receive high engagement.')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 text-center" style="background: var(--bs-tertiary-bg, rgba(0,0,0,0.02));">
                                        <span class="badge bg-info-soft text-info mb-2 capsuled">{{translate('High Engagement')}}</span>
                                        <h4 class="fw-bold mb-1" style="color: var(--text-primary, #1b1c1e);">11:30 AM</h4>
                                        <p class="fs-13 fw-semibold mb-1" style="color: var(--text-primary, #1b1c1e);">{{translate('Friday')}}</p>
                                        <p class="fs-12 mb-0" style="color: var(--text-secondary, #4c4b4b);">{{translate('Posts after work hours get increased visibility.')}}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded-3 p-3 text-center" style="background: var(--bs-tertiary-bg, rgba(0,0,0,0.02));">
                                        <span class="badge bg-warning-soft text-warning mb-2 capsuled">{{translate('Good Choice')}}</span>
                                        <h4 class="fw-bold mb-1" style="color: var(--text-primary, #1b1c1e);">08:00 AM</h4>
                                        <p class="fs-13 fw-semibold mb-1" style="color: var(--text-primary, #1b1c1e);">{{translate('Monday')}}</p>
                                        <p class="fs-12 mb-0" style="color: var(--text-secondary, #4c4b4b);">{{translate('Less competition and high user activity on afternoons.')}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 p-3 rounded-3 border" style="background: var(--bs-tertiary-bg, rgba(0,0,0,0.02));">
                                <p class="fs-13 mb-0 text-center" style="color: var(--text-secondary, #4c4b4b);">
                                    <i class="bi bi-info-circle me-1"></i> {{translate('Click "Analyze Best Times" to get AI-powered personalized timing predictions.')}}
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
document.getElementById('analyzeTimingBtn').addEventListener('click', function() {
    const timeframe = document.getElementById('timingTimeframe').value;
    const btn    = this;
    const output = document.getElementById('timingOutput');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> {{ translate("Analyzing...") }}';
    output.innerHTML = '<div class="text-center py-4"><span class="spinner-border text-info"></span><p class="mt-2 text-muted">{{ translate("AI is analyzing engagement patterns...") }}</p></div>';

    fetch('{{ route("user.ai_suggestions.analyze.timing") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ timeframe })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status && Array.isArray(data.result)) {
            const badgeClasses = ['bg-success-soft text-success', 'bg-info-soft text-info', 'bg-warning-soft text-warning'];
            const cols = data.result.map((item, i) => `
                <div class="col-md-4">
                    <div class="border rounded-3 p-3 text-center" style="background: var(--bs-tertiary-bg, rgba(0,0,0,0.02));">
                        <span class="badge ${badgeClasses[i] || 'bg-secondary text-secondary'} mb-2 capsuled">${item.label || ''}</span>
                        <h4 class="fw-bold mb-1" style="color: var(--text-primary, #1b1c1e);">${item.time || ''}</h4>
                        <p class="fs-13 fw-semibold mb-1" style="color: var(--text-primary, #1b1c1e);">${item.day || ''}</p>
                        <p class="fs-12 mb-0" style="color: var(--text-secondary, #4c4b4b);">${item.reason || ''}</p>
                    </div>
                </div>
            `).join('');
            output.innerHTML = `<div class="row g-3">${cols}</div>`;
        } else {
            output.innerHTML = `<div class="alert alert-danger">${data.message || '{{ translate("Failed to get results.") }}'}</div>`;
        }
    })
    .catch(() => {
        output.innerHTML = '<div class="alert alert-danger">{{ translate("Something went wrong. Please try again.") }}</div>';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-search me-2"></i> {{ translate("Analyze Best Times") }}';
    });
});
</script>
@endpush
@endsection

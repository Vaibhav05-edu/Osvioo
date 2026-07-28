@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="icon-box bg--primary-soft text--primary" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-hash fs-24"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">{{translate('AI Hashtag Generator')}}</h4>
                    <p class="mb-0 text-muted">{{translate('Generate high-performing, niche-specific hashtags to boost your post reach.')}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Describe your post or image')}}</label>
                        <textarea class="form-control capsuled" id="hashtagPrompt" rows="4" placeholder="{{translate('e.g. A sunny day at the beach in Miami wearing a yellow dress...')}}"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('Target Platform')}}</label>
                        <select class="form-select capsuled" id="hashtagPlatform">
                            <option value="instagram">Instagram</option>
                            <option value="tiktok">TikTok</option>
                            <option value="youtube">YouTube</option>
                            <option value="twitter">Twitter / X</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">{{translate('Number of Hashtags')}}</label>
                        <input type="number" class="form-control capsuled" id="hashtagCount" value="15" min="1" max="30">
                    </div>
                    <button type="button" class="btn btn--primary capsuled px-4 fw-bold w-100" id="generateHashtagBtn">
                        <i class="bi bi-magic me-2"></i> {{translate('Generate Hashtags')}}
                    </button>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="border p-4 h-100" style="border-radius: 16px; background: var(--bs-body-bg); color: var(--bs-body-color);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-card-text me-2 text-primary"></i>{{translate('Generated Hashtags')}}</h6>
                            <button class="btn btn-sm btn-outline-secondary capsuled d-none" id="copyHashtagsBtn" onclick="copyHashtags()">
                                <i class="bi bi-clipboard me-1"></i> {{translate('Copy All')}}
                            </button>
                        </div>
                        <div id="hashtagOutput" class="text-center py-5 opacity-50">
                            <i class="bi bi-stars fs-1 mb-2"></i>
                            <p class="fs-14">{{translate('Your generated hashtags will appear here.')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-push')
<script nonce="{{ csp_nonce() }}">
document.getElementById('generateHashtagBtn').addEventListener('click', function() {
    const prompt   = document.getElementById('hashtagPrompt').value.trim();
    const platform = document.getElementById('hashtagPlatform').value;
    const count    = document.getElementById('hashtagCount').value;
    const btn      = this;
    const output   = document.getElementById('hashtagOutput');

    if (!prompt) {
        output.className = 'py-2';
        output.innerHTML = '<div class="alert alert-warning">{{ translate("Please describe your post first.") }}</div>';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> {{ translate("Generating...") }}';
    output.className = 'text-center py-4';
    output.innerHTML = '<span class="spinner-border text-primary"></span><p class="mt-2 text-muted">{{ translate("AI is generating hashtags...") }}</p>';

    fetch('{{ route("user.ai_suggestions.generate.hashtag") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ prompt, platform, count })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status) {
            const rawTags = data.result.split(/\s+/).filter(t => t.length > 0);
            const tags = rawTags.map(t => t.startsWith('#') ? t : '#' + t);
            const html = tags.map(t =>
                `<span class="badge me-1 mb-2 px-3 py-2 hashtag-pill" style="background: var(--color-primary-light, rgba(127, 86, 217, 0.12)); color: var(--color-primary, #7f56d9) !important; border: 1px solid rgba(127, 86, 217, 0.25); font-size:13px; border-radius:20px; font-weight:600; display:inline-block;">${t}</span>`
            ).join('');
            output.className = 'py-2';
            output.innerHTML = `<div class="mb-2 d-flex flex-wrap gap-1">${html}</div>`;
            document.getElementById('copyHashtagsBtn').classList.remove('d-none');
            document.getElementById('copyHashtagsBtn').dataset.text = data.result;
        } else {
            output.className = 'py-2';
            output.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(e => {
        output.className = 'py-2';
        output.innerHTML = `<div class="alert alert-danger">{{ translate("Something went wrong. Please try again.") }}</div>`;
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-magic me-2"></i> {{ translate("Generate Hashtags") }}';
    });
});

function copyHashtags() {
    const text = document.getElementById('copyHashtagsBtn').dataset.text;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copyHashtagsBtn');
        btn.innerHTML = '<i class="bi bi-check me-1"></i> {{ translate("Copied!") }}';
        setTimeout(() => { btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> {{ translate("Copy All") }}'; }, 2000);
    });
}
</script>
@endpush
@endsection

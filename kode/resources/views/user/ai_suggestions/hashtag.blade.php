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
                            <button class="btn btn-sm btn-primary capsuled d-none" id="copyHashtagsBtn" onclick="copyHashtags()" style="background-color: #6366f1 !important; color: #ffffff !important; border-color: #4f46e5 !important;">
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
        if (data.status && data.result) {
            const rawTags = data.result.split(/\s+/).filter(t => t.length > 0);
            let tags = rawTags.map(t => {
                let clean = t.replace(/^[^\p{L}\p{N}#]+|[^\p{L}\p{N}]+$/gu, '');
                return clean.startsWith('#') ? clean : '#' + clean;
            }).filter(t => t.length > 1);

            if (tags.length === 0) {
                tags = rawTags.map(rt => rt.startsWith('#') ? rt : '#' + rt);
            }

            const html = tags.map(t => {
                const safeTag = t.replace(/'/g, "\\'");
                return `<span class="badge me-1 mb-2 px-3 py-2 hashtag-pill" onclick="copySingleHashtag('${safeTag}', this)" title="{{ translate("Click to copy") }}" style="background: #6366f1 !important; color: #ffffff !important; border: 1px solid #4f46e5; font-size:13px; border-radius:20px; font-weight:600; display:inline-block; cursor:pointer; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">${t}</span>`;
            }).join('');

            const formattedText = tags.join(' ');
            window.allGeneratedHashtags = formattedText;
            output.className = 'py-2';
            output.innerHTML = `<div class="mb-2 d-flex flex-wrap gap-1">${html}</div>`;
            const copyBtn = document.getElementById('copyHashtagsBtn');
            copyBtn.classList.remove('d-none');
            copyBtn.dataset.text = formattedText;
        } else {
            output.className = 'py-2';
            output.innerHTML = `<div class="alert alert-danger">${data.message || '{{ translate("Failed to generate hashtags.") }}'}</div>`;
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

function copySingleHashtag(tag, el) {
    selfContainedCopyToClipboard(tag, null, null, () => {
        const origHtml = el.innerHTML;
        el.innerHTML = '<i class="bi bi-check me-1"></i> {{ translate("Copied!") }}';
        el.style.setProperty('background', '#10b981', 'important');
        el.style.setProperty('color', '#ffffff', 'important');
        setTimeout(() => {
            el.innerHTML = origHtml;
            el.style.setProperty('background', '#6366f1', 'important');
            el.style.setProperty('color', '#ffffff', 'important');
        }, 1500);
    });
}

function copyHashtags() {
    const btn = document.getElementById('copyHashtagsBtn');
    let text = window.allGeneratedHashtags || (btn ? btn.dataset.text : '') || '';
    if (!text) {
        const pills = document.querySelectorAll('.hashtag-pill');
        if (pills.length > 0) {
            text = Array.from(pills).map(el => {
                let clone = el.cloneNode(true);
                clone.querySelectorAll('i').forEach(i => i.remove());
                return clone.textContent.trim();
            }).filter(Boolean).join(' ');
        }
    }
    selfContainedCopyToClipboard(text, btn, '<i class="bi bi-clipboard me-1"></i> {{ translate("Copy All") }}');
}

function selfContainedCopyToClipboard(text, btn, defaultHtml, customSuccessCallback) {
    if (!text) {
        if (typeof toastr !== 'undefined') {
            if (typeof toastr === 'function') toastr('{{ translate("Nothing to copy!") }}', 'danger');
            else if (toastr.error) toastr.error('{{ translate("Nothing to copy!") }}');
        }
        return;
    }

    function onSuccess() {
        if (typeof customSuccessCallback === 'function') {
            customSuccessCallback();
        } else if (btn && defaultHtml) {
            btn.innerHTML = '<i class="bi bi-check me-1"></i> {{ translate("Copied!") }}';
            setTimeout(() => { btn.innerHTML = defaultHtml; }, 2000);
        }
        if (typeof toastr !== 'undefined') {
            if (typeof toastr === 'function') toastr('{{ translate("Copied to clipboard!") }}', 'success');
            else if (toastr.success) toastr.success('{{ translate("Copied to clipboard!") }}');
        }
    }

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(onSuccess).catch(() => {
            execCopyFallbackHashtag(text, onSuccess);
        });
    } else {
        execCopyFallbackHashtag(text, onSuccess);
    }
}

function execCopyFallbackHashtag(text, onSuccess) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.top = '0';
    textarea.style.left = '0';
    textarea.style.width = '1px';
    textarea.style.height = '1px';
    textarea.style.padding = '0';
    textarea.style.border = 'none';
    textarea.style.outline = 'none';
    textarea.style.boxShadow = 'none';
    textarea.style.background = 'transparent';
    textarea.style.opacity = '0.01';
    textarea.style.pointerEvents = 'none';
    textarea.style.zIndex = '-9999';

    document.body.appendChild(textarea);
    textarea.focus();
    textarea.select();
    textarea.setSelectionRange(0, 999999);

    let successful = false;
    try {
        successful = document.execCommand('copy');
    } catch (err) {
        successful = false;
    }
    document.body.removeChild(textarea);

    if (successful) {
        onSuccess();
    } else {
        window.prompt('{{ translate("Copy to clipboard: Press Ctrl+C, Enter") }}', text);
        onSuccess();
    }
}
</script>
@endpush
@endsection

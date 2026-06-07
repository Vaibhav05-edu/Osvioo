@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="icon-box bg--success-soft text--success" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-chat-left-text fs-24"></i>
                </div>
                <div>
                    <h4 class="mb-1 fw-bold">{{translate('AI Post Content Generator')}}</h4>
                    <p class="mb-0 text-muted">{{translate("Overcome writer's block. Let AI write engaging captions and full posts for you.")}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{translate('What is the post about?')}}</label>
                        <textarea class="form-control capsuled" id="postPrompt" rows="4" placeholder="{{translate('e.g. Announcing our new summer clothing line launch on Friday...')}}"></textarea>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{translate('Tone of Voice')}}</label>
                            <select class="form-select capsuled" id="postTone">
                                <option value="casual">{{translate('Casual & Friendly')}}</option>
                                <option value="professional">{{translate('Professional')}}</option>
                                <option value="humorous">{{translate('Humorous / Funny')}}</option>
                                <option value="persuasive">{{translate('Persuasive / Sales')}}</option>
                                <option value="inspirational">{{translate('Inspirational')}}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">{{translate('Content Length')}}</label>
                            <select class="form-select capsuled" id="postLength">
                                <option value="short">{{translate('Short (1-2 sentences)')}}</option>
                                <option value="medium">{{translate('Medium (1 paragraph)')}}</option>
                                <option value="long">{{translate('Long (Detailed)')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4 form-check">
                        <input class="form-check-input" type="checkbox" id="addEmojis" checked>
                        <label class="form-check-label fw-bold fs-14" for="addEmojis">
                            {{translate('Include Emojis')}}
                        </label>
                    </div>
                    <button type="button" class="btn btn--primary capsuled px-4 fw-bold w-100" id="generatePostBtn">
                        <i class="bi bi-magic me-2"></i> {{translate('Generate Content')}}
                    </button>
                </div>
                <div class="col-lg-6 mt-4 mt-lg-0">
                    <div class="border p-4 h-100" style="border-radius: 16px; background: #f8fff8;">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0"><i class="bi bi-robot me-2 text-success"></i>{{translate('Generated Output')}}</h6>
                            <button class="btn btn-sm btn-outline-secondary capsuled d-none" id="copyPostBtn" onclick="copyPost()">
                                <i class="bi bi-clipboard me-1"></i> {{translate('Copy')}}
                            </button>
                        </div>
                        <div id="postOutput" class="text-center py-5 opacity-50">
                            <i class="bi bi-robot fs-1 mb-2"></i>
                            <p class="fs-14">{{translate('Your generated post captions will appear here.')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script-push')
<script nonce="{{ csp_nonce() }}">
document.getElementById('generatePostBtn').addEventListener('click', function() {
    const prompt    = document.getElementById('postPrompt').value.trim();
    const tone      = document.getElementById('postTone').value;
    const length    = document.getElementById('postLength').value;
    const addEmojis = document.getElementById('addEmojis').checked ? '1' : '0';
    const btn       = this;
    const output    = document.getElementById('postOutput');

    if (!prompt) {
        output.innerHTML = '<div class="alert alert-warning">{{ translate("Please describe your post first.") }}</div>';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> {{ translate("Generating...") }}';
    output.innerHTML = '<div class="text-center py-4"><span class="spinner-border text-success"></span><p class="mt-2 text-muted">{{ translate("AI is writing your post...") }}</p></div>';

    fetch('{{ route("user.ai_suggestions.generate.post") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ prompt, tone, length, add_emojis: addEmojis })
    })
    .then(r => r.json())
    .then(data => {
        if (data.status) {
            const escaped = data.result.replace(/\n/g, '<br>');
            output.innerHTML = `<div class="post-content" style="white-space:pre-wrap;line-height:1.8;font-size:15px;color:#222;">${escaped}</div>`;
            document.getElementById('copyPostBtn').classList.remove('d-none');
            document.getElementById('copyPostBtn').dataset.text = data.result;
        } else {
            output.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
        }
    })
    .catch(() => {
        output.innerHTML = '<div class="alert alert-danger">{{ translate("Something went wrong. Please try again.") }}</div>';
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-magic me-2"></i> {{ translate("Generate Content") }}';
    });
});

function copyPost() {
    const text = document.getElementById('copyPostBtn').dataset.text;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copyPostBtn');
        btn.innerHTML = '<i class="bi bi-check me-1"></i> {{ translate("Copied!") }}';
        setTimeout(() => { btn.innerHTML = '<i class="bi bi-clipboard me-1"></i> {{ translate("Copy") }}'; }, 2000);
    });
}
</script>
@endpush
@endsection

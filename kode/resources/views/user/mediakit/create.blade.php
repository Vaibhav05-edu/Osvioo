@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="i-card-md">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-stars text-warning"></i> {{translate('Create AI Media Kit')}}
                </h4>
                <a href="{{route('user.mediakit.index')}}" class="i-btn btn--md info">
                    <i class="bi bi-arrow-left"></i> {{translate('Back')}}
                </a>
            </div>
            <div class="card-body">
                <form action="{{route('user.mediakit.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="form-inner">
                                <label for="title">{{translate('Media Kit Title')}} <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{old('title')}}" placeholder="{{translate('e.g. My 2026 Media Kit')}}" required>
                            </div>

                            {{-- AI Bio Generator --}}
                            <div style="background: linear-gradient(135deg, #1a1a2e, #16213e); border: 1px solid #6366f1; border-radius: 12px; padding: 1.25rem; margin-bottom: 1rem;">
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom: 0.75rem;">
                                    <span style="color:#a78bfa; font-weight:700; font-size:0.95rem;">
                                        <i class="bi bi-stars"></i> ✨ AI Bio & Caption Generator
                                    </span>
                                    <button type="button" id="toggleAiPanel" style="background:rgba(99,102,241,0.3)!important; border:1px solid #a78bfa!important; color:#a78bfa!important; padding:4px 14px!important; border-radius:6px!important; font-size:0.8rem!important; cursor:pointer!important; font-weight:600!important;">
                                        <i class="bi bi-chevron-up" id="aiToggleIcon"></i> Hide
                                    </button>
                                </div>
                                <div id="aiPanel" style="display:block;">
                                    <textarea id="aiPromptCreate" rows="2" placeholder="Describe yourself: niche, platform, audience, brand voice... e.g. Fashion &amp; lifestyle influencer in Mumbai, targeting women 18-28, posting about sustainable fashion &amp; skincare" style="width:100%!important; background:rgba(255,255,255,0.07)!important; border:1px solid rgba(99,102,241,0.4)!important; border-radius:8px!important; padding:0.75rem!important; color:#e2e8f0!important; font-size:0.9rem!important; resize:vertical!important; outline:none!important;"></textarea>
                                    <button type="button" id="aiQuickBtn" style="margin-top:0.6rem!important; background:linear-gradient(135deg,#6366f1,#8b5cf6)!important; border:none!important; color:#fff!important; padding:10px 22px!important; border-radius:8px!important; font-weight:700!important; cursor:pointer!important; font-size:0.9rem!important; display:inline-flex!important; align-items:center!important; gap:6px!important;">
                                        <i class="bi bi-stars" id="aiQIcon"></i> <span id="aiQText">Generate Bio + Captions</span>
                                    </button>
                                    <div id="aiQuickResult" style="display:none; margin-top:1rem; padding-top:1rem; border-top:1px solid rgba(99,102,241,0.3);">
                                        <div style="margin-bottom:0.75rem;">
                                            <div style="color:#a78bfa; font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.4rem;">Generated Bio</div>
                                            <div id="aiBioPreview" style="background:rgba(255,255,255,0.05); border-radius:8px; padding:0.75rem; color:#e2e8f0; font-size:0.85rem; line-height:1.7; white-space:pre-wrap;"></div>
                                            <button type="button" id="useBioBtn" style="margin-top:0.4rem; background:rgba(99,102,241,0.3); border:1px solid #6366f1; color:#a78bfa; padding:4px 14px; border-radius:6px; font-size:0.8rem; cursor:pointer;">
                                                ✓ Use this Bio
                                            </button>
                                        </div>
                                        <div>
                                            <div style="color:#a78bfa; font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; margin-bottom:0.4rem;">Ready-to-Post Captions</div>
                                            <div id="aiCaptionsPreview" style="display:flex; flex-direction:column; gap:0.4rem;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-inner">
                                <label for="bio">{{translate('Bio / Pitch')}} <span class="text-danger">*</span></label>
                                <textarea name="bio" id="bio" rows="5" placeholder="{{translate('Write a compelling pitch for brands...')}}" required>{{old('bio')}}</textarea>
                            </div>
                            
                            <div class="form-inner">
                                <label>{{translate('Select Accounts to Include')}}</label>
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    @foreach($accounts as $account)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="accounts[]" id="acc_{{$account->id}}" value="{{$account->id}}" checked>
                                        <label class="form-check-label" for="acc_{{$account->id}}">
                                            <i class="bi bi-{{strtolower($account->platform->name ?? 'globe')}}"></i> {{$account->name ?? $account->username}}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-inner">
                                <label for="cover_image">{{translate('Cover / Profile Image')}}</label>
                                <input type="file" id="cover_image" name="cover_image" accept="image/*">
                            </div>

                            <div class="form-inner">
                                <label for="theme_color">{{translate('Theme Color')}} <span class="text-danger">*</span></label>
                                <input type="color" id="theme_color" name="theme_color" value="#c9a97a" class="form-control form-control-color w-100" required>
                            </div>

                            <div class="form-inner">
                                <label for="contact_email">{{translate('Contact Email')}} <span class="text-danger">*</span></label>
                                <input type="email" id="contact_email" name="contact_email" value="{{auth_user('web')->email}}" required>
                            </div>
                            
                            <div class="form-inner mt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_public" id="is_public" checked>
                                    <label class="form-check-label" for="is_public">{{translate('Make Publicly Accessible')}}</label>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="i-btn btn--primary btn--lg w-100">
                                    {{translate('Generate Media Kit')}} <i class="bi bi-magic"></i>
                                </button>
                            </div>

                            <div class="mt-3 p-3 rounded" style="background:rgba(99,102,241,0.08); border:1px solid rgba(99,102,241,0.2); font-size:0.8rem; color:#94a3b8;">
                                <i class="bi bi-info-circle text-primary"></i>
                                After creating, go to <strong>Edit</strong> to use the full AI Generator with 5 prompts per kit.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    // Toggle AI panel
    document.getElementById('toggleAiPanel').addEventListener('click', function(){
        const panel = document.getElementById('aiPanel');
        const isOpen = panel.style.display !== 'none';
        panel.style.display = isOpen ? 'none' : 'block';
        document.getElementById('aiToggleIcon').className = isOpen ? 'bi bi-chevron-down' : 'bi bi-chevron-up';
        this.innerHTML = isOpen
            ? '<i class="bi bi-chevron-down" id="aiToggleIcon"></i> Show AI'
            : '<i class="bi bi-chevron-up" id="aiToggleIcon"></i> Hide';
    });

    // Quick AI generate
    document.getElementById('aiQuickBtn').addEventListener('click', async function(){
        const prompt = document.getElementById('aiPromptCreate').value.trim();
        if(!prompt){ alert('Please describe your niche first.'); return; }

        document.getElementById('aiQText').textContent = 'Generating…';
        document.getElementById('aiQIcon').className = 'bi bi-hourglass-split';
        this.disabled = true;

        try {
            const res = await fetch('{{ route("user.mediakit.ai.quick") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ prompt }),
            });
            const data = await res.json();
            if(!res.ok || data.error){ alert(data.error || 'Generation failed.'); return; }

            document.getElementById('aiBioPreview').textContent = data.bio;
            const capWrap = document.getElementById('aiCaptionsPreview');
            capWrap.innerHTML = '';
            (data.captions||[]).forEach((c,i) => {
                capWrap.innerHTML += `<div style="background:rgba(255,255,255,0.05);border-radius:6px;padding:0.5rem 0.75rem;font-size:0.78rem;color:#cbd5e1;line-height:1.6;">
                    <span style="color:#8b5cf6;font-weight:700;">Caption ${i+1}:</span> ${c}
                    <button onclick="navigator.clipboard.writeText(this.closest('div').innerText.replace('Caption ${i+1}:','').trim())" style="float:right;background:none;border:1px solid #444;border-radius:4px;cursor:pointer;font-size:0.68rem;color:#aaa;padding:1px 6px;">Copy</button>
                </div>`;
            });
            document.getElementById('aiQuickResult').style.display = 'block';

        } catch(e){ alert('Network error.'); }
        finally {
            document.getElementById('aiQText').textContent = 'Generate Bio + Captions';
            document.getElementById('aiQIcon').className = 'bi bi-stars';
            document.getElementById('aiQuickBtn').disabled = false;
        }
    });

    // Use bio button
    document.getElementById('useBioBtn').addEventListener('click', function(){
        document.getElementById('bio').value = document.getElementById('aiBioPreview').textContent;
        this.textContent = '✓ Bio Copied to Form!';
        setTimeout(()=>{ this.textContent = '✓ Use this Bio'; }, 2000);
    });
})();
</script>

@endsection

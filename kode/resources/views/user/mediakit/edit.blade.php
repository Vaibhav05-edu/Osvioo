@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="i-card-md">
            <div class="card-header">
                <h4 class="card-title">
                    {{translate('Edit Media Kit')}}
                </h4>
                <a href="{{route('user.mediakit.index')}}" class="i-btn btn--md info">
                    <i class="bi bi-arrow-left"></i> {{translate('Back')}}
                </a>
            </div>
            <div class="card-body">
                <form action="{{route('user.mediakit.update', $mediaKit->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="form-inner">
                                <label for="title">{{translate('Media Kit Title')}} <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" value="{{old('title', $mediaKit->title)}}" required>
                            </div>

                            <div class="form-inner">
                                <label for="bio">{{translate('Bio / Pitch')}} <span class="text-danger">*</span></label>
                                <textarea name="bio" id="bio" rows="5" required>{{old('bio', $mediaKit->bio)}}</textarea>
                            </div>
                            
                            <div class="form-inner">
                                <label>{{translate('Stats (Auto-calculated on creation)')}}</label>
                                <div class="d-flex flex-wrap gap-3 mt-2">
                                    <span class="badge bg-primary fs-14">{{number_format($mediaKit->total_followers)}} {{translate('Followers')}}</span>
                                    <span class="badge bg-info fs-14">{{$mediaKit->engagement_rate}}% {{translate('Engagement')}}</span>
                                    <span class="badge bg-secondary fs-14">{{translate('Top Platform')}}: {{$mediaKit->top_platform}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-inner">
                                <label for="cover_image">{{translate('Cover Image')}}</label>
                                @if($mediaKit->cover_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('assets/images/custom/' . $mediaKit->cover_image) }}" class="img-fluid rounded" alt="Cover">
                                    </div>
                                @endif
                                <input type="file" id="cover_image" name="cover_image" accept="image/*">
                            </div>

                            <div class="form-inner">
                                <label for="theme_color">{{translate('Theme Color')}} <span class="text-danger">*</span></label>
                                <input type="color" id="theme_color" name="theme_color" value="{{old('theme_color', $mediaKit->theme_color)}}" class="form-control form-control-color w-100" required>
                            </div>

                            <div class="form-inner">
                                <label for="contact_email">{{translate('Contact Email')}} <span class="text-danger">*</span></label>
                                <input type="email" id="contact_email" name="contact_email" value="{{old('contact_email', $mediaKit->contact_email)}}" required>
                            </div>
                            
                            <div class="form-inner mt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_public" id="is_public" {{$mediaKit->is_public ? 'checked' : ''}}>
                                    <label class="form-check-label" for="is_public">{{translate('Make Publicly Accessible')}}</label>
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="i-btn btn--primary btn--lg w-100">
                                    {{translate('Update Media Kit')}} <i class="bi bi-save"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ── AI Generator Panel ── --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="i-card-md" style="border: 2px solid #6366f1; background: linear-gradient(135deg, #fafafa, #f0f0ff);">
            <div class="card-header" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 10px 10px 0 0;">
                <h4 class="card-title" style="color:#fff;">
                    <i class="bi bi-stars"></i> {{translate('AI Content Generator')}}
                    <span style="font-size:0.8rem; font-weight:400; margin-left:10px; opacity:0.85;">
                        {{ 5 - ($mediaKit->ai_prompts_used ?? 0) }}/5 prompts remaining
                    </span>
                </h4>
            </div>
            <div class="card-body">
                @if(($mediaKit->ai_prompts_used ?? 0) >= 5)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        You've used all 5 AI prompts for this Media Kit. Create a new kit to get more AI generations.
                    </div>
                @else
                    <p class="text-muted mb-3" style="font-size:0.9rem;">
                        Describe your niche, brand, and target audience. The AI will generate a compelling bio and 5 ready-to-post captions.
                        <strong style="color:#6366f1;">{{ 5 - ($mediaKit->ai_prompts_used ?? 0) }} prompts left.</strong>
                    </p>
                    <div class="row g-3">
                        <div class="col-lg-9">
                            <textarea id="aiPromptInput" rows="3" class="form-control" placeholder="e.g. I'm a fashion & lifestyle influencer based in Mumbai, targeting young women aged 18-28. I post about sustainable fashion, skincare routines, and travel. My brand is aesthetic and empowering."></textarea>
                        </div>
                        <div class="col-lg-3 d-flex align-items-end">
                            <button id="aiGenerateBtn" class="i-btn btn--primary btn--lg w-100" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); border:none;">
                                <i class="bi bi-stars" id="aiIcon"></i> <span id="aiBtnText">Generate with AI</span>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- AI Results Area --}}
                <div id="aiResultsArea" style="display:none; margin-top:1.5rem;">
                    <hr>
                    <div class="row g-3">
                        <div class="col-lg-7">
                            <label class="fw-bold mb-2"><i class="bi bi-person-lines-fill text-primary"></i> Generated Bio</label>
                            <div id="aiGeneratedBio" style="background:#f8f9ff; border:1px solid #e0e0ff; border-radius:10px; padding:1rem; font-size:0.95rem; line-height:1.8; color:#333; white-space:pre-wrap;"></div>
                            <button id="copyBioBtn" class="i-btn btn--md info mt-2" style="font-size:0.85rem;">
                                <i class="bi bi-clipboard"></i> Copy Bio to Editor
                            </button>
                        </div>
                        <div class="col-lg-5">
                            <label class="fw-bold mb-2"><i class="bi bi-chat-quote text-purple" style="color:#8b5cf6;"></i> Ready-to-Post Captions</label>
                            <div id="aiCaptionsList" style="display:flex;flex-direction:column;gap:0.6rem;"></div>
                        </div>
                    </div>
                </div>

                {{-- Show existing AI content if any --}}
                @if($mediaKit->ai_generated_bio || $mediaKit->ai_generated_captions)
                    <div style="margin-top:1.5rem;">
                        <hr>
                        <p class="text-muted" style="font-size:0.85rem;"><i class="bi bi-clock-history"></i> Last AI Generated Content:</p>
                        @if($mediaKit->ai_generated_bio)
                            <div style="background:#f8f9ff; border:1px solid #e0e0ff; border-radius:10px; padding:1rem; font-size:0.9rem; line-height:1.8; color:#333; white-space:pre-wrap; margin-top:0.5rem;">{{ $mediaKit->ai_generated_bio }}</div>
                        @endif
                        @if($mediaKit->ai_generated_captions)
                            @php $caps = json_decode($mediaKit->ai_generated_captions, true); @endphp
                            @if(is_array($caps))
                                <div style="margin-top:0.75rem; display:flex; flex-direction:column; gap:0.5rem;">
                                    @foreach($caps as $i => $cap)
                                        <div style="background:#fff; border:1px solid #e0e0ff; border-radius:8px; padding:0.75rem; font-size:0.85rem;">
                                            <strong style="color:#8b5cf6;">Caption {{ $i+1 }}:</strong> {{ $cap }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const btn = document.getElementById('aiGenerateBtn');
    if (!btn) return;

    const mediaKitId = {{ $mediaKit->id }};
    const csrfToken  = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

    btn.addEventListener('click', async function() {
        const prompt = document.getElementById('aiPromptInput').value.trim();
        if (!prompt) {
            alert('Please enter a prompt first.');
            return;
        }

        // Loading state
        document.getElementById('aiBtnText').textContent = 'Generating…';
        document.getElementById('aiIcon').className = 'bi bi-hourglass-split';
        btn.disabled = true;

        try {
            const res = await fetch('{{ route("user.mediakit.ai.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ mediakit_id: mediaKitId, prompt: prompt }),
            });

            const data = await res.json();

            if (!res.ok || data.error) {
                alert(data.error || 'AI generation failed. Please try again.');
                return;
            }

            // Show results
            document.getElementById('aiGeneratedBio').textContent = data.bio;
            const capList = document.getElementById('aiCaptionsList');
            capList.innerHTML = '';
            (data.captions || []).forEach((cap, i) => {
                capList.innerHTML += `
                    <div style="background:#fff;border:1px solid #e0e0ff;border-radius:8px;padding:0.75rem;font-size:0.82rem;line-height:1.6;position:relative;">
                        <span style="position:absolute;top:-8px;left:10px;background:#8b5cf6;color:#fff;width:18px;height:18px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.65rem;font-weight:700;">${i+1}</span>
                        ${cap}
                        <button onclick="navigator.clipboard.writeText(this.parentElement.innerText.replace('${i+1}','').trim())" style="position:absolute;top:6px;right:8px;background:none;border:1px solid #ccc;border-radius:4px;cursor:pointer;font-size:0.7rem;padding:1px 6px;color:#666;">Copy</button>
                    </div>`;
            });
            document.getElementById('aiResultsArea').style.display = 'block';

            // Update prompts remaining
            if (data.prompts_left <= 0) {
                btn.disabled = true;
                document.getElementById('aiBtnText').textContent = 'No Prompts Left';
            } else {
                document.querySelectorAll('.card-title span').forEach(el => {
                    if (el.textContent.includes('prompts remaining')) {
                        el.textContent = data.prompts_left + '/5 prompts remaining';
                    }
                });
            }

        } catch(e) {
            alert('Network error. Please try again.');
        } finally {
            if (btn.disabled !== true || (btn.getAttribute('data-exhausted'))) {
                document.getElementById('aiBtnText').textContent = 'Generate with AI';
                document.getElementById('aiIcon').className = 'bi bi-stars';
                btn.disabled = false;
            }
        }
    });

    // Copy bio to textarea
    const copyBioBtn = document.getElementById('copyBioBtn');
    if (copyBioBtn) {
        copyBioBtn.addEventListener('click', function() {
            const bio = document.getElementById('aiGeneratedBio').textContent;
            document.getElementById('bio').value = bio;
            copyBioBtn.innerHTML = '<i class="bi bi-check2"></i> Copied!';
            setTimeout(() => { copyBioBtn.innerHTML = '<i class="bi bi-clipboard"></i> Copy Bio to Editor'; }, 2000);
        });
    }
})();
</script>

@endsection

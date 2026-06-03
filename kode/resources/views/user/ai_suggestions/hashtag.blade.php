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
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('Describe your post or image')}}</label>
                            <textarea class="form-control capsuled" name="prompt" rows="4" placeholder="{{translate('e.g. A sunny day at the beach in Miami wearing a yellow dress...')}}"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('Target Platform')}}</label>
                            <select class="form-select capsuled" name="platform">
                                <option value="instagram">Instagram</option>
                                <option value="tiktok">TikTok</option>
                                <option value="twitter">X (Twitter)</option>
                                <option value="linkedin">LinkedIn</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">{{translate('Number of Hashtags')}}</label>
                            <input type="number" class="form-control capsuled" name="count" value="15" min="1" max="30">
                        </div>
                        <button type="button" class="btn btn--primary capsuled px-4 fw-bold w-100" onclick="alert('{{translate('API integration required. Please configure OpenAI keys first.')}}')">
                            <i class="bi bi-magic me-2"></i> {{translate('Generate Hashtags')}}
                        </button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light-soft border p-4 h-100" style="border-radius: 16px;">
                        <h6 class="fw-bold mb-3"><i class="bi bi-card-text me-2 text-primary"></i>{{translate('Generated Output')}}</h6>
                        <div class="text-center py-5 opacity-50">
                            <i class="bi bi-stars fs-1 mb-2"></i>
                            <p class="fs-14">{{translate('Your generated hashtags will appear here.')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

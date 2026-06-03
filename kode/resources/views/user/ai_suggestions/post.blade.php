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
                    <p class="mb-0 text-muted">{{translate('Overcome writer\'s block. Let AI write engaging captions and full posts for you.')}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('What is the post about?')}}</label>
                            <textarea class="form-control capsuled" name="prompt" rows="4" placeholder="{{translate('e.g. Announcing our new summer clothing line launch on Friday...')}}"></textarea>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{translate('Tone of Voice')}}</label>
                                <select class="form-select capsuled" name="tone">
                                    <option value="casual">Casual & Friendly</option>
                                    <option value="professional">Professional</option>
                                    <option value="humorous">Humorous / Funny</option>
                                    <option value="persuasive">Persuasive / Sales</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{translate('Content Length')}}</label>
                                <select class="form-select capsuled" name="length">
                                    <option value="short">Short (1-2 sentences)</option>
                                    <option value="medium">Medium (1 paragraph)</option>
                                    <option value="long">Long (Detailed)</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" id="addEmojis" checked>
                            <label class="form-check-label fw-bold fs-14" for="addEmojis">
                                {{translate('Include Emojis')}}
                            </label>
                        </div>
                        <button type="button" class="btn btn--primary capsuled px-4 fw-bold w-100" onclick="alert('{{translate('API integration required. Please configure OpenAI keys first.')}}')">
                            <i class="bi bi-magic me-2"></i> {{translate('Generate Content')}}
                        </button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light-soft border p-4 h-100" style="border-radius: 16px;">
                        <h6 class="fw-bold mb-3"><i class="bi bi-card-text me-2 text-primary"></i>{{translate('Generated Output')}}</h6>
                        <div class="text-center py-5 opacity-50">
                            <i class="bi bi-robot fs-1 mb-2"></i>
                            <p class="fs-14">{{translate('Your generated post captions will appear here.')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

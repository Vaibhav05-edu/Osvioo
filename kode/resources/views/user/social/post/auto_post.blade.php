@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg--danger-soft text--danger" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-send-check fs-24"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">{{translate('Instagram Auto Post Workflow')}}</h4>
                        <p class="mb-0 text-muted">{{translate('Set up fully automated posting queues and RSS feeds directly to your Instagram.')}}</p>
                    </div>
                </div>
                <a href="{{route('user.social.post.create')}}" class="btn btn--danger capsuled px-4 fw-bold">
                    <i class="bi bi-plus-circle me-2"></i> {{translate('Go to Scheduler')}}
                </a>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="border rounded-3 p-4 h-100 bg-light-soft hover-shadow transition-all">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-rss text-danger me-2"></i>{{translate('RSS to Auto-Post')}}</h5>
                            <span class="badge bg-secondary capsuled">{{translate('Coming Soon')}}</span>
                        </div>
                        <p class="text-muted fs-14 mb-4">{{translate('Automatically fetch content from your blog or news feed and post it to Instagram with AI-generated captions.')}}</p>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{translate('RSS Feed URL')}}</label>
                            <input type="text" class="form-control capsuled" placeholder="https://yourblog.com/feed" disabled>
                        </div>
                        <button class="btn btn-outline-danger w-100 capsuled fw-bold" disabled>{{translate('Connect Feed')}}</button>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="border rounded-3 p-4 h-100 bg-light-soft hover-shadow transition-all">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="fw-bold mb-0"><i class="bi bi-images text-primary me-2"></i>{{translate('Bulk Queue Folder')}}</h5>
                            <span class="badge bg-secondary capsuled">{{translate('Coming Soon')}}</span>
                        </div>
                        <p class="text-muted fs-14 mb-4">{{translate('Upload a batch of images/videos and let our system automatically distribute them across your optimal posting times.')}}</p>
                        
                        <div class="border-dashed rounded-3 p-4 text-center bg-white mb-3" style="border: 2px dashed #ccc;">
                            <i class="bi bi-cloud-arrow-up text-muted fs-1 mb-2 d-block"></i>
                            <span class="text-muted fs-14">{{translate('Drag and drop files or click to browse')}}</span>
                        </div>
                        <button class="btn btn-outline-primary w-100 capsuled fw-bold" disabled>{{translate('Upload Media')}}</button>
                    </div>
                </div>
            </div>

            <div class="mt-4 alert alert-info border-0 rounded-3 d-flex align-items-center gap-3">
                <i class="bi bi-info-circle-fill fs-4"></i>
                <div>
                    <strong>{{translate('Did you know?')}}</strong> {{translate('You can already schedule individual posts in advance using our Post Scheduler.')}} 
                    <a href="{{route('user.social.post.create')}}" class="alert-link text-decoration-underline">{{translate('Try it now')}}</a>.
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

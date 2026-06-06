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

@endsection

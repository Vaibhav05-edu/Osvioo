@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="i-card-md">
                <h4 class="card-title">
                    <i class="bi bi-stars text-warning"></i> {{translate('Create Media Kit')}}
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


                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

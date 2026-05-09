@extends('layouts.master')

@section('content')

@php
    $authContent     =  get_content("content_authentication_section")->first();
    $loginAttributes =  json_decode(site_settings('login_with'),true);
    $socialProviders =  json_decode(site_settings('social_login_with'),true);
    $mediums = [];
    foreach($socialProviders as $key=>$login_medium){
        if($login_medium['status'] == App\Enums\StatusEnum::true->status()){
            array_push($mediums, str_replace('_oauth',"",$key));
        }
    }

    $otpFlag =  App\Enums\StatusEnum::false->status();
    if( is_array($loginAttributes) &&
        count($loginAttributes) == 1 &&
        in_array('phone',$loginAttributes) &&
        site_settings('sms_otp_verification') == App\Enums\StatusEnum::true->status() ){

        $otpFlag = App\Enums\StatusEnum::true->status();
    }
    $socialAuth           =  (site_settings('social_login'));
    $googleCaptcha        =  (object) json_decode(site_settings("google_recaptcha"));
    $captcha              =  (site_settings('captcha_with_login'));
    $defaultcaptcha       =  (site_settings('default_recaptcha'));


@endphp


<section class="auth-new">
    <div class="container-fluid px-0">
        <div class="auth-wrapper-new">
            <div class="row g-0">
                <div class="col-xl-7 col-lg-7 d-flex align-items-center justify-content-center bg-white">
                    <div class="auth-right-content py-5 px-4 px-md-5 w-100" style="max-width: 600px;">
                        <div class="text-center mb-5">
                            <a href="{{route('home')}}" class="d-inline-block mb-4">
                                <span class="socialyt-logo-script fs-1 text-royal-blue">Socialyt</span>
                            </a>
                            <h2 class="fw-black display-5 mb-2">{{trans("default.login_page_title")}}</h2>
                            <p class="text-muted fs-5">{{translate(@$authContent->value->description) }}</p>
                        </div>

                        <form class="auth-form-new" action="{{route('auth.authenticate')}}" method="POST" id="login-form">
                            @csrf

                            <div class="mb-4">
                                <label for="login_key" class="form-label fw-bold text-dark">
                                    {{ucfirst(str_replace("_"," ",implode(" / ",$loginAttributes)))}} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group-custom">
                                    <input required type="text" name="login_data" id="login_key" @if(is_demo()) value="demo@beepost.com" @endif  placeholder='{{@ucWords(str_replace("_"," ",implode(" / ",$loginAttributes)))}}' class="form-control-custom" />
                                    <span class="input-icon"><i class="bi bi-person"></i></span>
                                </div>
                            </div>

                            @if($otpFlag == App\Enums\StatusEnum::false->status())
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold text-dark">
                                        {{translate('Password')}} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group-custom">
                                        <input name="password" id="password" required type="password" @if(is_demo()) value="123123" @endif  placeholder="{{translate('Password')}}" class="form-control-custom toggle-input" />
                                        <span class="input-icon toggle-password"><i class="bi bi-eye toggle-icon"></i></span>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div class="form-check custom-check">
                                    <input class="form-check-input" type="checkbox" id="remember" value="1" name="remember_me">
                                    <label class="form-check-label text-muted" for="remember">{{translate("Remember me")}}</label>
                                </div>
                                <a href="{{route('auth.password.request')}}" class="text-royal-blue fw-bold text-decoration-none">{{translate("Forgot password")}}?</a>
                            </div>

                            <div class="mb-4">
                                <button type="submit" class="btn btn-royal-blue-gradient w-100 py-3 rounded-pill fw-black fs-5">
                                    {{trans("default.login_btn_text")}}
                                </button>
                            </div>
                        </form>

                        @if($socialAuth == App\Enums\StatusEnum::true->status())
                            <div class="text-center my-4 position-relative">
                                <hr class="opacity-10">
                                <span class="bg-white px-3 text-muted small position-absolute top-50 start-50 translate-middle">OR CONTINUE WITH</span>
                            </div>

                            <div class="row g-3">
                                @foreach($mediums as $medium)
                                    <div class="col-6">
                                        <a href="{{route('auth.social.login', $medium)}}" class="btn btn-outline-light border text-dark w-100 py-2 d-flex align-items-center justify-content-center gap-2">
                                            <i class="bi bi-{{$medium}} text-{{$medium}}"></i> {{$medium}}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="text-center mt-5">
                            <p class="text-muted">
                                {{translate("Don't have an account")}}? 
                                <a href="{{route('auth.register')}}" class="text-royal-blue fw-black text-decoration-none ms-1">{{translate("Sign Up")}}</a>
                            </p>
                        </div>
                    </div>
                </div>
                @include("user.partials.auth_slider")
            </div>
        </div>
    </div>
</section>

<style>
    .text-royal-blue { color: #0052FF !important; }
    .fw-black { font-weight: 900; }
    
    .auth-new { background-color: #f8f9fa; min-height: 100vh; }
    
    .form-control-custom {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border: 2px solid #eee;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        outline: none;
    }
    
    .form-control-custom:focus {
        border-color: #0052FF;
        box-shadow: 0 0 15px rgba(0, 82, 255, 0.1);
    }
    
    .input-group-custom { position: relative; }
    
    .input-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        font-size: 1.2rem;
    }
    
    .btn-royal-blue-gradient {
        background: linear-gradient(90deg, #0052FF 0%, #0084FF 100%);
        color: white;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 82, 255, 0.3);
        transition: all 0.3s ease;
    }
    
    .btn-royal-blue-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(0, 82, 255, 0.4);
        color: white;
    }

    .custom-check .form-check-input:checked {
        background-color: #0052FF;
        border-color: #0052FF;
    }
    
    .socialyt-logo-script {
        font-family: 'Caveat', cursive !important;
        font-weight: 700;
    }
</style>
        </div>
      </div>
    </div>
  </section>


@endsection




@if($captcha  == App\Enums\StatusEnum::true->status() && $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())

    @push('script-include')
        <script nonce="{{ csp_nonce() }}" src="https://www.google.com/recaptcha/api.js"></script>
    @endpush

@endif


@push('script-push')

  @if($captcha  == App\Enums\StatusEnum::true->status() &&    $defaultcaptcha != App\Enums\StatusEnum::true->status() && $googleCaptcha->status == App\Enums\StatusEnum::true->status())

      <script nonce="{{ csp_nonce() }}">
          'use strict'
          function onSubmit(token) {
            document.getElementById("login-form").submit();
          }
      </script>

    @endif



@endpush

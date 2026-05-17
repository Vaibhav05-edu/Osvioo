@extends('layouts.master')
@section('content')

@include("frontend.partials.breadcrumb")

<section class="pages-wrapper pb-110" style="font-family: 'Outfit', sans-serif !important; background: #fbfbfd; padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card p-5 border-0 shadow-sm" style="background: white; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.02) !important;">
                    
                    <h2 class="fw-bold mb-4" style="color: #111; letter-spacing: -1px;">{{ translate('User Data Deletion Instructions') }}</h2>
                    <p class="text-muted mb-5 fs-15">{{ translate('Compliance: GDPR, CCPA, and Meta Platform Policies') }}</p>

                    <div class="content-section mb-5">
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Osivoo respects your privacy and is fully committed to user data control and GDPR compliance. We provide simple, instant methods for users to request and execute the deletion of all personal data, social profile tokens, posting history, and automation logs stored on our platform.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5" style="background: rgba(239, 68, 68, 0.03); border-left: 4px solid #ef4444; border-radius: 12px; padding: 25px;">
                        <h5 class="fw-bold mb-2 text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>{{ translate('Important Notice') }}</h5>
                        <p class="text-muted mb-0 fs-14">
                            {{ translate('Once your account or platform connection is deleted, all stored access tokens, trigger words, webhook logs, and automated message histories are permanently erased from our databases and cannot be restored under any circumstances.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-4" style="color: #2b2b2b;">{{ translate('How to Delete Your Account & Associated Data') }}</h4>
                        
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="step-badge d-flex align-items-center justify-content-center fw-bold text-white" style="width: 32px; height: 32px; background: #5D5AF1; border-radius: 50%; flex-shrink: 0; font-size: 14px;">1</div>
                            <div>
                                <h6 class="fw-bold mb-1 fs-16">{{ translate('Option A: Self-Service Deletion via Settings (Instant)') }}</h6>
                                <p class="text-muted fs-14 mb-0">
                                    {{ translate('Login to your Osivoo Dashboard, navigate to') }} <strong>{{ translate('Profile Settings') }}</strong>, {{ translate('click the') }} <strong>{{ translate('Delete Account') }}</strong> {{ translate('tab, tick the confirmation checkbox, and click "Permanently Delete My Account." All data is instantly erased from our MySQL server.') }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="step-badge d-flex align-items-center justify-content-center fw-bold text-white" style="width: 32px; height: 32px; background: #5D5AF1; border-radius: 50%; flex-shrink: 0; font-size: 14px;">2</div>
                            <div>
                                <h6 class="fw-bold mb-1 fs-16">{{ translate('Option B: Disconnect Specific Social Accounts') }}</h6>
                                <p class="text-muted fs-14 mb-0">
                                    {{ translate('If you only want to remove Facebook/Instagram integration data without deleting your Osivoo login, go to the') }} <strong>{{ translate('Social Accounts') }}</strong> {{ translate('section, find your profile connection card, and click') }} <strong>{{ translate('Delete') }}</strong>. {{ translate('This will revoke our Meta OAuth access tokens and wipe connection logs instantly.') }}
                                </p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="step-badge d-flex align-items-center justify-content-center fw-bold text-white" style="width: 32px; height: 32px; background: #5D5AF1; border-radius: 50%; flex-shrink: 0; font-size: 14px;">3</div>
                            <div>
                                <h6 class="fw-bold mb-1 fs-16">{{ translate('Option C: Submit a Written Request (1-2 Days)') }}</h6>
                                <p class="text-muted fs-14 mb-0">
                                    {{ translate('If you cannot access your account dashboard, send an email to') }} <a href="mailto:support@osivoo.com" class="text-primary fw-bold">support@osivoo.com</a> {{ translate('with the subject line "Request for Data Deletion." Our support team will process your request, verify identity, and wipe all databases within 24 to 48 hours.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="content-section mb-4">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">{{ translate('Meta Platform Connection Removal') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Additionally, you can revoke our access directly through Facebook Settings at any time:') }}
                        </p>
                        <ol class="text-muted fs-15 ps-4 mb-4" style="line-height: 1.8;">
                            <li>{{ translate('Go to your Facebook Profile\'s "Settings & Privacy" > "Settings".') }}</li>
                            <li>{{ translate('Scroll down and click on "Apps and Websites".') }}</li>
                            <li>{{ translate('Find "Osivoo" (our app) and click the "Remove" button next to it.') }}</li>
                        </ol>
                        <p class="text-muted fs-15 mb-0">
                            {{ translate('This directly stops Meta webhook subscriptions and terminates connection access to Osivoo.') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

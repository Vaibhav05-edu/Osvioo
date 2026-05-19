@extends('layouts.master')
@section('content')

@include("frontend.partials.breadcrumb")

<section class="pages-wrapper pb-110" style="font-family: 'Outfit', sans-serif !important; background: #fbfbfd; padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card p-5 border-0 shadow-sm" style="background: white; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.02) !important;">
                    
                    <h2 class="fw-bold mb-4" style="color: #111; letter-spacing: -1px;">{{ translate('Terms & Conditions') }}</h2>
                    <p class="text-muted mb-5 fs-15">{{ translate('Effective Date: May 18, 2026') }}</p>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">1. {{ translate('Acceptance of Terms') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('By accessing, signing up for, or using Osvioo ("we," "our," or "us") and all related services, you agree to be bound by these Terms & Conditions. These terms constitute a legally binding agreement between you and Osvioo. If you do not agree to all of these terms, you are prohibited from using the platform and must immediately disconnect all integrated social media accounts.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">2. {{ translate('Description of Services') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Osvioo provides a premium SaaS automation and scheduling platform designed to connect securely with Meta APIs (specifically Instagram and Facebook) to manage direct messaging (DM) automations, post scheduling, and comment auto-replies. All features are provided to help Creators, Brands, and Agencies scale organic engagement lawfully and securely.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">3. {{ translate('User Account & Security') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('To use Osvioo, you must register and authenticate your identity. You are solely responsible for:') }}
                        </p>
                        <ul class="text-muted fs-15 ps-4" style="list-style-type: square; line-height: 1.8;">
                            <li><strong>{{ translate('Account Details:') }}</strong> {{ translate('Providing accurate, current, and truthful information during registration.') }}</li>
                            <li><strong>{{ translate('Credential Security:') }}</strong> {{ translate('Maintaining the absolute confidentiality of your login passwords and account keys.') }}</li>
                            <li><strong>{{ translate('Integration Access:') }}</strong> {{ translate('Authorizing social connections securely via standard Meta OAuth dialogs. You are responsible for all actions executed through your access tokens.') }}</li>
                        </ul>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">4. {{ translate('Acceptable Use & Anti-Spam Policy') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('We promote organic growth and highly ethical interactions. By using Osvioo, you strictly covenant that you will not:') }}
                        </p>
                        <ul class="text-muted fs-15 ps-4" style="list-style-type: square; line-height: 1.8;">
                            <li>{{ translate('Use the Auto DM system to distribute unsolicited marketing messages (Spam), misleading promotions, or phishing links.') }}</li>
                            <li>{{ translate('Send or post any content that is illegal, defamatory, abusive, offensive, or violates the intellectual property of any third party.') }}</li>
                            <li>{{ translate('Circumvent or attempt to bypass Meta rate limits, safety restrictions, or standard API usage conditions.') }}</li>
                        </ul>
                        <p class="text-muted leading-relaxed fs-15 mt-3">
                            {{ translate('Violating these guidelines will result in the immediate and permanent termination of your account without a refund.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">5. {{ translate('Subscribing, Payments & Refunds') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Osvioo offers monthly and annual subscription plans. By subscribing, you agree to our automated recurring billing terms. Subscription fees are processed through secure gateways, and you authorize billing of the specified charges. Cancellation can be performed at any time via your user dashboard, and access will remain active until the end of the current billing cycle.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">6. {{ translate('Limitation of Liability') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Osvioo is built directly on the official and secure Meta Developer API framework. However, you acknowledge that we are not responsible for any modifications, limitations, rate changes, or downtime imposed by Meta. Osvioo, its employees, and affiliates will not be liable for any direct, indirect, incidental, or consequential damages resulting from account actions, suspension by third-party platforms, or loss of access to automated services.') }}
                        </p>
                    </div>

                    <div class="content-section mb-4">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">7. {{ translate('Governing Law & Contact') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('These terms shall be governed by and construed in accordance with the laws governing digital services and platform terms. If you have any inquiries, suggestions, or complaints regarding these Terms, please contact us at') }} <a href="mailto:support@osvioo.com" class="text-primary fw-bold">support@osvioo.com</a>.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

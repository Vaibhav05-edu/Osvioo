@extends('layouts.master')
@section('content')

@include("frontend.partials.breadcrumb")

<section class="pages-wrapper pb-110" style="font-family: 'Outfit', sans-serif !important; background: #fbfbfd; padding-top: 80px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card p-5 border-0 shadow-sm" style="background: white; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.02) !important;">
                    
                    <h2 class="fw-bold mb-4" style="color: #111; letter-spacing: -1px;">{{ translate('Privacy Policy') }}</h2>
                    <p class="text-muted mb-5 fs-15">{{ translate('Effective Date: May 18, 2026') }}</p>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">1. {{ translate('Introduction') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Welcome to Osvioo ("we," "our," or "us"). We are dedicated to protecting your personal data and your privacy. This Privacy Policy explains how we collect, use, process, and protect your information when you connect and use our platform, including our Meta and Instagram API-powered Auto DM automation services.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">2. {{ translate('Information We Collect') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('When you authenticate your social platforms (such as Facebook or Instagram) with Osvioo, we collect and store certain data to provide our automation and posting services:') }}
                        </p>
                        <ul class="text-muted fs-15 ps-4" style="list-style-type: square; line-height: 1.8;">
                            <li><strong>{{ translate('Social Profile Info:') }}</strong> {{ translate('Your name, profile picture, platform account ID, and platform usernames.') }}</li>
                            <li><strong>{{ translate('Access Tokens:') }}</strong> {{ translate('OAuth tokens provided by Meta to securely execute posting, direct messaging, and comment actions on your behalf.') }}</li>
                            <li><strong>{{ translate('Interaction Data:') }}</strong> {{ translate('Incoming Direct Messages and comments containing trigger keywords, so that our Auto DM system can process and send the correct automated reply.') }}</li>
                            <li><strong>{{ translate('Usage Logs:') }}</strong> {{ translate('Information about successful and failed automation flows to display on your Insights Dashboard.') }}</li>
                        </ul>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">3. {{ translate('How We Use Your Information') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('We strictly use your information to operate and optimize the Osvioo service. Specifically, we use it to:') }}
                        </p>
                        <ul class="text-muted fs-15 ps-4" style="list-style-type: square; line-height: 1.8;">
                            <li>{{ translate('Enable OAuth login and manage connected social accounts.') }}</li>
                            <li>{{ translate('Execute scheduled posts, reels, and stories to your connected accounts.') }}</li>
                            <li>{{ translate('Process incoming webhooks from Meta to trigger automated Direct Messages.') }}</li>
                            <li>{{ translate('Provide real-time analytics and tracking logs on your personal user dashboard.') }}</li>
                            <li>{{ translate('Ensure compliance with Meta Developer Policies.') }}</li>
                        </ul>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">4. {{ translate('Data Security & Integrity') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('Your security is our absolute priority. We employ advanced technical measures (including secure OAuth mechanisms, HTTPS encryption, and database access authorization controls) to prevent unauthorized access, alteration, disclosure, or destruction of your credentials and data.') }}
                        </p>
                    </div>

                    <div class="content-section mb-5">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">5. {{ translate('How to Delete Your Data') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('We believe in complete data ownership. You have the right to request deletion of your account and all associated social integration data at any time. You can do this by:') }}
                        </p>
                        <ul class="text-muted fs-15 ps-4" style="list-style-type: square; line-height: 1.8;">
                            <li>{{ translate('Going to your profile dashboard settings page under the "Delete Account" tab, checking the confirmation, and permanently deleting your account instantly.') }}</li>
                            <li>{{ translate('Disconnecting individual social accounts in the "Social Accounts" settings panel, which immediately revokes Meta access tokens and deletes all related connection keys.') }}</li>
                            <li>{{ translate('Visiting our') }} <a href="{{ route('page', 'data-deletion') }}" class="text-primary fw-bold">{{ translate('Data Deletion Instructions') }}</a> {{ translate('page for step-by-step procedures.') }}</li>
                        </ul>
                    </div>

                    <div class="content-section mb-4">
                        <h4 class="fw-bold mb-3" style="color: #2b2b2b;">6. {{ translate('Contact Us') }}</h4>
                        <p class="text-muted leading-relaxed fs-15">
                            {{ translate('If you have any questions or feedback regarding this Privacy Policy, please feel free to reach out to our privacy compliance officer at') }} <a href="mailto:support@osvioo.com" class="text-primary fw-bold">support@osvioo.com</a>.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection

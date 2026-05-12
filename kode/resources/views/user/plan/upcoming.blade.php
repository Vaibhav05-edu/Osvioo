@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-9">
        <div class="i-card h-100 p-0 overflow-hidden" style="border-radius: 24px;">
            <div class="p-5 text-center bg--primary-soft" style="border-bottom: 2px dashed #eef0f2;">
                <div class="icon-box mx-auto mb-4" style="width: 80px; height: 80px; background: #fff; border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 20px rgba(0,0,0,0.05);">
                    <i class="bi bi-calendar-check text--primary fs-40"></i>
                </div>
                <h3 class="fw-bold mb-1">{{translate('Upcoming Billing Details')}}</h3>
                <p class="text-muted">{{translate('Scheduled for next billing cycle')}}</p>
                <div class="badge bg--info-soft text--info capsuled px-3 py-2 mt-2">
                    <i class="bi bi-arrow-repeat"></i> {{translate('Recurring Payment')}}
                </div>
            </div>

            <div class="p-5">
                <div class="billing-details mb-5">
                    <h5 class="card--title-sm mb-4 border-bottom pb-2">{{translate('Breakdown')}}</h5>
                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-sm bg--light circle"><i class="bi bi-box"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Pro Influencer Plan</h6>
                                <p class="mb-0 text-muted fs-12">{{translate('Monthly Subscription')}}</p>
                            </div>
                        </div>
                        <span class="fw-bold fs-16">$49.99</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-sm bg--light circle"><i class="bi bi-plus-lg"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Extra Social Accounts (+5)</h6>
                                <p class="mb-0 text-muted fs-12">{{translate('Plan Add-on')}}</p>
                            </div>
                        </div>
                        <span class="fw-bold fs-16">$14.99</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-sm bg--light circle"><i class="bi bi-stars"></i></div>
                            <div>
                                <h6 class="mb-0 fw-bold">Advanced AI Writing Assistant</h6>
                                <p class="mb-0 text-muted fs-12">{{translate('Plan Add-on')}}</p>
                            </div>
                        </div>
                        <span class="fw-bold fs-16">$9.99</span>
                    </div>

                    <div class="mt-4 p-4 rounded-4 bg--light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 fw-bold text-uppercase fs-14">{{translate('Total Due on')}} 01 Feb, 2024</h5>
                            <h4 class="mb-0 fw-bold text--primary">$74.97</h4>
                        </div>
                    </div>
                </div>

                <div class="payment-method-card p-4 border rounded-4 mb-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="mb-0 fw-bold">{{translate('Payment Method')}}</h6>
                        <a href="{{route('user.profile')}}" class="text--primary fs-14 fw-bold">{{translate('Update')}}</a>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 50px; height: 32px; background: #000; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; font-weight: bold;">VISA</div>
                        <div>
                            <p class="mb-0 fw-bold">Visa Ending in 4242</p>
                            <p class="mb-0 text-muted fs-12">Exp: 12/26</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3">
                    <button class="i-btn btn--primary btn--lg w-100 capsuled">{{translate('Pay Early')}}</button>
                    <button class="i-btn btn--light btn--lg w-100 capsuled">{{translate('Pause Subscription')}}</button>
                </div>
                <p class="text-center mt-4 text-muted fs-12">
                    {{translate('By clicking Pay Early, your next cycle will start immediately.')}}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

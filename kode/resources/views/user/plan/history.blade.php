@extends('layouts.master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="i-card h-100">
            <div class="card-header d-flex align-items-center justify-content-between mb-20">
                <h4 class="card--title">{{translate('Subscription History')}}</h4>
                <p class="text-muted fs-14">{{translate('Track your journey as an influencer on Osvioo.')}}</p>
            </div>

            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table border-0 custom-table">
                        <thead>
                            <tr>
                                <th>{{translate('Plan')}}</th>
                                <th>{{translate('Period')}}</th>
                                <th>{{translate('Add-ons Used')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- This would be a loop in the real app --}}
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fs-18 text--primary"><i class="bi bi-box"></i></span>
                                        <div class="fw-bold">Standard Creator</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fs-14">01 Jan, 2024 - 01 Feb, 2024</div>
                                </td>
                                <td>
                                    <span class="badge border text-dark fs-11">AI Assistant</span>
                                    <span class="badge border text-dark fs-11">+2 Accounts</span>
                                </td>
                                <td><span class="badge bg--light text-dark">{{translate('Expired')}}</span></td>
                                <td>$29.99</td>
                                <td>
                                    <button class="icon-btn btn--light circle shadow-none"><i class="bi bi-download"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="fs-18 text--primary"><i class="bi bi-box"></i></span>
                                        <div class="fw-bold">Basic Creator</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fs-14">01 Dec, 2023 - 01 Jan, 2024</div>
                                </td>
                                <td>
                                    <span class="text-muted fs-12">{{translate('None')}}</span>
                                </td>
                                <td><span class="badge bg--light text-dark">{{translate('Expired')}}</span></td>
                                <td>$9.99</td>
                                <td>
                                    <button class="icon-btn btn--light circle shadow-none"><i class="bi bi-download"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

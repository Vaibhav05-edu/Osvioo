@extends('layouts.master')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="glass-card p-4 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box bg--primary-soft text--primary" style="width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-bar-chart-line fs-24"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">{{translate('Instagram Insights')}}</h4>
                        <p class="mb-0 text-muted">{{translate('Deep dive into your account analytics and audience demographics.')}}</p>
                    </div>
                </div>
                <button class="btn btn--primary capsuled px-4 fw-bold" id="btn-sync-data">
                    <i class="bi bi-arrow-repeat me-2"></i> <span>{{translate('Sync Data')}}</span>
                </button>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold">{{translate('Select Account')}}</label>
                    <select class="form-select capsuled" id="account-select">
                        @php
                            $instaAccounts = $accounts->filter(function($acc) {
                                return $acc->platform->slug == 'instagram';
                            });
                        @endphp
                        @if($instaAccounts->count() > 0)
                            @foreach($instaAccounts as $acc)
                                <option value="{{$acc->id}}">{{$acc->name}} ({{$acc->username}})</option>
                            @endforeach
                        @else
                            <option value="">{{translate('No Instagram accounts connected')}}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{translate('Date Range')}}</label>
                    <select class="form-select capsuled" id="date-range-select">
                        <option value="7">Last 7 Days</option>
                        <option value="30">Last 30 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>
                </div>
            </div>

            <div class="row g-4" id="data-container" style="display: none;">
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Accounts Reached')}}</h6>
                        <h3 class="fw-bold mb-1" id="val-reach">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Accounts Engaged')}}</h6>
                        <h3 class="fw-bold mb-1" id="val-engaged">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Total Followers')}}</h6>
                        <h3 class="fw-bold mb-1" id="val-followers">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="p-4 bg-light-soft rounded-3 border h-100 text-center">
                        <h6 class="text-muted fw-bold mb-2">{{translate('Profile Views')}}</h6>
                        <h3 class="fw-bold mb-1" id="val-interactions">0</h3>
                        <p class="fs-12 text-success mb-0"><i class="bi bi-arrow-up-right me-1"></i>0%</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-5 text-center bg-light-soft border rounded-3" id="no-data-alert">
                <i class="bi bi-graph-up text-muted mb-3" style="font-size: 3rem; opacity: 0.5;"></i>
                <h5 class="fw-bold text-dark" id="no-data-title">{{translate('No Data Available')}}</h5>
                <p class="text-muted mb-4" id="no-data-desc">{{translate('Please connect your Instagram Business account and click Sync Data to view charts and demographics.')}}</p>
                <a href="{{route('user.social.account.platform')}}" class="btn btn-outline-dark capsuled px-4 fw-bold">
                    <i class="bi bi-link-45deg me-2"></i> {{translate('Connect Account')}}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script-include')
<script nonce="{{ csp_nonce() }}">
    $(document).ready(function() {
        $('#btn-sync-data').on('click', function() {
            var accountId = $('#account-select').val();
            var days = $('#date-range-select').val();
            var $btn = $(this);
            var $btnIcon = $btn.find('i');

            if(!accountId) {
                toastr.error("{{translate('Please select an Instagram account first')}}");
                return;
            }

            // Loading state
            $btn.prop('disabled', true);
            $btnIcon.removeClass('bi-arrow-repeat').addClass('bi-hourglass-split spinner-border spinner-border-sm');
            $btn.find('span').text("{{translate('Syncing...')}}");

            $.ajax({
                url: "{{ route('user.social.account.insights.sync') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    account_id: accountId,
                    days: days
                },
                success: function(res) {
                    $btn.prop('disabled', false);
                    $btnIcon.addClass('bi-arrow-repeat').removeClass('bi-hourglass-split spinner-border spinner-border-sm');
                    $btn.find('span').text("{{translate('Sync Data')}}");

                    if(res.status) {
                        $('#data-container').show();
                        $('#no-data-alert').hide();

                        $('#val-followers').text(res.data.followers_count.toLocaleString());
                        $('#val-reach').text(res.data.reach.toLocaleString());
                        $('#val-engaged').text(res.data.impressions.toLocaleString()); // using impressions as engaged
                        $('#val-interactions').text(res.data.profile_views.toLocaleString());
                        
                        toastr.success("{{translate('Insights synced successfully')}}");
                    } else {
                        $('#data-container').hide();
                        $('#no-data-alert').show();
                        $('#no-data-title').text("{{translate('Sync Failed')}}");
                        $('#no-data-desc').text(res.message);
                        toastr.error(res.message);
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false);
                    $btnIcon.addClass('bi-arrow-repeat').removeClass('bi-hourglass-split spinner-border spinner-border-sm');
                    $btn.find('span').text("{{translate('Sync Data')}}");
                    
                    toastr.error("{{translate('Something went wrong')}}");
                }
            });
        });
    });
</script>
@endpush

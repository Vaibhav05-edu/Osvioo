@extends('layouts.master')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold mb-0" style="font-family: 'Outfit', sans-serif;">{{translate('Affiliate Dashboard')}}</h3>
</div>

{{-- REFERRAL LINK SECTION --}}
<div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
    <div class="card-body p-4 p-md-5">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h5 class="fw-bold mb-2">{{translate('Your Unique Referral Link')}}</h5>
                <p class="mb-4 text-muted">{{translate('Share this link to earn commissions on every successful signup and purchase.')}}</p>
                
                <div class="input-group" style="background: #f8f9fa; border-radius: 12px; padding: 4px; border: 1px solid #e9ecef;">
                    <input type="text" class="form-control" id="referralLink" value="{{ $referralLink }}" readonly style="background: transparent; border: none; font-size: 1.1rem; color: #495057;">
                    <button class="btn btn-primary" type="button" onclick="copyReferralLink()" style="border-radius: 10px; font-weight: 600;">
                        <i class="bi bi-clipboard me-2"></i>{{translate('Copy Link')}}
                    </button>
                </div>
            </div>
            <div class="col-lg-4 text-center d-none d-lg-block">
                <i class="bi bi-share text-primary" style="font-size: 6rem; opacity: 0.1;"></i>
            </div>
        </div>
    </div>
</div>

{{-- STATS ROW --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-body p-4 text-center">
                <div class="mb-3 mx-auto" style="width: 60px; height: 60px; background: #e0e7ff; color: #4f46e5; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="bi bi-mouse2"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($totalClicks) }}</h3>
                <p class="text-muted mb-0 fw-semibold">{{translate('Total Clicks')}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-body p-4 text-center">
                <div class="mb-3 mx-auto" style="width: 60px; height: 60px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="bi bi-people"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ number_format($totalSignups) }}</h3>
                <p class="text-muted mb-0 fw-semibold">{{translate('Total Signups')}}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
            <div class="card-body p-4 text-center">
                <div class="mb-3 mx-auto" style="width: 60px; height: 60px; background: #fef3c7; color: #d97706; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <h3 class="fw-bold mb-1">{{ session()->get('currency')?->symbol }}{{ number_format($totalEarnings, 2) }}</h3>
                <p class="text-muted mb-3 fw-semibold">{{translate('Total Earnings')}}</p>
                <a href="{{ route('user.withdraw.create') }}" class="btn btn-sm btn-outline-warning w-100 fw-bold capsuled" style="color: #d97706; border-color: #d97706;">
                    <i class="bi bi-cash-stack me-1"></i> {{translate('Withdraw Earnings')}}
                </a>
            </div>
        </div>
    </div>
</div>

{{-- EARNINGS HISTORY --}}
<div class="card border-0 shadow-sm" style="border-radius: 16px;">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
        <h5 class="fw-bold mb-0">{{translate('Recent Earnings')}}</h5>
    </div>
    <div class="card-body p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start">{{translate('Date')}}</th>
                        <th class="border-0">{{translate('Referred User')}}</th>
                        <th class="border-0">{{translate('Amount')}}</th>
                        <th class="border-0 rounded-end">{{translate('Details')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="text-muted">{{ $log->created_at->format('M d, Y h:i A') }}</td>
                        <td class="fw-semibold">{{ $log->referral?->name ?? 'Unknown' }}</td>
                        <td class="fw-bold text-success">+{{ session()->get('currency')?->symbol }}{{ number_format($log->commission_amount, 2) }}</td>
                        <td class="text-muted">{{ $log->note }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <div class="text-muted mb-3"><i class="bi bi-inbox fs-1"></i></div>
                            <h6>{{translate('No earnings yet')}}</h6>
                            <p class="mb-0" style="font-size: 0.9rem;">{{translate('Start sharing your link to earn!')}}</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($logs->hasPages())
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@push('script-push')
<script>
    function copyReferralLink() {
        var copyText = document.getElementById("referralLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        
        try {
            navigator.clipboard.writeText(copyText.value).then(function() {
                if (typeof toastr !== 'undefined') {
                    toastr.success("{{translate('Referral link copied to clipboard!')}}");
                } else {
                    alert("{{translate('Referral link copied to clipboard!')}}");
                }
            }).catch(function(err) {
                document.execCommand("copy");
                if (typeof toastr !== 'undefined') {
                    toastr.success("{{translate('Referral link copied to clipboard!')}}");
                } else {
                    alert("{{translate('Referral link copied to clipboard!')}}");
                }
            });
        } catch(e) {
            document.execCommand("copy");
            if (typeof toastr !== 'undefined') {
                toastr.success("{{translate('Referral link copied to clipboard!')}}");
            } else {
                alert("{{translate('Referral link copied to clipboard!')}}");
            }
        }
    }
</script>
@endpush

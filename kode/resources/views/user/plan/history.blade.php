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
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Action')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subscriptions as $sub)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fs-18 text--primary"><i class="bi bi-box"></i></span>
                                            <div class="fw-bold">{{ $sub->package->name ?? '-' }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fs-14">
                                            {{ $sub->created_at ? $sub->created_at->format('d M, Y') : '-' }}
                                            @if($sub->expired_at)
                                                &ndash; {{ \Carbon\Carbon::parse($sub->expired_at)->format('d M, Y') }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $statusVal = $sub->status;
                                        @endphp
                                        @if($statusVal == 1)
                                            <span class="badge bg--success-soft text--success capsuled">{{translate('Running')}}</span>
                                        @elseif($statusVal == 3)
                                            <span class="badge bg--danger-soft text--danger capsuled">{{translate('Expired')}}</span>
                                        @else
                                            <span class="badge bg--warning-soft text--warning capsuled">{{translate('Inactive')}}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ site_settings('base_currency_symbol') ?? '$' }}{{ number_format($sub->price ?? 0, 2) }}
                                    </td>
                                    <td>
                                        @if($sub->invoice_uid ?? false)
                                            <a href="{{ route('user.invoice.download', $sub->invoice_uid) }}"
                                               class="icon-btn btn--primary circle shadow-none"
                                               title="{{ translate('Download Invoice') }}">
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <button class="icon-btn circle shadow-none" disabled title="{{ translate('No invoice available') }}" style="opacity:0.4; cursor:not-allowed;">
                                                <i class="bi bi-download"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="opacity-50 mb-2">
                                            <i class="bi bi-receipt fs-1"></i>
                                        </div>
                                        <p class="text-muted mb-0">{{translate('No subscription history found.')}}</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($subscriptions->hasPages())
                    <div class="mt-4 px-3">
                        {{ $subscriptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

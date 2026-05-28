@extends('admin.layouts.master')

@section('content')

<style>
    .badge-type-admin  { background: #6a3be3; color:#fff; font-size:0.72rem; padding:2px 8px; border-radius:50px; }
    .badge-type-brand  { background: #0ea5e9; color:#fff; font-size:0.72rem; padding:2px 8px; border-radius:50px; }
    .badge-paid        { background: #d1fae5; color:#059669; border-radius:50px; padding:3px 10px; font-size:0.78rem; font-weight:700; }
    .badge-part_paid   { background: #e0f2fe; color:#0284c7; border-radius:50px; padding:3px 10px; font-size:0.78rem; font-weight:700; }
    .badge-unpaid      { background: #fef3c7; color:#b45309; border-radius:50px; padding:3px 10px; font-size:0.78rem; font-weight:700; }
    .wm-badge-approved { background: #d1fae5; color:#059669; border-radius:50px; padding:3px 9px; font-size:0.75rem; font-weight:600; }
    .wm-badge-pending  { background: #fef3c7; color:#b45309; border-radius:50px; padding:3px 9px; font-size:0.75rem; font-weight:600; }
    .wm-badge-rejected { background: #fee2e2; color:#dc2626; border-radius:50px; padding:3px 9px; font-size:0.75rem; font-weight:600; }
    .wm-badge-na       { background: #f3f4f6; color:#6b7280; border-radius:50px; padding:3px 9px; font-size:0.75rem; font-weight:600; }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{translate('Invoices Management')}}</h4>
                <a href="{{route('admin.invoice.create')}}" class="i-btn btn--primary btn--md capsuled">
                    <i class="bi bi-plus-circle"></i> {{translate('Create Admin Invoice')}}
                </a>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>{{translate('Invoice #')}}</th>
                                <th>{{translate('Type')}}</th>
                                <th>{{translate('User')}}</th>
                                <th>{{translate('Billed To')}}</th>
                                <th>{{translate('Amount')}}</th>
                                <th>{{translate('Status')}}</th>
                                <th>{{translate('Watermark')}}</th>
                                <th>{{translate('Date')}}</th>
                                <th>{{translate('Actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            @php
                                $details = is_array($invoice->details) ? $invoice->details : [];
                                $invNum  = $details['invoice_number'] ?? ('INV-' . substr($invoice->uid, 0, 8));
                            @endphp
                            <tr>
                                <td><b>{{ $invNum }}</b></td>
                                <td>
                                    @if($invoice->type == 'admin')
                                        <span class="badge-type-admin">Admin</span>
                                    @else
                                        <span class="badge-type-brand">Brand</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $invoice->user->name ?? 'Unknown' }}</div>
                                    <small class="text-muted">{{ $invoice->user->email ?? '' }}</small>
                                </td>
                                <td>{{ $invoice->brand_name ?? '—' }}</td>
                                <td><b>${{ number_format($invoice->amount, 2) }}</b></td>
                                <td>
                                    <span class="badge-{{ $invoice->status }}">
                                        {{ ucwords(str_replace('_', ' ', $invoice->status)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($invoice->watermark_removed)
                                        <span class="wm-badge-approved"><i class="bi bi-check-circle"></i> Removed</span>
                                    @elseif($invoice->watermark_request_status == 'pending')
                                        <span class="wm-badge-pending"><i class="bi bi-clock"></i> Pending</span>
                                    @elseif($invoice->watermark_request_status == 'rejected')
                                        <span class="wm-badge-rejected"><i class="bi bi-x-circle"></i> Rejected</span>
                                    @else
                                        <span class="wm-badge-na">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $invoice->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        {{-- View --}}
                                        <a href="{{route('user.invoice.share', $invoice->uid)}}"
                                           class="btn btn-sm btn-info text-white" target="_blank" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- Download PDF --}}
                                        <a href="{{route('admin.invoice.download', $invoice->uid)}}"
                                           class="btn btn-sm btn-dark text-white" title="Download PDF">
                                            <i class="bi bi-download"></i>
                                        </a>

                                        {{-- Watermark approve/reject for pending requests --}}
                                        @if($invoice->watermark_request_status == 'pending')
                                            <form action="{{route('admin.invoice.watermark.approve', $invoice->uid)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-success" type="submit" title="Approve Watermark Removal">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{route('admin.invoice.watermark.reject', $invoice->uid)}}" method="POST" class="d-inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit" title="Reject Watermark Removal">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    {{translate('No invoices found')}}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $invoices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

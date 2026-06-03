@extends('layouts.master')
@section('content')

<style>
.invoice-list-header {
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 18px 18px 0 0;
    padding: 1.25rem 1.75rem;
    color: #fff;
}
.invoice-list-header h4 { font-weight: 800; font-size: 1.15rem; }
.btn-create-invoice {
    background: rgba(255,255,255,0.18);
    border: 1.5px solid rgba(255,255,255,0.5);
    border-radius: 50px;
    color: #fff;
    font-size: 0.88rem;
    font-weight: 600;
    padding: 0.4rem 1.15rem;
    transition: background 0.2s;
    text-decoration: none;
}
.btn-create-invoice:hover { background: rgba(255,255,255,0.32); color: #fff; }
.invoice-table-wrap { border-radius: 0 0 18px 18px; overflow: hidden; }
.invoice-table thead th {
    background: #f8faff;
    color: #475569;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 2px solid #e2e8f0;
    padding: 0.85rem 1.2rem;
}
.invoice-table tbody td {
    vertical-align: middle;
    padding: 0.9rem 1.2rem;
    font-size: 0.93rem;
    border-bottom: 1px solid #f1f5f9;
}
.invoice-table tbody tr:last-child td { border-bottom: none; }
.invoice-table tbody tr:hover { background: #f8faff; }
.badge-paid   { background: #d1fae5; color: #059669; border-radius: 50px; padding: 4px 12px; font-size:0.78rem; font-weight:700; }
.badge-partpaid { background: #e0f2fe; color: #0284c7; border-radius: 50px; padding: 4px 12px; font-size:0.78rem; font-weight:700; }
.badge-unpaid { background: #fef3c7; color: #d97706; border-radius: 50px; padding: 4px 12px; font-size:0.78rem; font-weight:700; }
.badge-wm-removed   { background: #d1fae5; color: #059669; border-radius: 50px; padding: 4px 10px; font-size:0.76rem; font-weight:700; }
.badge-wm-requested { background: #fef3c7; color: #d97706; border-radius: 50px; padding: 4px 10px; font-size:0.76rem; font-weight:700; }
.uid-cell { font-family: monospace; font-size: 0.78rem; color: #94a3b8; max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.action-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; border-radius: 9px; border: none;
    font-size: 0.9rem; transition: all 0.18s; text-decoration: none;
}
.action-btn-view   { background: #eef2ff; color: #6366f1; }
.action-btn-view:hover   { background: #6366f1; color: #fff; }
.action-btn-dl     { background: #f0fdf4; color: #16a34a; }
.action-btn-dl:hover     { background: #16a34a; color: #fff; }
.action-btn-pay     { background: #fef9c3; color: #ca8a04; }
.action-btn-pay:hover     { background: #ca8a04; color: #fff; }
.action-btn-wm     { background: #fff7ed; color: #ea580c; border: 1.5px solid #fed7aa; font-size:0.72rem; width:auto; padding: 0 10px; font-weight:600; }
.action-btn-wm:hover     { background: #ea580c; color: #fff; border-color:#ea580c; }
.empty-state { padding: 3.5rem 1rem; text-align: center; }
.empty-state i { font-size: 3rem; color: #c7d2fe; margin-bottom: 1rem; display: block; }
.empty-state p { color: #94a3b8; margin-bottom: 1.2rem; }
</style>

<div class="card" style="border-radius:18px; border:none; box-shadow:0 8px 40px rgba(99,102,241,0.10); overflow:hidden;">
    <div class="invoice-list-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0 d-flex align-items-center gap-2">
            <i class="bi bi-receipt-cutoff"></i>
            {{ translate('My Invoices') }}
            <span style="background:rgba(255,255,255,0.25); border-radius:50px; font-size:0.8rem; padding:2px 10px; font-weight:600;">
                {{ $invoices->total() }}
            </span>
        </h4>
        <a href="{{ route('user.invoice.create') }}" class="btn-create-invoice">
            <i class="bi bi-plus-lg me-1"></i> {{ translate('Create Invoice') }}
        </a>
    </div>

    <div class="px-4 py-3 bg-white border-bottom d-flex gap-2">
        <a href="{{ route('user.invoice.list') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">
            {{ translate('All Invoices') }}
        </a>
        <a href="{{ route('user.invoice.list', ['status' => 'paid']) }}" class="btn btn-sm {{ request('status') == 'paid' ? 'btn-success' : 'btn-outline-success' }}">
            {{ translate('Paid') }}
        </a>
        <a href="{{ route('user.invoice.list', ['status' => 'part_paid']) }}" class="btn btn-sm {{ request('status') == 'part_paid' ? 'btn-info' : 'btn-outline-info' }}">
            {{ translate('Partially Paid') }}
        </a>
        <a href="{{ route('user.invoice.list', ['status' => 'unpaid']) }}" class="btn btn-sm {{ request('status') == 'unpaid' ? 'btn-warning' : 'btn-outline-warning' }}">
            {{ translate('Unpaid') }}
        </a>
    </div>

    <div class="invoice-table-wrap">
        <div class="table-responsive">
            <table class="invoice-table table mb-0">
                <thead>
                    <tr>
                        <th>{{ translate('Invoice #') }}</th>
                        <th>{{ translate('Date') }}</th>
                        <th>{{ translate('Brand / Client') }}</th>
                        <th>{{ translate('Amount') }}</th>
                        <th>{{ translate('Due Date') }}</th>
                        <th>{{ translate('Status') }}</th>
                        <th>{{ translate('Watermark') }}</th>
                        <th>{{ translate('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                    @php
                        $details     = is_array($invoice->details) ? $invoice->details : [];
                        $currSymbol  = $details['currency_symbol'] ?? '$';
                        $currCode    = $details['currency_code']   ?? 'USD';
                        $dueDate     = $details['due_date'] ?? null;
                        $isAdminInv  = $invoice->type === 'admin';
                    @endphp
                    <tr>
                        <td class="uid-cell" title="{{ $invoice->uid }}">
                            {{ $details['invoice_number'] ?? substr($invoice->uid, 0, 8).'...' }}
                        </td>
                        <td>{{ $invoice->created_at->format('d M Y') }}</td>
                        <td>
                            @if($isAdminInv)
                                <span class="fw-semibold">{{ $invoice->brand_name ?? 'Osvioo' }}</span>
                                <small class="d-block" style="font-size:0.72rem; background:#ede9fe; color:#7c3aed; border-radius:50px; padding:1px 8px; display:inline-block!important; margin-top:2px;">From Osvioo</small>
                            @else
                                <span class="fw-semibold">{{ $invoice->brand_name ?? 'Platform' }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark">{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</span>
                            <small class="text-muted d-block" style="font-size:0.75rem;">{{ $currCode }}</small>
                        </td>
                        <td>
                            @if($dueDate)
                                @php $due = \Carbon\Carbon::parse($dueDate); @endphp
                                <span class="{{ $due->isPast() && $invoice->status != 'paid' ? 'text-danger fw-semibold' : 'text-secondary' }}">
                                    {{ $due->format('d M Y') }}
                                </span>
                                @if($due->isPast() && $invoice->status != 'paid')
                                    <small class="text-danger d-block" style="font-size:0.73rem;">Overdue</small>
                                @endif
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($invoice->status == 'paid')
                                <span class="badge-paid"><i class="bi bi-check-circle me-1"></i>{{ translate('Paid') }}</span>
                            @elseif($invoice->status == 'part_paid')
                                <span class="badge-partpaid"><i class="bi bi-pie-chart me-1"></i>{{ translate('Partially Paid') }}</span>
                            @else
                                <span class="badge-unpaid"><i class="bi bi-clock me-1"></i>{{ translate('Unpaid') }}</span>
                            @endif
                        </td>
                        <td>
                            @if($isAdminInv)
                                <span class="badge-wm-removed"><i class="bi bi-check2"></i> {{ translate('N/A') }}</span>
                            @elseif($invoice->watermark_removed)
                                <span class="badge-wm-removed"><i class="bi bi-check2"></i> {{ translate('Removed') }}</span>
                            @elseif($invoice->watermark_request_status == 'pending')
                                <span class="badge-wm-requested"><i class="bi bi-hourglass-split"></i> {{ translate('Requested') }}</span>
                            @else
                                <form action="{{ route('user.invoice.watermark.request', $invoice->uid) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="action-btn action-btn-wm">
                                        <i class="bi bi-droplet-slash me-1"></i>{{ translate('Remove WM') }}
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                @if($invoice->status != 'paid')
                                <button type="button" class="action-btn action-btn-pay" data-bs-toggle="modal" data-bs-target="#paymentModal{{ $invoice->uid }}" title="{{ translate('Record Payment') }}">
                                    <i class="bi bi-currency-dollar"></i>
                                </button>
                                @endif
                                <button type="button" class="action-btn" style="background:#fef3c7; color:#b45309;" data-bs-toggle="modal" data-bs-target="#emailModal{{ $invoice->uid }}" title="{{ translate('Send Email') }}">
                                    <i class="bi bi-envelope"></i>
                                </button>
                                <a href="{{ route('user.invoice.share', $invoice->uid) }}"
                                    class="action-btn action-btn-view" target="_blank"
                                    title="{{ translate('Preview Invoice') }}">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('user.invoice.download', $invoice->uid) }}"
                                    class="action-btn action-btn-dl"
                                    title="{{ translate('Download PDF') }}">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </a>
                            </div>
                        </td>
                    </tr>

                    @if($invoice->status != 'paid')
                    <!-- Payment Modal -->
                    <div class="modal fade" id="paymentModal{{ $invoice->uid }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius:12px; border:none;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">{{ translate('Record Payment') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.invoice.payment.update', $invoice->uid) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted small mb-3">
                                            {{ translate('Current Total:') }} <b>{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</b><br>
                                            {{ translate('Amount Paid so far:') }} <b>{{ $currSymbol }}{{ number_format($details['amount_paid'] ?? 0, 2) }}</b><br>
                                            @php $due = $invoice->amount - ($details['amount_paid'] ?? 0); @endphp
                                            {{ translate('Due Amount:') }} <b class="text-danger">{{ $currSymbol }}{{ number_format($due, 2) }}</b>
                                        </p>
                                        <div class="form-group mb-0">
                                            <label class="form-label fw-semibold">{{ translate('Enter Amount Received') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text">{{ $currCode }}</span>
                                                <input type="number" step="0.01" name="amount_paid" class="form-control" placeholder="e.g. 500" required>
                                            </div>
                                            <small class="text-muted d-block mt-1">{{ translate('This amount will be added to the total amount paid.') }}</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="submit" class="btn btn-primary w-100" style="border-radius:8px; padding:10px; font-weight:600;">
                                            {{ translate('Update Payment') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- Email Modal -->
                    <div class="modal fade" id="emailModal{{ $invoice->uid }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius:12px; border:none;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">{{ translate('Send Invoice to Email') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('user.invoice.send.email', $invoice->uid) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <p class="text-muted small mb-3">
                                            {{ translate('Send this invoice as a PDF attachment to your client.') }}
                                        </p>
                                        <div class="form-group mb-0">
                                            <label class="form-label fw-semibold">{{ translate('Client Email Address') }}</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                <input type="email" name="client_email" class="form-control" placeholder="client@example.com" value="{{ $details['billed_to']['email'] ?? '' }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 pt-0">
                                        <button type="submit" class="btn btn-primary w-100" style="border-radius:8px; padding:10px; font-weight:600;">
                                            <i class="bi bi-send me-1"></i> {{ translate('Send Email') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="p-0">
                            <div class="empty-state">
                                <i class="bi bi-receipt"></i>
                                <h6 class="fw-bold text-dark">{{ translate('No invoices yet') }}</h6>
                                <p>{{ translate('Create your first professional invoice for brand deals.') }}</p>
                                <a href="{{ route('user.invoice.create') }}" class="i-btn btn--primary btn--sm capsuled">
                                    <i class="bi bi-plus-lg me-1"></i> {{ translate('Create Invoice') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($invoices->hasPages())
    <div class="px-4 py-3" style="border-top:1px solid #f1f5f9;">
        {{ $invoices->links() }}
    </div>
    @endif
</div>
@endsection

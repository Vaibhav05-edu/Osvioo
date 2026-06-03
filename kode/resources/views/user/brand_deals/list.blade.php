@extends('layouts.master')
@section('content')

<style>
.crm-board {
    display: flex;
    gap: 1.5rem;
    overflow-x: auto;
    padding-bottom: 1rem;
    min-height: 70vh;
}
.crm-column {
    flex: 0 0 320px;
    background: #f8faff;
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    border: 1px solid #e2e8f0;
}
.crm-column-header {
    font-weight: 700;
    font-size: 1.05rem;
    color: #334155;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e2e8f0;
}
.crm-card {
    background: white;
    border-radius: 10px;
    padding: 1rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid #f1f5f9;
    transition: transform 0.2s, box-shadow 0.2s;
    cursor: pointer;
}
.crm-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
}
.crm-card-title {
    font-weight: 700;
    font-size: 1rem;
    color: #1e293b;
    margin-bottom: 0.25rem;
}
.crm-card-meta {
    font-size: 0.8rem;
    color: #64748b;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.75rem;
}
.crm-card-amount {
    font-weight: 700;
    color: #059669;
    background: #d1fae5;
    padding: 2px 8px;
    border-radius: 50px;
}
.empty-col {
    text-align: center;
    color: #94a3b8;
    font-size: 0.85rem;
    padding: 2rem 0;
    border: 2px dashed #cbd5e1;
    border-radius: 8px;
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">{{ translate('Brand Deals CRM') }}</h4>
    <button class="i-btn btn--primary btn--sm capsuled" data-bs-toggle="modal" data-bs-target="#addDealModal">
        <i class="bi bi-plus-lg me-1"></i> {{ translate('New Deal') }}
    </button>
</div>

@php
    $statuses = ['Negotiating', 'In Progress', 'Pending Payment', 'Completed'];
@endphp

<div class="crm-board">
    @foreach($statuses as $status)
    <div class="crm-column">
        <div class="crm-column-header">
            {{ translate($status) }}
            <span class="badge bg-secondary">{{ $deals->where('status', $status)->count() }}</span>
        </div>
        
        @php $colDeals = $deals->where('status', $status); @endphp
        
        @if($colDeals->isEmpty())
            <div class="empty-col">No deals here</div>
        @else
            @foreach($colDeals as $deal)
            <div class="crm-card" data-bs-toggle="modal" data-bs-target="#editDealModal{{ $deal->uid }}">
                <div class="crm-card-title">{{ $deal->brand_name }}</div>
                <div class="text-truncate" style="font-size:0.85rem; color:#64748b;">
                    {{ $deal->deliverables ?? translate('No deliverables set') }}
                </div>
                <div class="crm-card-meta">
                    <span><i class="bi bi-calendar3 me-1"></i>{{ $deal->updated_at->format('M d') }}</span>
                    <span class="crm-card-amount">{{ base_currency() }}{{ number_format($deal->agreed_amount, 2) }}</span>
                </div>
            </div>

            <!-- Edit Deal Modal -->
            <div class="modal fade" id="editDealModal{{ $deal->uid }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">{{ translate('Edit Deal:') }} {{ $deal->brand_name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('user.brand_deals.update', $deal->uid) }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ translate('Brand Name') }}</label>
                                    <input type="text" name="brand_name" class="form-control" value="{{ $deal->brand_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ translate('Status') }}</label>
                                    <select name="status" class="form-select">
                                        @foreach($statuses as $s)
                                        <option value="{{ $s }}" {{ $deal->status == $s ? 'selected' : '' }}>{{ translate($s) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ translate('Agreed Amount') }} ({{ base_currency() }})</label>
                                    <input type="number" step="0.01" name="agreed_amount" class="form-control" value="{{ $deal->agreed_amount }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ translate('Deliverables') }}</label>
                                    <textarea name="deliverables" class="form-control" rows="2">{{ $deal->deliverables }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">{{ translate('Private Notes') }}</label>
                                    <textarea name="notes" class="form-control" rows="2">{{ $deal->notes }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-between">
                                <a href="{{ route('user.brand_deals.destroy', $deal->uid) }}" class="btn btn-danger btn-sm" onclick="return confirm('Delete this deal?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <button type="submit" class="btn btn-primary capsuled">{{ translate('Save Changes') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    @endforeach
</div>

<!-- Add Deal Modal -->
<div class="modal fade" id="addDealModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">{{ translate('New Brand Deal') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.brand_deals.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ translate('Brand Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="brand_name" class="form-control" placeholder="e.g. Nike" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ translate('Initial Status') }}</label>
                        <select name="status" class="form-select">
                            @foreach($statuses as $s)
                            <option value="{{ $s }}">{{ translate($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ translate('Agreed Amount') }} ({{ base_currency() }})</label>
                        <input type="number" step="0.01" name="agreed_amount" class="form-control" placeholder="0.00">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ translate('Deliverables') }}</label>
                        <textarea name="deliverables" class="form-control" rows="2" placeholder="e.g. 1 Reel, 2 Story mentions..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">{{ translate('Private Notes') }}</label>
                        <textarea name="notes" class="form-control" rows="2" placeholder="Contact info, terms, etc."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary capsuled w-100">{{ translate('Create Deal') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

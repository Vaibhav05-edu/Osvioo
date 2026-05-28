@extends('layouts.master')
@section('content')
@php
    $currency = session()->get('currency');
    $currencyCode   = optional($currency)->code   ?? 'USD';
    $currencySymbol = optional($currency)->symbol ?? '$';
@endphp

<style>
.invoice-creator {
    background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    min-height: 100vh;
    padding-bottom: 2rem;
}
.invoice-card {
    border-radius: 20px;
    border: none;
    box-shadow: 0 8px 40px rgba(99,102,241,0.10);
    overflow: hidden;
}
.invoice-card-header {
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
    padding: 1.5rem 2rem;
    color: #fff;
}
.invoice-card-header h4 { font-weight: 800; font-size: 1.25rem; letter-spacing: -0.5px; }
.invoice-card-header .btn-back {
    background: rgba(255,255,255,0.18);
    color: #fff;
    border: 1.5px solid rgba(255,255,255,0.4);
    border-radius: 50px;
    font-size: 0.85rem;
    padding: 0.35rem 1rem;
    transition: background 0.2s;
}
.invoice-card-header .btn-back:hover { background: rgba(255,255,255,0.32); }

.section-label {
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: #6366f1;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.form-floating-custom .form-control,
.form-floating-custom .form-select {
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    transition: border-color 0.2s, box-shadow 0.2s;
    font-size: 0.97rem;
}
.form-floating-custom .form-control:focus,
.form-floating-custom .form-select:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
}
.form-floating-custom label { font-size: 0.85rem; color: #64748b; font-weight: 600; }

.currency-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    color: #fff;
    border-radius: 50px;
    padding: 4px 14px;
    font-size: 0.82rem;
    font-weight: 700;
}

.items-section {
    background: #f8faff;
    border: 1.5px dashed #c7d2fe;
    border-radius: 16px;
    padding: 1.5rem;
}
.item-row-card {
    background: #fff;
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    padding: 1rem 1.25rem;
    position: relative;
    transition: border-color 0.2s, box-shadow 0.2s;
    margin-bottom: 0.75rem;
}
.item-row-card:hover { border-color: #a5b4fc; box-shadow: 0 2px 12px rgba(99,102,241,0.08); }
.item-row-card .row-num {
    position: absolute;
    top: -10px; left: 14px;
    background: #6366f1;
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    border-radius: 20px;
    padding: 1px 10px;
}

.total-bar {
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
    border-radius: 14px;
    padding: 1rem 1.5rem;
    color: #fff;
}
.total-bar .label { font-size: 0.9rem; opacity: 0.85; }
.total-bar .value { font-size: 1.5rem; font-weight: 800; }

.btn-submit-invoice {
    background: linear-gradient(90deg, #6366f1 0%, #8b5cf6 100%);
    border: none;
    border-radius: 14px;
    padding: 0.85rem 2.5rem;
    color: #fff;
    font-weight: 700;
    font-size: 1.02rem;
    letter-spacing: 0.02em;
    box-shadow: 0 6px 20px rgba(99,102,241,0.30);
    transition: transform 0.15s, box-shadow 0.15s;
}
.btn-submit-invoice:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(99,102,241,0.38); color:#fff; }
.btn-add-item {
    background: #eef2ff;
    border: 1.5px solid #c7d2fe;
    border-radius: 10px;
    color: #6366f1;
    font-weight: 600;
    font-size: 0.9rem;
    padding: 0.5rem 1.25rem;
    transition: all 0.2s;
}
.btn-add-item:hover { background: #6366f1; color: #fff; border-color: #6366f1; }
.btn-del-item {
    background: #fef2f2;
    border: 1.5px solid #fecaca;
    border-radius: 8px;
    color: #ef4444;
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s;
}
.btn-del-item:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
</style>

<div class="invoice-creator">
    <div class="invoice-card card">
        {{-- Header --}}
        <div class="invoice-card-header d-flex align-items-center justify-content-between">
            <h4 class="mb-0 d-flex align-items-center gap-2">
                <i class="bi bi-receipt-cutoff"></i>
                {{ translate('Create Professional Invoice') }}
            </h4>
            <div class="d-flex align-items-center gap-3">
                <span class="currency-badge">
                    <i class="bi bi-currency-exchange"></i>
                    {{ $currencyCode }} ({{ $currencySymbol }})
                </span>
                <a href="{{ route('user.invoice.list') }}" class="btn-back">
                    <i class="bi bi-arrow-left"></i> {{ translate('My Invoices') }}
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('user.invoice.store') }}" method="POST" id="invoice-form">
                @csrf

                {{-- Row 1: Client + Invoice Date + Due Date --}}
                <p class="section-label"><i class="bi bi-person-lines-fill"></i> {{ translate('Client & Schedule') }}</p>
                <div class="row g-3 mb-4">
                    <div class="col-md-5">
                        <div class="form-floating-custom">
                            <label class="mb-1">{{ translate('Brand / Client Name') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-radius:12px 0 0 12px; border:1.5px solid #e2e8f0; border-right:none;">
                                    <i class="bi bi-building text-muted"></i>
                                </span>
                                <input type="text" name="brand_name"
                                    class="form-control @error('brand_name') is-invalid @enderror"
                                    style="border-radius:0 12px 12px 0; border:1.5px solid #e2e8f0; border-left:none;"
                                    placeholder="{{ translate('e.g. Nike, Samsung, Pepsi') }}"
                                    value="{{ old('brand_name') }}" required>
                            </div>
                            @error('brand_name')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-floating-custom">
                            <label class="mb-1">{{ translate('Invoice Date') }}</label>
                            <input type="text" class="form-control"
                                style="border-radius:12px;"
                                value="{{ now()->format('M d, Y') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating-custom">
                            <label class="mb-1">{{ translate('Due Date') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white" style="border-radius:12px 0 0 12px; border:1.5px solid #e2e8f0; border-right:none;">
                                    <i class="bi bi-calendar-check text-muted"></i>
                                </span>
                                <input type="date" name="due_date"
                                    class="form-control @error('due_date') is-invalid @enderror"
                                    style="border-radius:0 12px 12px 0; border:1.5px solid #e2e8f0; border-left:none;"
                                    min="{{ now()->format('Y-m-d') }}"
                                    value="{{ old('due_date') }}">
                            </div>
                            @error('due_date')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Invoice Items --}}
                <p class="section-label mt-2"><i class="bi bi-list-task"></i> {{ translate('Invoice Items & Pricing') }}</p>
                <div class="items-section mb-4">
                    <div id="details-container"></div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <button type="button" class="btn-add-item" id="add-item-btn">
                            <i class="bi bi-plus-lg me-1"></i> {{ translate('Add Line Item') }}
                        </button>
                        <div class="total-bar d-flex align-items-center justify-content-between" style="min-width:260px;">
                            <span class="label">{{ translate('Total Amount') }}</span>
                            <span class="value" id="summary-total">{{ $currencySymbol }}0.00</span>
                        </div>
                    </div>
                </div>

                {{-- Hidden total amount field --}}
                <input type="hidden" name="amount" id="total-amount-hidden" value="0">

                {{-- Notes --}}
                <p class="section-label"><i class="bi bi-sticky"></i> {{ translate('Additional Notes') }}</p>
                <div class="form-floating-custom mb-4">
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror"
                        style="border-radius:12px; border:1.5px solid #e2e8f0; min-height:100px;"
                        placeholder="{{ translate('Payment terms, bank details, thank you message...') }}"
                        maxlength="1000">{{ old('notes') }}</textarea>
                    @error('notes')<span class="text-danger small">{{ $message }}</span>@enderror
                    <small class="text-muted">{{ translate('Optional - will appear at the bottom of your invoice.') }}</small>
                </div>

                {{-- Submit --}}
                <div class="d-flex align-items-center gap-3">
                    <button type="submit" class="btn-submit-invoice" id="submit-btn">
                        <i class="bi bi-check2-circle me-2"></i> {{ translate('Generate & Save Invoice') }}
                    </button>
                    <a href="{{ route('user.invoice.list') }}" class="btn btn-outline-secondary" style="border-radius:12px; padding:0.8rem 1.5rem;">
                        {{ translate('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script nonce="{{ csp_nonce() }}">
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('details-container');
    const addBtn    = document.getElementById('add-item-btn');
    const hiddenAmt = document.getElementById('total-amount-hidden');
    const summaryEl = document.getElementById('summary-total');
    const symbol    = @json($currencySymbol);

    let rowIdx = 0;

    function buildRow(idx) {
        const div = document.createElement('div');
        div.className = 'item-row-card';
        div.dataset.rowId = idx;
        div.innerHTML = `
            <span class="row-num">#${idx + 1}</span>
            <div class="row align-items-center g-2 mt-1">
                <div class="col-md-7">
                    <input type="text" name="details[${idx}][description]"
                        class="form-control" style="border-radius:10px;"
                        placeholder="{{ translate('e.g. Sponsored Reel, Brand Integration, Story Post') }}" required>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text" style="border-radius:10px 0 0 10px; background:#f8faff; font-weight:700; color:#6366f1;">${symbol}</span>
                        <input type="number" name="details[${idx}][price]"
                            class="form-control item-price" style="border-radius:0 10px 10px 0;"
                            placeholder="0.00" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn-del-item del-row-btn" title="{{ translate('Remove') }}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        return div;
    }

    function updateRowNumbers() {
        document.querySelectorAll('.item-row-card').forEach(function (row, i) {
            const num = row.querySelector('.row-num');
            if (num) num.textContent = '#' + (i + 1);
        });
    }

    function recalculate() {
        let total = 0;
        document.querySelectorAll('.item-price').forEach(function (inp) {
            const v = parseFloat(inp.value);
            if (!isNaN(v) && v >= 0) total += v;
        });
        hiddenAmt.value = total.toFixed(2);
        summaryEl.textContent = symbol + total.toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function toggleDeleteBtns() {
        const rows = document.querySelectorAll('.item-row-card');
        rows.forEach(function (r) {
            const btn = r.querySelector('.del-row-btn');
            if (btn) btn.style.visibility = rows.length > 1 ? 'visible' : 'hidden';
        });
    }

    // Add first row
    function addRow() {
        const row = buildRow(rowIdx++);
        container.appendChild(row);
        toggleDeleteBtns();
        updateRowNumbers();
    }

    addRow(); // initial row

    addBtn.addEventListener('click', function () {
        addRow();
    });

    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('item-price')) recalculate();
    });

    container.addEventListener('click', function (e) {
        const btn = e.target.closest('.del-row-btn');
        if (btn) {
            const row = btn.closest('.item-row-card');
            if (row && document.querySelectorAll('.item-row-card').length > 1) {
                row.remove();
                recalculate();
                toggleDeleteBtns();
                updateRowNumbers();
            }
        }
    });

    // Prevent submit if total is 0
    document.getElementById('invoice-form').addEventListener('submit', function (e) {
        if (parseFloat(hiddenAmt.value) <= 0) {
            e.preventDefault();
            alert('{{ translate("Please add at least one item with a price greater than 0.") }}');
        }
    });
});
</script>
@endsection

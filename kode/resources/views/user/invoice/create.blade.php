@extends('layouts.master')
@section('content')
<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-bottom py-3">
        <div class="d-flex align-items-center justify-content-between">
            <h4 class="card-title mb-0 fw-bold text-dark d-flex align-items-center gap-2">
                <i class="bi bi-receipt text-primary"></i>
                {{translate('Create Professional Invoice')}}
            </h4>
            <a href="{{route('user.invoice.list')}}" class="btn btn-outline-secondary btn-sm capsuled">
                <i class="bi bi-arrow-left"></i> {{translate('Back to List')}}
            </a>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{route('user.invoice.store')}}" method="POST" id="invoice-form">
            @csrf
            
            <div class="row g-4">
                {{-- Left Column: Brand details --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-semibold text-secondary mb-2">{{translate('Brand / Client Name')}}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-building text-muted"></i></span>
                            <input type="text" name="brand_name" class="form-control border-start-0 ps-0" placeholder="{{translate('Enter client or brand name')}}" required>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Total Amount (Automatically calculated) --}}
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-semibold text-secondary mb-2">{{translate('Total Invoice Amount')}}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 fw-bold text-primary">{{session()->get('currency')?->code}} ({{session()->get('currency')?->symbol}})</span>
                            <input type="number" id="total-amount-display" name="amount" class="form-control border-start-0 bg-light fw-bold text-dark" step="0.01" readonly required>
                        </div>
                        <small class="form-text text-muted">{{translate('Calculated automatically from item prices below.')}}</small>
                    </div>
                </div>

                {{-- Dynamic Invoice Details Section --}}
                <div class="col-12 mt-4">
                    <div class="border rounded-4 p-4 bg-light bg-opacity-25">
                        <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-list-task text-primary"></i>
                                {{translate('Invoice Items & Pricing')}}
                            </h5>
                            <button type="button" class="btn btn-primary btn-sm capsuled d-flex align-items-center gap-1" id="add-item-btn">
                                <i class="bi bi-plus-lg"></i> {{translate('Add Line Item')}}
                            </button>
                        </div>

                        <div id="details-container" class="d-flex flex-column gap-3">
                            {{-- Row template --}}
                            <div class="row align-items-center item-row g-3" data-row-id="0">
                                <div class="col-md-8">
                                    <label class="form-label d-md-none text-muted small">{{translate('Item Description')}}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-chat-left-text text-muted"></i></span>
                                        <input type="text" name="details[0][description]" class="form-control border-start-0 ps-0" placeholder="{{translate('e.g. Sponsored Post / Brand Integration')}}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label d-md-none text-muted small">{{translate('Price')}}</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">{{session()->get('currency')?->symbol}}</span>
                                        <input type="number" name="details[0][price]" class="form-control border-start-0 ps-0 item-price" placeholder="0.00" step="0.01" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 delete-row-btn p-2" style="display:none;" title="{{translate('Delete Item')}}">
                                        <i class="bi bi-trash fs-5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Summary area --}}
                        <div class="row mt-4 pt-3 border-top justify-content-end">
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center py-2 px-3 bg-white rounded-3 border">
                                    <span class="text-secondary fw-semibold">{{translate('Subtotal:')}}</span>
                                    <span class="fw-bold text-dark fs-5" id="summary-total">{{session()->get('currency')?->symbol}}0.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="i-btn btn--primary btn--md mt-4 capsuled px-4 py-2 fw-bold shadow-sm d-flex align-items-center gap-2">
                <i class="bi bi-check-circle"></i>
                {{translate('Generate & Save Invoice')}}
            </button>
        </form>
    </div>
</div>

<script nonce="{{ csp_nonce() }}">
document.addEventListener('DOMContentLoaded', function() {
    const detailsContainer = document.getElementById('details-container');
    const addItemBtn = document.getElementById('add-item-btn');
    const totalAmountInput = document.getElementById('total-amount-display');
    const summaryTotal = document.getElementById('summary-total');
    const currencySymbol = "{{session()->get('currency')?->symbol}}";
    
    let rowCounter = 0;

    // Recalculate totals
    function calculateTotal() {
        let total = 0;
        const priceInputs = document.querySelectorAll('.item-price');
        priceInputs.forEach(input => {
            const val = parseFloat(input.value);
            if (!isNaN(val)) {
                total += val;
            }
        });
        
        totalAmountInput.value = total.toFixed(2);
        summaryTotal.textContent = currencySymbol + total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // Toggle delete button visibility based on row count
    function toggleDeleteButtons() {
        const rows = document.querySelectorAll('.item-row');
        const deleteBtns = document.querySelectorAll('.delete-row-btn');
        if (rows.length <= 1) {
            deleteBtns.forEach(btn => btn.style.display = 'none');
        } else {
            deleteBtns.forEach(btn => btn.style.display = 'inline-block');
        }
    }

    // Handle price input changes to update totals
    detailsContainer.addEventListener('input', function(e) {
        if (e.target.classList.contains('item-price')) {
            calculateTotal();
        }
    });

    // Add new row
    addItemBtn.addEventListener('click', function() {
        rowCounter++;
        const newRow = document.createElement('div');
        newRow.className = 'row align-items-center item-row g-3';
        newRow.setAttribute('data-row-id', rowCounter);
        newRow.innerHTML = `
            <div class="col-md-8">
                <label class="form-label d-md-none text-muted small">{{translate('Item Description')}}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-chat-left-text text-muted"></i></span>
                    <input type="text" name="details[\${rowCounter}][description]" class="form-control border-start-0 ps-0" placeholder="{{translate('e.g. Sponsored Post / Brand Integration')}}" required>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label d-md-none text-muted small">{{translate('Price')}}</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">${currencySymbol}</span>
                    <input type="number" name="details[\${rowCounter}][price]" class="form-control border-start-0 ps-0 item-price" placeholder="0.00" step="0.01" min="0" required>
                </div>
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-outline-danger btn-sm border-0 delete-row-btn p-2" title="{{translate('Delete Item')}}">
                    <i class="bi bi-trash fs-5"></i>
                </button>
            </div>
        `;
        detailsContainer.appendChild(newRow);
        toggleDeleteButtons();
    });

    // Delete row
    detailsContainer.addEventListener('click', function(e) {
        const btn = e.target.closest('.delete-row-btn');
        if (btn) {
            const row = btn.closest('.item-row');
            if (row) {
                row.remove();
                calculateTotal();
                toggleDeleteButtons();
            }
        }
    });

    // Initial check
    toggleDeleteButtons();
});
</script>
@endsection

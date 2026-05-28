@extends('layouts.master')
@section('content')
@php
    $currency = session()->get('currency');
    $currencyCode   = optional($currency)->code   ?? 'USD';
    $currencySymbol = optional($currency)->symbol ?? '$';
@endphp

<style>
.invoice-creator {
    background-color: #f8f9fa;
    min-height: 100vh;
    padding-bottom: 3rem;
}
.invoice-card {
    background: #fff;
    border-radius: 8px;
    border: none;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 2rem 3rem;
    max-width: 1000px;
    margin: 0 auto;
}
.form-section-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1rem;
    border-bottom: 1px solid #eee;
    padding-bottom: 0.5rem;
}
.form-label {
    font-weight: 600;
    font-size: 0.85rem;
    color: #555;
    margin-bottom: 0.4rem;
}
.form-control, .form-select {
    border-radius: 4px;
    border: 1px solid #ddd;
    padding: 0.6rem 0.8rem;
    font-size: 0.9rem;
    box-shadow: none;
}
.form-control:focus, .form-select:focus {
    border-color: #7b4cf6;
    box-shadow: 0 0 0 3px rgba(123, 76, 246, 0.1);
}
.box-section {
    background: #fafafa;
    border: 1px solid #eaeaea;
    border-radius: 8px;
    padding: 1.5rem;
    height: 100%;
}
.items-table th {
    background: #7b4cf6;
    color: #fff;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 0.8rem;
    border: none;
}
.items-table td {
    vertical-align: middle;
    padding: 0.8rem;
    border-bottom: 1px solid #eee;
}
.items-table input.form-control {
    border: none;
    background: transparent;
    border-bottom: 1px solid #ddd;
    border-radius: 0;
    padding-left: 0;
    padding-right: 0;
}
.items-table input.form-control:focus {
    border-color: #7b4cf6;
    box-shadow: none;
}
.btn-primary-custom {
    background: #7b4cf6;
    border: none;
    color: #fff;
    padding: 0.8rem 2rem;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-primary-custom:hover {
    background: #6a3be3;
    color: #fff;
}
.total-section {
    background: #fdfdfd;
    border: 1px solid #eaeaea;
    border-radius: 8px;
    padding: 1.5rem;
}
.total-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.8rem;
    font-size: 0.95rem;
}
.total-line.final {
    font-size: 1.2rem;
    font-weight: 700;
    border-top: 1px solid #ddd;
    padding-top: 0.8rem;
    margin-bottom: 0;
}
.btn-add-line {
    color: #7b4cf6;
    background: transparent;
    border: 1px dashed #7b4cf6;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.2s;
}
.btn-add-line:hover {
    background: #f4f0ff;
}
.del-row-btn {
    color: #dc3545;
    background: transparent;
    border: none;
    font-size: 1.2rem;
    padding: 0;
}
</style>

<div class="invoice-creator pt-4">
    <div class="container">
        <form action="{{ route('user.invoice.store') }}" method="POST" id="invoice-form">
            @csrf
            
            <div class="d-flex justify-content-between align-items-center mb-4 max-w-1000 mx-auto" style="max-width: 1000px;">
                <h3 class="fw-bold mb-0 text-dark">Invoice</h3>
                <a href="{{ route('user.invoice.list') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <div class="invoice-card">
                {{-- Top details row --}}
                <div class="row mb-5">
                    <div class="col-md-6">
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-4 form-label mb-0">Invoice No <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light" value="{{ $invoiceNumber }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-4 form-label mb-0">Invoice Date <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control bg-light" value="{{ now()->format('M d, Y') }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label class="col-sm-4 form-label mb-0">Due Date</label>
                            <div class="col-sm-8">
                                <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}" min="{{ now()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Billed By / Billed To --}}
                <div class="row mb-5 g-4">
                    <div class="col-md-6">
                        <div class="box-section">
                            <h5 class="form-section-title">Billed By (Your Details)</h5>
                            <div class="mb-3">
                                <label class="form-label">Business/Your Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="billed_by_phone" class="form-control" placeholder="+1 234 567 8900" value="{{ old('billed_by_phone') }}">
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Address</label>
                                <textarea name="billed_by_address" class="form-control" rows="2" placeholder="Your full address">{{ old('billed_by_address') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box-section">
                            <h5 class="form-section-title">Billed To (Client Details)</h5>
                            <div class="mb-3">
                                <label class="form-label">Client/Brand Name <span class="text-danger">*</span></label>
                                <input type="text" name="brand_name" class="form-control" placeholder="e.g. Acme Corp" value="{{ old('brand_name') }}" required>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Client Address</label>
                                <textarea name="billed_to_address" class="form-control" rows="4" placeholder="Client's full address">{{ old('billed_to_address') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Items Table --}}
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <label class="form-label mb-0">Currency:</label>
                        <span class="badge bg-light text-dark border">{{ $currencyCode }} ({{ $currencySymbol }})</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table items-table mb-2">
                            <thead>
                                <tr>
                                    <th width="50%">Item</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Rate</th>
                                    <th width="15%">Amount</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="items-body">
                                <!-- JS items will go here -->
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn-add-line" id="add-item-btn">
                        <i class="bi bi-plus-lg"></i> Add New Line
                    </button>
                </div>

                {{-- Totals and Bank Details --}}
                <div class="row mt-5">
                    <div class="col-md-7 pe-md-5">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Bank Details</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input type="text" name="bank_account_name" class="form-control" placeholder="Account Name" value="{{ old('bank_account_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="bank_account_number" class="form-control" placeholder="Account Number" value="{{ old('bank_account_number') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="bank_ifsc" class="form-control" placeholder="IFSC / Routing Code" value="{{ old('bank_ifsc') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" value="{{ old('bank_name') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="bank_account_type" class="form-control" placeholder="Account Type (e.g. Current)" value="{{ old('bank_account_type') }}">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="upi_id" class="form-control" placeholder="UPI ID (Optional)" value="{{ old('upi_id') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Terms and Conditions</h6>
                            <textarea name="terms" class="form-control" rows="3">Please pay within the given date from the date of invoice. Overdue interest @ 7% will be charged on delayed payments.</textarea>
                        </div>
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2">Additional Notes</h6>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Any extra information..."></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-5">
                        <div class="total-section">
                            <div class="total-line text-muted">
                                <span>Subtotal</span>
                                <span id="lbl-subtotal">{{ $currencySymbol }}0.00</span>
                            </div>
                            <div class="total-line text-muted align-items-center">
                                <span>Discounts</span>
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <span class="input-group-text">{{ $currencySymbol }}</span>
                                    <input type="number" name="discount" id="inp-discount" class="form-control text-end" value="0" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="total-line text-muted align-items-center">
                                <span>Additional Charges</span>
                                <div class="input-group input-group-sm" style="width: 120px;">
                                    <span class="input-group-text">{{ $currencySymbol }}</span>
                                    <input type="number" name="additional_charges" id="inp-charges" class="form-control text-end" value="0" step="0.01" min="0">
                                </div>
                            </div>
                            <div class="total-line final">
                                <span>Total ({{ $currencyCode }})</span>
                                <span id="lbl-total">{{ $currencySymbol }}0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-5 border-top pt-4">
                    <button type="submit" class="btn-primary-custom" id="submit-btn">
                        <i class="bi bi-save me-1"></i> Save Invoice
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script nonce="{{ csp_nonce() }}">
document.addEventListener('DOMContentLoaded', function () {
    const tbody = document.getElementById('items-body');
    const addBtn = document.getElementById('add-item-btn');
    const lblSubtotal = document.getElementById('lbl-subtotal');
    const lblTotal = document.getElementById('lbl-total');
    const inpDisc = document.getElementById('inp-discount');
    const inpCharge = document.getElementById('inp-charges');
    const symbol = @json($currencySymbol);
    
    let rowIdx = 0;

    function buildRow(idx) {
        const tr = document.createElement('tr');
        tr.className = 'item-row';
        tr.innerHTML = `
            <td>
                <input type="text" name="items[${idx}][description]" class="form-control fw-semibold" placeholder="Item Name / Description" required>
            </td>
            <td>
                <input type="number" name="items[${idx}][quantity]" class="form-control item-qty" value="1" step="0.01" min="0" required>
            </td>
            <td>
                <div class="d-flex align-items-center">
                    <span class="text-muted me-1">${symbol}</span>
                    <input type="number" name="items[${idx}][rate]" class="form-control item-rate" placeholder="0.00" step="0.01" min="0" required>
                </div>
            </td>
            <td>
                <span class="text-dark fw-bold">${symbol}<span class="item-amt">0.00</span></span>
            </td>
            <td class="text-center">
                <button type="button" class="del-row-btn"><i class="bi bi-x-circle"></i></button>
            </td>
        `;
        return tr;
    }

    function calculate() {
        let subtotal = 0;
        
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const rate = parseFloat(row.querySelector('.item-rate').value) || 0;
            const amt = qty * rate;
            
            row.querySelector('.item-amt').textContent = amt.toFixed(2);
            subtotal += amt;
        });

        const disc = parseFloat(inpDisc.value) || 0;
        const charge = parseFloat(inpCharge.value) || 0;
        const total = subtotal - disc + charge;

        lblSubtotal.textContent = symbol + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        lblTotal.textContent = symbol + Math.max(0, total).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    function addRow() {
        tbody.appendChild(buildRow(rowIdx++));
        updateDelBtns();
    }

    function updateDelBtns() {
        const rows = document.querySelectorAll('.item-row');
        rows.forEach(r => {
            const btn = r.querySelector('.del-row-btn');
            if(btn) btn.style.visibility = rows.length > 1 ? 'visible' : 'hidden';
        });
    }

    // Init
    addRow();

    // Events
    addBtn.addEventListener('click', addRow);
    
    tbody.addEventListener('input', function(e) {
        if(e.target.classList.contains('item-qty') || e.target.classList.contains('item-rate')) {
            calculate();
        }
    });

    tbody.addEventListener('click', function(e) {
        const btn = e.target.closest('.del-row-btn');
        if(btn) {
            const row = btn.closest('.item-row');
            if(row && document.querySelectorAll('.item-row').length > 1) {
                row.remove();
                calculate();
                updateDelBtns();
            }
        }
    });

    inpDisc.addEventListener('input', calculate);
    inpCharge.addEventListener('input', calculate);

    document.getElementById('invoice-form').addEventListener('submit', function (e) {
        let isValid = false;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
            const rate = parseFloat(row.querySelector('.item-rate').value) || 0;
            if(qty * rate > 0) isValid = true;
        });
        if (!isValid) {
            e.preventDefault();
            alert('{{ translate("Please add at least one item with a valid amount.") }}');
        }
    });
});
</script>
@endsection

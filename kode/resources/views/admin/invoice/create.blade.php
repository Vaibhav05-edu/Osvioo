@extends('admin.layouts.master')

@section('content')

<style>
    .ai-create-wrapper { max-width: 960px; margin: 0 auto; }
    .ai-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.07); padding: 28px 32px; margin-bottom: 24px; }
    .ai-card-title { font-size: 1rem; font-weight: 700; color: #4b0082; border-bottom: 2px solid #f0ecff; padding-bottom: 10px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; }
    .items-table th { background: #f0ecff; color: #4b0082; font-weight: 600; font-size: 0.82rem; padding: 10px 8px; }
    .items-table td { vertical-align: middle; padding: 8px 6px; }
    .remove-row { cursor: pointer; color: #dc3545; background: none; border: none; font-size: 1.1rem; }
    .quick-add-btn { cursor: pointer; }
    .totals-box { background: #f9f7ff; border: 1px solid #e8e0ff; border-radius: 8px; padding: 18px 22px; }
    .totals-row { display: flex; justify-content: space-between; padding: 5px 0; font-size: 0.92rem; }
    .totals-row.grand { font-weight: 700; font-size: 1rem; border-top: 2px solid #6a3be3; margin-top: 8px; padding-top: 10px; color: #4b0082; }
    .badge-admin { background: #6a3be3; color: #fff; font-size: 0.72rem; padding: 2px 8px; border-radius: 50px; }
</style>

<div class="ai-create-wrapper">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-1">{{translate('Create Admin Invoice')}} <span class="badge-admin">Admin</span></h4>
            <small class="text-muted">{{translate('Generate an invoice for subscriptions or add-ons for a user')}}</small>
        </div>
        <a href="{{route('admin.invoice.list')}}" class="i-btn btn--secondary btn--md">
            <i class="bi bi-arrow-left"></i> {{translate('Back')}}
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{route('admin.invoice.store')}}" method="POST" id="adminInvoiceForm">
        @csrf

        {{-- User & Invoice Info --}}
        <div class="ai-card">
            <div class="ai-card-title"><i class="bi bi-person-fill"></i> {{translate('Invoice Details')}}</div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">{{translate('Select User')}} <span class="text-danger">*</span></label>
                    <select name="user_id" class="form-select" required>
                        <option value="">— {{translate('Choose User')}} —</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{$user->name}} ({{$user->email}})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id') <small class="text-danger">{{$message}}</small> @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{translate('Due Date')}}</label>
                    <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">{{translate('Discount ($)')}}</label>
                    <input type="number" name="discount" id="discountInput" class="form-control" step="0.01" min="0" value="{{ old('discount', 0) }}" placeholder="0.00">
                </div>
            </div>
        </div>

        {{-- Quick Add from Packages/Addons --}}
        <div class="ai-card">
            <div class="ai-card-title"><i class="bi bi-lightning-fill"></i> {{translate('Quick Add Items')}}</div>
            <div class="row g-2 mb-3">
                @if($packages->count())
                <div class="col-12">
                    <p class="text-muted mb-2" style="font-size:0.83rem; font-weight:600;">{{ translate('Subscription Packages') }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($packages as $pkg)
                        <button type="button" class="btn btn-sm btn-outline-primary quick-add-btn"
                            data-desc="{{$pkg->title}} (Subscription)"
                            data-rate="{{ $pkg->price }}"
                            data-qty="1">
                            <i class="bi bi-plus-circle"></i> {{$pkg->title}} — ${{ number_format($pkg->price, 2) }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($addons->count())
                <div class="col-12 mt-2">
                    <p class="text-muted mb-2" style="font-size:0.83rem; font-weight:600;">{{ translate('Add-ons') }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($addons as $addon)
                        <button type="button" class="btn btn-sm btn-outline-secondary quick-add-btn"
                            data-desc="{{$addon->title}} (Add-on)"
                            data-rate="{{ $addon->price }}"
                            data-qty="1">
                            <i class="bi bi-plus-circle"></i> {{$addon->title}} — ${{ number_format($addon->price, 2) }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Line Items --}}
        <div class="ai-card">
            <div class="ai-card-title"><i class="bi bi-list-ul"></i> {{translate('Invoice Line Items')}}</div>
            <div class="table-responsive">
                <table class="table items-table" id="itemsTable">
                    <thead>
                        <tr>
                            <th width="45%">{{translate('Description')}}</th>
                            <th width="15%" class="text-center">{{translate('Qty')}}</th>
                            <th width="20%" class="text-right">{{translate('Rate ($)')}}</th>
                            <th width="15%" class="text-right">{{translate('Amount')}}</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr class="item-row">
                            <td><input type="text" name="items[0][description]" class="form-control form-control-sm" placeholder="Service description" required></td>
                            <td><input type="number" name="items[0][quantity]" class="form-control form-control-sm qty-input" value="1" min="0" step="0.01" required></td>
                            <td><input type="number" name="items[0][rate]" class="form-control form-control-sm rate-input" value="0" min="0" step="0.01" required></td>
                            <td class="text-end fw-semibold amount-cell">$0.00</td>
                            <td class="text-center"><button type="button" class="remove-row" title="Remove"><i class="bi bi-x-circle-fill"></i></button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-1" id="addRow">
                <i class="bi bi-plus"></i> {{translate('Add Row')}}
            </button>
        </div>

        {{-- Totals + Notes --}}
        <div class="row">
            <div class="col-md-6">
                <div class="ai-card">
                    <div class="ai-card-title"><i class="bi bi-chat-left-text"></i> {{translate('Notes')}}</div>
                    <textarea name="notes" class="form-control" rows="4" placeholder="{{translate('Optional notes to the user...')}}">{{ old('notes') }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ai-card">
                    <div class="ai-card-title"><i class="bi bi-calculator"></i> {{translate('Summary')}}</div>
                    <div class="totals-box">
                        <div class="totals-row"><span>{{translate('Subtotal')}}</span><span id="summarySubtotal">$0.00</span></div>
                        <div class="totals-row"><span>{{translate('Discount')}}</span><span id="summaryDiscount">-$0.00</span></div>
                        <div class="totals-row grand"><span>{{translate('Total')}}</span><span id="summaryTotal">$0.00</span></div>
                    </div>
                    <div class="mt-3 d-grid">
                        <button type="submit" class="i-btn btn--primary btn--lg">
                            <i class="bi bi-file-earmark-check"></i> {{translate('Create Invoice')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

@endsection

@push('script-include')
<script>
(function($){
    "use strict";

    let rowIndex = 1;

    function calcRow(row) {
        const qty = parseFloat($(row).find('.qty-input').val()) || 0;
        const rate = parseFloat($(row).find('.rate-input').val()) || 0;
        const amount = qty * rate;
        $(row).find('.amount-cell').text('$' + amount.toFixed(2));
        return amount;
    }

    function recalcAll() {
        let subtotal = 0;
        $('.item-row').each(function() { subtotal += calcRow(this); });
        const discount = parseFloat($('#discountInput').val()) || 0;
        const total = Math.max(0, subtotal - discount);
        $('#summarySubtotal').text('$' + subtotal.toFixed(2));
        $('#summaryDiscount').text('-$' + discount.toFixed(2));
        $('#summaryTotal').text('$' + total.toFixed(2));
    }

    $(document).on('input', '.qty-input, .rate-input', function() { recalcAll(); });
    $(document).on('input', '#discountInput', recalcAll);

    $(document).on('click', '#addRow', function() {
        const row = `
        <tr class="item-row">
            <td><input type="text" name="items[${rowIndex}][description]" class="form-control form-control-sm" placeholder="Service description" required></td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control form-control-sm qty-input" value="1" min="0" step="0.01" required></td>
            <td><input type="number" name="items[${rowIndex}][rate]" class="form-control form-control-sm rate-input" value="0" min="0" step="0.01" required></td>
            <td class="text-end fw-semibold amount-cell">$0.00</td>
            <td class="text-center"><button type="button" class="remove-row" title="Remove"><i class="bi bi-x-circle-fill"></i></button></td>
        </tr>`;
        $('#itemsBody').append(row);
        rowIndex++;
        recalcAll();
    });

    $(document).on('click', '.remove-row', function() {
        if ($('.item-row').length > 1) {
            $(this).closest('tr').remove();
            recalcAll();
        }
    });

    // Quick Add from packages/addons
    $(document).on('click', '.quick-add-btn', function() {
        const desc = $(this).data('desc');
        const rate = $(this).data('rate');
        const qty  = $(this).data('qty');
        const row = `
        <tr class="item-row">
            <td><input type="text" name="items[${rowIndex}][description]" class="form-control form-control-sm" value="${desc}" required></td>
            <td><input type="number" name="items[${rowIndex}][quantity]" class="form-control form-control-sm qty-input" value="${qty}" min="0" step="0.01" required></td>
            <td><input type="number" name="items[${rowIndex}][rate]" class="form-control form-control-sm rate-input" value="${rate}" min="0" step="0.01" required></td>
            <td class="text-end fw-semibold amount-cell">$0.00</td>
            <td class="text-center"><button type="button" class="remove-row" title="Remove"><i class="bi bi-x-circle-fill"></i></button></td>
        </tr>`;
        $('#itemsBody').append(row);
        rowIndex++;
        recalcAll();
    });

    recalcAll();
})(jQuery);
</script>
@endpush

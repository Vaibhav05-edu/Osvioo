<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; margin: 0; padding: 0; font-size: 13px; line-height: 1.5; }
        .invoice-container { padding: 40px; position: relative; }
        .watermark { position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 6rem; color: rgba(0,0,0,0.03); z-index: -1; white-space: nowrap; }
        
        /* Header */
        .header { width: 100%; margin-bottom: 30px; }
        .header table { width: 100%; border-collapse: collapse; }
        .invoice-title { font-size: 28px; color: #6a3be3; margin: 0 0 5px 0; font-weight: bold; }
        .status-badge { display: inline-block; background-color: #6a3be3; color: #fff; font-size: 10px; padding: 2px 8px; border-radius: 4px; vertical-align: middle; text-transform: uppercase; font-weight: bold; margin-left: 10px; }
        .status-unpaid { background-color: #f59e0b; }
        .status-paid { background-color: #10b981; }
        
        .meta-info table { width: 300px; border-collapse: collapse; }
        .meta-info td { padding: 3px 0; font-size: 12px; }
        .meta-label { color: #888; width: 100px; }
        
        .logo-placeholder { font-size: 50px; color: #6a3be3; font-weight: bold; font-family: serif; text-align: right; }

        /* Billed By / To Boxes */
        .billing-boxes { width: 100%; margin-bottom: 30px; border-collapse: separate; border-spacing: 20px 0; }
        .billing-boxes td { width: 50%; background-color: #f4f0ff; padding: 20px; border-radius: 8px; vertical-align: top; }
        .box-title { color: #6a3be3; font-size: 14px; font-weight: bold; margin-bottom: 10px; }
        
        /* Items Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th { background-color: #6a3be3; color: #fff; padding: 10px; text-align: left; font-size: 12px; }
        .items-table th.text-right { text-align: right; }
        .items-table th.text-center { text-align: center; }
        .items-table td { padding: 10px; border-bottom: 1px solid #eee; font-size: 12px; }
        .items-table td.text-right { text-align: right; }
        .items-table td.text-center { text-align: center; }
        
        /* Totals Section */
        .totals-wrapper { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .totals-wrapper > tbody > tr > td { vertical-align: top; }
        
        /* Left side: In words and Bank Details */
        .left-details { padding-right: 20px; width: 60%; }
        .in-words { margin-bottom: 20px; font-size: 11px; }
        .bank-details-box { background-color: #f4f0ff; padding: 15px; border-radius: 8px; font-size: 11px; }
        .bank-details-box table { width: 100%; border-collapse: collapse; }
        .bank-details-box td { padding: 3px 0; }
        .bank-label { font-weight: bold; color: #6a3be3; width: 100px; }
        
        /* Right side: Totals */
        .right-totals { width: 40%; }
        .totals-table { width: 100%; border-collapse: collapse; font-size: 12px; }
        .totals-table td { padding: 8px 0; text-align: right; }
        .totals-table td.label { text-align: left; color: #555; }
        .totals-table tr.grand-total td { font-weight: bold; font-size: 14px; border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 10px 0; }
        
        /* Footer */
        .footer-terms { font-size: 11px; color: #555; }
        .footer-terms .title { color: #6a3be3; font-size: 13px; font-weight: bold; margin-bottom: 5px; }
        
        .page-footer { text-align: center; font-size: 9px; color: #999; margin-top: 50px; }
    </style>
</head>
<body>
    @php
        $details = is_array($invoice->details) ? $invoice->details : [];
        $items = $details['items'] ?? [];
        $currSymbol = $details['currency_symbol'] ?? '$';
        $currCode = $details['currency_code'] ?? 'USD';
        
        $billedBy = $details['billed_by'] ?? [];
        $billedTo = $details['billed_to'] ?? [];
        $bankDetails = $details['bank_details'] ?? [];
        
        $subtotal = $details['subtotal'] ?? $invoice->amount;
        $discount = $details['discount'] ?? 0;
        $charges = $details['additional_charges'] ?? 0;
        
        $statusClass = $invoice->status == 'paid' ? 'status-paid' : 'status-unpaid';
        
        $amountInWords = '';
        if (class_exists('NumberFormatter')) {
            $f = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
            $amountInWords = strtoupper($f->format($invoice->amount));
        }
    @endphp

    <div class="invoice-container">
        @if(!$invoice->watermark_removed)
            <div class="watermark">{{ site_settings('site_name', 'Osvioo') }} - PREVIEW</div>
        @endif

        <!-- Header -->
        <div class="header">
            <table>
                <tr>
                    <td style="vertical-align: top;">
                        <h1 class="invoice-title">
                            Invoice 
                            <span class="status-badge {{ $statusClass }}">{{ $invoice->status }}</span>
                        </h1>
                        <div class="meta-info">
                            <table>
                                <tr>
                                    <td class="meta-label">Invoice No</td>
                                    <td><b>{{ $details['invoice_number'] ?? $invoice->uid }}</b></td>
                                </tr>
                                <tr>
                                    <td class="meta-label">Invoice Date</td>
                                    <td><b>{{ $invoice->created_at->format('M d, Y') }}</b></td>
                                </tr>
                                @if(!empty($details['due_date']))
                                <tr>
                                    <td class="meta-label">Due Date</td>
                                    <td><b>{{ \Carbon\Carbon::parse($details['due_date'])->format('M d, Y') }}</b></td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </td>
                    <td class="logo-placeholder">
                        <!-- Abstract Logo Placeholder, similar to Refrens 'V' -->
                        <span style="font-style: italic;">O</span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Billed By / Billed To -->
        <table class="billing-boxes">
            <tr>
                <td>
                    <div class="box-title">Billed By</div>
                    <b>{{ $billedBy['name'] ?? 'User' }}</b><br>
                    @if(!empty($billedBy['address'])) {!! nl2br(e($billedBy['address'])) !!}<br> @endif
                    @if(!empty($billedBy['email'])) Email: {{ $billedBy['email'] }}<br> @endif
                    @if(!empty($billedBy['phone'])) Phone: {{ $billedBy['phone'] }} @endif
                </td>
                <td>
                    <div class="box-title">Billed To</div>
                    <b>{{ $billedTo['name'] ?? 'Client' }}</b><br>
                    @if(!empty($billedTo['address'])) {!! nl2br(e($billedTo['address'])) !!} @endif
                </td>
            </tr>
        </table>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="45%">Item</th>
                    <th width="15%" class="text-center">Quantity</th>
                    <th width="15%" class="text-right">Rate</th>
                    <th width="20%" class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(count($items) > 0)
                    @foreach($items as $idx => $item)
                    <tr>
                        <td>{{ $idx + 1 }}.</td>
                        <td>{{ $item['description'] ?? 'Service' }}</td>
                        <td class="text-center">{{ rtrim(rtrim(number_format($item['quantity'] ?? 1, 2), '0'), '.') }}</td>
                        <td class="text-right">{{ $currSymbol }}{{ number_format((float)($item['rate'] ?? 0), 2) }}</td>
                        <td class="text-right">{{ $currSymbol }}{{ number_format((float)($item['amount'] ?? 0), 2) }}</td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>1.</td>
                        <td>Service</td>
                        <td class="text-center">1</td>
                        <td class="text-right">{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</td>
                        <td class="text-right">{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- Totals and Bank Details -->
        <table class="totals-wrapper">
            <tr>
                <td class="left-details">
                    @if($amountInWords)
                    <div class="in-words">
                        Total (in words): <b>{{ $amountInWords }} {{ $currCode }} ONLY</b>
                    </div>
                    @endif

                    @if(!empty($bankDetails['account_number']) || !empty($bankDetails['upi_id']))
                    <div class="bank-details-box">
                        <div class="box-title">Bank Details</div>
                        <table>
                            @if(!empty($bankDetails['account_name']))
                            <tr>
                                <td class="bank-label">Account Name</td>
                                <td>{{ $bankDetails['account_name'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($bankDetails['account_number']))
                            <tr>
                                <td class="bank-label">Account Number</td>
                                <td>{{ $bankDetails['account_number'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($bankDetails['ifsc']))
                            <tr>
                                <td class="bank-label">IFSC</td>
                                <td>{{ $bankDetails['ifsc'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($bankDetails['account_type']))
                            <tr>
                                <td class="bank-label">Account Type</td>
                                <td>{{ $bankDetails['account_type'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($bankDetails['bank_name']))
                            <tr>
                                <td class="bank-label">Bank</td>
                                <td>{{ $bankDetails['bank_name'] }}</td>
                            </tr>
                            @endif
                            @if(!empty($details['upi_id']))
                            <tr>
                                <td class="bank-label">UPI ID</td>
                                <td>{{ $details['upi_id'] }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    @endif
                </td>
                <td class="right-totals">
                    <table class="totals-table">
                        @if($discount > 0 || $charges > 0)
                        <tr>
                            <td class="label">Subtotal</td>
                            <td>{{ $currSymbol }}{{ number_format($subtotal, 2) }}</td>
                        </tr>
                        @endif
                        @if($discount > 0)
                        <tr>
                            <td class="label">Discounts</td>
                            <td>-{{ $currSymbol }}{{ number_format($discount, 2) }}</td>
                        </tr>
                        @endif
                        @if($charges > 0)
                        <tr>
                            <td class="label">Additional Charges</td>
                            <td>{{ $currSymbol }}{{ number_format($charges, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="grand-total">
                            <td class="label">Total ({{ $currCode }})</td>
                            <td>{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</td>
                        </tr>
                        @if($invoice->status == 'paid')
                        <tr>
                            <td class="label">Amount Paid</td>
                            <td>({{ $currSymbol }}{{ number_format($invoice->amount, 2) }})</td>
                        </tr>
                        <tr>
                            <td class="label">Due Amount</td>
                            <td>{{ $currSymbol }}0.00</td>
                        </tr>
                        @else
                        <tr>
                            <td class="label">Due Amount</td>
                            <td>{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>

        <!-- Terms and Notes -->
        <div class="footer-terms">
            @if(!empty($details['terms']))
            <div class="title">Terms and Conditions</div>
            <div>{!! nl2br(e($details['terms'])) !!}</div>
            <br>
            @endif
            
            @if(!empty($details['notes']))
            <div class="title">Notes</div>
            <div>{!! nl2br(e($details['notes'])) !!}</div>
            @endif
        </div>

        <div class="page-footer">
            This is an electronically generated document, no signature is required.
        </div>
    </div>
</body>
</html>

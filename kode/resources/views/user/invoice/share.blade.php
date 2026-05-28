<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta_data['title'] ?? 'Invoice' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f3f4f6; color: #374151; margin: 0; padding: 40px 20px; font-size: 14px; line-height: 1.5; }
        .invoice-wrapper { max-width: 850px; margin: 0 auto; }
        .invoice-box { background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); position: relative; overflow: hidden; }
        .watermark { position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%) rotate(-30deg); font-size: 6rem; color: rgba(0,0,0,0.03); z-index: 0; white-space: nowrap; user-select: none; pointer-events: none; }
        
        .invoice-content { position: relative; z-index: 1; }
        
        /* Header */
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .invoice-title { font-size: 32px; color: #6a3be3; margin: 0 0 10px 0; font-weight: 700; display: flex; align-items: center; gap: 15px; }
        .status-badge { background-color: #6a3be3; color: #fff; font-size: 12px; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; }
        .status-unpaid { background-color: #f59e0b; }
        .status-paid { background-color: #10b981; }
        
        .meta-info { display: grid; grid-template-columns: 120px 1fr; gap: 8px; font-size: 13px; }
        .meta-label { color: #6b7280; }
        .meta-value { font-weight: 600; color: #111827; }
        
        .logo-placeholder { font-size: 60px; color: #6a3be3; font-weight: 800; font-family: Georgia, serif; font-style: italic; line-height: 1; }

        /* Billed By / To Boxes */
        .billing-boxes { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 40px; }
        .billing-box { background-color: #f5f3ff; padding: 24px; border-radius: 12px; }
        .box-title { color: #6a3be3; font-size: 15px; font-weight: 700; margin-bottom: 12px; }
        .box-content { font-size: 14px; color: #374151; }
        .box-content strong { color: #111827; font-size: 15px; display: block; margin-bottom: 4px; }
        
        /* Items Table */
        .table-responsive { overflow-x: auto; margin-bottom: 30px; }
        .items-table { width: 100%; border-collapse: collapse; min-width: 600px; }
        .items-table th { background-color: #6a3be3; color: #fff; padding: 12px 16px; text-align: left; font-size: 13px; font-weight: 600; border: none; }
        .items-table th.text-right { text-align: right; }
        .items-table th.text-center { text-align: center; }
        .items-table th:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; }
        .items-table th:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; }
        .items-table td { padding: 16px; border-bottom: 1px solid #f3f4f6; font-size: 14px; color: #111827; }
        .items-table td.text-right { text-align: right; }
        .items-table td.text-center { text-align: center; }
        .items-table tr:last-child td { border-bottom: none; }
        
        /* Totals Section */
        .totals-section { display: flex; justify-content: space-between; gap: 40px; margin-bottom: 40px; flex-wrap: wrap; }
        
        /* Left side: In words and Bank Details */
        .left-details { flex: 1; min-width: 300px; }
        .in-words { margin-bottom: 24px; font-size: 13px; color: #4b5563; }
        .in-words strong { color: #111827; }
        .bank-details-box { background-color: #f5f3ff; padding: 20px; border-radius: 12px; }
        .bank-details-box table { width: 100%; border-collapse: collapse; font-size: 13px; }
        .bank-details-box td { padding: 6px 0; }
        .bank-label { font-weight: 600; color: #6a3be3; width: 130px; }
        .bank-val { color: #111827; font-weight: 500; }
        
        /* Right side: Totals */
        .right-totals { width: 320px; }
        .totals-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .totals-table td { padding: 10px 0; text-align: right; color: #111827; font-weight: 500; }
        .totals-table td.label { text-align: left; color: #4b5563; }
        .totals-table tr.grand-total td { font-weight: 700; font-size: 18px; border-top: 2px solid #e5e7eb; border-bottom: 2px solid #e5e7eb; padding: 16px 0; color: #111827; }
        
        /* Footer */
        .footer-terms { font-size: 13px; color: #4b5563; }
        .footer-terms .title { color: #6a3be3; font-size: 14px; font-weight: 700; margin-bottom: 8px; }
        .footer-section { margin-bottom: 24px; }
        
        /* Actions */
        .actions { text-align: center; margin-top: 40px; }
        .btn-download { display: inline-flex; align-items: center; gap: 8px; padding: 12px 32px; background: #6a3be3; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 15px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(106, 59, 227, 0.2); }
        .btn-download:hover { background: #5a2bd1; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(106, 59, 227, 0.3); }
        
        @media (max-width: 768px) {
            .billing-boxes { grid-template-columns: 1fr; }
            .totals-section { flex-direction: column; }
            .right-totals { width: 100%; }
        }
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
        
        function numberToWordsHtml($number) {
            $f = new \NumberFormatter( 'en', \NumberFormatter::SPELLOUT );
            return strtoupper($f->format($number));
        }
        $amountInWords = class_exists('NumberFormatter') ? numberToWordsHtml($invoice->amount) : '';
    @endphp

    <div class="invoice-wrapper">
        <div class="invoice-box">
            @if(!$invoice->watermark_removed)
                <div class="watermark">{{ site_settings('site_name', 'Osvioo') }} - PREVIEW</div>
            @endif

            <div class="invoice-content">
                <!-- Header -->
                <div class="header">
                    <div>
                        <h1 class="invoice-title">
                            Invoice 
                            <span class="status-badge {{ $statusClass }}">{{ $invoice->status }}</span>
                        </h1>
                        <div class="meta-info">
                            <div class="meta-label">Invoice No</div>
                            <div class="meta-value">{{ $details['invoice_number'] ?? $invoice->uid }}</div>
                            
                            <div class="meta-label">Invoice Date</div>
                            <div class="meta-value">{{ $invoice->created_at->format('M d, Y') }}</div>
                            
                            @if(!empty($details['due_date']))
                            <div class="meta-label">Due Date</div>
                            <div class="meta-value">{{ \Carbon\Carbon::parse($details['due_date'])->format('M d, Y') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="logo-placeholder">
                        O
                    </div>
                </div>

                <!-- Billed By / Billed To -->
                <div class="billing-boxes">
                    <div class="billing-box">
                        <div class="box-title">Billed By</div>
                        <div class="box-content">
                            <strong>{{ $billedBy['name'] ?? 'User' }}</strong>
                            @if(!empty($billedBy['address'])) <div>{!! nl2br(e($billedBy['address'])) !!}</div><br> @endif
                            @if(!empty($billedBy['email'])) <div>Email: {{ $billedBy['email'] }}</div> @endif
                            @if(!empty($billedBy['phone'])) <div>Phone: {{ $billedBy['phone'] }}</div> @endif
                        </div>
                    </div>
                    <div class="billing-box">
                        <div class="box-title">Billed To</div>
                        <div class="box-content">
                            <strong>{{ $billedTo['name'] ?? 'Client' }}</strong>
                            @if(!empty($billedTo['address'])) <div>{!! nl2br(e($billedTo['address'])) !!}</div> @endif
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="table-responsive">
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
                </div>

                <!-- Totals and Bank Details -->
                <div class="totals-section">
                    <div class="left-details">
                        @if($amountInWords)
                        <div class="in-words">
                            Total (in words): <br><strong>{{ $amountInWords }} {{ $currCode }} ONLY</strong>
                        </div>
                        @endif

                        @if(!empty($bankDetails['account_number']) || !empty($bankDetails['upi_id']))
                        <div class="bank-details-box">
                            <div class="box-title">Bank Details</div>
                            <table>
                                @if(!empty($bankDetails['account_name']))
                                <tr>
                                    <td class="bank-label">Account Name</td>
                                    <td class="bank-val">{{ $bankDetails['account_name'] }}</td>
                                </tr>
                                @endif
                                @if(!empty($bankDetails['account_number']))
                                <tr>
                                    <td class="bank-label">Account Number</td>
                                    <td class="bank-val">{{ $bankDetails['account_number'] }}</td>
                                </tr>
                                @endif
                                @if(!empty($bankDetails['ifsc']))
                                <tr>
                                    <td class="bank-label">IFSC</td>
                                    <td class="bank-val">{{ $bankDetails['ifsc'] }}</td>
                                </tr>
                                @endif
                                @if(!empty($bankDetails['account_type']))
                                <tr>
                                    <td class="bank-label">Account Type</td>
                                    <td class="bank-val">{{ $bankDetails['account_type'] }}</td>
                                </tr>
                                @endif
                                @if(!empty($bankDetails['bank_name']))
                                <tr>
                                    <td class="bank-label">Bank</td>
                                    <td class="bank-val">{{ $bankDetails['bank_name'] }}</td>
                                </tr>
                                @endif
                                @if(!empty($details['upi_id']))
                                <tr>
                                    <td class="bank-label">UPI ID</td>
                                    <td class="bank-val">{{ $details['upi_id'] }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        @endif
                    </div>
                    
                    <div class="right-totals">
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
                    </div>
                </div>

                <!-- Terms and Notes -->
                <div class="footer-terms">
                    @if(!empty($details['terms']))
                    <div class="footer-section">
                        <div class="title">Terms and Conditions</div>
                        <div>{!! nl2br(e($details['terms'])) !!}</div>
                    </div>
                    @endif
                    
                    @if(!empty($details['notes']))
                    <div class="footer-section">
                        <div class="title">Notes</div>
                        <div>{!! nl2br(e($details['notes'])) !!}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="actions">
            <a href="{{ route('user.invoice.download', $invoice->uid) }}" class="btn-download">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                Download PDF
            </a>
        </div>
    </div>
</body>
</html>

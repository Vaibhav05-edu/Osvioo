<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta_data['title'] ?? 'Invoice' }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; background: #f4f7f6; padding: 40px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; line-height: 24px; color: #555; background: #fff; position: relative; }
        .watermark { position: absolute; top: 30%; left: 10%; font-size: 6rem; color: rgba(0,0,0,0.05); transform: rotate(-30deg); user-select: none; z-index: 0; white-space: nowrap; }
        .invoice-box table { width: 100%; line-height: inherit; text-align: left; position: relative; z-index: 1; }
        .invoice-box table td { padding: 5px; vertical-align: top; }
        .invoice-box table tr td:nth-child(2) { text-align: right; }
        .invoice-box table tr.top table td { padding-bottom: 20px; }
        .invoice-box table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        .invoice-box table tr.item td { border-bottom: 1px solid #eee; }
        .invoice-box table tr.item.last td { border-bottom: none; }
        .invoice-box table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        @if(!$invoice->watermark_removed)
            <div class="watermark">{{ site_settings('site_name', 'Osvioo') }} - PREVIEW</div>
        @endif
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h2>{{ site_settings('site_name', 'Osvioo') }}</h2>
                            </td>
                            <td>
                                Invoice #: {{ $invoice->uid }}<br>
                                Created: {{ $invoice->created_at->format('M d, Y') }}<br>
                                Status: {{ ucfirst($invoice->status) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>From:</strong><br>
                                {{ $invoice->user->name }}<br>
                                {{ $invoice->user->email }}
                            </td>
                            <td>
                                <strong>To:</strong><br>
                                {{ $invoice->brand_name ?? 'Platform' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>Item</td>
                <td>Price</td>
            </tr>
            @php
                $details    = is_array($invoice->details) ? $invoice->details : [];
                $items      = isset($details['items']) ? $details['items'] : (isset($details[0]) ? $details : []);
                $currSymbol = $details['currency_symbol'] ?? '$';
                $currCode   = $details['currency_code'] ?? 'USD';
                $notes      = $details['notes'] ?? null;
                $dueDate    = $details['due_date'] ?? null;
            @endphp
            @if(count($items) > 0)
                @foreach($items as $item)
                <tr class="item">
                    <td>{{ $item['description'] ?? 'Service' }}</td>
                    <td>{{ $currSymbol }}{{ number_format((float)($item['price'] ?? 0), 2) }}</td>
                </tr>
                @endforeach
            @else
                <tr class="item">
                    <td>Service</td>
                    <td>{{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</td>
                </tr>
            @endif
            <tr class="total">
                <td></td>
                <td>Total ({{ $currCode }}): {{ $currSymbol }}{{ number_format($invoice->amount, 2) }}</td>
            </tr>
            @if($dueDate)
            <tr>
                <td colspan="2" style="padding-top:10px; color:#888; font-size:13px;">Due Date: {{ \Carbon\Carbon::parse($dueDate)->format('M d, Y') }}</td>
            </tr>
            @endif
            @if($notes)
            <tr>
                <td colspan="2" style="padding-top:14px; font-size:13px; border-top:1px solid #eee;"><strong>Notes:</strong><br>{{ $notes }}</td>
            </tr>
            @endif
        </table>
        
        <div style="text-align: center; margin-top: 40px; position: relative; z-index: 1;">
            <a href="{{ route('user.invoice.download', $invoice->uid) }}" style="padding: 10px 25px; background: linear-gradient(90deg,#6366f1,#8b5cf6); color: white; text-decoration: none; border-radius: 8px; font-weight:700;">&#8659; Download PDF</a>
        </div>
    </div>
</body>
</html>

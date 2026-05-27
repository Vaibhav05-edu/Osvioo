<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice PDF</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; padding: 20px; }
        .invoice-box { font-size: 16px; line-height: 24px; color: #555; position: relative; }
        .watermark { position: absolute; top: 40%; left: 5%; font-size: 6rem; color: rgba(0,0,0,0.05); transform: rotate(-30deg); z-index: -1; }
        table { width: 100%; text-align: left; border-collapse: collapse; }
        table td { padding: 5px; vertical-align: top; }
        table tr td:nth-child(2) { text-align: right; }
        table tr.heading td { background: #eee; border-bottom: 1px solid #ddd; font-weight: bold; }
        table tr.item td { border-bottom: 1px solid #eee; }
        table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
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
                                {{ $invoice->user->name ?? 'User' }}<br>
                                {{ $invoice->user->email ?? '' }}
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
            @if(is_array($invoice->details) || is_object($invoice->details))
                @foreach($invoice->details as $item)
                <tr class="item">
                    <td>{{ $item['description'] ?? 'Service' }}</td>
                    <td>{{ num_format($item['price'] ?? 0) }}</td>
                </tr>
                @endforeach
            @else
                <tr class="item">
                    <td>Service</td>
                    <td>{{ num_format($invoice->amount) }}</td>
                </tr>
            @endif
            <tr class="total">
                <td></td>
                <td>Total: {{ num_format($invoice->amount) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>

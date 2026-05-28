<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Schema;

class InvoiceController extends Controller
{
    public function list()
    {
        $invoices = Invoice::where('user_id', auth_user('web')->id)->latest()->paginate(15);
        $meta_data = $this->metaData(['title' => translate("My Invoices")]);
        return view('user.invoice.list', compact('invoices', 'meta_data'));
    }

    public function create()
    {
        $meta_data = $this->metaData(['title' => translate("Create Invoice")]);
        return view('user.invoice.create', compact('meta_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name'       => 'required|string|max:255',
            'amount'           => 'required|numeric|min:0',
            'details'          => 'nullable|array',
            'details.*.description' => 'required_with:details|string|max:500',
            'details.*.price'       => 'required_with:details|numeric|min:0',
            'due_date'         => 'nullable|date|after_or_equal:today',
            'notes'            => 'nullable|string|max:1000',
        ]);

        try {
            $currency = session()->get('currency');

            $invoice              = new Invoice();
            $invoice->uid         = (string) Str::uuid();
            $invoice->user_id     = auth_user('web')->id;
            $invoice->type        = 'brand';
            $invoice->brand_name  = $request->brand_name;
            $invoice->amount      = $request->amount;
            $invoice->status      = 'unpaid';

            // Build rich details payload
            $detailsPayload = [
                'items'         => collect($request->details ?? [])->values()->map(function ($item) {
                    return [
                        'description' => $item['description'] ?? '',
                        'price'       => (float) ($item['price'] ?? 0),
                    ];
                })->toArray(),
                'currency_code'   => optional($currency)->code   ?? 'USD',
                'currency_symbol' => optional($currency)->symbol ?? '$',
                'due_date'        => $request->due_date,
                'notes'           => $request->notes,
            ];

            $invoice->details = $detailsPayload;
            $invoice->save();

            return redirect()->route('user.invoice.list')
                ->with('success', translate('Invoice created successfully.'));

        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', translate('Could not save invoice. Please ensure the database is up to date (run php artisan migrate).'));
        }
    }

    public function download($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();

        if (auth_user('web') && auth_user('web')->id !== $invoice->user_id && auth_user('admin') == null) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.invoice.pdf', compact('invoice'));
        return $pdf->download('Invoice-' . $invoice->uid . '.pdf');
    }

    public function share($uid)
    {
        $invoice   = Invoice::where('uid', $uid)->firstOrFail();
        $meta_data = $this->metaData(['title' => translate("Invoice ") . $invoice->uid]);
        return view('user.invoice.share', compact('invoice', 'meta_data'));
    }

    public function requestWatermarkRemoval($uid)
    {
        $invoice = Invoice::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();

        if ($invoice->watermark_request_status == 'pending') {
            return back()->with('error', translate('Watermark removal request is already pending.'));
        }

        $invoice->watermark_request_status = 'pending';
        $invoice->save();

        return back()->with('success', translate('Watermark removal requested successfully.'));
    }
}

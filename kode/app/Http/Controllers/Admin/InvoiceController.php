<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Admin invoice list — shows all user invoices AND admin-generated invoices.
     */
    public function list()
    {
        $invoices  = Invoice::with('user')->latest()->paginate(20);
        $meta_data = $this->metaData(['title' => translate('Invoices Management')]);
        return view('admin.invoice.list', compact('invoices', 'meta_data'));
    }

    /**
     * Show the admin invoice creation form.
     */
    public function create()
    {
        $users     = User::orderBy('name')->get(['id', 'name', 'email']);
        $packages  = Package::orderBy('title')->get(['id', 'title', 'price']);
        $addons    = Addon::where('status', 1)->orderBy('title')->get(['id', 'title', 'price', 'type']);
        $meta_data = $this->metaData(['title' => translate('Create Admin Invoice')]);
        return view('admin.invoice.create', compact('users', 'packages', 'addons', 'meta_data'));
    }

    /**
     * Store a new admin-generated invoice.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'             => 'required|exists:users,id',
            'items'               => 'required|array|min:1',
            'items.*.description' => 'required|string|max:500',
            'items.*.quantity'    => 'required|numeric|min:0',
            'items.*.rate'        => 'required|numeric|min:0',
            'due_date'            => 'nullable|date',
            'notes'               => 'nullable|string|max:1000',
            'discount'            => 'nullable|numeric|min:0',
        ]);

        $user     = User::findOrFail($request->user_id);
        $subtotal = 0;
        $items    = [];

        foreach ($request->items as $item) {
            $qty    = (float) ($item['quantity'] ?? 1);
            $rate   = (float) ($item['rate'] ?? 0);
            $amount = $qty * $rate;
            $subtotal += $amount;
            $items[] = [
                'description' => trim($item['description']),
                'quantity'    => $qty,
                'rate'        => $rate,
                'amount'      => $amount,
            ];
        }

        $discount = (float) ($request->discount ?? 0);
        $total    = $subtotal - $discount;

        // Auto invoice number for admin invoices
        $count         = Invoice::where('type', 'admin')->count() + 1;
        $invoiceNumber = 'ADM-' . str_pad($count, 4, '0', STR_PAD_LEFT);

        $invoice                           = new Invoice();
        $invoice->uid                      = (string) Str::uuid();
        $invoice->user_id                  = $user->id;
        $invoice->type                     = 'admin';
        $invoice->brand_name               = site_settings('site_name', 'Osvioo');
        $invoice->amount                   = max(0, $total);
        $invoice->status                   = 'unpaid';
        $invoice->watermark_removed        = true; // Admin invoices have no watermark
        $invoice->details = [
            'invoice_number'  => $invoiceNumber,
            'billed_by'       => [
                'name'    => site_settings('site_name', 'Osvioo'),
                'email'   => site_settings('site_email', ''),
                'address' => site_settings('site_address', ''),
            ],
            'billed_to'       => [
                'name'    => $user->name,
                'email'   => $user->email,
                'address' => '',
            ],
            'items'           => $items,
            'subtotal'        => $subtotal,
            'discount'        => $discount,
            'currency_code'   => 'USD',
            'currency_symbol' => '$',
            'due_date'        => $request->due_date,
            'notes'           => $request->notes,
            'invoice_type'    => 'admin', // marks it as an admin invoice in the view
        ];

        $invoice->save();

        return redirect()->route('admin.invoice.list')
            ->with('success', translate('Admin invoice created successfully.'));
    }

    /**
     * Download an invoice as PDF (admin can download any invoice).
     */
    public function download($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();

        $pdf = Pdf::loadView('user.invoice.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        if (ob_get_length()) {
            ob_end_clean();
        }

        return $pdf->download('Invoice-' . ($invoice->details['invoice_number'] ?? $invoice->uid) . '.pdf');
    }

    /**
     * Approve watermark removal request.
     */
    public function approveWatermark($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        $invoice->watermark_removed         = true;
        $invoice->watermark_request_status  = 'approved';
        $invoice->save();

        return back()->with('success', translate('Watermark removed successfully.'));
    }

    /**
     * Reject watermark removal request.
     */
    public function rejectWatermark($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        $invoice->watermark_request_status = 'rejected';
        $invoice->save();

        return back()->with('success', translate('Watermark removal request rejected.'));
    }
}

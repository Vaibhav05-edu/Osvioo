<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function list(Request $request)
    {
        $query = Invoice::where('user_id', auth_user('web')->id);
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $invoices  = $query->latest()->paginate(15);
        $meta_data = $this->metaData(['title' => translate("My Invoices")]);
        return view('user.invoice.list', compact('invoices', 'meta_data'));
    }

    public function create()
    {
        $user = auth_user('web');

        // Enforce invoice limit
        $limitError = $this->checkInvoiceLimit($user);
        if ($limitError) {
            return redirect()->route('user.invoice.list')->with('error', $limitError);
        }

        $meta_data = $this->metaData(['title' => translate("Create Invoice")]);

        // Auto-generate next invoice number
        $count         = Invoice::where('user_id', $user->id)->count() + 1;
        $invoiceNumber = 'INV-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('user.invoice.create', compact('meta_data', 'user', 'invoiceNumber'));
    }

    public function store(Request $request)
    {
        // Enforce invoice limit
        $limitError = $this->checkInvoiceLimit(auth_user('web'));
        if ($limitError) {
            return redirect()->route('user.invoice.list')->with('error', $limitError);
        }
        $request->validate([
            'brand_name'               => 'required|string|max:255',
            'billed_to_address'        => 'nullable|string|max:500',
            'billed_by_phone'          => 'nullable|string|max:50',
            'billed_by_address'        => 'nullable|string|max:500',
            'items'                    => 'required|array|min:1',
            'items.*.description'      => 'required|string|max:500',
            'items.*.quantity'         => 'required|numeric|min:0',
            'items.*.rate'             => 'required|numeric|min:0',
            'due_date'                 => 'nullable|date',
            'notes'                    => 'nullable|string|max:1000',
            'terms'                    => 'nullable|string|max:2000',
            'discount'                 => 'nullable|numeric|min:0',
            'additional_charges'       => 'nullable|numeric|min:0',
            'bank_account_name'        => 'nullable|string|max:255',
            'bank_account_number'      => 'nullable|string|max:50',
            'bank_ifsc'                => 'nullable|string|max:30',
            'bank_account_type'        => 'nullable|string|max:50',
            'bank_name'                => 'nullable|string|max:255',
            'upi_id'                   => 'nullable|string|max:100',
        ]);

        try {
            $currency = session()->get('currency') ?? base_currency();
            $user     = auth_user('web');

            // Build items & calculate subtotal
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

            $discount           = (float) ($request->discount ?? 0);
            $additional_charges = (float) ($request->additional_charges ?? 0);
            $total              = $subtotal - $discount + $additional_charges;

            // Auto invoice number
            $count         = Invoice::where('user_id', $user->id)->count() + 1;
            $invoiceNumber = 'INV-' . str_pad($count, 3, '0', STR_PAD_LEFT);

            $invoice           = new Invoice();
            $invoice->uid      = (string) Str::uuid();
            $invoice->user_id  = $user->id;
            $invoice->type     = 'brand';
            $invoice->brand_name = $request->brand_name;
            $invoice->amount   = $total;
            $invoice->status   = 'unpaid';

            $invoice->details  = [
                'invoice_number'     => $invoiceNumber,
                'billed_by'          => [
                    'name'    => $user->name,
                    'email'   => $user->email,
                    'phone'   => $request->billed_by_phone ?? '',
                    'address' => $request->billed_by_address ?? '',
                ],
                'billed_to'          => [
                    'name'    => $request->brand_name,
                    'address' => $request->billed_to_address ?? '',
                ],
                'items'              => $items,
                'subtotal'           => $subtotal,
                'discount'           => $discount,
                'additional_charges' => $additional_charges,
                'currency_code'      => optional($currency)->code ?? 'USD',
                'currency_symbol'    => optional($currency)->symbol ?? '$',
                'due_date'           => $request->due_date,
                'notes'              => $request->notes,
                'terms'              => $request->terms ?? 'Please pay within the given date from the date of invoice.',
                'bank_details'       => [
                    'account_name'   => $request->bank_account_name ?? '',
                    'account_number' => $request->bank_account_number ?? '',
                    'ifsc'           => $request->bank_ifsc ?? '',
                    'account_type'   => $request->bank_account_type ?? '',
                    'bank_name'      => $request->bank_name ?? '',
                ],
                'upi_id'             => $request->upi_id ?? '',
            ];

            $invoice->save();

            return redirect()->route('user.invoice.list')
                ->with('success', translate('Invoice created successfully.'));

        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', translate('Could not save invoice. Please ensure migrations are run: php artisan migrate. Error: ') . $e->getMessage());
        }
    }

    public function edit($uid)
    {
        $invoice = Invoice::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();
        $user = auth_user('web');
        $meta_data = $this->metaData(['title' => translate("Edit Invoice")]);

        return view('user.invoice.edit', compact('meta_data', 'user', 'invoice'));
    }

    public function update(Request $request, $uid)
    {
        $invoice = Invoice::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();

        $request->validate([
            'brand_name'               => 'required|string|max:255',
            'billed_to_address'        => 'nullable|string|max:500',
            'billed_by_phone'          => 'nullable|string|max:50',
            'billed_by_address'        => 'nullable|string|max:500',
            'items'                    => 'required|array|min:1',
            'items.*.description'      => 'required|string|max:500',
            'items.*.quantity'         => 'required|numeric|min:0',
            'items.*.rate'             => 'required|numeric|min:0',
            'due_date'                 => 'nullable|date',
            'notes'                    => 'nullable|string|max:1000',
            'terms'                    => 'nullable|string|max:2000',
            'discount'                 => 'nullable|numeric|min:0',
            'additional_charges'       => 'nullable|numeric|min:0',
            'bank_account_name'        => 'nullable|string|max:255',
            'bank_account_number'      => 'nullable|string|max:50',
            'bank_ifsc'                => 'nullable|string|max:30',
            'bank_account_type'        => 'nullable|string|max:50',
            'bank_name'                => 'nullable|string|max:255',
            'upi_id'                   => 'nullable|string|max:100',
        ]);

        try {
            $currency = session()->get('currency') ?? base_currency();
            
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

            $discount           = (float) ($request->discount ?? 0);
            $additional_charges = (float) ($request->additional_charges ?? 0);
            $total              = $subtotal - $discount + $additional_charges;

            $invoice->brand_name = $request->brand_name;
            $invoice->amount   = $total;

            $details = is_array($invoice->details) ? $invoice->details : [];
            $details['billed_by']['phone'] = $request->billed_by_phone ?? '';
            $details['billed_by']['address'] = $request->billed_by_address ?? '';
            $details['billed_to']['name'] = $request->brand_name;
            $details['billed_to']['address'] = $request->billed_to_address ?? '';
            $details['items'] = $items;
            $details['subtotal'] = $subtotal;
            $details['discount'] = $discount;
            $details['additional_charges'] = $additional_charges;
            $details['due_date'] = $request->due_date;
            $details['notes'] = $request->notes;
            $details['terms'] = $request->terms ?? '';
            $details['bank_details'] = [
                'account_name'   => $request->bank_account_name ?? '',
                'account_number' => $request->bank_account_number ?? '',
                'ifsc'           => $request->bank_ifsc ?? '',
                'account_type'   => $request->bank_account_type ?? '',
                'bank_name'      => $request->bank_name ?? '',
            ];
            $details['upi_id'] = $request->upi_id ?? '';

            $invoice->details = $details;
            
            if ($invoice->status == 'paid' && $invoice->amount > ($details['amount_paid'] ?? 0)) {
                $invoice->status = 'part_paid';
            }

            $invoice->save();

            return redirect()->route('user.invoice.list')
                ->with('success', translate('Invoice updated successfully.'));

        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', translate('Could not update invoice. Error: ') . $e->getMessage());
        }
    }

    public function download($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();

        $webUser = auth_user('web');
        if ($webUser && (int)$webUser->id !== (int)$invoice->user_id && auth_user('admin') == null) {
            abort(403, 'You do not have permission to download this invoice.');
        }

        try {
            $pdf = Pdf::loadView('user.invoice.pdf', compact('invoice'))
                ->setPaper('a4', 'portrait');

            if (ob_get_length()) {
                ob_end_clean();
            }

            $filename = 'Invoice-' . ($invoice->details['invoice_number'] ?? $invoice->uid) . '.pdf';

            $response = $pdf->download($filename);

            // Remove CSP headers that block PDF download in browsers
            $response->headers->remove('Content-Security-Policy');
            $response->headers->remove('Content-Security-Policy-Report-Only');
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
            $response->headers->set('X-Content-Type-Options', 'nosniff');
            $response->headers->set('Cache-Control', 'private, no-cache, no-store, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');

            return $response;
        } catch (\Exception $e) {
            return back()->with('error', 'Could not generate PDF: ' . $e->getMessage());
        }
    }

    public function updatePayment(Request $request, $uid)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0'
        ]);

        $invoice = Invoice::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();
        
        $details = is_array($invoice->details) ? $invoice->details : [];
        $currentPaid = (float)($details['amount_paid'] ?? 0);
        $newPayment = (float)$request->amount_paid;
        $totalPaid = $currentPaid + $newPayment;

        if ($totalPaid > $invoice->amount) {
            $totalPaid = $invoice->amount;
        }

        $details['amount_paid'] = $totalPaid;
        $invoice->details = $details;

        if ($totalPaid >= $invoice->amount) {
            $invoice->status = 'paid';
        } else if ($totalPaid > 0) {
            $invoice->status = 'part_paid';
        } else {
            $invoice->status = 'unpaid';
        }

        $invoice->save();

        return back()->with('success', translate('Payment status updated successfully.'));
    }

    public function share($uid)
    {
        $invoice   = Invoice::where('uid', $uid)->firstOrFail();
        $meta_data = $this->metaData(['title' => translate("Invoice ") . ($invoice->details['invoice_number'] ?? $invoice->uid)]);
        return view('user.invoice.share', compact('invoice', 'meta_data'));
    }

    public function sendEmail(Request $request, $uid)
    {
        $request->validate([
            'client_email' => 'required|email|max:255',
        ]);

        $invoice = Invoice::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();
        $details = is_array($invoice->details) ? $invoice->details : [];
        $invNum  = $details['invoice_number'] ?? $invoice->uid;

        try {
            $pdf = Pdf::loadView('user.invoice.pdf', compact('invoice'))->setPaper('a4', 'portrait');
            $pdfContent = $pdf->output();

            Mail::send([], [], function ($message) use ($request, $invoice, $invNum, $pdfContent) {
                $message->to($request->client_email)
                    ->subject('Invoice ' . $invNum . ' from ' . auth_user('web')->name)
                    ->setBody(
                        '<p>Dear Client,</p>' .
                        '<p>Please find attached your invoice <strong>' . $invNum . '</strong>.</p>' .
                        '<p>Amount Due: <strong>' . ($invoice->details['currency_symbol'] ?? '$') . number_format($invoice->amount, 2) . '</strong></p>' .
                        '<p>Thank you for your business!</p>' .
                        '<p>Regards,<br>' . auth_user('web')->name . '</p>',
                        'text/html'
                    )
                    ->attachData($pdfContent, 'Invoice-' . $invNum . '.pdf', ['mime' => 'application/pdf']);
            });

            return back()->with('success', translate('Invoice sent successfully to ') . $request->client_email);
        } catch (\Throwable $e) {
            return back()->with('error', translate('Failed to send invoice email. Error: ') . $e->getMessage());
        }
    }

    /**
     * Check invoice limit against subscription plan.
     * Returns an error string if limit exceeded, null if OK.
     */
    protected function checkInvoiceLimit($user): ?string
    {
        try {
            $subscription = $user->runningSubscription ?? $user->load('runningSubscription')->runningSubscription;
            if (!$subscription) {
                return null; // No subscription — allow (no limit enforced)
            }
            $package = $subscription->package ?? $subscription->load('package')->package;
            if (!$package) {
                return null;
            }
            $limit = (int) ($package->social_access->invoice_limit ?? -1);
            if ($limit === -1) {
                return null; // Unlimited
            }
            $currentCount = Invoice::where('user_id', $user->id)->where('type', 'brand')->count();
            if ($currentCount >= $limit) {
                return translate('You have reached your invoice limit (' . $limit . ') for your current plan. Please upgrade to create more invoices.');
            }
        } catch (\Throwable $e) {
            // On any error, allow creation
        }
        return null;
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

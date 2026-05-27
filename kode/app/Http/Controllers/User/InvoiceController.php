<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function list()
    {
        $invoices = Invoice::where('user_id', auth_user('web')->id)->latest()->paginate(15);
        $meta_data = $this->metaData(['title'=> translate("My Invoices")]);
        return view('user.invoice.list', compact('invoices', 'meta_data'));
    }

    public function create()
    {
        $meta_data = $this->metaData(['title'=> translate("Create Invoice")]);
        return view('user.invoice.create', compact('meta_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'details' => 'nullable|array',
        ]);

        $invoice = new Invoice();
        $invoice->uid = (string) Str::uuid();
        $invoice->user_id = auth_user('web')->id;
        $invoice->type = 'brand';
        $invoice->brand_name = $request->brand_name;
        $invoice->amount = $request->amount;
        $invoice->details = $request->details;
        $invoice->status = 'unpaid';
        $invoice->save();

        return redirect()->route('user.invoice.list')->with('success', translate('Invoice created successfully.'));
    }

    public function download($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        
        // Ensure user has access or it is a public share
        if (auth_user('web') && auth_user('web')->id !== $invoice->user_id && auth_user('admin') == null) {
            abort(403);
        }

        $pdf = Pdf::loadView('user.invoice.pdf', compact('invoice'));
        return $pdf->download('Invoice-' . $invoice->uid . '.pdf');
    }

    public function share($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        $meta_data = $this->metaData(['title'=> translate("Invoice ") . $invoice->uid]);
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

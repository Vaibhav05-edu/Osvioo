<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function list()
    {
        $invoices = Invoice::with('user')->latest()->paginate(15);
        $meta_data = $this->metaData(['title'=> translate("Invoices Management")]);
        return view('admin.invoice.list', compact('invoices', 'meta_data'));
    }

    public function approveWatermark($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        $invoice->watermark_removed = true;
        $invoice->watermark_request_status = 'approved';
        $invoice->save();

        return back()->with('success', translate('Watermark removed successfully.'));
    }

    public function rejectWatermark($uid)
    {
        $invoice = Invoice::where('uid', $uid)->firstOrFail();
        $invoice->watermark_request_status = 'rejected';
        $invoice->save();

        return back()->with('success', translate('Watermark removal request rejected.'));
    }
}

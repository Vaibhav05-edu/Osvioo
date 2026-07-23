<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class SendInvoiceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;  // Don't retry on this driver
    public $timeout = 30;  // Quick timeout

    protected $invoiceUid;
    protected $clientEmail;
    protected $senderName;

    public function __construct($invoiceUid, $clientEmail, $senderName)
    {
        $this->invoiceUid = $invoiceUid;
        $this->clientEmail = $clientEmail;
        $this->senderName = $senderName;
    }

    public function handle()
    {
        try {
            $invoice = Invoice::where('uid', $this->invoiceUid)->first();
            if (!$invoice) {
                \Log::warning('Invoice not found: ' . $this->invoiceUid);
                return;
            }

            $details = is_array($invoice->details) ? $invoice->details : [];
            $invNum  = $details['invoice_number'] ?? $invoice->uid;

            // Generate PDF
            $pdf = Pdf::loadView('user.invoice.pdf', compact('invoice'))->setPaper('a4', 'portrait');
            $pdfContent = $pdf->output();

            // Send email with PDF attachment
            Mail::send([], [], function ($message) use ($invNum, $pdfContent, $details, $invoice) {
                $message->to($this->clientEmail)
                    ->subject('Invoice ' . $invNum . ' from ' . $this->senderName)
                    ->setBody(
                        '<p>Dear Client,</p>' .
                        '<p>Please find attached your invoice <strong>' . $invNum . '</strong>.</p>' .
                        '<p>Amount Due: <strong>' . ($details['currency_symbol'] ?? '$') . number_format($invoice->amount, 2) . '</strong></p>' .
                        '<p>Thank you for your business!</p>' .
                        '<p>Regards,<br>' . $this->senderName . '</p>',
                        'text/html'
                    )
                    ->attachData($pdfContent, 'Invoice-' . $invNum . '.pdf', ['mime' => 'application/pdf']);
            });

            \Log::info('Invoice email sent successfully to ' . $this->clientEmail . ' for invoice ' . $invNum);

        } catch (\Throwable $e) {
            \Log::error('Failed to send invoice email: ' . $e->getMessage());
            // Don't rethrow - we don't want to retry
        }
    }
}

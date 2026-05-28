<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $invoice = \App\Models\Invoice::first();
    if (!$invoice) {
        echo "No invoice found.\n";
        exit;
    }
    echo "Rendering PDF for invoice: " . $invoice->uid . "\n";
    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.invoice.pdf', compact('invoice'))->setPaper('a4', 'portrait');
    $output = $pdf->output();
    echo "PDF generated successfully. Length: " . strlen($output) . "\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

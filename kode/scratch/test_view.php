<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::first();
auth()->login($user);
$addons = App\Models\Addon::where('status', 1)->get();
$methods = App\Models\Admin\PaymentMethod::with(['file','currency'])->active()->orderBy('serial_id','asc')->get();
$meta_data = ['title' => 'test'];

try {
    echo view('user.addon.marketplace', compact('addons', 'meta_data', 'methods'))->render();
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . " on line " . $e->getLine() . " in " . $e->getFile();
}

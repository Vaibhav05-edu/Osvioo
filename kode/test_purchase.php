<?php
$user = App\Models\User::first();
$package = App\Models\Package::where("slug", "core")->first();

if (!$package) {
    echo "Package not found";
    exit;
}
$price = round($package->discount_price) > 0 ? $package->discount_price : $package->price;
echo "Price: $price\n";
echo "User balance: " . $user->balance . "\n";

$method = \App\Models\Admin\PaymentMethod::where('code', 'razorpay')->first();
$depositReq = new \Illuminate\Http\Request();
$depositReq->replace([
    'amount'  => $price,
    'remarks' => 'Plan Purchase via Razorpay'
]);

$userService = new \App\Http\Services\UserService();
$depositResponse = $userService->createDepositLog($depositReq, $user, $method, \App\Enums\DepositStatus::value('INITIATE', true));
$depositLog      = \Illuminate\Support\Arr::get($depositResponse, "log");

if ($depositLog) {
    $depositLog->custom_data = json_encode(['plan_id' => $package->id]);
    $depositLog->save();
    
    // Simulate deposit confirm
    $app = app();
    $controller = $app->make(\App\Http\Controllers\User\DepositController::class);
    $res = $controller->depositConfirm($depositLog);
    echo "Success: deposit Confirm returned \n";
} else {
    echo "Deposit log null\n";
}

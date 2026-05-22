<?php

// Bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Package;
use App\Http\Services\UserService;

try {
    $email = 'vaibhav@gmail.com';
    $user = User::where('email', $email)->first();
    if (!$user) {
        echo "ERROR: User with email $email not found.\n";
        exit(1);
    }

    echo "User found: " . $user->username . " (ID: " . $user->id . ")\n";

    // Find the top-most plan
    $package = Package::active()->orderBy('price', 'desc')->first();
    if (!$package) {
        echo "ERROR: No active packages found in the database.\n";
        exit(1);
    }

    echo "Top-most package found: " . $package->title . " (Price: " . $package->price . ", ID: " . $package->id . ")\n";

    // Ensure the user has enough balance to purchase
    $price = round($package->discount_price) > 0 ? $package->discount_price : $package->price;
    if ($user->balance < $price) {
        echo "User balance is currently " . $user->balance . ". Increasing to " . ($price + 1000) . "...\n";
        $user->balance = $price + 1000;
        $user->save();
    }

    // Purchase the plan
    $userService = new UserService();
    $result = $userService->createSubscription($user, $package, "Manual test recharge for " . $email);

    if (isset($result['status']) && $result['status']) {
        echo "SUCCESS: User successfully subscribed to " . $package->title . "!\n";
    } else {
        echo "FAILURE: " . ($result['message'] ?? 'Unknown error during subscription creation') . "\n";
    }

} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}

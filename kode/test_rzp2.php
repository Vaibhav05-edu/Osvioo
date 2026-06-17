<?php
try {
    $api_key = env('RAZORPAY_KEY');
    $api_secret = env('RAZORPAY_SECRET');
    echo "Key: $api_key\n";
    require_once(app_path('Http/Services/Gateway/razorpay/razorpay-php/Razorpay.php'));
    $razorPayApi = new Razorpay\Api\Api($api_key, $api_secret);
    $razorOrder = $razorPayApi->order->create([
        'receipt'         => 'TEST1234',
        'amount'          => 100 * 100,
        'currency'        => 'INR',
        'payment_capture' => '0'
    ]);
    echo "Order created: " . $razorOrder['id'] . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

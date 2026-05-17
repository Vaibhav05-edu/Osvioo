<?php

use App\Models\AutoDmTrigger;
use App\Models\AutoDmLog;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Request;

// 1. Setup Test Data
$user = User::first();
if (!$user) {
    echo "No user found\n";
    exit;
}

$account = SocialAccount::where('user_id', $user->id)->first();
if (!$account) {
    echo "No social account found for user\n";
    exit;
}

// Create a trigger
$trigger = AutoDmTrigger::create([
    'user_id' => $user->id,
    'social_account_id' => $account->id,
    'keyword' => 'test-keyword',
    'reply_text' => 'This is an automated test reply',
    'match_type' => 'exact',
    'status' => true,
]);

echo "Created trigger: " . $trigger->uid . "\n";

// 2. Simulate Webhook Payload
$payload = [
    'object' => 'instagram',
    'entry' => [
        [
            'messaging' => [
                [
                    'sender' => ['id' => 'sender-123'],
                    'recipient' => ['id' => $account->account_id],
                    'message' => ['text' => 'test-keyword']
                ]
            ]
        ]
    ]
];

// Mock the request
request()->merge($payload);

// 3. Call the Controller Method
$controller = new \App\Http\Controllers\CoreController();
$response = $controller->postWebhook();

echo "Webhook Response Status: " . $response->getStatusCode() . "\n";

// 4. Verify Logs
$log = AutoDmLog::where('sender_id', 'sender-123')->latest()->first();
if ($log) {
    echo "Log Found!\n";
    echo "Received: " . $log->received_message . "\n";
    echo "Reply: " . $log->reply_sent . "\n";
    echo "Status: " . $log->status . "\n";
} else {
    echo "Log NOT Found!\n";
}

// Cleanup
$trigger->delete();
// $log->delete(); // Keep log for inspection?

<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\SocialAccount;
use App\Models\AutoDmLog;
use App\Enums\StatusEnum;
use App\Enums\PlanDuration;
use App\Http\Services\Account\instagram\Account as InstagramAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;

class SendAutoDmJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $accountId;
    public $senderId;
    public $replyText;
    public $userId;
    public $triggerId;
    public $messageText;

    /**
     * Create a new job instance.
     */
    public function __construct($accountId, string $senderId, string $replyText, $userId, $triggerId, ?string $messageText = null)
    {
        $this->accountId = $accountId;
        $this->senderId = $senderId;
        $this->replyText = $replyText;
        $this->userId = $userId;
        $this->triggerId = $triggerId;
        $this->messageText = $messageText;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $user = User::with(['runningSubscription', 'runningSubscription.package'])->find($this->userId);
            if (!$user) {
                return;
            }

            $account = SocialAccount::find($this->accountId);
            if (!$account) {
                return;
            }

            $subscription = $user->runningSubscription;
            if (!$subscription) {
                AutoDmLog::create([
                    'user_id' => $user->id,
                    'social_account_id' => $account->id,
                    'sender_id' => $this->senderId,
                    'received_message' => $this->messageText ?? 'N/A (Trigger Execution)',
                    'reply_sent' => $this->replyText,
                    'status' => 'failed',
                    'error_message' => 'No active subscription found',
                ]);
                return;
            }

            $package = $subscription->package;
            $webhookAccess = @$package->social_access->webhook_access;
            if (!$webhookAccess || $webhookAccess != StatusEnum::true->status()) {
                AutoDmLog::create([
                    'user_id' => $user->id,
                    'social_account_id' => $account->id,
                    'sender_id' => $this->senderId,
                    'received_message' => $this->messageText ?? 'N/A (Trigger Execution)',
                    'reply_sent' => $this->replyText,
                    'status' => 'failed',
                    'error_message' => 'Webhook access is not enabled for your package',
                ]);
                return;
            }

            // Check auto dm limit
            $dmLimit = isset($package->social_access->auto_dm_limit) ? (int)$package->social_access->auto_dm_limit : -1;
            
            if ($dmLimit != PlanDuration::value('UNLIMITED')) {
                // Count successful Auto DM logs sent within current subscription period
                $dmUsedCount = AutoDmLog::where('user_id', $user->id)
                    ->where('status', 'success')
                    ->where('created_at', '>=', $subscription->created_at)
                    ->count();

                if ($dmUsedCount >= $dmLimit) {
                    AutoDmLog::create([
                        'user_id' => $user->id,
                        'social_account_id' => $account->id,
                        'sender_id' => $this->senderId,
                        'received_message' => $this->messageText ?? 'N/A (Trigger Execution)',
                        'reply_sent' => $this->replyText,
                        'status' => 'failed',
                        'error_message' => 'Auto DM limit exceeded for this plan period',
                    ]);
                    return;
                }
            }

            // Dispatch message via Instagram Account service
            $response = InstagramAccount::sendMessage($account, $this->senderId, $this->replyText);

            // Log DM execution
            AutoDmLog::create([
                'user_id' => $user->id,
                'social_account_id' => $account->id,
                'sender_id' => $this->senderId,
                'received_message' => $this->messageText ?? 'N/A (Trigger Execution)',
                'reply_sent' => $this->replyText,
                'status' => isset($response['status']) && $response['status'] ? 'success' : 'failed',
                'error_message' => isset($response['status']) && $response['status'] ? null : ($response['message'] ?? 'Unknown error'),
            ]);

        } catch (Exception $e) {
            // Safe fallback logging in case of any unhandled exception in background job
            try {
                AutoDmLog::create([
                    'user_id' => $this->userId,
                    'social_account_id' => $this->accountId,
                    'sender_id' => $this->senderId,
                    'received_message' => $this->messageText ?? 'N/A (Trigger Execution)',
                    'reply_sent' => $this->replyText,
                    'status' => 'failed',
                    'error_message' => 'Job execution error: ' . $e->getMessage(),
                ]);
            } catch (Exception $logEx) {
                // Fail silently to prevent infinite job fail loops
            }
        }
    }
}

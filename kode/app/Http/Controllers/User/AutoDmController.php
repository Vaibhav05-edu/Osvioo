<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AutoDmTrigger;
use App\Models\AutoDmLog;
use App\Models\AutoDmStep;
use App\Models\SocialAccount;
use App\Enums\StatusEnum;
use App\Enums\PlanDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoDmController extends Controller
{
    public function list()
    {
        $user = auth_user('web');

        if (!$user) {
            return redirect()->route('login');
        }

        $user->load(['runningSubscription', 'runningSubscription.package']);
        $subscription = $user->runningSubscription;
        
        $dmLimit = -1;
        $dmUsedCount = 0;
        
        if ($subscription) {
            $package = $subscription->package;
            if ($package && isset($package->social_access->auto_dm_limit)) {
                $dmLimit = (int)$package->social_access->auto_dm_limit;
            }
            
            $dmUsedCount = AutoDmLog::where('user_id', $user->id)
                ->where('status', 'success')
                ->where('created_at', '>=', $subscription->created_at)
                ->count();
        }

        $triggers = AutoDmTrigger::where('user_id', $user->id)
            ->with(['socialAccount', 'steps'])
            ->latest()
            ->get();
        
        $logs = AutoDmLog::where('user_id', $user->id)
            ->with('socialAccount')
            ->latest()
            ->take(20)
            ->get();

        $accounts = SocialAccount::where('user_id', $user->id)
            ->whereHas('platform', function($q) {
                $q->where('slug', 'instagram');
            })
            ->active()
            ->get();

        return view('user.auto_dm.index', [
            'meta_data' => $this->metaData(['title' => translate('Auto DM Manager')]),
            'title' => translate('Auto DM Manager'),
            'triggers' => $triggers,
            'logs' => $logs,
            'accounts' => $accounts,
            'dmLimit' => $dmLimit,
            'dmUsedCount' => $dmUsedCount
        ]);
    }

    public function store(Request $request)
    {
        $user = auth_user('web');

        if (!$user) {
            return redirect()->route('login');
        }

        $user->load(['runningSubscription', 'runningSubscription.package']);
        $subscription = $user->runningSubscription;
        
        if (!$subscription) {
            return back()->with('error', translate('Please subscribe to a plan first'));
        }
        
        $package = $subscription->package;
        $webhookAccess = @$package->social_access->webhook_access;
        
        if (!$webhookAccess || $webhookAccess != StatusEnum::true->status()) {
            return back()->with('error', translate('Auto DM automation is not supported in your current plan'));
        }

        // Limit Check
        $baseLimit = isset($package->social_access->auto_dm_limit) ? (int) $package->social_access->auto_dm_limit : 1;
        if($baseLimit == -1) $baseLimit = 999999; // Unlimited
        
        $currentCount = \App\Models\AutoDmTrigger::where('user_id', $user->id)->count();

        if ($currentCount >= $baseLimit) {
            return back()->with('error', translate('You have reached your Auto DM limit. Please upgrade your plan.'));
        }

        $request->validate([
            'keyword' => 'required|string|max:255',
            'reply_text' => 'required|string',
            'match_type' => 'required|in:exact,contains,start_with',
            'social_account_id' => 'required_if:trigger_type,comment_to_dm|nullable|exists:social_accounts,id',
            'trigger_type' => 'required|in:inbox_dm,comment_to_dm',
            'comment_reply_text' => 'nullable|required_if:trigger_type,comment_to_dm|string',
            'media_id' => 'nullable|string',
            'media_url' => 'nullable|string',
            'steps' => 'nullable|array',
            'steps.*.reply_text' => 'required|string',
            'steps.*.delay_seconds' => 'required|integer|min:0',
        ]);

        $trigger = AutoDmTrigger::create([
            'user_id' => $user->id,
            'social_account_id' => $request->social_account_id,
            'keyword' => $request->keyword,
            'reply_text' => $request->reply_text,
            'match_type' => $request->match_type,
            'trigger_type' => $request->trigger_type,
            'media_id' => $request->trigger_type == 'comment_to_dm' ? $request->media_id : null,
            'media_url' => $request->trigger_type == 'comment_to_dm' ? $request->media_url : null,
            'comment_reply_text' => $request->trigger_type == 'comment_to_dm' ? $request->comment_reply_text : null,
            'status' => true,
        ]);

        if ($request->has('steps') && is_array($request->steps)) {
            $order = 1;
            foreach ($request->steps as $stepData) {
                AutoDmStep::create([
                    'auto_dm_trigger_id' => $trigger->id,
                    'step_order' => $order++,
                    'reply_text' => $stepData['reply_text'],
                    'delay_seconds' => (int)$stepData['delay_seconds'],
                ]);
            }
        }

        return back()->with('success', translate('Auto DM Trigger created successfully'));
    }

    public function updateStatus(Request $request)
    {
        $trigger = AutoDmTrigger::where('user_id', auth_user('web')->id)
            ->where('uid', $request->uid)
            ->firstOrFail();

        $trigger->status = !$trigger->status;
        $trigger->save();

        return response()->json(['status' => true, 'message' => translate('Status updated')]);
    }

    public function destroy($uid)
    {
        $trigger = AutoDmTrigger::where('user_id', auth_user('web')->id)
            ->where('uid', $uid)
            ->firstOrFail();

        $trigger->delete();

        return back()->with('success', translate('Trigger deleted successfully'));
    }

    public function fetchInstagramMedia($accountId)
    {
        $user = auth_user('web');
        if (!$user) {
            return response()->json(['status' => false, 'message' => translate('Unauthorized')]);
        }

        $account = SocialAccount::where('user_id', $user->id)
            ->where('id', $accountId)
            ->active()
            ->first();

        if (!$account) {
            return response()->json(['status' => false, 'message' => translate('Instagram account not found or inactive')]);
        }

        $response = \App\Http\Services\Account\instagram\Account::getInstagramMedia($account);

        return response()->json($response);
    }
}

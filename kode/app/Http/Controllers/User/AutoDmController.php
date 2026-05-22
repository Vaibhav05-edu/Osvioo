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
        $user = auth_user('web')->load(['runningSubscription', 'runningSubscription.package']);
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
        $user = auth_user('web')->load(['runningSubscription', 'runningSubscription.package']);
        $subscription = $user->runningSubscription;
        
        if (!$subscription) {
            return back()->with('error', translate('Please subscribe to a plan first'));
        }
        
        $package = $subscription->package;
        $webhookAccess = @$package->social_access->webhook_access;
        
        if (!$webhookAccess || $webhookAccess != StatusEnum::true->status()) {
            return back()->with('error', translate('Auto DM automation is not supported in your current plan'));
        }

        $request->validate([
            'keyword' => 'required|string|max:255',
            'reply_text' => 'required|string',
            'match_type' => 'required|in:exact,contains,start_with',
            'social_account_id' => 'nullable|exists:social_accounts,id',
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
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AutoDmTrigger;
use App\Models\AutoDmLog;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoDmController extends Controller
{
    public function list()
    {
        $user = auth_user('web');
        $triggers = AutoDmTrigger::where('user_id', $user->id)
            ->with('socialAccount')
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
            'accounts' => $accounts
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'reply_text' => 'required|string',
            'match_type' => 'required|in:exact,contains,start_with',
            'social_account_id' => 'nullable|exists:social_accounts,id',
        ]);

        AutoDmTrigger::create([
            'user_id' => auth_user('web')->id,
            'social_account_id' => $request->social_account_id,
            'keyword' => $request->keyword,
            'reply_text' => $request->reply_text,
            'match_type' => $request->match_type,
            'status' => true,
        ]);

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

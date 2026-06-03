<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AffiliateLog;
use App\Models\AffiliateClickLog;
use App\Models\User;

class AffiliateController extends Controller
{
    // Status constants: 0=none, 1=pending, 2=approved, 3=rejected

    public function index()
    {
        $user = auth_user('web');
        $meta_data = $this->metaData(['title'=>translate("Affiliate Program")]);

        if ($user->affiliate_status == 2) {
            return $this->dashboard($user);
        } elseif ($user->affiliate_status == 1) {
            return view('user.affiliate.pending', compact('meta_data'));
        } elseif ($user->affiliate_status == 3) {
            return view('user.affiliate.apply', ['rejected' => true, 'meta_data' => $meta_data]);
        }

        return view('user.affiliate.apply', ['rejected' => false, 'meta_data' => $meta_data]);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'how_to_promote' => 'required|string|max:1000',
            'website_url'    => 'nullable|url|max:255',
        ]);

        $user = auth_user('web');
        $user->affiliate_status = 1; // pending
        $user->affiliate_application = json_encode([
            'how_to_promote' => $request->how_to_promote,
            'website_url'    => $request->website_url,
        ]);
        $user->save();

        return redirect()->route('user.affiliate.index')->with('success', translate('Your affiliate application has been submitted and is pending approval.'));
    }

    private function dashboard(User $user)
    {
        $totalClicks   = AffiliateClickLog::where('referral_id', $user->id)->count();
        $totalSignups  = User::where('referral_id', $user->id)->count();
        $totalEarnings = AffiliateLog::where('user_id', $user->id)->sum('commission_amount');
        $logs          = AffiliateLog::where('user_id', $user->id)->latest()->paginate(10);

        // Ensure referral code exists
        if (!$user->referral_code) {
            $user->referral_code = $user->id . rand(1000, 9999);
            $user->save();
        }

        // Clicks chart data for last 30 days
        $clicksChart = [];
        $signupsChart = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $clicksChart[$date]  = AffiliateClickLog::where('referral_id', $user->id)->whereDate('created_at', $date)->count();
            $signupsChart[$date] = User::where('referral_id', $user->id)->whereDate('created_at', $date)->count();
        }

        $referralLink = url('/') . '/' . $user->username;
        $meta_data = $this->metaData(['title'=>translate("Affiliate Dashboard")]);

        return view('user.affiliate.dashboard', compact(
            'totalClicks', 'totalSignups', 'totalEarnings', 'logs', 'referralLink', 'clicksChart', 'signupsChart', 'meta_data'
        ));
    }
}

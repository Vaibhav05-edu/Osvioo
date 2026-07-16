<?php

namespace App\Http\Controllers\User;

use App\Enums\FileKey;
use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Core\File;
use App\Models\CreditLog;
use App\Models\MediaPlatform;
use App\Models\Notification;
use App\Models\SocialAccount;
use App\Models\SocialPost;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Rules\General\FileExtentionCheckRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
use App\Traits\Fileable;
use App\Traits\ModelAction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{



    protected $user ,$subscription,$accessPlatforms,$webhookAccess;

    use Fileable , ModelAction;
    public function __construct(){

        $this->middleware(function ($request, $next) {
            $this->user = auth_user('web');
            $this->subscription           = $this->user->runningSubscription;
            $this->accessPlatforms        = (array) ($this->subscription ? @$this->subscription->package->social_access->platform_access : []);
            $this->webhookAccess          = @optional($this->subscription?->package?->social_access)
                                                 ->webhook_access;

            return $next($request);
        });
    }


    /**
     * User Dashboard
     *
     * @param Request $request
     * @return View
     */
    public function home(Request $request): View
    {

        return view('user.home',[
            'meta_data' => $this->metaData(["title" => trans('default.user_dashboard')]),
            'data'      => $this->dashboardCounter()
        ]);
    }


    /**
     * counter dashboard data
     */

     public function dashboardCounter() :array{

        $data['account_report']            = [

            "total_account"         => SocialAccount::where('user_id', $this->user->id)->count(),
            "active_account"        => SocialAccount::where('user_id', $this->user->id)->active()->count(),
            "inactive_account"      => SocialAccount::where('user_id', $this->user->id)->inactive()->count(),
            "accounts_by_platform"  => MediaPlatform::withCount(['accounts' => function($q){
                                            $q->where('user_id', $this->user->id);
                                        }])
                                        ->where('slug', 'instagram')
                                        ->integrated()
                                        ->get()
        ];


        $data['latest_post']  = SocialPost::with(['file','account','account.platform'])
                                            ->where('user_id', $this->user->id)
                                            ->latest()
                                            ->take(10)
                                            ->get();



        $data['latest_activities']           =  CreditLog::with(['user'])
                                                            ->where('user_id',$this->user->id)
                                                            ->search(['remark','trx_code'])
                                                            ->filter(['type'])
                                                            ->date()
                                                            ->latest()
                                                            ->take(10)
                                                            ->get();


        $data['latest_transactiions']           =  Transaction::with(['user','admin','currency'])
                                                        ->search(['remarks','trx_code'])
                                                        ->filter(["user:username",'trx_type'])
                                                        ->where('user_id', $this->user->id)
                                                        ->date()
                                                        ->latest()
                                                        ->take(5)
                                                        ->get();

        $data['total_post']               = SocialPost::where('user_id', $this->user->id)
                                                       ->date()
                                                       ->count();

        $data['pending_post']             = SocialPost::where('user_id', $this->user->id)
                                                       ->pending()
                                                       ->date()
                                                       ->count();
        $data['schedule_post']            = SocialPost::where('user_id', $this->user->id)
                                                       ->schedule()
                                                       ->date()
                                                       ->count();
        $data['success_post']             = SocialPost::where('user_id', $this->user->id)
                                                       ->success()
                                                       ->date()
                                                       ->count();
        $data['failed_post']              = SocialPost::where('user_id', $this->user->id)->failed()->date()->count();

        $data['affiliate_earnings']       =  $this->user->affiliates->sum("commission_amount");




        $data['monthly_post_graph']          = sortByMonth(SocialPost::filter(["platform:slug"])
                                                            ->date()
                                                            ->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                            ->whereYear('created_at', '=',date("Y"))
                                                            ->groupBy('months')
                                                            ->where('user_id', $this->user->id)
                                                            ->pluck('total', 'months')
                                                            ->toArray(),true);

        $data['monthly_pending_post']      = sortByMonth(SocialPost::filter(["platform:slug"])
                                                            ->date()
                                                            ->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                            ->whereYear('created_at', '=',date("Y"))
                                                            ->pending()
                                                            ->where('user_id', $this->user->id)
                                                            ->groupBy('months')
                                                            ->pluck('total', 'months')
                                                            ->toArray(),true);

        $data['monthly_schedule_post']     = sortByMonth(SocialPost::filter(["platform:slug"])
                                                            ->date()
                                                            ->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                            ->whereYear('created_at', '=',date("Y"))
                                                            ->schedule()
                                                            ->where('user_id', $this->user->id)
                                                            ->groupBy('months')
                                                            ->pluck('total', 'months')
                                                            ->toArray(),true);

        $data['monthly_success_post']      = sortByMonth(SocialPost::filter(["platform:slug"])
                                                            ->date()
                                                            ->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                            ->whereYear('created_at', '=',date("Y"))
                                                            ->success()
                                                            ->where('user_id', $this->user->id)
                                                            ->groupBy('months')
                                                            ->pluck('total', 'months')
                                                            ->toArray(),true);

        $data['monthly_failed_post']      = sortByMonth(SocialPost::filter(["platform:slug"])
                                                            ->date()
                                                            ->selectRaw("MONTHNAME(created_at) as months, COUNT(*) as total")
                                                            ->whereYear('created_at', '=',date("Y"))
                                                            ->failed()
                                                            ->where('user_id', $this->user->id)
                                                            ->groupBy('months')
                                                            ->pluck('total', 'months')
                                                            ->toArray(),true);

        $data['subscription_log']          = Subscription::with(['user','package','oldPackage'])
                                                            ->where('user_id', $this->user->id)
                                                            ->date()
                                                            ->latest()
                                                            ->take(8)
                                                            ->get();







        return $data;

     }


    /**
     * profile Update view
     * @param Request $request
     * @return View
     */
    public function profile(Request $request ) :View{

        return view('user.profile',[
            'meta_data'=> $this->metaData(['title'=> translate("Profile")])
        ]);
    }


    /**
     * profile Update
     * @param Request $request
     * @return RedirectResponse
     */
    public function profileUpdate(Request $request ) :RedirectResponse{

        $user                       =  $this->user;

        if($user->email == 'demo@cartuser.test'){
            if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                return back()->with(response_status('This Function Is Not Available For Website Demo Mode'));
            }
        }



        $request->validate([
            'name'               => ["required","max:100",'string'],
            'username'           => ['required',"string","max:155","alpha_dash",'unique:users,username,'.$this->user->id],
            "country_id"         => ['nullable',"exists:countries,id"],
            'phone'              => ['unique:users,phone,'.$this->user->id ,'max:191'],
            'email'              => ['email','required','unique:users,email,'.$this->user->id],
            'auto_subscription'  => ['nullable', Rule::in(StatusEnum::toArray())],
            'address'            => ['nullable','array'],
            'address.*'          => ['nullable','max:191'],
            "image"              => ['nullable','image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'),true)) ]
        ]);

        $user->name                 =  $request->input('name');
        $user->username             =  $request->input('username');
        $user->phone                =  $request->input('phone');
        $user->email                =  $request->input('email');
        $user->address              =  $request->input('address',[]);
        $user->country_id           =  $request->input('country_id');

        $user->auto_subscription    =  $request->input('auto_subscription')?? StatusEnum::false->status();

        $user->save();

         if($request->hasFile('image')){
                $oldFile = $user->file()->where('type',FileKey::AVATAR->value)->first();
                $this->saveFile($user ,$this->storeFile(
                                               file       : $request->file('image'),
                                               location   : config("settings")['file_path']['profile']['user']['path'],
                                               removeFile : @$oldFile
                                            )
                                            ,FileKey::AVATAR->value);

            }


        return back()->with(response_status('Profile Updated'));
    }


    /**
     * update password
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function passwordUpdate(Request $request ): RedirectResponse
    {
        $user                       =  $this->user;

        if($user->email == 'demo@cartuser.test'){
            if ($request->expectsJson() || $request->isXmlHttpRequest()) {
                return back()->with(response_status('This Function Is Not Available For Website Demo Mode'));
            }
        }
        
        $rules   = [
            'current_password' => 'required|max:100',
            'password'         => 'required|confirmed|min:6',
        ];

        if(site_settings('strong_password') == StatusEnum::true->status()){
            $rules['password']    =  ["required","confirmed",Password::min(8)
                                        ->mixedCase()
                                        ->letters()
                                        ->numbers()
                                        ->symbols()
                                        ->uncompromised()
                                    ];
        }

        $request->validate($rules);
        if( $this->user->password && !Hash::check($request->input('current_password'), $this->user->password)) {
            return back()->with('error', translate("Your Current Password does not match !!"));
        }

        $user->password = $request->input('password');
        $user->save();
        return back()->with(response_status('Password Updated'));
    }



    /**
     * read a notifications
     *
     */

    public function readNotification(Request $request) :string{

        $notification = Notification::where('notificationable_type','App\Models\User')
                                ->where("id", $request->input("id"))
                                ->where("notificationable_id",$this->user->id)
                                ->first();
        $status  = false;
        $message = translate('Notification Not Found');
        if( $notification ){
            $notification->is_read =  (StatusEnum::true)->status();
            $notification->save();
            $status = true;
            $message = translate('Notification Readed');
        }
        return json_encode([
            "status"  => $status,
            "message" => $message
        ]);

    }


    /**
     * view  all notifications
     *
     */

    public function notification(Request $request) :View{

        Notification::where('notificationable_type','App\Models\User')
                ->where("notificationable_id",$this->user->id)
                ->update([
                    "is_read" =>  (StatusEnum::true)->status()
                ]);

        return view('user.notifications',[
            'meta_data'=> $this->metaData(['title'=>translate("Notifications")]),
            'notifications' => Notification::where('notificationable_type','App\Models\User')
                                    ->where("notificationable_id",$this->user->id)
                                    ->latest()
                                    ->paginate(paginateNumber())
        ]);


    }


    /**
     * Affiliate Config Update
     * @param Request $request
     * @return RedirectResponse
     */
    public function affiliateUpdate(Request $request)
    {
        $request->validate([
            'referral_code' => ['required','unique:users,referral_code,'.auth_user('web')->id],
        ]);

        $user = auth_user('web');
        $user->referral_code = $request->referral_code;
        $user->save();

        return back()->with('success',translate('Affiliate configured successfully'));
    }

    public function affiliateApply(Request $request)
    {
        $user = auth_user('web');
        if ($user->affiliate_status == 0) {
            $user->affiliate_status = 1;
            $user->save();
            return back()->with('success',translate('Affiliate application submitted successfully'));
        }
        return back()->with('error',translate('You have already applied for affiliate program'));
    }


    /**
     * Webhook Config Update
     * @param Request $request
     * @return RedirectResponse
     */
    public function webhookUpdate(Request $request ) :RedirectResponse{

        $response = response_status('You current plan doesnot have webhook access');
        if($this->webhookAccess == StatusEnum::true->status()){
            $response = response_status('Webhook Api Key Updated');
            $request->validate([
                'webhook_api_key'      => ['required','unique:users,webhook_api_key,'.$this->user->id],
            ]);

            $user                       =  $this->user;
            $user->webhook_api_key      =  $request->input('webhook_api_key');
            $user->save();

        }

        return back()->with( $response);
    }
    /**
     * Active Plan details
     */
    public function activePlan() :View{
        return view('user.plan.active', [
            'meta_data' => $this->metaData(['title' => translate("Active Plan")]),
        ]);
    }

    /**
     * Subscription History
     */
    public function planHistory() :View{
        $subscriptions = \App\Models\Subscription::with(['package'])
            ->where('user_id', $this->user->id)
            ->latest()
            ->paginate(10);

        return view('user.plan.history', [
            'meta_data'     => $this->metaData(['title' => translate("Subscription History")]),
            'subscriptions' => $subscriptions,
        ]);
    }

    /**
     * Upcoming Billing
     */
    public function upcomingBilling() :View{
        return view('user.plan.upcoming', [
            'meta_data' => $this->metaData(['title' => translate("Upcoming Billing")]),
        ]);
    }

    /**
     * Delete user account permanently
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAccount(Request $request): RedirectResponse
    {
        $user = $this->user;

        if ($user->email == 'demo@cartuser.test') {
            return back()->with('error', translate('This function is not available for website demo mode'));
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($user) {
            // Delete related tables to prevent FK errors
            $user->accounts()->delete();
            $user->posts()->delete();
            $user->subscriptions()->delete();
            $user->transactions()->delete();
            $user->creditLogs()->delete();
            $user->tickets()->delete();
            $user->kycLogs()->delete();
            $user->affiliates()->delete();
            $user->webhookLogs()->delete();

            // Finally delete the user
            $user->delete();
        });

        // Logout user
        auth()->guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', translate('Your account and all associated data have been permanently deleted successfully.'));
    }

    /**
     * Get dynamic AI insights for user dashboard via AJAX
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function aiInsights(Request $request)
    {
        $user = auth_user('web');
        $instaAccount = SocialAccount::where('user_id', $user->id)
            ->whereHas('platform', function($q){
                $q->where('slug', 'instagram');
            })->first();

        $followersVal = 0;
        if($instaAccount) {
            $info = $instaAccount->account_information;
            if(isset($info->followers_count) && $info->followers_count > 0) {
                $followersVal = $info->followers_count;
            } else {
                try {
                    $platform = $instaAccount->platform;
                    $configuration = $platform->configuration;
                    $token = $instaAccount->token ?? ($info->token ?? null);
                    $igId = $instaAccount->account_id;
                    if ($token && $igId) {
                        $apiUrl = \App\Http\Services\Account\instagram\Account::getApiUrl($igId, ['fields' => 'followers_count'], $configuration);
                        $response = \Illuminate\Support\Facades\Http::withToken($token)->get($apiUrl);
                        $followersVal = $response->json('followers_count') ?? 0;
                        if ($followersVal > 0) {
                            $infoArray = (array)$info;
                            $infoArray['followers_count'] = $followersVal;
                            $instaAccount->account_information = $infoArray;
                            $instaAccount->save();
                        }
                    }
                } catch (\Exception $e) { }
            }
        }
        
        $rateMinUSD = round($followersVal * 0.015);
        $rateMaxUSD = round($followersVal * 0.025);

        // Fetch AI data using Cache to avoid slow loads every time
        $cacheKey = 'user_ai_insights_' . $user->id;
        $aiData = cache()->remember($cacheKey, 86400, function() use ($user, $followersVal) {
            try {
                $aiService = new \App\Http\Services\AiService();
                $prompt = "Act as an expert AI social media manager. I have an Instagram account with {$followersVal} followers. Provide a highly personalized, unique strategic analysis in pure JSON format without markdown wrapping, and no other text:\n"
                    . "1. profileHealth (integer between 0 and 100 based on the followers count)\n"
                    . "2. profileHealthStatus (string, evaluate the health score with a 2-word status)\n"
                    . "3. nextStrategy (string, provide a very specific, creative, and actionable content strategy unique to this profile size)\n"
                    . "4. topKeywords (array of 3 highly relevant and trending hashtags that are unique)\n"
                    . "5. tasks (array of exactly 3 objects. Each object must have: 'badge' (e.g. 'High Priority', 'Growth Hack'), 'title', 'desc' (short actionable sentence), 'action_text' (e.g. 'Do It Now', 'Settings'), 'benefit' (e.g. '+15% Reach', '+10% Engagement'), and 'action_type' (exactly either 'post' or 'profile')).";

                $aiParams = [
                    'model' => $aiService->getAiModel() ?: 'gpt-3.5-turbo',
                    'temperature' => 0.8,
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are an AI assistant.'],
                        ['role' => 'user', 'content' => $prompt]
                    ],
                ];

                $response = $aiService->generateContent($aiParams, []);
                if(isset($response['status']) && $response['status'] && !empty($response['message'])) {
                    $message = preg_replace('/```json|```/', '', $response['message']);
                    $json = json_decode(trim($message), true);
                    if($json && isset($json['profileHealth'])) {
                        return $json;
                    }
                }
            } catch (\Exception $e) {}

            return [
                'profileHealth' => $followersVal > 0 ? 85 : 0,
                'profileHealthStatus' => $followersVal > 0 ? 'Strong Growth' : 'Needs Setup',
                'nextStrategy' => $followersVal > 0 ? 'Create a short-form video leveraging a trending audio' : 'Connect your Instagram account to get real insights',
                'topKeywords' => ['growth', 'content', 'strategy'],
                'tasks' => [
                    ['badge' => 'High Priority', 'title' => 'Connect Social Account', 'desc' => 'Connect Instagram to start scheduling posts.', 'action_text' => 'Connect Now', 'benefit' => 'Get Started', 'action_type' => 'profile'],
                    ['badge' => 'Medium Priority', 'title' => 'Optimize Bio Description', 'desc' => 'Add keywords to your bio to attract more organic views.', 'action_text' => 'Profile Settings', 'benefit' => '+10% Reach', 'action_type' => 'profile'],
                    ['badge' => 'Growth Hack', 'title' => 'Consistent Branding', 'desc' => 'Use a consistent font style for thumbnail branding.', 'action_text' => 'Create Post', 'benefit' => '+15% Engagement', 'action_type' => 'post'],
                ]
            ];
        });
        
        $followersStr = '0';
        if ($followersVal > 0) {
            $followersStr = $followersVal >= 1000 ? number_format($followersVal / 1000, 1) . 'K' : $followersVal;
        }

        return response()->json([
            'followersStr' => $followersStr,
            'engagementStr' => $followersVal > 0 ? number_format(3.2 + ($user->id % 3) * 0.5, 2) . '%' : '0%',
            'folGrowthStr' => $followersVal > 0 ? number_format(5.4 + ($user->id % 4) * 1.2, 1) . '%' : '0%',
            'engGrowthStr' => $followersVal > 0 ? number_format(2.1 + ($user->id % 2) * 0.8, 1) . '%' : '0%',
            'rateMinUSD' => number_format($rateMinUSD),
            'rateMaxUSD' => number_format($rateMaxUSD),
            'rateMinINR' => number_format(round($rateMinUSD * 82.5)),
            'rateMaxINR' => number_format(round($rateMaxUSD * 82.5)),
            'ai' => $aiData
        ]);
    }
}


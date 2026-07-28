<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\UserAddon;
use App\Models\Admin\PaymentMethod;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function marketplace()
    {
        try {
            $addons  = \Illuminate\Support\Facades\Schema::hasTable('addons')
                ? Addon::where('status', 1)->get()
                : collect();
            $methods = \Illuminate\Support\Facades\Schema::hasTable('payment_methods')
                ? PaymentMethod::with(['file','currency'])->active()->orderBy('serial_id','asc')->get()
                : collect();
        } catch (\Exception $e) {
            $addons  = collect();
            $methods = collect();
        }
        $meta_data = $this->metaData(['title'=>translate("Add-on Marketplace")]);
        return view('user.addon.marketplace', compact('addons', 'meta_data', 'methods'));
    }

    public function purchase(Request $request, $uid)
    {
        try {
            $addon = Addon::where('uid', $uid)->where('status', 1)->firstOrFail();
            $user  = auth_user('web');

            // Check if user has sufficient balance
            if ($user->balance < $addon->price && $addon->price > 0) {
                $method = PaymentMethod::where('code', 'razorpay')->first();
                if ($method) {
                    $depositReq = new \Illuminate\Http\Request();
                    $depositReq->replace([
                        'amount'  => $addon->price,
                        'remarks' => 'Addon Purchase via Razorpay'
                    ]);

                    $depositResponse = app(\App\Http\Services\UserService::class)->createDepositLog($depositReq, $user, $method, \App\Enums\DepositStatus::value('INITIATE', true));
                    $depositLog      = \Illuminate\Support\Arr::get($depositResponse, "log");

                    if ($depositLog) {
                        $depositLog->custom_data = json_encode(['addon_id' => $addon->id]);
                        $depositLog->save();
                        
                        return app(\App\Http\Controllers\User\DepositController::class)->depositConfirm($depositLog);
                    }
                } else {
                    return redirect()->route('user.deposit.create')->with('error', translate('Insufficient wallet balance. Please deposit funds first.'));
                }
            }

            return $this->applyAddon($user, $addon);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Addon purchase error: ' . $e->getMessage());
            return back()->with('error', translate('Purchase failed. Please try again.'));
        }
    }

    public function applyAddon($user, $addon)
    {
        try {
            // Deduct balance
            $user->balance -= $addon->price;

            // Apply Add-on Benefits
            if ($addon->type === 'extra_account') {
                if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'extra_social_accounts')) {
                    $user->extra_social_accounts = ($user->extra_social_accounts ?? 0) + $addon->value;
                }
                if ($user->runningSubscription) {
                    $user->runningSubscription->total_profile += $addon->value;
                    $user->runningSubscription->save();
                }
            } elseif ($addon->type === 'extra_media_kit') {
                if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'extra_media_kits')) {
                    $user->extra_media_kits = ($user->extra_media_kits ?? 0) + $addon->value;
                }
            } elseif ($addon->type === 'credits') {
                // Apply AI Word Balance Credits
                if ($user->runningSubscription) {
                    $user->runningSubscription->word_balance += $addon->value;
                    $user->runningSubscription->remaining_word_balance += $addon->value;
                    $user->runningSubscription->save();
                } else {
                    // Restore balance if it fails
                    $user->balance += $addon->price;
                    $user->save();
                    return back()->with('error', translate('You need an active subscription to purchase AI credits.'));
                }
            }
            $user->save();

            // Record UserAddon purchase
            $userAddon = new UserAddon();
            $userAddon->user_id = $user->id;
            $userAddon->addon_id = $addon->id;
            $userAddon->payment_status = 'completed';
            $userAddon->status = 1;
            $userAddon->save();

            // Log the transaction
            $params = [
                'currency_id'  => base_currency()->id,
                'amount'       => $addon->price,
                'final_amount' => $addon->price,
                'trx_type'     => \App\Models\Transaction::$MINUS,
                'remarks'      => 'addon_purchase',
                'details'      => 'Purchased Addon: ' . $addon->title,
                'trx_code'     => trx_number()
            ];
            \App\Http\Services\PaymentService::makeTransaction($user, $params);

            return back()->with('success', translate('Addon purchased and activated successfully!'));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Addon application error: ' . $e->getMessage());
            return back()->with('error', translate('Failed to activate addon. Please contact support.'));
        }
    }
}

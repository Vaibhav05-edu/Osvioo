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
        $addons = Addon::where('status', 1)->get();
        $meta_data = $this->metaData(['title'=> translate("Add-on Marketplace")]);
        $methods = PaymentMethod::with(['file','currency'])->active()->orderBy('serial_id','asc')->get();
        return view('user.addon.marketplace', compact('addons', 'meta_data', 'methods'));
    }

    public function purchase(Request $request, $uid)
    {
        $addon = Addon::where('uid', $uid)->where('status', 1)->firstOrFail();
        
        $request->validate([
            'method_id' => 'required|exists:payment_methods,id'
        ]);

        $userAddon = new UserAddon();
        $userAddon->user_id = auth_user('web')->id;
        $userAddon->addon_id = $addon->id;
        $userAddon->payment_status = 'pending';
        $userAddon->status = 1;
        $userAddon->save();

        // Redirecting to Deposit process to make payment
        // Usually, you would integrate a seamless payment logic like Package purchase does.
        // For simplicity in this milestone, we set up a mock or use DepositController.
        // We will just redirect to deposit request page, or directly process.
        
        $request->merge([
            'amount' => $addon->price,
            'custom_data' => ['user_addon_id' => $userAddon->id],
            'remarks' => 'Purchase Addon: ' . $addon->title,
        ]);
        
        return app(\App\Http\Controllers\User\DepositController::class)->process($request);
    }
}

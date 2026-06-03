<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BrandDeal;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BrandDealController extends Controller
{
    public function list(): View
    {
        $meta_data = ['title' => translate("Brand Deals")];
        $deals = BrandDeal::where('user_id', auth_user('web')->id)->latest()->paginate(15);
        return view('user.brand_deals.list', compact('deals', 'meta_data'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'status' => 'required|string|in:Negotiating,In Progress,Pending Payment,Completed',
            'agreed_amount' => 'nullable|numeric|min:0',
            'deliverables' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $data = $request->except('_token');
        $data['user_id'] = auth_user('web')->id;
        BrandDeal::create($data);

        return back()->with('success', translate('Brand deal added successfully.'));
    }

    public function update(Request $request, $uid): RedirectResponse
    {
        $deal = BrandDeal::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();
        
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'status' => 'required|string|in:Negotiating,In Progress,Pending Payment,Completed',
            'agreed_amount' => 'nullable|numeric|min:0',
            'deliverables' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $deal->update($request->except('_token'));

        return back()->with('success', translate('Brand deal updated successfully.'));
    }

    public function destroy($uid): RedirectResponse
    {
        $deal = BrandDeal::where('uid', $uid)->where('user_id', auth_user('web')->id)->firstOrFail();
        $deal->delete();

        return back()->with('success', translate('Brand deal deleted successfully.'));
    }
}

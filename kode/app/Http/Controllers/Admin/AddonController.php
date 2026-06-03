<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AddonController extends Controller
{
    public function list()
    {
        $addons = Addon::latest()->paginate(15);
        $meta_data = $this->metaData(['title'=> translate("Manage Add-ons")]);
        return view('admin.addon.list', compact('addons', 'meta_data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|in:extra_account,extra_media_kit,credits',
            'value' => 'required|integer|min:1',
            'status' => 'required|in:1,2'
        ]);

        $addon = new Addon();
        $addon->uid = (string) Str::uuid();
        $addon->title = $request->title;
        $addon->price = $request->price;
        $addon->type = $request->type;
        $addon->value = $request->value;
        $addon->status = $request->status;
        $addon->save();

        return back()->with('success', translate('Addon created successfully.'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:addons,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'type' => 'required|string|in:extra_account,extra_media_kit,credits',
            'value' => 'required|integer|min:1',
        ]);

        $addon = Addon::findOrFail($request->id);
        $addon->title = $request->title;
        $addon->price = $request->price;
        $addon->type = $request->type;
        $addon->value = $request->value;
        $addon->save();

        return back()->with('success', translate('Addon updated successfully.'));
    }

    public function updateStatus(Request $request)
    {
        $addon = Addon::findOrFail($request->id);
        $addon->status = $addon->status == 1 ? 2 : 1;
        $addon->save();
        return response()->json(['message' => translate('Status updated successfully.')]);
    }

    public function destroy($id)
    {
        $addon = Addon::findOrFail($id);
        $addon->delete();
        return back()->with('success', translate('Addon deleted successfully.'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaKit;

class MediaKitController extends Controller
{
    public function index()
    {
        $title = translate("Media Kits");
        $mediaKits = MediaKit::with('user')->latest()->paginate(paginateNumber());
        return view('admin.mediakit.list', compact('title', 'mediaKits'));
    }

    public function approveWatermark($uid)
    {
        $mediaKit = MediaKit::where('uid', $uid)->firstOrFail();
        $mediaKit->watermark_removed = true;
        $mediaKit->watermark_request_status = 'approved';
        $mediaKit->save();

        return back()->with('success', translate('Watermark removed successfully.'));
    }

    public function rejectWatermark($uid)
    {
        $mediaKit = MediaKit::where('uid', $uid)->firstOrFail();
        $mediaKit->watermark_request_status = 'rejected';
        $mediaKit->save();

        return back()->with('success', translate('Watermark removal request rejected.'));
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaKit;
use App\Models\SocialAccount;
use Illuminate\Support\Str;
use App\Rules\General\FileExtentionCheckRule;

class MediaKitController extends Controller
{
    public function index()
    {
        $title = translate("Previous Media Kits");
        $user = auth_user('web');
        $mediaKits = MediaKit::where('user_id', $user->id)->latest()->paginate(15);
        return view('user.mediakit.index', compact('title', 'mediaKits'));
    }

    public function create()
    {
        $title = translate("Media Kit AI Maker");
        $user = auth_user('web');
        
        // Fetch stats from connected social accounts to help AI/user generate the kit
        $accounts = SocialAccount::where('user_id', $user->id)->get();
        
        return view('user.mediakit.create', compact('title', 'accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'bio' => 'required',
            'theme_color' => 'required',
            'contact_email' => 'required|email',
            'cover_image' => ['nullable', 'image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true))]
        ]);

        $user = auth_user('web');

        $mediaKit = new MediaKit();
        $mediaKit->user_id = $user->id;
        $mediaKit->uid = Str::uuid();
        $mediaKit->title = $request->title;
        $mediaKit->bio = $request->bio;
        $mediaKit->theme_color = $request->theme_color;
        $mediaKit->contact_email = $request->contact_email;
        $mediaKit->is_public = $request->has('is_public');
        
        // Stats parsing from accounts
        $totalFollowers = 0;
        $topPlatform = null;
        $maxFollowers = 0;
        $socialLinks = [];
        
        if($request->has('accounts')) {
            $accounts = SocialAccount::whereIn('id', $request->accounts)->where('user_id', $user->id)->get();
            foreach($accounts as $acc) {
                // Here we'd normally get followers from API, but for now we can mock or use cached
                $followers = rand(1000, 50000); // Mock for now if not available in $acc
                $totalFollowers += $followers;
                
                if($followers > $maxFollowers) {
                    $maxFollowers = $followers;
                    $topPlatform = $acc->platform->name ?? 'Instagram';
                }
                
                $socialLinks[$acc->platform->name ?? 'Platform'] = "https://" . ($acc->platform->slug ?? '') . ".com/" . $acc->username;
            }
        }
        
        $mediaKit->total_followers = $totalFollowers;
        $mediaKit->top_platform = $topPlatform;
        $mediaKit->social_links = $socialLinks;
        $mediaKit->engagement_rate = rand(10, 50) / 10; // Mock 1.0% to 5.0%
        
        if($request->hasFile('cover_image')){
            $mediaKit->cover_image = store_file($request->cover_image, config('settings')['file_path']['profile']['path']);
        }
        
        $mediaKit->save();

        return redirect()->route('user.mediakit.index')->with('success', translate('Media Kit generated successfully!'));
    }

    public function edit($id)
    {
        $title = translate("Edit Media Kit");
        $user = auth_user('web');
        $mediaKit = MediaKit::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        
        return view('user.mediakit.edit', compact('title', 'mediaKit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'bio' => 'required',
            'theme_color' => 'required',
            'contact_email' => 'required|email',
            'cover_image' => ['nullable', 'image', new FileExtentionCheckRule(json_decode(site_settings('mime_types'), true))]
        ]);

        $user = auth_user('web');
        $mediaKit = MediaKit::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        
        $mediaKit->title = $request->title;
        $mediaKit->bio = $request->bio;
        $mediaKit->theme_color = $request->theme_color;
        $mediaKit->contact_email = $request->contact_email;
        $mediaKit->is_public = $request->has('is_public');
        
        if($request->hasFile('cover_image')){
            // delete old
            if($mediaKit->cover_image) {
                remove_file(config('settings')['file_path']['profile']['path'], $mediaKit->cover_image);
            }
            $mediaKit->cover_image = store_file($request->cover_image, config('settings')['file_path']['profile']['path']);
        }
        
        $mediaKit->save();

        return redirect()->route('user.mediakit.index')->with('success', translate('Media Kit updated successfully!'));
    }
    
    public function delete($id)
    {
        $user = auth_user('web');
        $mediaKit = MediaKit::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        if($mediaKit->cover_image) {
            remove_file(config('settings')['file_path']['profile']['path'], $mediaKit->cover_image);
        }
        $mediaKit->delete();
        
        return back()->with('success', translate('Media Kit deleted successfully!'));
    }

    public function insights()
    {
        $title = translate("Media Kit Insights");
        $user = auth_user('web');
        $mediaKits = MediaKit::where('user_id', $user->id)->get();
        $totalViews = $mediaKits->sum('views');
        
        return view('user.mediakit.insights', compact('title', 'mediaKits', 'totalViews'));
    }

    // Public method
    public function showPublic($username, $uid)
    {
        $mediaKit = MediaKit::where('uid', $uid)->where('is_public', true)->firstOrFail();
        // Check if username matches the user who owns it
        if($mediaKit->user->username !== $username && $mediaKit->user->user_name !== $username) {
            abort(404);
        }
        
        // Increment views
        $mediaKit->increment('views');
        
        return view('user.mediakit.public', compact('mediaKit'));
    }
}

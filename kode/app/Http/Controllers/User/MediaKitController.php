<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MediaKit;
use App\Models\SocialAccount;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class MediaKitController extends Controller
{
    public function index()
    {
        $title = translate("Previous Media Kits");
        $meta_data = $this->metaData(['title' => $title]);
        $user = auth_user('web');
        $mediaKits = MediaKit::where('user_id', $user->id)->latest()->paginate(15);
        return view('user.mediakit.index', compact('title', 'meta_data', 'mediaKits'));
    }

    public function create()
    {
        $title = translate("Media Kit AI Maker");
        $meta_data = $this->metaData(['title' => $title]);
        $user = auth_user('web');

        $accounts = SocialAccount::where('user_id', $user->id)
            ->with('platform')
            ->get();

        return view('user.mediakit.create', compact('title', 'meta_data', 'accounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'bio'           => 'required',
            'theme_color'   => 'required',
            'contact_email' => 'required|email',
            'cover_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $user = auth_user('web');

        // Limit Check
        $user->load(['runningSubscription', 'runningSubscription.package']);
        $package = $user->runningSubscription?->package;
        
        $baseLimit = $package && isset($package->social_access->media_kit_limit) ? (int) $package->social_access->media_kit_limit : 1;
        if($baseLimit == -1) $baseLimit = 999999; // Unlimited
        
        $addonLimit = (int) $user->extra_media_kits;
        $totalLimit = $baseLimit + $addonLimit;

        $currentCount = \App\Models\MediaKit::where('user_id', $user->id)->count();

        if ($currentCount >= $totalLimit) {
            return back()->with('error', translate('You have reached your Media Kit limit. Please upgrade your plan or purchase an add-on.'));
        }

        $mediaKit = new MediaKit();
        $mediaKit->user_id       = $user->id;
        $mediaKit->uid           = (string) Str::uuid();
        $mediaKit->title         = $request->title;
        $mediaKit->bio           = $request->bio;
        $mediaKit->theme_color   = $request->theme_color;
        $mediaKit->contact_email = $request->contact_email;
        $mediaKit->is_public     = $request->has('is_public');

        // Stats from connected social accounts
        $totalFollowers = 0;
        $topPlatform    = null;
        $maxFollowers   = 0;
        $socialLinks    = [];

        if ($request->has('accounts')) {
            $accounts = SocialAccount::whereIn('id', $request->accounts)
                ->where('user_id', $user->id)
                ->with('platform')
                ->get();

            foreach ($accounts as $acc) {
                // Try real follower data from account_information
                $info = $acc->account_information;
                $followers = 0;
                if ($info && isset($info->followers_count)) {
                    $followers = (int) $info->followers_count;
                } elseif ($info && isset($info->followers)) {
                    $followers = (int) $info->followers;
                } elseif ($acc->details && is_array($acc->details) && isset($acc->details['followers'])) {
                    $followers = (int) $acc->details['followers'];
                } else {
                    // No real data — store 0, user can update later
                    $followers = 0;
                }

                $totalFollowers += $followers;

                if ($followers > $maxFollowers) {
                    $maxFollowers = $followers;
                    $topPlatform  = $acc->platform->name ?? 'Instagram';
                }

                $platformSlug = $acc->platform->slug ?? 'instagram';
                $socialLinks[$acc->platform->name ?? 'Platform'] =
                    "https://" . $platformSlug . ".com/" . ($acc->username ?? $acc->name ?? '');
            }
        }

        $mediaKit->total_followers  = $totalFollowers;
        $mediaKit->top_platform     = $topPlatform;
        $mediaKit->social_links     = $socialLinks;
        $mediaKit->engagement_rate  = round(rand(10, 50) / 10, 1);
        $mediaKit->ai_prompts_used  = 0;

        if ($request->hasFile('cover_image')) {
            try {
                $file     = $request->file('cover_image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destDir  = public_path('assets/images/custom');
                if (!file_exists($destDir)) {
                    mkdir($destDir, 0775, true);
                }
                $file->move($destDir, $filename);
                $mediaKit->cover_image = $filename;
            } catch (\Throwable $e) {
                \Log::error('MediaKit cover image upload error: ' . $e->getMessage());
            }
        }

        $mediaKit->save();

        return redirect()->route('user.mediakit.index')
            ->with('success', translate('Media Kit generated successfully!'));
    }

    public function edit($id)
    {
        $title     = translate("Edit Media Kit");
        $meta_data = $this->metaData(['title' => $title]);
        $user      = auth_user('web');
        $mediaKit  = MediaKit::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        return view('user.mediakit.edit', compact('title', 'meta_data', 'mediaKit'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required|max:255',
            'bio'           => 'required',
            'theme_color'   => 'required',
            'contact_email' => 'required|email',
            'cover_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
        ]);

        $user     = auth_user('web');
        $mediaKit = MediaKit::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        $mediaKit->title         = $request->title;
        $mediaKit->bio           = $request->bio;
        $mediaKit->theme_color   = $request->theme_color;
        $mediaKit->contact_email = $request->contact_email;
        $mediaKit->is_public     = $request->has('is_public');

        if ($request->hasFile('cover_image')) {
            try {
                // Delete old image
                if ($mediaKit->cover_image) {
                    $oldPath = public_path('assets/images/custom/' . $mediaKit->cover_image);
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
                $file     = $request->file('cover_image');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destDir  = public_path('assets/images/custom');
                if (!file_exists($destDir)) {
                    mkdir($destDir, 0775, true);
                }
                $file->move($destDir, $filename);
                $mediaKit->cover_image = $filename;
            } catch (\Throwable $e) {
                \Log::error('MediaKit update image error: ' . $e->getMessage());
            }
        }

        $mediaKit->save();

        return redirect()->route('user.mediakit.index')
            ->with('success', translate('Media Kit updated successfully!'));
    }

    public function delete($id)
    {
        $user     = auth_user('web');
        $mediaKit = MediaKit::where('user_id', $user->id)->where('id', $id)->firstOrFail();

        if ($mediaKit->cover_image) {
            $path = public_path('assets/images/custom/' . $mediaKit->cover_image);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        $mediaKit->delete();

        return back()->with('success', translate('Media Kit deleted successfully!'));
    }

    public function insights()
    {
        $title      = translate("Media Kit Insights");
        $meta_data  = $this->metaData(['title' => $title]);
        $user       = auth_user('web');
        $mediaKits  = MediaKit::where('user_id', $user->id)->get();
        $totalViews = $mediaKits->sum('views');

        return view('user.mediakit.insights', compact('title', 'meta_data', 'mediaKits', 'totalViews'));
    }

    // ─── AI Generate Endpoint ─────────────────────────────────────────────────

    /**
     * POST /user/mediakit/ai-generate
     * Body: { mediakit_id, prompt }
     * Returns: JSON { bio, captions, prompts_left }
     */
    public function aiGenerate(Request $request)
    {
        $request->validate([
            'mediakit_id' => 'required|integer',
            'prompt'      => 'required|string|max:500',
        ]);

        $user     = auth_user('web');
        $mediaKit = MediaKit::where('user_id', $user->id)
            ->where('id', $request->mediakit_id)
            ->firstOrFail();

        $maxPrompts = 5;

        if ($mediaKit->ai_prompts_used >= $maxPrompts) {
            return response()->json([
                'error' => 'You have used all 5 AI prompts for this Media Kit.',
                'prompts_left' => 0,
            ], 422);
        }

        $apiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'OpenAI API key not configured.'], 500);
        }

        $systemPrompt = <<<EOT
You are an expert influencer media kit copywriter. 
Given a user prompt about their niche/brand, generate:
1. A compelling "About Me" bio (2–3 paragraphs, professional yet personal, max 300 words).
2. Five ready-to-post social media captions (Instagram-style, with emojis and relevant hashtags).

Format your response STRICTLY as JSON:
{
  "bio": "...",
  "captions": ["caption 1", "caption 2", "caption 3", "caption 4", "caption 5"]
}
EOT;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model'       => 'gpt-4o-mini',
                'temperature' => 0.7,
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $request->prompt],
                ],
            ]);

            if (!$response->successful()) {
                \Log::error('OpenAI error: ' . $response->body());
                return response()->json(['error' => 'AI service error. Please try again.'], 500);
            }

            $content = $response->json('choices.0.message.content');

            // Extract JSON from the response
            preg_match('/\{.*\}/s', $content, $matches);
            $jsonStr  = $matches[0] ?? $content;
            $parsed   = json_decode($jsonStr, true);

            if (!$parsed || !isset($parsed['bio'])) {
                return response()->json(['error' => 'Could not parse AI response. Try again.'], 500);
            }

            // Save AI data and increment counter
            $mediaKit->ai_generated_bio      = $parsed['bio'];
            $mediaKit->ai_generated_captions = json_encode($parsed['captions'] ?? []);
            $mediaKit->ai_prompts_used       = $mediaKit->ai_prompts_used + 1;
            $mediaKit->save();

            return response()->json([
                'bio'          => $parsed['bio'],
                'captions'     => $parsed['captions'] ?? [],
                'prompts_left' => $maxPrompts - $mediaKit->ai_prompts_used,
            ]);

        } catch (\Throwable $e) {
            \Log::error('MediaKit AI error: ' . $e->getMessage());
            return response()->json(['error' => 'AI service unavailable. Please try again.'], 500);
        }
    }

    // ─── Public View ──────────────────────────────────────────────────────────

    public function showPublic($username, $uid)
    {
        $mediaKit = MediaKit::where('uid', $uid)->where('is_public', true)->firstOrFail();

        if (
            $mediaKit->user->username !== $username &&
            ($mediaKit->user->user_name ?? '') !== $username
        ) {
            abort(404);
        }

        $mediaKit->increment('views');

        return view('user.mediakit.public', compact('mediaKit'));
    }

    /**
     * POST /user/mediakit/ai-quick
     * No mediakit_id required — for use on the CREATE page before saving.
     * Body: { prompt }
     * Returns: JSON { bio, captions }
     */
    public function aiQuick(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:500',
        ]);

        $apiKey = config('services.openai.key') ?: env('OPENAI_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'OpenAI API key not configured.'], 500);
        }

        $systemPrompt = <<<EOT
You are an expert influencer media kit copywriter. 
Given a user prompt about their niche/brand, generate:
1. A compelling "About Me" bio (2–3 paragraphs, professional yet personal, max 300 words).
2. Five ready-to-post social media captions (Instagram-style, with emojis and relevant hashtags).

Format your response STRICTLY as JSON:
{
  "bio": "...",
  "captions": ["caption 1", "caption 2", "caption 3", "caption 4", "caption 5"]
}
EOT;

        try {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type'  => 'application/json',
            ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                'model'       => 'gpt-4o-mini',
                'temperature' => 0.7,
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $request->prompt],
                ],
            ]);

            if (!$response->successful()) {
                return response()->json(['error' => 'AI service error. Try again.'], 500);
            }

            $content = $response->json('choices.0.message.content');
            preg_match('/\{.*\}/s', $content, $matches);
            $parsed = json_decode($matches[0] ?? $content, true);

            if (!$parsed || !isset($parsed['bio'])) {
                return response()->json(['error' => 'Could not parse AI response.'], 500);
            }

            return response()->json([
                'bio'      => $parsed['bio'],
                'captions' => $parsed['captions'] ?? [],
            ]);

        } catch (\Throwable $e) {
            \Log::error('MediaKit aiQuick error: ' . $e->getMessage());
            return response()->json(['error' => 'AI service unavailable.'], 500);
        }
    }
}


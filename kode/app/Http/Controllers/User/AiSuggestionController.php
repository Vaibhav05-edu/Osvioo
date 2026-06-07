<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\AiService;
use Illuminate\Http\Request;

class AiSuggestionController extends Controller
{
    public function hashtag()
    {
        $title     = translate("AI Post Hashtag");
        $meta_data = $this->metaData(['title' => $title]);
        return view('user.ai_suggestions.hashtag', compact('title', 'meta_data'));
    }

    public function post()
    {
        $title     = translate("AI Post Suggestion");
        $meta_data = $this->metaData(['title' => $title]);
        return view('user.ai_suggestions.post', compact('title', 'meta_data'));
    }

    public function timing()
    {
        $title     = translate("AI Post Timing");
        $meta_data = $this->metaData(['title' => $title]);
        return view('user.ai_suggestions.timing', compact('title', 'meta_data'));
    }

    public function trend()
    {
        $title     = translate("AI Current Trend");
        $meta_data = $this->metaData(['title' => $title]);
        return view('user.ai_suggestions.trend', compact('title', 'meta_data'));
    }

    // ─── AJAX Generators ─────────────────────────────────────────────────────

    public function generateHashtag(Request $request)
    {
        $request->validate([
            'prompt'   => 'required|string|max:500',
            'platform' => 'nullable|string',
            'count'    => 'nullable|integer|min:1|max:30',
        ]);

        $prompt   = $request->input('prompt');
        $platform = $request->input('platform', 'instagram');
        $count    = $request->input('count', 15);

        $aiPrompt = "Generate exactly {$count} trending, niche-specific hashtags for a {$platform} post about: \"{$prompt}\". "
            . "Return ONLY the hashtags separated by spaces, each starting with #, no explanations, no numbering, no markdown.";

        try {
            $aiService = new AiService();
            $response  = $aiService->generateContent([
                'model'       => $aiService->getAiModel() ?: 'gpt-3.5-turbo',
                'temperature' => 0.8,
                'messages'    => [
                    ['role' => 'system', 'content' => 'You are an expert social media hashtag strategist.'],
                    ['role' => 'user',   'content' => $aiPrompt],
                ],
            ], []);

            if (isset($response['status']) && $response['status'] && !empty($response['message'])) {
                return response()->json(['status' => true, 'result' => trim($response['message'])]);
            }

            return response()->json(['status' => false, 'message' => $response['message'] ?? 'AI failed']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function generatePost(Request $request)
    {
        $request->validate([
            'prompt'     => 'required|string|max:500',
            'tone'       => 'nullable|string',
            'length'     => 'nullable|string',
            'add_emojis' => 'nullable|string',
        ]);

        $prompt    = $request->input('prompt');
        $tone      = $request->input('tone', 'casual');
        $length    = $request->input('length', 'medium');
        $addEmojis = $request->input('add_emojis') === '1';

        $lengthMap = [
            'short'  => '1-2 sentences',
            'medium' => '1 paragraph (3-5 sentences)',
            'long'   => '3-5 paragraphs',
        ];
        $lengthDesc = $lengthMap[$length] ?? '1 paragraph';
        $emojiNote  = $addEmojis ? 'Include relevant emojis throughout.' : 'Do not use emojis.';

        $aiPrompt = "Write an engaging social media caption/post in a {$tone} tone about: \"{$prompt}\". "
            . "Length: {$lengthDesc}. {$emojiNote} Return ONLY the post content, no explanations, no markdown.";

        try {
            $aiService = new AiService();
            $response  = $aiService->generateContent([
                'model'       => $aiService->getAiModel() ?: 'gpt-3.5-turbo',
                'temperature' => 0.8,
                'messages'    => [
                    ['role' => 'system', 'content' => 'You are an expert social media content writer.'],
                    ['role' => 'user',   'content' => $aiPrompt],
                ],
            ], []);

            if (isset($response['status']) && $response['status'] && !empty($response['message'])) {
                return response()->json(['status' => true, 'result' => trim($response['message'])]);
            }

            return response()->json(['status' => false, 'message' => $response['message'] ?? 'AI failed']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function analyzeTiming(Request $request)
    {
        $request->validate([
            'timeframe' => 'nullable|integer',
        ]);

        $timeframe = $request->input('timeframe', 30);

        $aiPrompt = "You are a social media analytics expert. Based on general Instagram engagement data and best practices for the last {$timeframe} days, "
            . "suggest the top 3 best posting times. Return ONLY a JSON array with exactly 3 objects, each having: "
            . "\"time\" (e.g. \"06:00 PM\"), \"day\" (e.g. \"Wednesday\"), \"label\" (e.g. \"Top Choice\"), \"reason\" (short 1-sentence reason). "
            . "No markdown, no extra text.";

        try {
            $aiService = new AiService();
            $response  = $aiService->generateContent([
                'model'       => $aiService->getAiModel() ?: 'gpt-3.5-turbo',
                'temperature' => 0.6,
                'messages'    => [
                    ['role' => 'system', 'content' => 'You are a social media analytics expert. Respond only in JSON.'],
                    ['role' => 'user',   'content' => $aiPrompt],
                ],
            ], []);

            if (isset($response['status']) && $response['status'] && !empty($response['message'])) {
                $clean = preg_replace('/```json|```/', '', $response['message']);
                $data  = json_decode(trim($clean), true);
                if (is_array($data)) {
                    return response()->json(['status' => true, 'result' => $data]);
                }
            }

            return response()->json(['status' => false, 'message' => 'Could not parse timing data. Try again.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function scanTrends(Request $request)
    {
        $request->validate([
            'niche'    => 'nullable|string',
            'platform' => 'nullable|string',
        ]);

        $niche    = $request->input('niche', 'general');
        $platform = $request->input('platform', 'instagram_reels');

        $aiPrompt = "You are a social media trend analyst. List the top 5 current trending topics, audios, or content formats for the \"{$niche}\" niche on {$platform}. "
            . "Return ONLY a JSON array with exactly 5 objects, each having: "
            . "\"title\" (trend name), \"type\" (Audio/Format/Topic/Hashtag), \"growth\" (e.g. \"+320%\"), \"description\" (1 sentence why it's trending). "
            . "No markdown, no extra text.";

        try {
            $aiService = new AiService();
            $response  = $aiService->generateContent([
                'model'       => $aiService->getAiModel() ?: 'gpt-3.5-turbo',
                'temperature' => 0.8,
                'messages'    => [
                    ['role' => 'system', 'content' => 'You are a social media trend analyst. Respond only in JSON.'],
                    ['role' => 'user',   'content' => $aiPrompt],
                ],
            ], []);

            if (isset($response['status']) && $response['status'] && !empty($response['message'])) {
                $clean = preg_replace('/```json|```/', '', $response['message']);
                $data  = json_decode(trim($clean), true);
                if (is_array($data)) {
                    return response()->json(['status' => true, 'result' => $data]);
                }
            }

            return response()->json(['status' => false, 'message' => 'Could not fetch trend data. Try again.']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}


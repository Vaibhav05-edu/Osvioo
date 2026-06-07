<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
}

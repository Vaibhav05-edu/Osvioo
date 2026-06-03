<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AiSuggestionController extends Controller
{
    public function hashtag()
    {
        $title = translate("AI Post Hashtag");
        return view('user.ai_suggestions.hashtag', compact('title'));
    }

    public function post()
    {
        $title = translate("AI Post Suggestion");
        return view('user.ai_suggestions.post', compact('title'));
    }

    public function timing()
    {
        $title = translate("AI Post Timing");
        return view('user.ai_suggestions.timing', compact('title'));
    }

    public function trend()
    {
        $title = translate("AI Current Trend");
        return view('user.ai_suggestions.trend', compact('title'));
    }
}

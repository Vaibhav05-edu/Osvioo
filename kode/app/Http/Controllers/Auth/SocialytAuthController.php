<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Faq;
use App\Models\Story;
use App\Models\PlateformStat;
use App\Models\Video;
use App\Models\Creator;


class SocialytAuthController extends Controller
{

    public function showWelcome()
    {
        $settings = \App\Models\LandingPageSetting::first();
        
        // Order ke hisaab se fetch karein aur active records lein
        $faqs = Faq::where('is_active', true)
                    ->orderBy('order', 'asc')
                    ->get();
                    
        $stories = Story::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        $stats = PlateformStat::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        $creators = Creator::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        $videos = Video::where('status', true)
                    ->orderBy('order', 'asc')
                    ->get();
        
        return view('welcome', compact('settings', 'faqs', 'stories', 'stats', 'videos' , 'creators'));
    }

    // Showing the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

  
    public function login(Request $request)
    {
        // 1. Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Encrypted Email Search
        // Hum database se saare users (ya email list) nikal kar decrypt karenge
        $user = User::all()->filter(function ($u) use ($request) {
            try {
                return Crypt::decryptString($u->email) === $request->email;
            } catch (\Exception $e) {
                return false;
            }
        })->first();

        // 3. Password Check
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->remember);

            $request->session()->regenerate();

            // Success redirect
            return redirect()->intended('/dashboard')->with('success', 'Welcome back!');
        }

        // 4. Fail Return
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    

    
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('socialyt.login');
    }

    // Role ke hisaab se redirect
    private function redirectByRole(string $role): \Illuminate\Http\RedirectResponse
    {
        return match($role) {
            'admin'    => redirect()->route('socialyt.dashboard'),
            'advocate' => redirect()->route('socialyt.dashboard'),
            default    => redirect()->route('socialyt.login'),
        };
    }
}

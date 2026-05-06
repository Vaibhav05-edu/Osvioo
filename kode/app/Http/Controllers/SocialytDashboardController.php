<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\FAQ;
use App\Models\Story;
use App\Models\PlatformStat;
use App\Models\Creator;
use App\Models\Video;
use Carbon\Carbon;


class SocialytDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $getStats = function($model, $label, $icon, $color) {
            $total = $model::count();

            $currentWeek = $model::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
            $lastWeek = $model::whereBetween('created_at', [
                Carbon::now()->subWeek()->startOfWeek(),
                Carbon::now()->subWeek()->endOfWeek()
            ])->count();

            $change = ($lastWeek > 0) ? round((($currentWeek - $lastWeek) / $lastWeek) * 100, 1) : ($currentWeek > 0 ? 100 : 0);

            return [
                'label'  => $label,
                'value'  => $total,
                'change' => abs($change) . '%',
                'up'     => $change >= 0,
                'icon'   => $icon,
                'color'  => $color
            ];
        };

        $stats = [
            $getStats(Story::class, 'Total Stories', 'fa-book-open', '#6366f1'),
            $getStats(Creator::class, 'Active Creators', 'fa-users', '#f59e0b'),
            $getStats(Video::class, 'Video Assets', 'fa-video', '#10b981'),
            $getStats(FAQ::class, 'Total FAQs', 'fa-question-circle', '#8b5cf6'),
        ];

        return view('dashboard.index', [
            'user' => $user,
            'stats' => $stats,
            'latestFaqs' => FAQ::latest()->take(5)->get(),
            'latestStories' => Story::latest()->take(4)->get(),
            'latestCreators' => Creator::latest()->take(6)->get(),
        ]);
    }

    public function profile()
    {
        $user = auth()->user();

        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Validate Request
            |--------------------------------------------------------------------------
            */

            $request->validate([

                'profile_photo' => 'nullable|mimes:jpg,jpeg|max:500',

                'dob' => 'nullable|date',

                'date_of_enrollment' => 'nullable|date',

            ]);


            /*
            |--------------------------------------------------------------------------
            | Get Logged In User
            |--------------------------------------------------------------------------
            */

            $user = User::findOrFail(auth()->id());


            /*
            |--------------------------------------------------------------------------
            | Upload Profile Photo To Storage
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('profile_photo')) {

                $file = $request->file('profile_photo');


                // Minimum Size Check (20KB)
                if ($file->getSize() < 20480) {

                    return back()
                        ->withErrors([
                            'profile_photo' => 'Image must be at least 20KB.'
                        ])
                        ->withInput();
                }


                /*
                |--------------------------------------------------------------------------
                | Delete Old Photo
                |--------------------------------------------------------------------------
                */

                if ($user->profile_photo) {

                    Storage::disk('public')->delete($user->profile_photo);
                }


                /*
                |--------------------------------------------------------------------------
                | Store New File
                |--------------------------------------------------------------------------
                */

                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();


                $path = $file->storeAs(

                    'profile_photos',

                    $fileName,

                    'public'

                );


                /*
                |--------------------------------------------------------------------------
                | Save Path In Database
                |--------------------------------------------------------------------------
                */

                $user->profile_photo = $path;
            }


            /*
            |--------------------------------------------------------------------------
            | Save Additional Details
            |--------------------------------------------------------------------------
            */

            $user->dob = $request->dob;

            $user->date_of_enrollment = $request->date_of_enrollment;


            $user->save();


            return back()->with('success', 'Profile updated successfully!');


        } catch (\Exception $e) {

            Log::error('Profile Update Error: ' . $e->getMessage());

            return back()
                ->withErrors([
                    'error' => 'Something went wrong while updating profile.'
                ])
                ->withInput();
        }
    }
}